<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/notification', function () {
    $extract = \App\Extract::first();
    $transaction = $extract->transaction()->first();
    $sourceAccount = $extract->sourceAccount()->first();
    $sourceAccountPerson = null;
    $sourceAccountUser = null;

    if ($sourceAccount) {
        $sourceAccountPerson = $sourceAccount->person()->first();
        $sourceAccountUser = $sourceAccountPerson->user()->first();
    }

    $destinationAccount =  $extract->destinationAccount()->first();
    $destinationAccountPerson = null;
    $destinationAccountUser = null;

    if ($destinationAccount) {
        $destinationAccountPerson =  $destinationAccount->person()->first();
        $destinationAccountUser =  $destinationAccountPerson->user()->first();
    }

    return view('notification', [
        'extract'                  => $extract,
        'sourceAccount'            => $sourceAccount,
        'sourceAccountPerson'      => $sourceAccountPerson,
        'sourceAccountUser'        => $sourceAccountUser,
        'destinationAccount'       => $destinationAccount,
        'destinationAccountPerson' => $destinationAccountPerson,
        'destinationAccountUser'   => $destinationAccountUser,
        'transaction'              => $transaction
    ]);
});
