<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class AdminPanelController extends Controller
{
    /**

     * @return \Illuminate\Http\Response
     */
    public function getReports()
    {
        // get all reports in the database.
        $reports = App\Report::all();
        return view('admin.reports')->with('reports', $reports);
    }

    public function getGroups()
    {
        // get all groups in the database.
        $groups = App\Group::all();
        return view('admin.groups')->with('groups', $groups);
    }

    public function getUsers()
    {
        // get all users in the database.
        $users = App\User::all();
        return view('admin.users')->with('users', $users);
    }


}
