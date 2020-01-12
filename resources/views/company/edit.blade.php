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

@section('title', __('edit company'))
@section('site_title', __('edit company'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">ausbilder.org</a></li>
    <li class="breadcrumb-item">{{ __('Company') }}</li>
    <li class="breadcrumb-item active">{{ __('edit') }}</li>
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
                            <h3 class="card-title">{{ __('edit company') }}</h3>
                        </div>
                    @include('layouts.error')
                    <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="{{ route('company.put', ['company' => session('company_id')]) }}" method="post">
                            @csrf
                            @method('put')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="inputCompanyName">{{ __('Company name') }}</label>
                                    <input type="text" class="form-control" id="inputCompanyName" name="name" value="{{ $company->name }}" placeholder="{{ __('Company name') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputCompanyNameSuffix">{{ __('Company name suffix') }}</label>
                                    <input type="text" class="form-control" id="inputCompanyNameSuffix" name="name_suffix" value="{{ $company->name_suffix }}" placeholder="{{ __('Company name suffix') }}">
                                </div>
                                <div class="form-group">
                                    <label for="inputStreet">{{ __('street') }}</label>
                                    <input type="text" class="form-control" id="inputStreet" name="street" value="{{ $company->street }}" placeholder="{{ __('street') }}" required>
                                </div>
                                <div class="row">
                                    <div class="form-group col-3">
                                        <label for="inputZipcode">{{ __('zipcode') }}</label>
                                        <input type="text" class="form-control" id="inputZipcode" name="zipcode" value="{{ $company->zipcode }}" placeholder="{{ __('zipcode') }}" required>
                                    </div>
                                    <div class="form-group col-9">
                                        <label for="inputLocation">{{ __('location') }}</label>
                                        <input type="text" class="form-control" id="inputLocation" name="location" value="{{ $company->location }}" placeholder="{{ __('location') }}" required>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ __('edit') }}</button>
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