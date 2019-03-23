<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::middleware(['auth'])->group(function() {

    Route::get('/', 'ReportController@index');

    
    /*
    * Default User: search for reports.
    * No need for authorization since the reports that will be filtered using the search query
    * are the reports that belong to the user's groups only.
    */
    Route::get('/reports/search', 'ReportController@search');


    /*
    * Default User: reports routes. a policy is attached to the resource
    * to authorize access on different reports based on the user's groups.
    */
    Route::resource('reports', 'ReportController');


    /*
    * Default User: groups routes.
    * a policy is attached to the resource
    * to authorize access on different reports based on the user's groups.
    */
    Route::resource('groups', 'GroupController')->only(['show', 'index']);
    
    
    /* 
    * routes to retrieve and delete report images,
    * The user should be authorized to access the requested image, otherwise the file won't appear.
    */
    Route::get('/storage/app/{filePath}', 'FileController@serveReportFile')
    ->where(['filePath' => '.*'])->name('serveReportFile');
    Route::post('/reports/{id}/images/removeImage', 'FileController@removeReportFile')->middleware('auth');
    
    // routes to upload images and audio files for a specific report.
    Route::post('/reports/{id}/images', 'ReportController@uploadImages');
    Route::post('/reports/{id}/audios', 'ReportController@uploadAudios');
    
    
    // Admin routes. Only accessible by admins.
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function() {
        Route::get('/reports', 'AdminPanelController@getReports')->name('reports');
        Route::get('/groups', 'AdminPanelController@getGroups')->name('groups');
        Route::get('/users', 'AdminPanelController@getUsers')->name('users');
        Route::get('/reports/search', 'AdminPanelController@search')->name('reports.search');
        Route::resource('users', 'UserController')->middleware('auth')->only(['edit', 'update', 'destroy']);
        Route::resource('groups', 'GroupController')->except(['show', 'index']);
    
    });    
});

// Route::get('/reports/search', 'ReportController@search')->middleware('auth');
// Route::resource('reports', 'ReportController')->middleware('auth');

// Route::resource('groups', 'GroupController')->middleware('auth');


// // route to retrieve and delete report images
// Route::get('/storage/app/{filePath}', 'FileController@serveReportFile')
// ->where(['filePath' => '.*'])->name('serveReportFile');
// Route::post('/reports/{id}/images/removeImage', 'FileController@removeReportFile')->middleware('auth');
// Route::post('/reports/{id}/images', 'ReportController@uploadImages');
// Route::post('/reports/{id}/audios', 'ReportController@uploadAudios');


// // Admin routes
// Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function() {
//     Route::get('/reports', 'AdminPanelController@getReports')->name('reports');
//     Route::get('/groups', 'AdminPanelController@getGroups')->name('groups');
//     Route::get('/users', 'AdminPanelController@getUsers')->name('users');
//     Route::get('/reports/search', 'AdminPanelController@search')->name('reports.search');
//     Route::resource('users', 'UserController')->middleware('auth')->only(['edit', 'update', 'destroy']);

// });