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

Auth::routes(['register' => false]);
Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('pub')->group(function () {
    Route::get('/assets/{id}/{keyword}', 'PublicController@index');
    Route::get('/assets/lists/{id}/{keyword}', 'PublicController@assets');
    Route::get('/devices/{id}/{keyword}', 'PublicController@devices');
    Route::get('/stations/lists', 'StationController@stations');
});

Route::middleware(['role:Administrator','auth'])->group(function () {
    Route::get('/staffs', 'StaffController@index'); 
    Route::get('/agencies', 'MemberController@index'); 
    Route::get('/lgus', 'MemberController@index1'); 
    Route::get('/lists', 'DropdownController@page'); 
    Route::get('/devices', 'DeviceController@index'); 
    Route::get('/trackers', 'DeviceController@index1'); 
});

Route::middleware(['role:Member','auth'])->group(function () {
    Route::get('/assets/list', 'AssetController@index'); 
    Route::get('/assets/list/{id}', 'AssetController@page'); 
    Route::get('/stations', 'StationController@index'); 
    Route::get('/search', 'AssetController@search'); 
});

//###########==========! REQUEST ROUTES !=========###########//

Route::prefix('request')->group(function () {

    Route::get('/dropdown/{classification}/{type}/{keyword}', 'DropdownController@index');
    Route::get('/dropdowns/{classification}/{type}', 'DropdownController@lists');
    Route::get('/dropdowncount/{classification}/{type}', 'DropdownController@count');
    Route::post('/dropdown/store', 'DropdownController@store');

    Route::middleware('auth')->group(function(){
        Route::get('/agency', 'HomeController@agency');
        Route::post('/user/password', 'HomeController@password');
        Route::get('/regions', 'HomeController@regions');
        Route::get('/provinces/{id}', 'HomeController@provinces');
        Route::get('/municipalities/{id}', 'HomeController@municipalities');
    });

    Route::prefix('admin')->group(function(){
        Route::get('/totals', 'AdminHomeController@total');

        Route::get('/users/{keyword}', 'StaffController@lists');
        Route::post('/user/store', 'StaffController@store');

        Route::get('/members/{keyword}', 'MemberController@lists');
        Route::post('/member/store', 'MemberController@store');
        Route::get('/member/lgu/{keyword}', 'MemberController@lgu');
        Route::get('/member/list', 'MemberController@list');

        Route::post('/device/store', 'DeviceController@store');
        Route::get('/devices/{keyword}/{status}/{type}', 'DeviceController@lists');
    });

    Route::prefix('member')->group(function(){

        Route::get('/totals', 'HomeMemberController@total');

        Route::get('/locations', 'StationController@list');
        Route::get('/location/lists/{keyword}', 'StationController@lists');
        Route::post('/location/store', 'StationController@store');

        Route::post('/asset/store', 'AssetController@store');
        Route::get('/assets/{keyword}', 'AssetController@index1');
        Route::get('/asset/{id}', 'AssetController@view'); 
        Route::get('/asset/{id}/purchased', 'AssetController@purchases'); 
        Route::post('/asset/locations', '\AssetController@locations'); 
        Route::post('/status/update', 'AssetController@status'); 
        Route::post('/quantity/update', 'AssetController@updateQuantity'); 

        Route::get('/lists/{id}/{keyword}', 'ListsController@index'); 
        Route::post('/tracker/store', 'ListsController@store'); 
        Route::post('/asset/update', 'ListsController@update'); 
        Route::get('/coordinates/{id}', 'ListsController@coordinates'); 
        Route::get('/assets/search/{keyword}', 'ListsController@search');
        Route::get('/assets/search2/{location}/{category}/{status}/{keyword}', 'ListsController@search2');
        Route::post('/status/up', 'ListsController@status'); 
        Route::get('/foraction/{type}', 'ListsController@check'); 

        Route::get('/logs/{id}', 'ListsController@logs'); 
        Route::get('/logs', 'ListsController@logsAll'); 
        
    });

});

Route::prefix('krad')->group(function () {
    Route::post('/api/login', 'Api\DeviceController@login');
    Route::post('/api/check', 'Api\DeviceController@check');
    Route::post('/api/devices', 'Api\DeviceController@devices');
    Route::post('/api/device/search', 'Api\DeviceController@search');
});