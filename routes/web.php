<?php
Route::get('/', function () { return redirect('/admin/home'); });


// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('auth.login');
Route::post('login', 'Auth\LoginController@login')->name('auth.login');
Route::post('logout', 'Auth\LoginController@logout')->name('auth.logout');

Route::get('register/{confirmation_token?}', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
Route::post('register/verification', '\App\Http\Controllers\Auth\RegisterController@verification')
    ->name('register.verification');
Route::get('register/verification', '\App\Http\Controllers\Auth\RegisterController@verify')
    ->name('verification.index');
// resend the token
Route::match(['get', 'post'], 'register/verification/resend', '\App\Http\Controllers\Auth\RegisterController@resend')
    ->name('verification.resend');
// confirm and finish the registration process and log in the user
Route::get('register/confirmation/{token?}', '\App\Http\Controllers\Auth\RegisterController@confirmation')
    ->name('register.confirmation');

// Change Password Routes...
Route::get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
Route::patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.reset');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('auth.password.reset');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('/notification', 'HomeController@store')->name('notification.store');
    Route::get('reload_notifications', 'HomeController@reloadNotifications')->name('notification.reload');
    Route::resource('permissions', 'Admin\PermissionsController');
    Route::post('permissions_mass_destroy', ['uses' => 'Admin\PermissionsController@massDestroy', 'as' => 'permissions.mass_destroy']);
    Route::resource('roles', 'Admin\RolesController');
    Route::post('roles_mass_destroy', ['uses' => 'Admin\RolesController@massDestroy', 'as' => 'roles.mass_destroy']);
    Route::resource('users', 'Admin\UsersController');
    Route::post('users_mass_destroy', ['uses' => 'Admin\UsersController@massDestroy', 'as' => 'users.mass_destroy']);
    Route::resource('ships', 'Admin\ShipController');
    Route::post('ships_mass_destroy', ['uses' => 'Admin\ShipController@massDestroy', 'as' => 'ships.mass_destroy']);

});
