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
    <li class="breadcrumb-item active">{{ __('edit') }}</li>
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
                    <form action="{{ route('permission.update', ['user' => $user->hashid()]) }}" method="post"
                          onsubmit="submit.disabled = true; submit.innerText='{{ __('saving') }}…'; return true;"
                          role="form">
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
                                                @if ($user->isAbleTo('trainer.add', session('company_id')))
                                                    checked
                                                @endif
                                            >
                                            <label for="checkbox-trainer.add">
                                                {{ __('add trainer') }}
                                            </label>
                                        </div><br />
                                        <div class="icheck-danger d-inline">
                                            <input
                                                type="checkbox"
                                                name="permissions[]"
                                                id="checkbox-trainer.details"
                                                value="trainer.details"
                                                @if ($user->isAbleTo('trainer.details', session('company_id')))
                                                    checked
                                                @endif
                                            >
                                            <label for="checkbox-trainer.details">
                                                {{ __('show trainer details') }}
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
                                                    @if ($user->isAbleTo('permissions.edit', session('company_id')))
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
                                                @if ($user->isAbleTo('course-types.edit', session('company_id')))
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
                                                @if ($user->isAbleTo('company.edit', session('company_id')))
                                                    checked
                                                @endif
                                            >
                                            <label for="checkbox-company.edit">
                                                {{ __('edit company') }}
                                            </label>
                                        </div><br />
                                        <div class="icheck-warning d-inline">
                                            <input
                                                    type="checkbox"
                                                    name="permissions[]"
                                                    id="checkbox-templates.edit"
                                                    value="templates.edit"
                                                    @if ($user->isAbleTo('templates.edit', session('company_id')))
                                                        checked
                                                    @endif
                                            >
                                            <label for="checkbox-templates.edit">
                                                {{ __('edit templates') }}
                                            </label>
                                        </div><br />
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 m-t-35">
                                    <h5 class="checkbox_header_bottom">{{ __('courses') }}</h5>
                                    <div class="form-group clearfix">
                                        <div class="icheck-success d-inline">
                                            <input
                                                    type="checkbox"
                                                    name="permissions[]"
                                                    id="checkbox-course.view"
                                                    value="course.view"
                                                    @if ($user->isAbleTo('course.view', session('company_id')))
                                                    checked
                                                    @endif
                                            >
                                            <label for="checkbox-course.view">
                                                {{ __('view all courses') }}
                                            </label>
                                        </div><br />
                                        <div class="icheck-success d-inline">
                                            <input
                                                type="checkbox"
                                                name="permissions[]"
                                                id="checkbox-course.add"
                                                value="course.add"
                                                @if ($user->isAbleTo('course.add', session('company_id')))
                                                    checked
                                                @endif
                                            >
                                            <label for="checkbox-course.add">
                                                {{ __('add course') }}
                                            </label>
                                        </div><br />
                                        <div class="icheck-success d-inline">
                                            <input
                                                type="checkbox"
                                                name="permissions[]"
                                                id="checkbox-course.register"
                                                value="course.register"
                                                @if ($user->isAbleTo('course.register', session('company_id')))
                                                    checked
                                                @endif
                                            >
                                            <label for="checkbox-course.register">
                                                {{ __('register course') }}
                                            </label>
                                        </div><br />
                                        <div class="icheck-success d-inline">
                                            <input
                                                type="checkbox"
                                                name="permissions[]"
                                                id="checkbox-course.perform-electronically"
                                                value="course.perform-electronically"
                                                @if ($user->isAbleTo('course.perform-electronically', session('company_id')))
                                                    checked
                                                @endif
                                            >
                                            <label for="checkbox-course.perform-electronically">
                                                {{ __('perform course electronically') }}
                                            </label>
                                        </div><br />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button class="btn btn-primary" name="submit" type="submit">{{ __('update') }}</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
@endsection