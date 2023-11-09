<?php

use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImgController;
use App\Http\Controllers\InvoicesAttachmentController;
use App\Http\Controllers\InvoicesDetalisController;
use App\Http\Controllers\InvoivicesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;


use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Models\invoices_attachment;
use App\Models\invoices_detalis;
use App\Models\Invoivices;
use Faker\Guesser\Name;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Invoices_ReportController;
use App\Http\Controllers\RoleController;


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

Route::fallback(function () {
    return view('404');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('home', HomeController::class);

    // الصلاحيات
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);


    Route::resource('invoices', InvoivicesController::class);
    Route::resource('section', SectionController::class);
    Route::resource('products', ProductController::class);


    Route::get('invouce_report', [Invoices_ReportController::class, 'index']);
    Route::get('/Search_invoices', [Invoices_ReportController::class, 'Search_invoices'])->name('Search_invoices');

    Route::get('/customer_search', [Invoices_ReportController::class, 'customer_search'])->name('customer_search');
    Route::get('/Customer', [Invoices_ReportController::class, 'Customer'])->name('Customer');
    Route::post('/get-products-by-section', [InvoivicesController::class, 'getProductsBySection'])->name('getProductsBySection');

    Route::resource('detalis', InvoicesDetalisController::class);

    Route::get('download/{file_name}/{file_num}', [InvoicesDetalisController::class, 'download']);

    Route::get('viwe/{file_name}/{file_num}', [InvoicesDetalisController::class, 'open_file']);

    Route::post('delete_file', [InvoicesDetalisController::class, 'destroy'])->name('delete_file');

    Route::resource('invattachment', InvoicesAttachmentController::class);


    Route::get('Status_show', [InvoivicesController::class, 'status'])->name('Status_show');
    Route::post('Status_Update', [InvoivicesController::class, 'Status_Update'])->name('Status_Update');
    Route::get('show_invoices_status/{id}', [InvoivicesController::class, 'show_invoices_status'])->name('show_invoices_status');
    Route::resource('Archive', ArchiveController::class);
    Route::get('Print_invoice/{id}', [InvoivicesController::class, 'Print_invoice']);
    Route::get('export_invoices', [InvoivicesController::class, 'export'])->name('export_invoices');
    Route::get('read_all', [InvoivicesController::class, 'read_all'])->name('read_all');
    Route::get('markAsRead/{v_id}/{n_id}', [InvoicesDetalisController::class, 'markAsRead']);
    Route::get('delete_notifiction', [InvoicesDetalisController::class, 'delete_notifiction']);

    Route::resource('add_img', ImgController::class);
});


Route::get('test', function () {
    return view('icons');
});
