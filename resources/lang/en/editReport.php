<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Edit Report Form Language Lines
    |--------------------------------------------------------------------------
    */

    'editDetails' => 'Edit Report Details',
    'editImages' => 'Manage Report Images',
    'editAudios' => 'Manage Report Audio Files',
    'titleField' => 'Title',
    'tags' => 'Tags',
    'tagsHelper' => '• Enter tags separated by a comma (tag1, tag2, tag3... etc.)',
    'blankSpaces' => '• Blank spaces included in tags will be ignored.',
    'description' => 'Description',
    'group' => 'Group',
    'uploadImages' => 'Upload Images',
    'uploadImagesHelper' => '(only the following extensions are allowed: '.implode(' ', config('files.allowedImagesExtensions')).')',
    'uploadAudios' => 'Upload Audio Files',
    'uploadAudiosHelper' => '(only the following extesnions are allowed:'.implode(' ', config('files.allowedAudioFilesExtensions')).')',
    'editButton' => 'Edit Report',
    'upload' => 'Upload',
    'deleteButton' => 'Delete Report',

];
