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

@extends('layouts.backend')

@section('title', __('Register Company'))
@section('site_title', __('Register Company'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">ausbilder.org</a></li>
    <li class="breadcrumb-item">{{ __('Company') }}</li>
    <li class="breadcrumb-item active">{{ __('Register') }}</li>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Register Company') }}</h3>
                        </div>
                        @include('layouts.error')
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="{{ route('company-store') }}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="inputCompanyName">{{ __('Company name') }}</label>
                                    <input type="text" class="form-control" id="inputCompanyName" name="name" value="{{ old('name') }}" placeholder="{{ __('Company name') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputCompanyNameSuffix">{{ __('Company name suffix') }}</label>
                                    <input type="text" class="form-control" id="inputCompanyNameSuffix" name="name_suffix" value="{{ old('name_suffix') }}" placeholder="{{ __('Company name suffix') }}">
                                </div>
                                <div class="form-group">
                                    <label for="inputStreet">{{ __('street') }}</label>
                                    <input type="text" class="form-control" id="inputStreet" name="street" value="{{ old('street') }}" placeholder="{{ __('street') }}" required>
                                </div>
                                <div class="row">
                                    <div class="form-group col-3">
                                        <label for="inputZipcode">{{ __('zipcode') }}</label>
                                        <input type="text" class="form-control" id="inputZipcode" name="zipcode" value="{{ old('zipcode') }}" placeholder="{{ __('zipcode') }}" required>
                                    </div>
                                    <div class="form-group col-9">
                                        <label for="inputLocation">{{ __('location') }}</label>
                                        <input type="text" class="form-control" id="inputLocation" name="location" value="{{ old('location') }}" placeholder="{{ __('location') }}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="inputDoctor">{{ __('responsible doctor') }}</label>
                                        <input type="text" class="form-control" id="inputDoctor" name="doctor" value="{{ old('doctor') }}" placeholder="{{ __('responsible doctor') }}">
                                    </div>
                                    <div class="form-group col-6">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="inputReference">{{ __('qseh reference (optional)') }}</label>
                                        <input type="text" class="form-control" id="inputReference" name="reference" value="{{ old('reference') }}" placeholder="{{ __('qseh reference (optional)') }}">
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="inputQsehPassword">{{ __('qseh password (optional)') }}</label>
                                        <input type="password" class="form-control" id="inputQsehPassword" name="qseh_password" value="{{ old('qseh_password') }}" placeholder="{{ __('qseh password (optional)') }}">
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ __('Register') }}</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection