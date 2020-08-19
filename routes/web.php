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


Route::any('/HotelSystem/{user}/{ssid}/{isid}', 'HotelDatabaseController@index');
Route::post('/SearchHotel', 'HotelDatabaseController@SearchHotel');
Route::post('/ChkCountry', 'HotelDatabaseController@ChkCountry');
Route::post('/SearchHotelENT', 'HotelDatabaseController@SearchHotelENT');
Route::any('/viewHotel/{Hotelid}/{ssid}/{isid}', 'HotelDatabaseController@viewHotel');
Route::any('/addHotel/{ssid}/{isid}', 'HotelDatabaseController@addHotel');
Route::post('/SaveNewHotel', 'HotelDatabaseController@SaveNewHotel');
Route::any('/ViewEditHotel/{Hotelid}/{ssid}/{isid}', 'HotelDatabaseController@ViewEditHotel');
Route::any('/SaveEditHotel', 'HotelDatabaseController@SaveEditHotel');
Route::any('/ViewRoomCategory/{Hotelid}/{ssid}/{isid}', 'HotelDatabaseController@ViewRoomCategory');
Route::post('/SaveRoomcat', 'HotelDatabaseController@SaveRoomcat');
Route::post('/SearchRoomMaster', 'HotelDatabaseController@SearchRoomMaster');
Route::post('/DelRoomcat', 'HotelDatabaseController@DelRoomcat');
Route::any('/AddNewRate/{Hotelid}/{ssid}/{isid}', 'HotelDatabaseController@AddNewRate');
Route::post('/SaveNewRate', 'HotelDatabaseController@SaveNewRate');
