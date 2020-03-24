<?php

Route::group(['middleware' => 'web', 'prefix' => 'admin'], function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::group(['namespace' => 'ThallesTeodoro\BaseAdmin\App\Http\Controllers\Admin', 'middleware' => 'web' ], function () {
            // login
            Route::get('login', 'AuthenticationController@index')->name('admin.login');
            Route::post('login', 'AuthenticationController@auth')->name('admin.login.submit');

            // forgot-password
            Route::get('forgot-password', 'ForgotPasswordController@showLinkRequestForm')->name('admin.forgot-password');
            Route::post('forgot-password', 'ForgotPasswordController@sendResetLinkEmail')->name('admin.forgot-password.submit');

            // reset-password
            Route::get('reset-password/{token}', 'ResetPasswordController@showResetForm')->name('admin.reset-password');
            Route::post('reset-password', 'ResetPasswordController@reset')->name('admin.reset-password.submit');
        });
    });

    Route::group(['middleware' => 'auth'], function () {
        Route::group(['namespace' => 'ThallesTeodoro\BaseAdmin\App\Http\Controllers\Admin', 'middleware' => 'web' ], function () {
            // dashboard
            Route::get('/','DashboardController@index')->name('admin.dashboard');

            // logout
            Route::post('logout', 'AuthenticationController@logout')->name('admin.logout');

            // users
            Route::resource('users', 'UsersController', ['as' => 'admin'])->except('show');

            // profile
            Route::get('profile', 'ProfileController@edit')->name('admin.profile.edit');
            Route::put('profile/{id}', 'ProfileController@update')->name('admin.profile.update');
        });
    });
});
