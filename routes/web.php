<?php

use App\Livewire\Home;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


Route::redirect('/', '/login');
Route::get('/register', function () {return view('registeraccount'); })->name('register');




/* Admin account role ------------------------------------------------------------------------------*/
Route::middleware(['auth', 'checkrole:sa,admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});




/* User account role --------------------------------------------------------------------------*/
Route::middleware(['auth', 'checkrole:user'])->group(function () {
    Route::get('/home', Home::class)->name('home');
});




/* User and Admin account role --------------------------------------------------------------------------*/
Route::middleware(['auth', 'checkrole:sa,admin,user'])->group(function () {

});




/* Profile Photo -----------------------------------------------------------------------------------*/
Route::get('/profile-photo/{filename}', function ($filename) {
    $path = 'profile-photos/' . $filename;

    if (!Storage::disk('public')->exists($path)) {
        abort(404);
    }

    $file = Storage::disk('public')->get($path);
    $type = File::mimeType(storage_path('app/public/' . $path));

    return response($file, 200)->header('Content-Type', $type);
})->name('profile-photo.file');
