<?php

use Illuminate\Support\Facades\Route;

Route::group(["as" => "medicines.", "prefix" => "medicines"], function () {
	Route::get('/{id}/price', 'MedicineController@price')->name('price');
	Route::get('/', 'MedicineController@index')->name('index');
});