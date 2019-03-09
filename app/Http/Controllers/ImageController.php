<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;

class ImageController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function serveReportImage($filePath)
    {
        if (!Storage::disk('local')->exists($filePath)) {
            abort(404);
        }

        $localPath = config('filesystems.disks.local.root').DIRECTORY_SEPARATOR.$filePath;

        return response()->file($localPath);
    }
}
