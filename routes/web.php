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
Route::get('enquiries/{id}/downloadPDF', 'EnquiryController@downloadPDF');

Route::resource('enquiries', 'EnquiryController');

Route::get('contracts/{id}/downloadPDF', 'ContractController@downloadPDF');
Route::resource('contracts', 'ContractController');

Route::resource('contractitems', 'ContractItemsController');
Route::get('contract/{contract_id}/contractitems/create', 'ContractItemsController@create')->name('contractitems.create');

Route::resource('repairs', 'RepairController');
Route::get('repairs/{id}/downloadPDF', 'RepairController@downloadPDF');
Route::post('repairs/emailPDF', 'RepairController@emailPDF')->name('repair.emailpdf');

Route::resource('repairitems', 'RepairItemController');
Route::get('repair/{repair_id}/repairitems/create', 'RepairItemController@create')->name('repairitems.create');

Auth::routes(['register'=>false]);
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Route::get('customers/{customer_id}/contacts/create', 'ContactController@create')->name('contacts.create');
//Route::get('contacts/{id}/edit', 'ContactController@edit')->name('contacts.edit');
//Route::delete('contacts', 'ContactController@destroy')->name('contacts.destroy');
//Route::put('contacts/{id}', 'ContactController@update')->name('contacts.update');
//Route::post('customers/{customer_id}/contacts', 'ContactController@store')->name('contacts.store');
//Route::resource('contacts', 'ContactController');
//placing this after means it overrides the standard create routes

Route::resource('parts', 'PartController');

Route::resource('groups', 'GroupController');
Route::get('groups/{id}/edit', 'GroupController@zedit')->name('zohogroups.edit');

Route::get('/signin', 'OAuth2Controller@signin');
Route::get('/authorize', 'OAuth2Controller@gettoken');

Route::resource('zohocontacts', 'ZohoController');
Route::get('contacts/{id}/edit', 'ZohoController@zedit')->name('zohocontacts.edit');
//fetches from zoho
Route::get('/zohocontacts', 'ZohoController@contacts')->name('zohocontacts');
Route::get('/zohoparts', 'PartController@parts')->name('zohoparts');
Route::get('/zohogroups', 'GroupController@groups')->name('zohogroups');
//fetches from db
Route::get('/contacts', 'ZohoController@index')->name('zohocontacts.index');
Route::get('/contacts/customers', 'ZohoController@customerindex')->name('zohocontacts.customerindex');
Route::get('/contacts/vendors', 'ZohoController@vendorindex')->name('zohocontacts.vendorindex');
Route::get('/parts', 'PartController@index')->name('zohoparts.index');
Route::get('/groups', 'GroupController@index')->name('zohogroups.index');

//Route::post('contacts/{id}/update', 'ZohoController@zupdate')->name('zohocontacts.update');