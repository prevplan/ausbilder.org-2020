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

@section('title', __('add price'))
@section('site_title', __('add price'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">ausbilder.org</a></li>
    <li class="breadcrumb-item">{{ __('prices') }}</li>
    <li class="breadcrumb-item active">{{ __('add price') }}</li>
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
                            <h3 class="card-title">{{ __('add price') }}</h3>
                        </div>
                        @include('layouts.error')
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="{{ route('price.store') }}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{ __('title') }}</label>
                                        <input type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="{{ __('title') }}" required="">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>{{ __('price') }}</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="price" value="{{ old('price') }}" placeholder="{{ __('price') }}" required="">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fas fa-euro-sign"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-1"></div>
                                    <div class="form-group col-lg-5">
                                        <label>{{ __('description') }}</label>
                                        <textarea name="description" class="form-control" rows="5" placeholder="{{ __('Enter a description here.') }}"></textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ __('add') }}</button>
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
