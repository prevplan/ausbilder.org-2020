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

@section('title', __('add trainer'))
@section('site_title', __('add trainer'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">ausbilder.org</a></li>
    <li class="breadcrumb-item">{{ __('trainer') }}</li>
    <li class="breadcrumb-item active">{{ __('add trainer') }}</li>
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
                            <h3 class="card-title">{{ __('add trainer') }}</h3>
                        </div>
                        @include('layouts.error')
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('trainer.store') }}" method="post"
                              onsubmit="submit.disabled = true; submit.innerText='{{ __('saving') }}…'; return true;"
                              role="form">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="inputTrainerEmail">{{ __('trainer email') }}</label>
                                    <input class="form-control" id="inputTrainerEmail" name="email" placeholder="{{ __('trainer email') }}"
                                           required type="email" value="{{ old('email') }}">
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button class="btn btn-primary" name="submit" type="submit">{{ __('add') }}</button>
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