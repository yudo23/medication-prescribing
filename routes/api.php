<?php

use Illuminate\Support\Facades\Route;

Route::group(["as" => "medicines.", "prefix" => "medicines"], function () {
	Route::get('/{id}/price', 'MedicineController@price')->name('price');
	Route::get('/', 'MedicineController@index')->name('index');
});

Route::group(["as" => "patient-records.", "prefix" => "patient-records"], function () {
	Route::get('/{id}', 'PatientRecordController@show')->name('show');
});