<?php
namespace App\Services;

use App\Report;
use App\File;
use App\Tag;

class StoreReportServices
{


    // Create tags and attach them to the report (if the tag exist, it will be attached immediately).
    public function createAndAttachTags($report, $tags) {
        // first detach all tags, so when a report tag is edited, it gets edited and not duplicated.
        $report->tags()->detach();
        
        $tags = $this->formatTags($tags);
        // attach tags
        foreach($tags as $tag) {
            $tag = Tag::firstOrCreate(['title' => $tag], ['title' => $tag]);
            if($report->tags->contains($tag)) {
                continue;
            } else {
                $report->tags()->attach($tag);
            }
        }
        $report->save();
    }

    private function formatTags($tags) {
        // break tags into an array of tags
        $tags = str_replace(' ','',$tags);
        $tags = explode(',', $tags);

        // remove any unnecessary items in the array
        return array_filter($tags, function($value, $key){
            if ($value === '')
                return false;
            else
                return true;
        }, ARRAY_FILTER_USE_BOTH);
        
    }

    /* 
    * This function takes a base64 array of files, stores them into the database
    * and attaches them to the related report.
    * returns true if all files were uploaded, false otherwise.
    */
    public function decodeAndStoreFiles($files, $allowedExtensions, $reportId, $outputExtension) {
        foreach($files as $fileObject){
            if (strpos($fileObject['name'], ',')) {
                $file = explode(',', $fileObject['name']);
                $file = str_replace(' ', '+', $file[1]);
            } else {
                $file = str_replace(' ', '+', $fileObject['name']);
            }
            $fileName = 'reportsFiles/'.str_random(16).'.'.$outputExtension;
            while(File::where('path', $fileName)->exists())
                $fileName = 'reportsFiles/'.str_random(16).'.'.$outputExtension;
            \File::put(storage_path(). '/app' . '/' . $fileName, base64_decode($file));    
            File::create([
                'report_id' => $reportId,
                'path' => $fileName
            ]);
        }
        return true;
    }


    /* 
    * This function takes an array of files, stores them into the database
    * and attaches them to the related report.
    * returns true if all files were uploaded, false otherwise.
    */
    public function storeFiles($files, $allowedExtensions, $reportId) {
        foreach($files as $file){
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            // check whether the file has an accepted extension
            $check=in_array($extension,$allowedExtensions);

            if($check) {
                $filename = $file->store('reportsFiles');
                File::create([
                    'report_id' => $reportId,
                    'path' => $filename
                ]);
            } else {
                return false;
            }
        }
        return true;
    }

}