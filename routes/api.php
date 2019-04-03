<?php

use Illuminate\Http\Request;

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

Route::group(['middleware' => ['api']], function () {
    Route::post('v1/user-login', 'User\LoginController@login');
    Route::post('v1/supplier-login', 'Supplier\LoginController@login');
});

Route::group(['middleware' => ['api', 'manage_token:api_user,ROLE_USER_ADMIN|ROLE_USER_SALES']], function () {
    Route::post('v1/user/home', 'User\Profile\HomeController@home');
});

Route::group(['middleware' => ['api', 'manage_token:api_supplier,ROLE_SUPPLIER_ADMIN|ROLE_SUPPLIER_DESPATCH']], function () {
    Route::post('v1/supplier/home', 'Supplier\Profile\HomeController@home');
});

Route::group(['middleware' => ['api', 'manage_token:api_supplier|api_user,ROLE_SUPPLIER_ADMIN|ROLE_USER_ADMIN']], function () {
    Route::post('v1/admin/home', 'Global\Admin\HomeController@home');
});