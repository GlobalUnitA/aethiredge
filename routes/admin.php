
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Package\DeviceController;

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'login']);

Route::middleware(['web', 'admin'])->group(function () {

    Route::get('/', [AdminController::class, 'index'])->name('home');
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');

    Route::prefix('device')->group(function () {
        Route::get('list', [DeviceController::class, 'list'])->name('device.list');
        Route::get('view/{id}', [DeviceController::class, 'view'])->name('device.view');

        Route::get('update/{id}', [DeviceController::class, 'update'])->name('device.update');
    });
});