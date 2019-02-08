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


Auth::routes();

Route::get('/', 'ProfileController@index')->name('profile.index');
Route::get('/home', 'ProfileController@index')->name('profile.index');

#PROFILES##GET
Route::get('/user', 'ProfileController@index')->name('profile.index');
Route::get('/user/debit/history/{id}', 'ProfileController@history')->name('profile.debit.history');
Route::get('/user/debit/{id}', 'ProfileController@debit')->name('profile.debit');
//Route::get('/user/unpaid/{id}', 'ProfileController@get_total_unpaid')->name('profile.unpaid');
Route::get('/user/add', 'ProfileController@index_add_user')->name('profile.index.adduser');
Route::get('/user/delete/{id}', 'ProfileController@delete')->name('profile.delete');
Route::get('/user/all', 'ProfileController@get_all')->name('profile.get_all');

#PROFILES##POST
Route::post('/user/search', 'ProfileController@search')->name('profile.search');
Route::post('/user', 'ProfileController@store')->name('profile.store');
Route::post('/user/debit', 'ProfileController@debit_post')->name('profile.debit.post');

#ORDER##GET
Route::get('/order/add/{id}', 'OrderController@index')->name('order.add');
Route::get('/order/delete/{id}', 'OrderController@delete')->name('order.delete');
Route::get('/order/profile/history/{idx}', 'OrderController@get_all_by_idx')->name('profile.orders');
Route::get('/order/date/{idx}/{iduser}', 'ProfileController@order_filter')->name('order.filter');

#ORDER##POST
Route::post('/order', 'OrderController@store')->name('order.store');


#DEBITS##GET
Route::get('/debit/delete/{id}', 'OrderController@delete_debit')->name('debit.delete');
Route::get('/debit/date/{idx}/{iduser}', 'ProfileController@debit_filter')->name('debit.filter');