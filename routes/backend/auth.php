<?php

use App\Domains\Auth\Http\Controllers\Backend\Auth\Role\RoleController;
use App\Domains\Auth\Http\Controllers\Backend\Auth\User\UserController;
use App\Domains\Auth\Http\Controllers\Backend\Auth\User\DeletedUserController;

// All route names are prefixed with 'admin.auth'.
Route::group([
    'prefix' => 'auth',
    'as' => 'auth.',
    'middleware' => ['permission:access.*', 'password.confirm:frontend.auth.password.confirm'],
], function () {
    // User Management
    Route::group(['prefix' => 'user', 'middleware' => 'permission:access.users.*'], function () {
//        Route::get('deactivated', [UserStatusController::class, 'getDeactivated'])->name('user.deactivated');
        Route::get('deleted', [DeletedUserController::class, 'index'])->name('user.deleted')
            ->middleware('permission:access.users.delete|access.users.restore|access.users.permanently-delete');

        Route::get('/', [UserController::class, 'index'])->name('user.index')->middleware('permission:access.users.read');
        Route::get('create', [UserController::class, 'create'])->name('user.create')->middleware(['permission:access.users.create']);
        Route::post('/', [UserController::class, 'store'])->name('user.store')->middleware(['permission:access.users.create']);

        Route::group(['prefix' => '{user}'], function () {
            Route::get('/', [UserController::class, 'show'])->name('user.show')->middleware('permission:access.users.read');
            Route::get('edit', [UserController::class, 'edit'])->name('user.edit')->middleware('permission:access.users.update');
            Route::patch('/', [UserController::class, 'update'])->name('user.update')->middleware('permission:access.users.update');
            Route::delete('/', [UserController::class, 'destroy'])->name('user.destroy')->middleware('permission:access.users.delete');


//            Route::get('mark/{status}', [UserStatusController::class, 'mark'])->name('user.mark')->where(['status' => '[0,1]']);
        });

        Route::group(['prefix' => '{deletedUser}'], function () {
            Route::get('restore', [DeletedUserController::class, 'update'])->name('user.restore')->middleware('permission:access.users.restore');

            if (config('boilerplate.access.users.permanently_delete')) {
                Route::delete('permanently-delete', [DeletedUserController::class, 'destroy'])
                    ->name('user.permanently-delete')
                    ->middleware('permission:access.users.permanently-delete');
            }
        });
    });

    // Role Management
    Route::group(['prefix' => 'role', 'middleware' => 'permission:access.roles.*'], function () {
        Route::get('/', [RoleController::class, 'index'])->name('role.index')->middleware('permission:access.roles.read');
        Route::get('create', [RoleController::class, 'create'])->name('role.create')->middleware(['permission:access.roles.create']);
        Route::post('/', [RoleController::class, 'store'])->name('role.store')->middleware('permission:access.roles.create');

        Route::group(['prefix' => '{role}'], function () {
            Route::get('edit', [RoleController::class, 'edit'])->name('role.edit')->middleware('permission:access.roles.update');
            Route::patch('/', [RoleController::class, 'update'])->name('role.update')->middleware('permission:access.roles.update');
            Route::delete('/', [RoleController::class, 'destroy'])->name('role.destroy')->middleware('permission:access.roles.delete');
        });
    });
});
