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

@section('title', __('company details'))
@section('site_title', __('company details'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">ausbilder.org</a></li>
    <li class="breadcrumb-item">{{ __('Company') }}</li>
    <li class="breadcrumb-item active">{{ __('company details') }}</li>
@endsection

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('company details') }}</h3>
                @permission('company.edit', session('company_id'))
                    <div class="card-tools">
                        <a href="{{ route('company.edit') }}"><i class="fas fa-pen" style="color:grey"></i></a>
                    </div>
                @endpermission
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <strong>{{ __('Company name') }}</strong> {{ $company->name }}<br />
                <strong>{{ __('Company name suffix') }}</strong> {{ $company->name_suffix }}<br />
                <strong>{{ __('street') }}</strong> {{ $company->street }}<br />
                <strong>{{ __('zipcode') }} {{ __('location') }}</strong> {{ $company->zipcode }} {{ $company->location }}<br />
                <strong>{{ __('responsible doctor') }}</strong> {{ $company->doctor }}<br />
                <strong>{{ __('qseh reference') }}</strong> {{ $company->reference }} &nbsp; <i class="{{ ($company->qseh_password ? 'fas fa-lock' : 'fas fa-lock-open') }}"></i><br />
            </div>
        </div>
    </section>
@endsection