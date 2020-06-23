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

use Illuminate\Support\Facades\Route;
use Spatie\Honeypot\ProtectAgainstSpam;

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

        Route::middleware(ProtectAgainstSpam::class)->group(function () {
            Auth::routes(['verify' => true]);
        });

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

        Route::get('course/create', 'CourseController@create')->name('course.create');
        Route::post('course', 'CourseController@store')->name('course.store');
        Route::get('course', 'CourseController@index')->name('course.overview');
        Route::get('course/old', 'CourseController@old')->name('course.old');
        Route::get('course/{course}/show', 'CourseController@show')->name('course.show');

        Route::get('courseday/{course}/start', 'CourseDayController@start')->name('courseday.start');
        Route::post('courseday/start', 'CourseDayController@store_start')->name('courseday.store_start');
        Route::get('courseday/{course}/end', 'CourseDayController@end')->name('courseday.end');
        Route::post('courseday/end', 'CourseDayController@store_end')->name('courseday.store_end');

        Route::get('profile', 'ProfileController@index')->name('profile');

        Route::get('cal/{parameter}/cal.ics', 'CalendarController@index');

        Route::get('api/regenerate', 'ApiController@regenerate')->name('api.regenerate');

        Route::get('price/create', 'PriceController@create')->name('price.create');
        Route::get('price', 'PriceController@index')->name('price.overview');
        Route::post('price', 'PriceController@store')->name('price.store');

        Route::get('participant/{course}/create', 'ParticipantController@create')->name('participant.create');
        Route::post('participant/{course}', 'ParticipantController@store')->name('participant.store');

        Route::get('booking/{company}/loc/{location}', 'BookingController@location')->name('booking.location');
        Route::get('booking/{company}/sloc/{location}', 'BookingController@seminarLocation')->name('booking.seminarLocation');
        Route::get('booking/{company}/{course}', 'BookingController@create')->name('booking.create');
        Route::post('booking/{company}/{course}', 'BookingController@store')->name('booking.store')->middleware(ProtectAgainstSpam::class);

        Route::group(['middleware' => 'revalidate'], function () {
            Route::get('event', 'EventController@index')->name('event.index');
            Route::post('event', 'EventController@search')->name('event.search')->middleware(ProtectAgainstSpam::class);
            Route::get('event/{number}/{code}', 'EventController@login')->name('event.login');
            Route::get('event/name', 'EventController@name')->name('event.name');
            Route::post('event/name', 'EventController@processName')->name('event.name');
            Route::get('event/payee', 'EventController@selectPayee')->name('event.payee');
            Route::post('event/payee', 'EventController@showPayee')->name('event.payee');
            Route::post('event/company', 'EventController@company')->name('event.company');
            Route::get('event/email', 'EventController@email')->name('event.email');
            Route::post('event/check', 'EventController@check')->name('event.check');
            Route::get('event/check', 'EventController@check')->name('event.check');
            Route::post('event/validate', 'EventController@validating')->name('event.validate');
            Route::get('event/sign', 'EventController@signature')->name('event.sign');
            Route::post('event/finish', 'EventController@finish')->name('event.finish');
        });
    });
