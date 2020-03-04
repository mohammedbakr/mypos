<?php

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ],
    function(){ 

        Route::prefix('dashboard')->name('dashboard.')->middleware('auth')->group(function(){

            // Dashboard Route
            Route::get('/', 'WelcomeController@index')->name('welcome');

            // Category Routes
            Route::resource('/categories', 'CategoryController');

            // Product Routes
            Route::resource('/products', 'ProductController');

            // Client Routes
            Route::resource('/clients', 'ClientController');
            Route::resource('/clients.orders', 'client\OrderController');

            // User Routes
            Route::resource('/users', 'UserController');

        
        }); // end of dashboard routes

    });

