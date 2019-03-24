<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use App\Report;
use App\File;
use Illuminate\Support\Facades\Gate;

class FileController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function serveReportFile($filePath) {
        $this->authorize('accessReportFile', [File::class, $filePath]);
        if (!Storage::disk('local')->exists($filePath)) {
            // The file does not exist or the user is not allowed to access it.
            return abort(404);
        }

        $localPath = config('filesystems.disks.local.root').DIRECTORY_SEPARATOR.$filePath;

        return response()->file($localPath);
    }

    public function removeReportFile(Request $request, $reportId) {
        $filePath = $request->input('filePath');
        $this->authorize('accessReportFile', [File::class, $filePath]);
        
        if (!Storage::disk('local')->exists($filePath)) {
            // The file does not exist or the user is not allowed to access it.
            return abort(404);
        }

        $fileId = $request->input('fileId');

        Storage::delete($filePath);
        $report = Report::find($reportId);
        File::find($fileId)->delete();
        flash('Changes have been saved.')->success();
        return redirect()->action('ReportController@edit', $reportId);
    }
}
