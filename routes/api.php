<?php

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


use App\Http\Controllers\api\MainCategoriesController;
use App\Http\Controllers\api\admin\AuthController;

use App\Http\Middleware\CheckPassword;


 Route::middleware(['changeLang', 'api'])->group(function () {
    Route::post('main_categories',[MainCategoriesController::class,'index']);
    Route::post('main_category_ById',[MainCategoriesController::class,'main_category_ById']);
    Route::post('main_category_active/{id}',[MainCategoriesController::class,'main_category_active']);

    Route::prefix('admin')->group(function () {
        Route::post('login',[AuthController::class,'login']);
        Route::post('logout',[AuthController::class,'logout'])->middleware('assign.guard:admin-api');
    });
    Route::prefix('user')->group(function () {
        Route::post('login',[App\Http\Controllers\api\user\AuthController::class,'login']);
        Route::post('logout',[App\Http\Controllers\api\user\AuthController::class,'logout'])->middleware('assign.guard:user-api');
    });

    Route::middleware(['assign.guard:user-api'])->prefix('user')->group(function () {
        Route::post('profile', function () {
            return 'hello this is profile only can user reach me';
        });

    });

});


Route::middleware(['api', 'checkAdminToken:admin-api'])->group(function () {

    Route::post('main_categories',[MainCategoriesController::class,'index']);

});



