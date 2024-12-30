<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
// uesr controllers

use App\Http\Controllers\HomeController;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

use App\Http\Controllers\Profile\ProfileController;

use App\Http\Controllers\Package\DeviceController;
use App\Http\Controllers\Package\StakingController;

use App\Http\Controllers\Bonus\DeviceBonusController;
use App\Http\Controllers\Bonus\StakingBonusController;

use App\Http\Controllers\Chart\RefChartController;
use App\Http\Controllers\Chart\AffChartController;

use App\Http\Controllers\Board\BoardController;

// admin controllers
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\User\UserController;

use App\Http\Controllers\Admin\Package\DeviceController as AdminDeviceController;
use App\Http\Controllers\Admin\Package\StakingController as AdminStakingController;

use App\Http\Controllers\Admin\Bonus\DeviceBonusController as AdminDeviceBonusController;
use App\Http\Controllers\Admin\Bonus\StakingBonusController as AdminStakingBonusController;

use App\Http\Controllers\Admin\Board\BoardController as AdminBoardController;



//use App\Http\Controllers\Policy\PolicyController;
//Route::get('policy', [PolicyController::class, 'store']);

Route::get('register/{mid?}', [RegisterController::class, 'index'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
Route::post('register/emailCheck', [RegisterController::class, 'emailCheck'])->name('register.emailCheck');

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('password/request', [ForgotPasswordController::class, 'index'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'index'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::middleware(['auth'])->group(function () {

    Route::get('test', [TestController::class, 'index'])->name('test');

    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::prefix('profile')->group(function() {
        Route::get('/', [ProfileController::class, 'index'])->name('profile');
        Route::post('update', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/password', [ProfileController::class, 'password'])->name('profile.password');
        Route::post('/password/update', [ProfileController::class, 'passwordUpdate'])->name('profile.password.update');
    });
    
    Route::prefix('device')->group(function () {
        Route::get('/', [DeviceController::class, 'index'])->name('device');
        Route::post('apply', [DeviceController::class, 'apply'])->name('device.apply');
        Route::post('store', [DeviceController::class, 'store'])->name('device.store');
        Route::get('list', [DeviceController::class, 'list'])->name('device.list');
    }); 

    Route::prefix('staking')->group(function () {
        Route::get('/', [StakingController::class, 'index'])->name('staking');
        Route::post('apply', [StakingController::class, 'apply'])->name('staking.apply');
        Route::post('store', [StakingController::class, 'store'])->name('staking.store');
        //Route::get('list', [StakingController::class, 'list'])->name('staking.list');
        Route::get('test', [StakingController::class, 'test'])->name('staking.test');
        
    });

    Route::prefix('bonus')->group(function () {
        Route::prefix('dvice')->group(function () {
            Route::get('/', [DeviceBonusController::class, 'index'])->name('bonus.device');
            Route::get('list/{mode}', [DeviceBonusController::class, 'list'])->name('bonus.device.list');
        });

        Route::prefix('staking')->group(function () {
            Route::post('/', [StakingBonusController::class, 'index'])->name('bonus.staking');
            Route::get('list/{mode}', [StakingBonusController::class, 'list'])->name('bonus.staking.list');
        }); 
    });

    Route::prefix('chart')->group(function () {
        Route::get('ref', [RefChartController::class, 'index'])->name('chart.ref');
        Route::get('aff', [AffChartController::class, 'index'])->name('chart.aff');
    });

    Route::prefix('board')->group(function () {
        Route::get('/{code}', [BoardController::class, 'list'])->name('board.list');
        Route::get('/{code}/{mode}/{id?}', [BoardController::class, 'view'])->name('board.view');
        Route::post('/write', [BoardController::class, 'write'])->name('board.write');
        Route::post('/modify', [BoardController::class, 'modify'])->name('board.modify');
        Route::post('/delete/{code}/{id}', [BoardController::class, 'delete'])->name('board.delete');
    });
});

Route::middleware(['admin.auth'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin');

        Route::prefix('user')->group(function () {
            Route::get('list', [UserController::class, 'list'])->name('admin.user.list');
            Route::get('view/{id}', [UserController::class, 'view'])->name('admin.user.view');
            Route::post('update', [UserController::class, 'update'])->name('admin.user.update');
            Route::get('export', [UserController::class, 'export'])->name('admin.user.export');
        });

        Route::prefix('device')->group(function () {
            Route::get('list', [AdminDeviceController::class, 'list'])->name('admin.device.list');
            Route::get('view/{id}', [AdminDeviceController::class, 'view'])->name('admin.device.view');
            Route::post('status', [AdminDeviceController::class, 'status'])->name('admin.device.status');
            Route::post('update', [AdminDeviceController::class, 'update'])->name('admin.device.update');
            Route::prefix('bonus')->group(function () {
                Route::get('list', [AdminDeviceBonusController::class, 'list'])->name('admin.device.bonus.list');
                Route::get('view/{id}', [AdminDeviceBonusController::class, 'view'])->name('admin.device.bonus.view');
            });
        });

        Route::prefix('staking')->group(function () {
            Route::get('list', [AdminStakingController::class, 'list'])->name('admin.staking.list');
            Route::get('view/{id}', [AdminStakingController::class, 'view'])->name('admin.staking.view');
            Route::post('status', [AdminStakingController::class, 'status'])->name('admin.staking.status');
            Route::post('update', [AdminStakingController::class, 'update'])->name('admin.staking.update');
            Route::post('test', [AdminStakingController::class, 'test'])->name('admin.staking.test');
            Route::post('delete', [AdminStakingController::class, 'delete'])->name('admin.staking.delete');
            Route::prefix('bonus')->group(function () {
                Route::get('list', [AdminStakingBonusController::class, 'list'])->name('admin.staking.bonus.list');
                Route::get('view/{id}', [AdminStakingBonusController::class, 'view'])->name('admin.staking.bonus.view');
            });
        });

        Route::prefix('board')->group(function () {
            Route::get('/{code}', [AdminBoardController::class, 'list'])->name('admin.board.list');
            Route::get('/{code}/{mode}/{id?}', [AdminBoardController::class, 'view'])->name('admin.board.view');
            Route::post('/write', [AdminBoardController::class, 'write'])->name('admin.board.write');
            Route::post('/comment', [AdminBoardController::class, 'comment'])->name('admin.board.comment');
            Route::post('/modify', [AdminBoardController::class, 'modify'])->name('admin.board.modify');
            Route::post('/delete', [AdminBoardController::class, 'delete'])->name('admin.board.delete');
        });  
    });
});