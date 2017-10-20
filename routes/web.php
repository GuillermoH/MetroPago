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
    /*
     * User related routes
     */
    Route::get('/users', 'AdminController@listUsers')->name('admin.listUsers');
    Route::delete('/user/{user}', 'AdminController@userDestroy')->name('admin.userDestroy');
    Route::get('/user/create', 'AdminController@createUser')->name('admin.createUser');
    Route::post('/user/store', 'AdminController@storeUser')->name('admin.storeUser');
    Route::get('/user/{user}/edit', 'AdminController@editUser')->name('admin.editUser');
    Route::put('/user/{user}', 'AdminController@updateUser')->name('admin.updateUser');

    Route::post('/user/{user}/deposit', 'AdminController@addFunds')->name('admin.depositUser');
    /*
     * Store related routes
     */
    Route::get('/stores', 'AdminController@listStores')->name('admin.listStores');
    Route::delete('/store/{user}', 'AdminController@storeDestroy')->name('admin.storeDestroy');
    Route::get('/store/create', 'AdminController@createStore')->name('admin.createStore');
    Route::post('/store/store', 'AdminController@storeStore')->name('admin.storeStore');
    Route::get('/store/{user}/edit', 'AdminController@editStore')->name('admin.editStore');
    Route::put('/store/{user}', 'AdminController@updateStore')->name('admin.updateStore');
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