<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use App\Report;
use App\File;
use Illuminate\Support\Facades\Gate;

class ImageController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function serveReportImage($filePath) {
        if (!Storage::disk('local')->exists($filePath) || Gate::denies('accessReportFile', $filePath)) {
            // The file does not exist or the user is not allowed to access it.
            return abort(404);
        }

        $localPath = config('filesystems.disks.local.root').DIRECTORY_SEPARATOR.$filePath;

        return response()->file($localPath);
    }

    public function removeReportImage(Request $request, $reportId) {
        $filePath = $request->input('imagePath');
        if (!Storage::disk('local')->exists($filePath) || Gate::denies('accessReportFile', $filePath)) {
            // The file does not exist or the user is not allowed to access it.
            return abort(404);
        }

        $imageId = $request->input('imageId');

        Storage::delete($filePath);
        $report = Report::find($reportId);
        File::find($imageId)->delete();
        flash('Changes have been saved.')->success();
        return redirect()->action('ReportController@edit', $reportId);
    }
}
