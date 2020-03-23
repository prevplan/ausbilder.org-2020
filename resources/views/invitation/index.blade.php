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
    <li class="breadcrumb-item active">{{ __('invitation') }}</li>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
               <div class="card card-primary card-outline">
                    <div class="card-body">
                        <h5 class="card-title"><strong>{{ __('you got an invitation from :company', ['company' => $company->name]) }}</strong></h5>
                        <p class="card-text" align="center">
                            <a href="{{ route('invitation.accept', ['company' => $company->hashid(), 'code' => $code]) }}" class="btn btn-success">
                                {{ __('accept invitation') }}
                            </a>
                        </p>
                        <p class="card-text" align="center">
                            <a href="{{ route('invitation.decline', ['company' => $company->hashid(), 'code' => $code]) }}" class="btn btn-danger">
                                {{ __('decline invitation') }}
                            </a>
                        </p>
                    </div>
                </div><!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
@endsection
