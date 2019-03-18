<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\Input;

class AdminPanelController extends Controller
{
    /**

     * @return \Illuminate\Http\Response
     */
    public function getReports()
    {
        // get all reports in the database.
        $reports = App\Report::paginate(10);
        return view('admin.reports')->with('reports', $reports);
    }

    public function getGroups()
    {
        // get all groups in the database.
        $groups = App\Group::paginate(10);
        return view('admin.groups')->with('groups', $groups);
    }

    public function getUsers()
    {
        // get all users in the database.
        $users = App\User::paginate(10);
        return view('admin.users')->with('users', $users);
    }

    public function search()
    {
        // search through reports, forward to appropriate function.
        switch (Input::get('searchBy')) {
            case 'title': 
                return $this->searchByTitle();
            case 'group':
                return $this->searchByGroup();
            case 'tag':
                return $this->searchByTags();
            case 'user': 
                return $this->searchByUser();
        }

        return $this->getReports();

    }

    public function searchByTitle()
    {
        $reports = App\Report::where('title', 'like', '%'.Input::get('query').'%')->paginate(10);
        return view('admin.reports')->with('reports', $reports);
    }

    public function searchByGroup()
    {
        $reports = App\Report::whereHas('group', function ($query) {
            $query->where('title', 'like', '%'.Input::get('query').'%');
        })->paginate(10);
        
        return view('admin.reports')->with('reports', $reports);
    }

    public function searchByUser()
    {
        $reports = App\Report::whereHas('user', function ($query) {
            $query->where('name', 'like', '%'.Input::get('query').'%');
        })->paginate(10);
        
        return view('admin.reports')->with('reports', $reports);
    }

    public function searchByTags()
    {
        $reports = App\Report::whereHas('tags', function ($query) {
            $query->where('title', '=', Input::get('query'));
        })->paginate(10);
        
        return view('admin.reports')->with('reports', $reports);
    }







}
