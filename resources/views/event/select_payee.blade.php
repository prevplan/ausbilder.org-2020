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

                <form method="post" action="{{ route('event.payee') }}">
                    @csrf
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <p align="center">
                                <select class="form-control" name="payee_type" onchange="this.form.submit()" required>
                                    <option {{ !session()->has('company') || session('company') == '' ? 'selected' : '' }} value="" disabled>{{ __('select payee') }}</option>
                                    <option value="private">{{ __('private / i pay myself') }}</option>
                                    <option value="company" {{ session()->has('company') && session('company') != '' ? 'selected' : '' }}>{{ __('company / insurance association') }}</option>
                                </select>
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
