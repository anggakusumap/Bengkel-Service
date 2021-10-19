<?php

use Illuminate\Support\Facades\Auth;
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


Auth::routes(['verify' => true]);


Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/', 'Auth\LoginController@login')->name('login');

Route::get('/register', 'Auth\RegisterController@showRegisterForm')->name('register');
Route::post('/register', 'Auth\RegisterController@register')->name('register');
Route::get("/getkabupaten/{id}", "Auth\RegisterController@kabupaten_baru");
Route::get("/getkecamatan/{id}", "Auth\RegisterController@kecamatan_baru");
Route::get("/getdesa/{id}", "Auth\RegisterController@desa_baru");


Route::get('account/password', 'Account\PasswordController@edit')->name('password.edit');
Route::patch('account/password', 'Account\PasswordController@update')->name('password.edit');

Route::group(
    ['middleware' => 'auth'],
    function () {
        // ------------------------------------------------------------------------
        // MODUL SERVICE
        // DASHBOARD
        Route::prefix('service')
            ->namespace('Service')
            ->middleware(['admin_service_gabung', 'verified'])
            ->group(function () {
                Route::get('/', 'DashboardServiceController@index')
                    ->name('dashboardservice');
            });

        // PENERIMAANSERVICE
        Route::prefix('service')
            ->namespace('Service')
            ->middleware(['admin_service_instructor', 'verified'])
            ->group(function () {
                Route::resource('jadwalmekanik', 'JadwalMekanikController');
                Route::resource('stoksparepart', 'StokSparepartController');
                Route::resource('pengerjaanservice', 'PengerjaanServiceController');
                Route::put('updateservice/{id_service_advisor}', 'PengerjaanServiceController@Updateservice')
                    ->name('updateservice');
            });

        Route::prefix('service')
            ->namespace('Service')
            ->middleware(['admin_service_advisor', 'verified'])
            ->group(function () {
                Route::resource('penerimaanservice', 'PenerimaanServiceController');
                Route::post('penerimaanservice-booking', 'PenerimaanServiceController@booking')->name('penerimaan-booking');
                Route::get("/kode-reservasi", "PenerimaanServiceController@reservasi");
            });
    }
);
