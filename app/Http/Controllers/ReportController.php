<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;
use App\Group;
use App\File;
use App\Tag;


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
        $reports = Report::whereIn('group_title', $user->groups)->paginate(10);
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
        $validator = $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'group' => 'required',
            'tags' => 'required'
        ]);

        if(!$validator)
            $this->invalidFields();
        
        $fields = $request->only(['title', 'description']);
        $fields['user_id'] = auth()->user()->id;
        $fields['group_title'] = $request->group;
        $report = Report::create($fields);

        $tags = str_replace(' ','',$request->tags);
        $tags = explode(',', $tags);

        // Create tags and attach them to the report (if the tag exist, it will be attached immediately).
        foreach($tags as $tag) {
            $tag = Tag::firstOrCreate(['title' => $tag], ['title' => $tag]);
            $report->tags()->attach($tag);
        }
        $report->save();

        if($request->photos) {
            $uploadStatus = $this->storeFiles($request->photos, ['png', 'jpg', 'gif'], $report->id);
            if (!$uploadStatus)
                return $this->invalidFiles();
        }

        if($request->audios) {
            $uploadStatus = $this->storeFiles($request->audios, ['mp3'], $report->id);
            if (!$uploadStatus)
                return $this->invalidFiles();
        }

                
        return redirect()->route('reports.index');

        
            
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
