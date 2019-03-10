<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use Illuminate\Support\Facades\Gate;

class ImageController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function serveReportImage($filePath)
    {
        if (!Storage::disk('local')->exists($filePath) || Gate::denies('serveReportFile', $filePath)) {
            // The file does not exist or the user is not allowed to access it.
            return abort(404);
        }

        $localPath = config('filesystems.disks.local.root').DIRECTORY_SEPARATOR.$filePath;

        return response()->file($localPath);
    }
}
