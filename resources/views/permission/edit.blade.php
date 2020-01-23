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

@section('title', __('permission management'))
@section('site_title', __('permission management'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">ausbilder.org</a></li>
    <li class="breadcrumb-item">{{ __('permission management') }}</li>
    <li class="breadcrumb-item active">{{ __('overview') }}</li>
@endsection

@section('css')
    <link href="{{ asset('vendors/icheckbootstrap/css/icheck-bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('permissions for :user', ['user' => $user->name]) }}</h3>
                    </div>
                    @include('layouts.status')
                    <form role="form" action="{{ route('permission.update', ['user' => $user->id]) }}" method="post">
                        @csrf
                        @method('patch')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-4 m-t-35">
                                    <h5 class="checkbox_header_bottom">{{ __('trainer') }}</h5>
                                    <div class="form-group clearfix">
                                        <div class="icheck-danger d-inline">
                                            <input
                                                    type="checkbox"
                                                    name="permissions[]"
                                                    id="checkbox-trainer.add"
                                                    value="trainer.add"
                                                    @if ($user->can('trainer.add', session('company_id')))
                                                        checked
                                                    @endif
                                            >
                                            <label for="checkbox-trainer.add">
                                                {{ __('add trainer') }}
                                            </label>
                                        </div><br />
                                        <div class="icheck-danger d-inline">
                                            @if (Auth::user()->id == $user->id)
                                                <input type="checkbox" checked disabled>
                                                <input type="hidden" name="permissions[]" value="permissions.edit">
                                            @else
                                                <input
                                                        type="checkbox"
                                                        name="permissions[]"
                                                        id="checkbox-permissions.edit"
                                                        value="permissions.edit"
                                                        @if ($user->can('permissions.edit', session('company_id')))
                                                        checked
                                                        @endif
                                                >
                                            @endif
                                            <label for="checkbox-permissions.edit">
                                                {{ __('edit permissions') }}
                                            </label>
                                        </div><br />
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 m-t-35">
                                    <h5 class="checkbox_header_bottom">{{ __('Company') }}</h5>
                                    <div class="form-group clearfix">
                                        <div class="icheck-warning d-inline">
                                            <input
                                                    type="checkbox"
                                                    name="permissions[]"
                                                    id="checkbox-course-types.edit"
                                                    value="course-types.edit"
                                                    @if ($user->can('course-types.edit', session('company_id')))
                                                        checked
                                                    @endif
                                            >
                                            <label for="checkbox-course-types.edit">
                                                {{ __('edit course types') }}
                                            </label>
                                        </div><br />
                                        <div class="icheck-warning d-inline">
                                            <input
                                                type="checkbox"
                                                name="permissions[]"
                                                id="checkbox-company.edit"
                                                value="company.edit"
                                                @if ($user->can('company.edit', session('company_id')))
                                                    checked
                                                @endif
                                            >
                                            <label for="checkbox-company.edit">
                                                {{ __('edit company') }}
                                            </label>
                                        </div><br />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">{{ __('update') }}</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
@endsection