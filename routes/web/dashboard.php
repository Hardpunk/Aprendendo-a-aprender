<?php

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::prefix('painel')->name('admin.')->group(
    function () {
        Route::namespace('Admin')->group(
            function () {
                Route::middleware('guest:admin')->group(
                    function () {
                        Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
                        Route::post('/login', 'Auth\LoginController@login')->name('auth_login');

                        Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')
                            ->name('password.request');

                        Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')
                            ->name('password.email');

                        Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')
                            ->name('password.reset');

                        Route::post('/password/reset', 'Auth\ResetPasswordController@reset')
                            ->name('password.update');

                        Route::fallback(function() {
                            return redirect(route('admin.login'));
                        });
                    }
                );

                Route::middleware('auth:admin')->group(
                    function () {
                        Route::get('/', 'HomeController@index')->name('home');
                        Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
                        Route::prefix('users')->group(
                            function () {
                                Route::get('/', 'UserController@index')->name('users.index');
                                Route::get('/registered', 'UserController@registered')->name('users.registered');
                                Route::get('/unregistered', 'UserController@unregistered')->name('users.unregistered');
                            }
                        );
                        Route::resource('payments', 'PaymentController')->only(['index', 'show']);
                        Route::resource('coupons', 'CouponController');
                        Route::resource('banners', 'BannerController');
                        Route::resource('newsletters', 'NewsletterController')->only(['index', 'destroy']);
                        Route::resource('contacts', 'ContactController')->only(['index', 'show', 'destroy']);

                        Route::fallback(function() {
                            return redirect(route('admin.home'));
                        });
                    }
                );
            }
        );
    }
);
