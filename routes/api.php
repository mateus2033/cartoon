<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\BankDataController;
use App\Http\Controllers\BankController;
use App\Http\Middleware\ProtectedAdmRoute;
use App\Http\Middleware\ProtectedUserRoute;

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

Route::prefix('account/')->group(function () {
    Route::POST('login',  [AuthController::class, 'login']);
    Route::POST('storage',  [UserController::class, 'storage']);
    Route::POST('administrador', [AdministratorController::class, 'saveAdministrator']);
});

Route::prefix('/cartoon')->group(function () {
    Route::GET('index', [ProductController::class, 'indexOfProductForUser']);
});

Route::prefix('/administrator')->group(function () {
    Route::group(['middleware' => ['adminAuth']], function () {
        Route::POST('logout', [ProtectedAdmRoute::class, 'logout']);
        Route::GET('show', [AdministratorController::class, 'showAdministrator']);
        Route::PUT('update', [AdministratorController::class, 'updateAdministrator']);
        Route::DELETE('delete', [AdministratorController::class, 'destroyAdministrator']);
        Route::POST('updatePhotoPerfil', [AdministratorController::class, 'updatePicture']);
    });
});

Route::prefix('user/')->group(function () {
    Route::group(['middleware' => ['userAuth']], function () {
        Route::POST('logout', [ProtectedUserRoute::class, 'logout']);
        Route::GET('listUser',   [UserController::class, 'listUser']);
        Route::GET('show',       [UserController::class, 'show']);
        Route::PUT('update',     [UserController::class, 'update']);
        Route::DELETE('destroy', [UserController::class, 'destroy']);
        Route::DELETE('removePhoto',     [UserController::class, 'removePhotoPerfil']);
        Route::POST('updatePhotoPerfil', [UserController::class, 'updatePicture']);
    });
});

Route::prefix('address/')->group(function () {
    Route::group(['middleware' => ['userAuth']], function () {
        Route::POST('storage',   [AddressController::class, 'storage']);
        Route::GET('index',      [AddressController::class, 'index']);
        Route::PUT('update',     [AddressController::class, 'update']);
        Route::DELETE('destroy', [AddressController::class, 'destroy']);
    });
});

Route::prefix('product/')->group(function () {
    Route::group(['middleware' => ['adminAuth']], function () {
        Route::GET('index',      [ProductController::class, 'index']);
        Route::GET('show',       [ProductController::class, 'show']);
        Route::POST('storage',   [ProductController::class, 'storage']);
        Route::PUT('update',     [ProductController::class, 'update']);
        Route::DELETE('destroy', [ProductController::class, 'destroy']);
        Route::GET('indexMoreSold',      [ProductController::class, 'indexOfMoreSoldInMonth']);
    });
});

Route::prefix('bankdata/')->group(function () {
    Route::group(['middleware' => ['userAuth']], function () {
        Route::GET('index/{page}', [BankDataController::class, 'index'])->name('bank.data.index');
        Route::GET('show/{id}',  [BankDataController::class, 'show'])->name('bank.data.show');
        Route::POST('storage', [BankDataController::class, 'storage'])->name('bank.data.storage');
        Route::PUT('update',  [BankDataController::class, 'update'])->name('bank.data.update');
        Route::DELETE('delete', [BankDataController::class, 'delete'])->name('bank.data.delete');
    });
});

Route::prefix('bank/')->group(function () {
    Route::group(['middleware' => ['adminAuth']], function () {
        Route::GET('index', [BankController::class, 'index']);
        Route::POST('storage', [BankController::class, 'storage']);
        Route::PUT('update', [BankController::class, 'update']);
        Route::DELETE('delete', [BankController::class, 'delete']);
    });
});
