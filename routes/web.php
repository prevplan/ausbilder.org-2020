<?php

/**
 * ausbilder.org - the free course management and planning software.
 * Copyright (C) 2020 Holger Schmermbeck & others (see the AUTHORS file).
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

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

/** ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP **/
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    ], function () {
        Route::get('/', function () {
            return view('welcome');
        });

        Auth::routes(['verify' => true]);

        Route::get('/home', 'HomeController@index')->name('home');

        Route::get('impressum', 'LegalController@imprint')->name('imprint');
        Route::get('datenschutz', 'LegalController@data_protection')->name('data-protection');

        Route::get('company/create', 'CompanyController@create')->name('company-register');
        Route::post('company/store', 'CompanyController@store')->name('company-store');

        Route::get('company/change', 'CompanyChangeController@index')->name('company-change');
        Route::get('company/change/{company}', 'CompanyChangeController@change')->name('company-change-id');

        Route::get('company/activate/{company}', 'CompanyController@activate')->name('company.activate');
        Route::get('company/deactivate/{company}', 'CompanyController@deactivate')->name('company.deactivate');

        Route::get('company/{company}/invite/{code}', 'InvitationController@index');
        Route::get('company/{company}/invite/{code}/accept', 'InvitationController@accept')
            ->middleware('auth', 'verified')
            ->name('invitation.accept');
        Route::get('company/{company}/invite/{code}/register', 'InvitationController@index')
            ->middleware('guest')
            ->name('invitation.register');
        Route::get('company/{company}/invite/{code}/decline', 'InvitationController@destroy')->name('invitation.decline');

        Route::get('company', 'CompanyController@index')->name('company.show');

        Route::get('company/edit', 'CompanyController@edit')->name('company.edit');
        Route::put('company/{company}', 'CompanyController@update')->name('company.put');

        Route::get('course-types', 'CourseTypesController@index')->name('course-types.show');
        Route::patch('course-types/{company}', 'CourseTypesController@update')->name('course-types.update');

        Route::get('trainer', 'TrainerController@index')->name('trainer.show');
        Route::get('trainer/create', 'TrainerController@create')->name('trainer.create');
        Route::post('trainer', 'TrainerController@store')->name('trainer.store');

        Route::get('permission/{user}/edit', 'PermissionController@edit')->name('permission.edit');
        Route::patch('permission/{user}', 'PermissionController@update')->name('permission.update');
    });
