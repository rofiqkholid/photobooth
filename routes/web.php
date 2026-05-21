<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/send-photo', [PhotoController::class, 'sendPhoto'])->name('send-photo');

Route::get('/download/{filename}', [PhotoController::class, 'showDownload'])->name('photo.download');
Route::get('/download-file/{filename}', [PhotoController::class, 'downloadFile'])->name('photo.download-file');
