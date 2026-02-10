<?php

use App\Livewire\Home;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\BudgetManagement;
use App\Livewire\Admin\ProcurementPlanningManagement;
use App\Livewire\Admin\ProcurementManagement;
use App\Livewire\Admin\ContractManagement;


// Route::redirect('/', '/login');
// Route::get('/register', function () {return view('registeraccount'); })->name('register');

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', Dashboard::class)->name('dashboard');
Route::get('/budgets', BudgetManagement::class)->name('budgets');
Route::get('/procurement-planning', ProcurementPlanningManagement::class)->name('procurement-planning');
Route::get('/procurements', ProcurementManagement::class)->name('procurements');
Route::get('/contracts', ContractManagement::class)->name('contracts');


/* Admin account role ------------------------------------------------------------------------------*/
// Route::middleware(['auth', 'checkrole:sa,admin'])->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// });




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
