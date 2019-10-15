<?php

// 页面
Route::get('/', 'StaticPagesController@home') -> name('home');
Route::get('/help', 'StaticPagesController@help') -> name('help');
Route::get('/about', 'StaticPagesController@about') -> name('about');

// 注册
Route::get('/signup', 'UsersController@create') -> name('signup');

// 注册邮件验证
Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');

// 用户
Route::resource('/users', 'UsersController');

// session
Route::get('/login', 'SessionController@create')->name('login');
Route::post('/login', 'SessionController@store')->name('login');
Route::delete('/logout', 'SessionController@destroy') -> name('logout');

// 密码重设
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
