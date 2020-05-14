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

Route::get('/', "Home@index");

// All owners display
Route::get('/owners', "Owners@index");

// Owner Entry
Route::get('/owners/create', "Owners@create");
Route::post('/owners/create', "Owners@createOwner");

// 1 owner display
Route::get('/owners/{owner}', "Owners@show");
