<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
|--------------------------------------------------------------------------
| Client Unauthenticated Routes
|--------------------------------------------------------------------------
 */
Route::prefix('aluno')->name('user.')->namespace('User')->group(
    function () {
        Route::get(
            '/',
            function () {
                return redirect(route('user.login'));
            }
        );

        Route::post('/login', 'Auth\LoginController@login')->name('login.post');
        Route::get('/login', 'Auth\RegisterController@showRegistrationForm')->name('login');

        Route::post('/password/confirm', 'Auth\ConfirmPasswordController@confirm')->name('password.confirm.post');
        Route::get('/password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');

        Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');

        Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
        Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

        Route::post('/register', 'Auth\RegisterController@register')->name('register.post');
        Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    }
);

/*
|--------------------------------------------------------------------------
| Client Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth:user')->group(
    function () {
        Route::get('/account', 'User\HomeController@index')->name('user.home');
        Route::post('/aluno/logout', 'User\Auth\LoginController@logout')->name('user.logout');

        Route::group(
            ['prefix' => '/checkout'],
            function () {
                Route::get('/', 'CheckoutController@index')->name('checkout.index');
                Route::get('/confirmation/{order}', 'CheckoutController@confirmation')->name('checkout.confirmation');
                Route::post('/payment', 'CheckoutController@payment')->name('checkout.payment');
                Route::post('/addCoupon', 'CheckoutController@addCoupon')->name('checkout.addCoupon');
            }
        );
    }
);

/*
|--------------------------------------------------------------------------
| Pages Routes
|--------------------------------------------------------------------------
 */

// Home
Route::get('/', 'PageController@home')->name('home');

// Search results
Route::get('/search', 'SearchController@search')->name('search');

// Route::get('/termos-de-uso', 'PageController@termos')->name('termos-de-uso');

// Course routes group
Route::group(
    ['prefix' => '/cursos'],
    function () {
        Route::get('/', 'CourseController@index')->name('courses.index');
        Route::get('/{category}', 'CourseController@category')->name('courses.category');
        Route::get('/{category}/{course}', 'CourseController@course')->name('courses.course_details');
    }
);

// Trail routes group
Route::group(
    ['prefix' => '/trilhas-conhecimento'],
    function () {
        Route::group(
            ['prefix' => '/{trilha}'],
            function () {
                Route::get('/', 'TrailController@show')->name('trails.show');
            }
        );
    }
);

// Cart routes group
Route::group(
    ['prefix' => '/cart'],
    function () {
        Route::get('/', 'CartController@index')->name('cart.index');
        Route::post('/remove/{type}/{id}', 'CartController@remove')->name('cart.remove');
        Route::post('/add', 'CartController@add')->name('cart.add');
    }
);

//Route::get('/pagarme/callback', 'PostbackController@callback')->name('pagarme.callback');

/*
|--------------------------------------------------------------------------
| AJAX Requests Routes
|--------------------------------------------------------------------------
*/
Route::group(
    ['prefix' => '/ajax'],
    function () {
        Route::group(
            ['prefix' => '/cart'],
            function () {
                Route::post('/remove/{type}/{id}', 'CartController@remove')->name('ajax.cart.remove');
                Route::post('/add', 'CartController@add')->name('ajax.cart.add');
            }
        );
        Route::post('/newsletter', 'Admin\NewsletterController@store')->name('ajax.newsletter.store');
        Route::post('/contact', 'Admin\ContactController@store')->name('ajax.newsletter.store');
    }
);

/*
|--------------------------------------------------------------------------
| CRON Jobs Routes
|--------------------------------------------------------------------------
*/
Route::group(
    ['prefix' => '/cron'],
    function () {
        Route::get('/load_api_files', 'IpedAPIController@load_api_files')->name('cronjobs.load_api_files');
        Route::get('/course_sync/{category}/{course}', 'CourseController@courseSync')->name('cronjobs.course_sync');
        Route::get('/category_sync/', 'CourseController@categorySync')->name('cronjobs.category_sync');
        Route::get('/category_courses_sync', 'CourseController@categoryCourses')->name(
            'cronjobs.category_courses_sync'
        );
    }
);
