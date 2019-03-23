<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = auth()->user()->groups()->paginate(10);
        return view('groups.index')->with('groups', $groups);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('groups.create');
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
            'title' => 'required|min:3',
        ]);
        // $id is group's title
        $group = App\Group::create($request->only(['title']));
        flash('Successfully created group: '.$group->title)->success();
        return redirect()->action('AdminPanelController@getGroups');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $title
     * @return \Illuminate\Http\Response
     */
    public function show($title)
    {
        $group = App\Group::find($title);
        $this->authorize('view', $group);

        if (!$group) {
            return abort(404);
        }
        $users = $group->users()->paginate(10);
        return view('groups.show')->with('group', $group)->with('users', $users);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $id is group's title
        $group = App\Group::findOrFail($id);
        return view('groups.edit')->with('group', $group);
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
        $validator = $this->validate($request, [
            'title' => 'required|min:3',
        ]);
        // $id is group's title
        $group = App\Group::find($id);
        $group->title = $request->title;
        $group->save();
        flash('Success! Group details has changed.')->success();
        return redirect()->action('GroupController@edit', $request->title);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = App\Group::find($id);
        $group->delete();
        flash('Successfully deleted group: '.$group->title)->success();
        return redirect()->action('AdminPanelController@getGroups');
    }
}
