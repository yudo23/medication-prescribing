<?php

use Illuminate\Support\Facades\Route;
use App\Enums\RoleEnum;

Route::group(["as" => "auth.", "prefix" => "auth", "namespace" => "Auth"], function () {

    Route::group(["as" => "login.", "prefix" => "login"], function () {
        Route::get('/', 'LoginController@index')->name('index');
        Route::post('/', 'LoginController@post')->name('post');
    });

    Route::get('/logout', 'LogoutController@logout')->name("logout")->middleware(["auth"]);
});

Route::group(['middleware' => ['auth', 'dashboard.access']], function () {
    Route::impersonate();

    Route::get('/', 'DashboardController@index')->name('index')->middleware(['role:' . implode('|', [RoleEnum::ADMINISTRATOR,RoleEnum::DOKTER,RoleEnum::APOTEKER])]);

    Route::get('notification', 'NotificationController@notification')->name('notification')->middleware(['role:' . implode('|', [RoleEnum::ADMINISTRATOR,RoleEnum::DOKTER,RoleEnum::APOTEKER])]);
    Route::get('notification/read/{id}', 'NotificationController@notificationRead')->name('notification.read')->middleware(['role:' . implode('|', [RoleEnum::ADMINISTRATOR,RoleEnum::DOKTER,RoleEnum::APOTEKER])]);
    Route::get('notification/markAsRead', 'NotificationController@markAsRead')->name('notification.markAsRead')->middleware(['role:' . implode('|', [RoleEnum::ADMINISTRATOR,RoleEnum::DOKTER,RoleEnum::APOTEKER])]);

    Route::group(["as" => "profile.", "prefix" => "profile"], function () {
        Route::get('/', 'ProfileController@index')->name("index")->middleware(['role:' . implode('|', [RoleEnum::ADMINISTRATOR,RoleEnum::DOKTER,RoleEnum::APOTEKER])]);
        Route::post('/update', 'ProfileController@update')->name("update")->middleware(['role:' . implode('|', [RoleEnum::ADMINISTRATOR,RoleEnum::DOKTER,RoleEnum::APOTEKER])]);
        Route::post('/updateAvatar', 'ProfileController@updateAvatar')->name("updateAvatar")->middleware(['role:' . implode('|', [RoleEnum::ADMINISTRATOR,RoleEnum::DOKTER,RoleEnum::APOTEKER])]);
        Route::post('/updatePassword', 'ProfileController@updatePassword')->name("updatePassword")->middleware(['role:' . implode('|', [RoleEnum::ADMINISTRATOR,RoleEnum::DOKTER,RoleEnum::APOTEKER])]);
    });

    Route::group(["as" => "log-users.", "prefix" => "log-users"], function () {
        Route::get('/', 'LogUserController@index')->name("index")->middleware(['role:' . implode('|', [RoleEnum::ADMINISTRATOR])]);
    });

    Route::group(["as" => "users.", "prefix" => "users"], function () {
        Route::get('/{id}/impersonate', 'UserController@impersonate')->name("impersonate")->middleware(['role:' . implode('|', [RoleEnum::ADMINISTRATOR])]);
        Route::put('/{id}/restore', 'UserController@restore')->name("restore")->middleware(['role:' . implode('|', [RoleEnum::ADMINISTRATOR])]);
        Route::get('/', 'UserController@index')->name("index")->middleware(['role:' . implode('|', [RoleEnum::ADMINISTRATOR])]);
        Route::get('/create', 'UserController@create')->name("create")->middleware(['role:' . implode('|', [RoleEnum::ADMINISTRATOR])]);
        Route::get('/{id}', 'UserController@show')->name("show")->middleware(['role:' . implode('|', [RoleEnum::ADMINISTRATOR])]);
        Route::get('/{id}/edit', 'UserController@edit')->name("edit")->middleware(['role:' . implode('|', [RoleEnum::ADMINISTRATOR])]);
        Route::post('/', 'UserController@store')->name("store")->middleware(['role:' . implode('|', [RoleEnum::ADMINISTRATOR])]);
        Route::put('/{id}', 'UserController@update')->name("update")->middleware(['role:' . implode('|', [RoleEnum::ADMINISTRATOR])]);
        Route::delete('/{id}', 'UserController@destroy')->name("destroy")->middleware(['role:' . implode('|', [RoleEnum::ADMINISTRATOR])]);
    });

    Route::group(["as" => "log-users.", "prefix" => "log-users"], function () {
        Route::get('/', 'LogUserController@index')->name("index")->middleware(['role:' . implode('|', [RoleEnum::ADMINISTRATOR])]);
    });

    Route::group(["as" => "patient-records.", "prefix" => "patient-records"], function () {
        Route::get('/{Id}/print-invoice', 'PatientRecordController@printInvoice')->name("print-invoice")->middleware(['role:' . implode('|', [RoleEnum::ADMINISTRATOR,RoleEnum::DOKTER])]);
        Route::get('/', 'PatientRecordController@index')->name("index")->middleware(['role:' . implode('|', [RoleEnum::ADMINISTRATOR,RoleEnum::DOKTER,RoleEnum::APOTEKER])]);
        Route::get('/create', 'PatientRecordController@create')->name("create")->middleware(['role:' . implode('|', [RoleEnum::ADMINISTRATOR,RoleEnum::DOKTER])]);
        Route::get('/{id}', 'PatientRecordController@show')->name("show")->middleware(['role:' . implode('|', [RoleEnum::ADMINISTRATOR,RoleEnum::DOKTER,RoleEnum::APOTEKER])]);
        Route::get('/{id}/edit', 'PatientRecordController@edit')->name("edit")->middleware(['role:' . implode('|', [RoleEnum::ADMINISTRATOR,RoleEnum::DOKTER])]);
        Route::post('/', 'PatientRecordController@store')->name("store")->middleware(['role:' . implode('|', [RoleEnum::ADMINISTRATOR,RoleEnum::DOKTER])]);
        Route::put('/{id}', 'PatientRecordController@update')->name("update")->middleware(['role:' . implode('|', [RoleEnum::ADMINISTRATOR,RoleEnum::DOKTER])]);
        Route::delete('/{id}', 'PatientRecordController@destroy')->name("destroy")->middleware(['role:' . implode('|', [RoleEnum::ADMINISTRATOR,RoleEnum::DOKTER])]);
    });

     Route::group(["as" => "payments.", "prefix" => "payments"], function () {
        Route::get('/{Id}/print-receipt', 'PaymentController@printReceipt')->name("print-receipt")->middleware(['role:' . implode('|', [RoleEnum::ADMINISTRATOR,RoleEnum::APOTEKER])]);
        Route::get('/', 'PaymentController@index')->name("index")->middleware(['role:' . implode('|', [RoleEnum::ADMINISTRATOR,RoleEnum::APOTEKER])]);
        Route::get('/create', 'PaymentController@create')->name("create")->middleware(['role:' . implode('|', [RoleEnum::ADMINISTRATOR,RoleEnum::APOTEKER])]);
        Route::get('/{id}', 'PaymentController@show')->name("show")->middleware(['role:' . implode('|', [RoleEnum::ADMINISTRATOR,RoleEnum::APOTEKER])]);
        Route::post('/', 'PaymentController@store')->name("store")->middleware(['role:' . implode('|', [RoleEnum::ADMINISTRATOR,RoleEnum::APOTEKER])]);
        Route::delete('/{id}', 'PaymentController@destroy')->name("destroy")->middleware(['role:' . implode('|', [RoleEnum::ADMINISTRATOR])]);
    });
});
