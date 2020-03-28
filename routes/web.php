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

Route::get('/', 'PageController@front')->name('home');


Route::post('access/grant', 'UserController@login');
Route::get('access/logout', 'UserController@logout');
Route::get('auth/{page}', 'PageController@auth');

//redirect to this route when site in maintenance
Route::get('/maintenance', 'PageController@maintenance');

Route::get('backoffice/{page}', 'PageController@back')->middleware('can:manage-site');
Route::get('backoffice/{page}/{action}', 'PageController@back')->middleware('can:manage-site');
Route::get('backoffice/{page}/{action}/{var}', 'PageController@back')->middleware('can:manage-site');

// upload route
Route::post('upload/{folder}', "FileUploadController@upload");

route::post('/maintenance/change', 'SiteSettingsController@changeMaintenanceMode');

// Service Route
Route::get('admin/services', 'ServiceController@fetchAll');
Route::post('admin/service/upsert', 'ServiceController@upsert');
Route::delete('admin/service/delete/{service}', 'ServiceController@delete');
Route::delete('admin/service/bulk_delete/{ids}', 'ServiceController@destroyMany');

// Profile Update Route
Route::post('admin/profile/update', 'UserController@update');

// Post Route
Route::get('admin/posts', 'PostController@fetchAll');
Route::post('admin/post/upsert', 'PostController@upsert');
Route::delete('admin/post/delete/{post}', 'PostController@delete');
Route::delete('admin/post/bulk_delete/{ids}', 'PostController@destroyMany');

// Category route
Route::get('admin/categories', 'CategoryController@fetch');
Route::post('admin/category/upsert', 'CategoryController@upsert');
Route::delete('admin/category/remove/{category}', 'CategoryController@remove');
Route::delete('admin/category/delete/bulk/{ids}', 'TagsController@destroyMany');


// Tag routes
Route::get('admin/tags', 'TagsController@fetch');
Route::post('tag/upsert', 'TagsController@upsert');
Route::delete('tag/remove/{tag}', 'TagsController@remove');
Route::delete('tag/delete/bulk/{ids}', 'TagsController@destroyMany');

// Contact routes
Route::get('admin/contacts', 'ContactsController@fetch');
Route::post('contact/send', 'ContactsController@send');
Route::delete('admin/contact/remove/{contact}', 'ContactsController@remove');
Route::delete('admin/contact/delete/bulk/{ids}', 'ContactsController@destroyMany');

// FAQs routes
Route::get('admin/faqs', 'FaqController@fetch');
Route::post('admin/faqs/upsert', 'FaqController@upsert');
Route::get('faqs/{faq_id}', 'FaqController@get');
Route::delete('admin/faqs/remove/{faq}', 'FaqController@remove');
Route::delete('admin/faqs/delete/bulk/{ids}', 'TagsController@destroyMany');

// Site info Routes
Route::post('site_info/update', 'SiteInfoController@update');

// Subscribers routes
Route::get('admin/subscribes', 'SubscriberController@fetch');
Route::post('subscriber/create', 'SubscriberController@create');
Route::delete('subscriber/remove/{subscriber}', 'SubscriberController@remove');
Route::delete('admin/subscriber/delete/bulk/{ids}', 'SubscriberController@destroyMany');


Route::get('/{page}', 'PageController@front');
Route::get('/{page}/{subPage}', 'PageController@front');
