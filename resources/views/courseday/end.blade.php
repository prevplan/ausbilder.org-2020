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

@section('title', __('end course day'))
@section('site_title', __('end course day'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">ausbilder.org</a></li>
    <li class="breadcrumb-item">{{ __('courses') }}</li>
    <li class="breadcrumb-item active">{{ __('end course day') }}</li>
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
                            <h3 class="card-title">{{ __('end course day') }}</h3>
                        </div>
                        <!-- /.card-header -->
                        @include('layouts.error')
                        <form role="form" action="{{ route('courseday.store_end') }}" method="post">
                            @csrf
                            <input type="hidden" name="course_id" value="{{ $course->hashid() }}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-lg">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="inputCourseType">{{ __('course type') }}</label>
                                                <div>
                                                    {{ __($course->course_types[0]->name) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg">
                                        <label for="inputInternalNumber">{{ __('internal number') }}</label>
                                        <div>{{ $course->internal_number }}</div>
                                    </div>
                                    <div class="form-group col-lg">
                                        <label for="inputRegistrationNumber">{{ __('QSEH registration number') }}</label>
                                        <div>{{ ($course->registration_number ? $course->registration_number : __('not specified') ) }}</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-2">
                                        <label for="inputendDate">{{ __('end') }}</label>
                                        <input type="date" class="form-control" name="end_date" value="{{ old('end_date') ?? \Carbon\Carbon::create($time)->format('Y-m-d') }}" required="">
                                    </div>
                                    <div class="col-1"></div>
                                    <div class="form-group col-lg-1">
                                        <label for="inputendTime">{{ __('time') }}</label>
                                        <input type="time" class="form-control" name="end_time" value="{{ old('end_time') ?? \Carbon\Carbon::create($time)->format('H:i') }}" required="">
                                    </div>
                                    <div class="col-1"></div>
                                    <div class="form-group col-lg-1">
                                        <label for="inputLessons">{{ __('lessons') }}</label>
                                        <input type="text" class="form-control" name="lessons" value="{{ old('lessons') ?? $lessons }}" required="">
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ __('end course day') }}</button>
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
