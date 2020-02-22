<?php

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ],
    function(){ 

        Route::prefix('dashboard')->name('dashboard.')->middleware('auth')->group(function(){

            Route::get('/index', 'DashboardController@index')->name('index');
            
            // User Routes
            Route::resource('/users', 'UserController');
        
        
        }); // end of dashboard routes

    });

