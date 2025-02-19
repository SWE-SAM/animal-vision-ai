<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageAnalysisController;
use App\Http\Controllers\UploadScanController;


Route::get('/', function () {
    return view('dashboard'); // Make sure 'dashboard.blade.php' exists
});

// Route for analyzing images (API endpoint)
Route::post('/analyze-image', [ImageAnalysisController::class, 'analyze']);

// Testing route for image analyzer
Route::get('/image-analyzer', function () {
    return view('analyze'); 
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::get('/uploadscan', [UploadScanController::class, 'index'])->name('uploadscan');
Route::post('/uploadscan/process', [UploadScanController::class, 'process'])->name('uploadscan.process');