<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;
use App\Group;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'group' => 'required',
        ]);
        $fields = $request->only(['title', 'description']);
        $fields['user_id'] = auth()->user()->id;
        $fields['group_title'] = $request->group;
        $report = Report::create($fields);
        // $group = Group::find($request->group);
        // $report->group->associate($group);
        // $report->save();
        // if($request->hasFile('photos')) {
        //     $allowedExtension = ['gif', 'jpg', 'png'];
        //     $files = $request->file('photos');
        //     $this->storeFiles($files, $allowedExtension);
        // }


        
            
    }


    /* 
    * This function takes a request, stores t into the database
    * and attaches them to the related report.
    */
    public function storeFiles($files, $allowedExtensions, $reportId) {
        foreach($files as $file){
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $check=in_array($extension,$allowedfileExtension);
            if($check) {
                $items= Item::create($request->all());
                foreach ($request->photos as $photo) {
                    $filename = $photo->store('reportsPhotos');
                    ItemDetail::create([
                        'item_id' => $items->id,
                        'filename' => $filename
                    ]);
                }
            }
        }
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
