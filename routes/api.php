<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * Routes with middleware
 */
Route::group(['middleware' => ['auth:api']], function () {

    Route::prefix('accounts')->group(function () {
        Route::patch('debits', 'AccountController@debit');
        Route::patch('credits', 'AccountController@credit');
        Route::patch('transfers', 'AccountController@transfer');
    });

    Route::patch('accounts/restore', 'AccountController@restore');
    Route::resource('accounts', 'AccountController');

    Route::patch('addresses/restore', 'AddressController@restore');
    Route::resource('addresses', 'AddressController');

    Route::get('auth/logout', 'AuthController@logout');
    Route::get('auth/user', 'AuthController@user');

    Route::patch('extracts/restore', 'ExtractController@restore');
    Route::resource('extracts', 'ExtractController');

    Route::patch('people/restore', 'PersonController@restore');
    Route::resource('people', 'PersonController');

    Route::patch('transactions/restore', 'TransactionController@restore');
    Route::resource('transactions', 'TransactionController');

    Route::resource('users', 'UserController');
});

/**
 * Routes without middleware
 */
Route::group([], function () {
    Route::post('auth/login', 'AuthController@login');
    Route::post('auth/signup', 'AuthController@signup');
});
