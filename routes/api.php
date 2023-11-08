<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\BankDataController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\EnterpriseController;
use App\Http\Middleware\ProtectedAdmRoute;
use App\Http\Middleware\ProtectedUserRoute;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('account/')->group(function () {
    Route::POST('login',  [AuthController::class, 'login'])->name('login');
    Route::POST('storage',  [UserController::class, 'storage'])->name('save.user');
    Route::POST('administrador', [AdministratorController::class, 'saveAdministrator'])->name('save.administrator');
});

Route::prefix('/cartoon')->group(function () {
    Route::GET('index', [ProductController::class, 'indexOfProductForUser']);
});

Route::prefix('/administrator')->group(function () {
    Route::group(['middleware' => ['adminAuth']], function () {
        Route::GET('logout', [ProtectedAdmRoute::class, 'logout'])->name('logout.administrator');
        Route::GET('show', [AdministratorController::class, 'showAdministrator'])->name('show.administrator');
        Route::PUT('update', [AdministratorController::class, 'updateAdministrator'])->name('update.administrator');
        Route::DELETE('delete', [AdministratorController::class, 'destroyAdministrator'])->name('delete.administrator');
        Route::POST('updatePhotoPerfil', [AdministratorController::class, 'updatePicture'])->name('update.photo.perfil.administrator');
    });
});

Route::prefix('user/')->group(function () {
    Route::group(['middleware' => ['userAuth']], function () {
        Route::GET('logout', [ProtectedUserRoute::class, 'logout'])->name('logout.user');
        Route::GET('listUser',   [UserController::class, 'listUser'])->name('list.user');
        Route::GET('show',       [UserController::class, 'show'])->name('show.user');
        Route::PUT('update',     [UserController::class, 'update'])->name('update.user');
        Route::DELETE('destroy', [UserController::class, 'destroy'])->name('destroy.user');
        Route::DELETE('removePhoto',     [UserController::class, 'removePhotoPerfil'])->name('remove.photo.user');
        Route::POST('updatePhotoPerfil', [UserController::class, 'updatePicture'])->name('update.photo.perfil.user');
    });
});

Route::prefix('address/')->group(function () {
    Route::group(['middleware' => ['userAuth']], function () {
        Route::POST('storage',   [AddressController::class, 'storage'])->name('address.storage');
        Route::GET('index',      [AddressController::class, 'index'])->name('address.index');
        Route::PUT('update',     [AddressController::class, 'update'])->name('address.update');
        Route::DELETE('destroy', [AddressController::class, 'destroy'])->name('address.destroy');
    });
});

Route::prefix('product/')->group(function () {
    Route::group(['middleware' => ['adminAuth']], function () {
        Route::GET('index',      [ProductController::class, 'index'])->name('product.index');
        Route::GET('show/{id}',[ProductController::class, 'show'])->name('product.show');
        Route::POST('storage',   [ProductController::class, 'storage'])->name('product.storage');
        Route::PUT('update',     [ProductController::class, 'update'])->name('product.update');
        Route::DELETE('destroy', [ProductController::class, 'destroy'])->name('product.destroy');
        Route::GET('indexMoreSold', [ProductController::class, 'indexOfMoreSoldInMonth'])->name('product.index.more.sold');
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
        Route::GET('index/{page}', [BankController::class, 'index'])->name('index.bank');
        Route::POST('storage', [BankController::class, 'storage'])->name('storage.bank');
        Route::PUT('update', [BankController::class, 'update'])->name('update.bank');
        Route::DELETE('delete', [BankController::class, 'delete'])->name('delete.bank');
    });
});


Route::prefix('enterprise/')->group(function () {
    Route::group(['middleware' => []], function () {
        Route::GET('show/{id}', [EnterpriseController::class, 'show'])->name('show.enterprise');
        Route::POST('storage', [EnterpriseController::class, 'storage'])->name('storage.enterprise');
        Route::PUT('update', [EnterpriseController::class, 'update'])->name('update.enterprise');
        Route::DELETE('delete', [EnterpriseController::class, 'delete'])->name('delete.enterprise');
    });
});
