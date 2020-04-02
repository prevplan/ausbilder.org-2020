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

@extends('layouts.frontend')

@section('title', 'ausbilder.org')
@section('site_title', 'ausbilder.org')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">ausbilder.org</a></li>
    <li class="breadcrumb-item active">Home</li>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title m-0"><strong>{{ __('the free course management and planning software') }}</strong></h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{ __("please enter the following data") }}</p>
                    </div>
                </div>

                @include('layouts.error')

                <form method="post" action="{{ route('event.name') }}">
                    @csrf
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <p align="center">
                                <label for="inputStreet">{{ __('first name') }}</label>
                                <input type="text" class="form-control" id="inputFirstName" name="first_name" value="{{ old('first_name') }}" placeholder="{{ __('first name') }}" required>
                                <br />
                                <label for="inputStreet">{{ __('last name') }}</label>
                                <input type="text" class="form-control" id="inputLastName" name="last_name" value="{{ old('last_name') }}" placeholder="{{ __('last name') }}" required>
                                <br />
                                <label for="inputStreet">{{ __('date of birth') }}</label>
                                <input type="date" class="form-control" id="inputCode" name="date_of_birth" value="{{ old('date_of_birth') ?? \Carbon\Carbon::now()->subYears(20)->format('Y-m-d') }}" required>
                            </p>
                            <br />
                            <button type="submit" class="btn btn-primary">{{ __('next') }}</button>
                        </div>
                    </div><!-- /.card -->
                </form>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
@endsection
