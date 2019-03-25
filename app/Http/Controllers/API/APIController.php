<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Services\StoreReportServices;
use App\Report;

class APIController extends Controller
{
    protected $reportStoringServices;

    public function __construct(StoreReportServices $services)
    {
        $this->reportStoringServices = $services;
    }

    public function storeReports(Request $request) {
        foreach($request->all() as $report) {
            $response = $this->storeSingleReport($report);
            if (!is_null($response))
                return $response;
        }
        return new Response(['success' => 'reports stored','reports' => $request->all()], 200);
    }

    private function storeSingleReport($reportData) {
        $validator = Validator::make($reportData, [
            'title' => 'required',
            'description' => 'required',
            'group' => 'required|exists:groups,title',
            'tags' => 'required',
            'user_id' => 'required|exists:users,id'
        ]);
        if ($validator->fails()) {
            return new Response(['error' => $validator->messages()->first()], 400);
        }

        $fields = ['title' => $reportData['title'], 'description' => $reportData['description'], 'user_id' => $reportData['user_id'], 'group_title' => $reportData['group']];
        $reportModel = Report::create($fields);
        
        $this->reportStoringServices->createAndAttachTags($reportModel, $reportData['tags']);
          
        if(isset($reportData['photos'])) {
            $uploadStatus = $this->reportStoringServices->decodeAndStoreFiles($reportData['photos'], config('files.allowedImagesExtensions'), $reportModel['id'], 'png');
            if (!$uploadStatus)
                return new Response(['error' => 'Something went wrong while storing report images.'], 400);
        }

        if(isset($reportData['audios'])) {
            $uploadStatus = $this->reportStoringServices->decodeAndStoreFiles($reportData['audios'], config('files.allowedAudioFilesExtensions'), $reportModel['id'], 'mp3');
            if (!$uploadStatus)
            return new Response(['error' => 'Something went wrong while storing report audio files.'], 400);
        }

        return null;
    }
}
