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


Route::get('enquiries/diary', 'EnquiryController@getdate')->name('enquiries.diary');
Route::resource('enquiries', 'EnquiryController');

//Auth::routes(['register'=>false]);
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('customers', 'CustomerController');

Route::get('customers/{customer_id}/contacts', 'ContactController@index');

//Route::get('customers/{customer_id}/contacts/create', 'ContactController@create')->name('contacts.create');
//Route::get('contacts/{id}/edit', 'ContactController@edit')->name('contacts.edit');
//Route::delete('contacts', 'ContactController@destroy')->name('contacts.destroy');
//Route::put('contacts/{id}', 'ContactController@update')->name('contacts.update');
//Route::post('customers/{customer_id}/contacts', 'ContactController@store')->name('contacts.store');
Route::resource('contacts', 'ContactController');
//placing this after means it overrides the standard create routes
Route::get('customers/{customer_id}/contacts/create', 'ContactController@create')->name('contacts.create');

Route::resource('parts', 'PartController');

Route::resource('groups', 'GroupController');