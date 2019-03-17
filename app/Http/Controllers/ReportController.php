<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;
use App\Group;
use App\File;
use App\Tag;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Input;


class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // shows the reports that belong to the groups assigned to the user.
        $user = auth()->user();
        $reports = Report::whereIn('group_title', $user->groups->pluck('title'))->paginate(10);
        return view('reports.index')->with('reports', $reports);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();
        return view('reports.create')->with('groups', $user->groups);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $user = auth()->user();
        $validator = $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'group' => ['required', Rule::in($user->groups->pluck('title'))],
            'tags' => 'required'
        ]);
        if(!$validator)
            $this->invalidFields();
        
        $fields = $request->only(['title', 'description']);
        $fields['user_id'] = $user->id;
        $fields['group_title'] = $request->group;
        $report = Report::create($fields);

        $this->createAndAttachTags($report, $request->tags);

        if($request->photos) {
            $uploadStatus = $this->storeFiles($request->photos, ['png', 'jpg', 'gif', 'jpeg'], $report->id);
            if (!$uploadStatus)
                return $this->invalidFiles();
        }
        if($request->audios) {
            $uploadStatus = $this->storeFiles($request->audios, ['mp3', 'mpga'], $report->id);
            if (!$uploadStatus)
                return $this->invalidFiles();
        }      
        return redirect()->route('reports.index');     
    }

    // Create tags and attach them to the report (if the tag exist, it will be attached immediately).
    public function createAndAttachTags($report, $tags) {
        $tags = str_replace(' ','',$tags);
        $tags = explode(',', $tags);
        $tags = array_filter($tags, function($value, $key){
            if ($value === '')
                return false;
            else
                return true;
        }, ARRAY_FILTER_USE_BOTH);

        foreach($tags as $tag) {
            $tag = Tag::firstOrCreate(['title' => $tag], ['title' => $tag]);
            if($report->tags->contains($tag)) {
                continue;
            } else {
                $report->tags()->attach($tag);
            }
        }
        $report->save();
    }

    /* 
    * This function takes a request, stores t into the database
    * and attaches them to the related report.
    * returns true if all files were uploaded, false otherwise.
    */
    public function storeFiles($files, $allowedExtensions, $reportId) {
        foreach($files as $file){
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            // check whether the file has an accepted extension
            $check=in_array($extension,$allowedExtensions);

            if($check) {
                $filename = $file->store('reportsFiles');
                File::create([
                    'report_id' => $reportId,
                    'path' => $filename
                ]);
            } else {
                return false;
            }
        }
        return true;
    }

    public function invalidFiles() {
        flash('Could not upload files, please make sure to upload valid files then try again.')->error();
        return redirect()->route('reports.create');
    }

    public function invalidFields() {
        flash('Could not add report, please make sure to fill the fields correctly and try again.')->error();
        return redirect()->route('reports.create');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $report = Report::find($id);
        if (!$report) {
            return abort(404);
        }
        return view('reports.show')->with('report', $report);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $report = Report::find($id);
        if (!$report) {
            return abort(404);
        }
        $user = auth()->user();
        return view('reports.edit')->with('report', $report)->with('groups', $user->groups);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $validator = $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'group' => ['required', Rule::in($user->groups->pluck('title'))],
            'tags' => 'required'
        ]);
        if(!$validator)
            $this->invalidFields();
        
        $report = Report::find($id);
        $report->title = $request->title;
        $report->description = $request->description;
        $report->group_title = $request->group;
        $this->createAndAttachTags($report, $request->tags);
        $report->save();
        return redirect()->action('ReportController@edit', $id);
    }

    public function uploadImages(Request $request, $id) {
        if ($request->photos) {
            $uploadStatus = $this->storeFiles($request->photos, ['png', 'jpg', 'gif', 'jpeg'], $id);
            if (!$uploadStatus)
                return $this->invalidFiles();
            flash('Images uploaded!')->success();
        } else {
            flash('No images were uploaded, please select images then try again')->error();
        }
        return redirect()->action('ReportController@edit', $id);
    }

    public function uploadAudios(Request $request, $id) {
        if ($request->audios) {
            $uploadStatus = $this->storeFiles($request->audios, ['mp3', 'mpga'], $id);
            if (!$uploadStatus)
                return $this->invalidFiles();
            flash('Audio files uploaded!')->success();
        } else {
            flash('No files were uploaded, please select images then try again')->error();
        }
        return redirect()->action('ReportController@edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $report = Report::find($id);
        if (!$report) {
            return abort(404);
        }
        $report->delete();

        return redirect()->action('ReportController@index');
    }

    public function search()
    {
        // search through reports, forward to appropriate function.
        if (!Input::get('query')) {
            return redirect()->action('ReportController@index');
        }

        switch (Input::get('searchBy')) {
            case 'title': 
                return $this->searchByTitle();
            case 'group':
                return $this->searchByGroup();
            case 'tag':
                return $this->searchByTags();
        }
        return redirect()->action('ReportController@index');
    }

    public function searchByTitle()
    {
        $reports = auth()->user()->groups->pluck('reports')->flatten(1)->filter(function($report){
                return false !== stristr($report->title, Input::get('query'));
            });
        return view('reports.index')->with('reports', $reports->paginate(10));
    }

    public function searchByGroup()
    {
        // TODO authorization
        $group = Group::find(Input::get('query'));
        if (!$group) {
            // if no reports were found, pass null to show no reports.
            return view('reports.index')->with('reports', null);
        }
        return view('reports.index')->with('reports', $group->reports->paginate(10));
    }

    public function searchByTags()
    {
        $reports = auth()->user()->groups->pluck('reports')->flatten(1)->filter(function($report){
                return $report->tags->pluck('title')->contains(Input::get('query'));
        });
        return view('reports.index')->with('reports', $reports->paginate(10));
    }

}
