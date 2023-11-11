<?php

use App\Http\Controllers\api\apiAuthController;
use App\Http\Controllers\api\ApiInvoicesController;
use App\Http\Controllers\api\apiProductController;
use App\Http\Controllers\api\ApiSectionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::middleware(['auth'.'verified'],)


// Route::get('products', [apiProductController::class, 'index'])->middleware('auth.sanctum');


// login/register

Route::any('login', [apiAuthController::class, 'login']);
Route::any('register', [apiAuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {


    Route::any('profile', [apiAuthController::class, 'profile']);
    Route::post('update', [apiAuthController::class, 'update']);
    Route::get('show_all', [apiAuthController::class, 'show_all']);
    Route::delete('destory/{id}', [apiAuthController::class, 'destory']);




    // invoices
    Route::get('apinvoices', [ApiInvoicesController::class, 'index']);
    Route::post('apinvoice', [ApiInvoicesController::class, 'store']);
    Route::get('apinvoice/{id}', [ApiInvoicesController::class, 'show']);
    Route::post('apinvoice/{id}', [ApiInvoicesController::class, 'update']);
    Route::delete('archive/{id}', [ApiInvoicesController::class, 'archive']);
    Route::delete('apinvoice/{id}', [ApiInvoicesController::class, 'destroy']);


    // section
    Route::get('sections', [ApiSectionController::class, 'index']);
    Route::post('sections', [ApiSectionController::class, 'store']);
    Route::get('section/{id}', [ApiSectionController::class, 'show']);
    Route::post('section/{id}', [ApiSectionController::class, 'update']);
    Route::delete('section/{id}', [ApiSectionController::class, 'destroy']);


    // product
    Route::any('products', [apiProductController::class, 'index']);
    Route::post('product', [apiProductController::class, 'store']);
    Route::get('product/{id}', [apiProductController::class, 'show']);
    Route::post('product/{id}', [apiProductController::class, 'update']);
    Route::delete('product/{id}', [apiProductController::class, 'destroy']);
});
