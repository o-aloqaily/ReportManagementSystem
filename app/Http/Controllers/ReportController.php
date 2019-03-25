<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;
use App\Group;
use App\File;
use App\Tag;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Input;
use App\Services\StoreReportServices;


class ReportController extends Controller
{
    protected $reportStoringServices;

    public function __construct(StoreReportServices $services)
    {
        $this->reportStoringServices = $services;
    }

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
    public function create(Request $request)
    {
        $user = auth()->user();
        $groups = $user->groups;
        if ($user->isAdmin()) {
            // if the user is admin allow him to create reports on any group.
            $groups = Group::all();
        } else if ($user->groups->count() <= 0) {
            flash('You cannot create a new report, you are not assigned to any group yet.')->error();
            return redirect()->action('ReportController@index');
        }

        return view('reports.create')->with('groups', $groups);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $this->authorize('store', Report::class);
        $user = auth()->user();
        $validator = $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'group' => 'required',
            'tags' => 'required'
        ]);

        $fields = $request->only(['title', 'description']);
        $fields['user_id'] = $user->id;
        $fields['group_title'] = $request->group;
        $report = Report::create($fields);

        $this->reportStoringServices->createAndAttachTags($report, $request->tags);

        if($request->photos) {
            $uploadStatus = $this->reportStoringServices->storeFiles($request->photos, config('files.allowedImagesExtensions'), $report->id);
            if (!$uploadStatus)
                return $this->invalidFiles();
        }
        if($request->audios) {
            $uploadStatus = $this->reportStoringServices->storeFiles($request->audios, config('files.allowedAudioFilesExtensions'), $report->id);
            if (!$uploadStatus)
                return $this->invalidFiles();
        }      
        flash('Successfully created report: '.$report->title)->success();
        return redirect()->route('reports.index');     
    }


    public function invalidFiles() {
        flash('Could not upload files, please make sure to upload valid files then try again.')->error();
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
        $report = Report::findOrFail($id);
        $this->authorize('show', $report);
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
        $report = Report::findOrFail($id);
        $this->authorize('update', $report);
        $user = auth()->user();
        $groups = $user->groups;
        if ($user->isAdmin()) // allow the admin to switch the group of the reprot to any group.
            $groups = Group::all();

        return view('reports.edit')->with('report', $report)->with('groups', $groups);
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
        $report = Report::findOrFail($id);
        $this->authorize('update', $report);
        $user = auth()->user();

        $validator = $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'group' => ['required', Rule::in($user->groups->pluck('title'))],
            'tags' => 'required'
        ]);

        $report->title = $request->title;
        $report->description = $request->description;
        $report->group_title = $request->group;
        $this->reportStoringServices->createAndAttachTags($report, $request->tags);
        $report->save();
        flash('Changes have been saved.')->success();
        return redirect()->action('ReportController@edit', $id);
    }

    public function uploadImages(Request $request, $id) {
        $report = Report::findOrFail($id);
        $this->authorize('uploadFile', $report);

        if ($request->photos) {
            $uploadStatus = $this->reportStoringServices->storeFiles($request->photos, config('files.allowedImagesExtensions'), $id);
            if (!$uploadStatus)
                return $this->invalidFiles();
            flash('Images uploaded!')->success();
        } else {
            flash('No images were uploaded, please select images then try again')->error();
        }
        return redirect()->action('ReportController@edit', $id);
    }

    public function uploadAudios(Request $request, $id) {
        $report = Report::findOrFail($id);
        $this->authorize('uploadFile', $report);

        if ($request->audios) {
            $uploadStatus = $this->reportStoringServices->storeFiles($request->audios, ['mp3', 'mpga'], $id);
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
        $report = Report::findOrFail($id);
        $this->authorize('delete', $report);

        $report->delete();
        flash('Report has been successfully deleted.')->success();
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
