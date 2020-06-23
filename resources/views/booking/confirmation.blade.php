{{--
    * ausbilder.org - the free course management and planning software.
    * Copyright (C) 2020 Holger Schmermbeck & others (see the AUTHORS file)
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
--}}

@extends('layouts.no-header')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title m-0"><strong>{{ __('booking successful') }}</strong></h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text" align="center">{{ __("You have booked successfully. A confirmation mail is sent to you.") }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-primary card-outline">
            <div class="card-body">
                <p class="card-text" align="middle">
                    <a href="{{ route('booking.create', ['company' => $company, 'course' => $course]) }}">{{ __('register another participant') }}</a>
                </p>
            </div>
        </div><!-- /.card -->
        <!-- /.row -->
    </div><!-- /.container-fluid -->
@endsection
