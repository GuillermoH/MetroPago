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
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group([
    'middleware' => 'roles',
    'roles' => ['Admin'],
    'prefix' => '/admin'
],function() {
    Route::get('/', 'AdminController@index')->name('admin.home');
    Route::get('/users', 'AdminController@listUsers')->name('admin.listUsers');
    Route::get('/stores', 'AdminController@listStores')->name('admin.listStores');
    Route::delete('/admin/user/{user}', 'AdminController@userDestroy')->name('admin.userDestroy');
    Route::delete('/admin/store/{user}', 'AdminController@storeDestroy')->name('admin.storeDestroy');
    Route::get('/admin/user/create', 'AdminController@createUser')->name('admin.createUser');
    Route::post('/admin/user/store', 'AdminController@storeUser')->name('admin.storeUser');
    Route::get('/admin/store/create', 'AdminController@createStore')->name('admin.createStore');
    Route::post('/admin/store/store', 'AdminController@storeStore')->name('admin.storeStore');
});

Route::group([
    'middleware' => 'roles',
    'roles' => ['Store'],
    'prefix' => '/store'
],function() {
    Route::get('/', 'StoreController@index')->name('store.home');
});

Route::group([
    'middleware' => 'roles',
    'roles' => ['User'],
    'prefix' => '/user'
],function() {
    Route::get('/', 'UserController@index')->name('user.home');
});