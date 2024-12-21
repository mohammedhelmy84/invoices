<?php

use App\Http\Controllers\InvoicesAttachmentsController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoicesDetailsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('auth.login');
});

Route::get('/m', function () {
    return "hello";
});



Route::get('/modals', function () {
    return view('modals');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Auth::routes();
// Auth::routes(['register'=>false]);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('invoices', InvoicesController::class);

Route::resource('sections', SectionController::class);
Route::get('/section/{id}', [InvoicesController::class, 'getproducts']);

Route::resource('products', ProductController::class);
// Route::get('new', function(){
//     return "hello";
// });

Route::get('invoices_details/{id}', [InvoicesDetailsController::class,'edit']);

Route::get('view_file/{invoice_number}/{file_name}', [InvoicesDetailsController::class,'open_file'])->name('view_file');

Route::get('download_file/{invoice_number}/{file_name}', [InvoicesDetailsController::class,'download_file'])->name('download_file');

Route::post('delete_file', [InvoicesDetailsController::class,'destroy'])->name('delete_file');
Route::resource('invoice_attachments', InvoicesAttachmentsController::class);
Route::get('edit/{id}', [InvoicesController::class,'edit'])->name('invoice.edit');
Route::delete('delete/{id}', [InvoicesController::class,'destroy'])->name('invoice.destroy');




require __DIR__.'/auth.php';
