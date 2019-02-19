<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;

class AdminPanelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all reports in the database.
        $reports = Report::all();
        return view('reports.reports')->with('reports', $reports);
    }
}
