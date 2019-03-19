<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App;

class UserController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $user = App\User::findOrFail($id);
        $groups = App\Group::all();
        return view('users.edit')->with('user', $user)->with('groups', $groups);
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
        $user = App\User::findOrFail($id);
        $validator = $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->email, 'email')],
            'password' => ['nullable', 'string', 'min:6'],
            'groups' => 'exists:groups,title',
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->groups()->sync($request->groups);

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        if ($request->adminRole) {
            $user->roles()->sync(['User', 'Admin']);
        } else {
            $user->roles()->sync('User');
        }
        $user->save();

        flash('Successfully updated user details!')->success();
        return redirect()->action('UserController@edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = App\User::findOrFail($id);
        $user->delete();
        flash('User deleted successfully!')->success();
        return redirect()->action('AdminPanelController@getUsers');

    }
}
