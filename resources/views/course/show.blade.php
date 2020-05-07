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

@section('title', __('course details'))
@section('site_title', __('course details'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">ausbilder.org</a></li>
    <li class="breadcrumb-item">{{ __('courses') }}</li>
    <li class="breadcrumb-item active">{{ __('course details') }}</li>
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
                            <h3 class="card-title">{{ __('course details') }}</h3>
                        </div>

                        @include('layouts.error')
                        <!-- /.card-header -->

                        <div class="card-body">
                            <div class="row">
                                <div class="col-5 form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="inputCourseType">{{ __('course type') }}</label>
                                            <div>
                                                {{ __($course->course_types[0]->name) }}
                                                &nbsp;
                                                @if( $course->running )
                                                    <i class="fas fa-toggle-on"></i>
                                                @else
                                                    <i class="fas fa-toggle-off"></i>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-7 form-group">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group" id="item_table">
                                                <label>{{ __('position') }}</label>
                                                @foreach($course->user as $user)
                                                    <div>{{ __($position[$user->pivot->position_id]) }}</div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <div class="form-group" id="item_table">
                                                <label>{{ __('trainer') }}</label>
                                                @foreach($course->user as $user)
                                                    <div>{{ $user->name }}</div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-2">
                                    <label for="inputZipcode">{{ __('start') }}</label>
                                    <div>{{  \Carbon\Carbon::parse($course->start)->format('d.m.Y')  }}</div>
                                </div>
                                <div class="col-1"></div>
                                <div class="form-group col-lg-1">
                                    <label for="inputZipcode">{{ __('time') }}</label>
                                    <div>{{  \Carbon\Carbon::parse($course->start)->format('H:i')  }}</div>
                                </div>
                                <div class="col-4"></div>
                                <div class="form-group col-lg-2">
                                    <label for="inputZipcode">{{ __('end') }}</label>
                                    <div>{{  \Carbon\Carbon::parse($course->end)->format('d.m.Y')  }}</div>
                                </div>
                                <div class="col-1"></div>
                                <div class="form-group col-lg-1">
                                    <label for="inputZipcode">{{ __('time') }}</label>
                                    <div>{{  \Carbon\Carbon::parse($course->end)->format('H:i')  }}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputCourseTypeSuffix">{{ __('location / company') }}</label>
                                <div>{{ $course->seminar_location }}</div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg">
                                    <label for="inputZipcode">{{ __('street') }}</label>
                                    <div>{{ $course->street }}</div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputZipcode">{{ __('zipcode') }}</label>
                                    <div>{{ $course->zipcode }}</div>
                                </div>
                                <div class="form-group col-lg">
                                    <label for="inputLocation">{{ __('location') }}</label>
                                    <div>{{ $course->location }}</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg">
                                    <label for="inputInternalNumber">{{ __('internal number') }}</label>
                                    <div>{{ $course->internal_number }}</div>
                                </div>
                                <div class="form-group col-lg">
                                    <label for="inputRegistrationNumber">{{ __('QSEH registration number') }}</label>
                                    <div>{{ ($course->registration_number ? $course->registration_number : __('not specified') ) }}</div>
                                </div>
                                @if(
                                    \Carbon\Carbon::now()->addHour() >= $course->start
                                    && \Carbon\Carbon::now() < $course->end
                                    && !$course->running
                                    && \Laratrust::isAbleTo('course.perform-electronically', session('company_id'))
                                    && $user_in
                                )
                                    <div class="form-group col-lg">
                                        <label for="course_day">{{ __('course day') }}</label>
                                        <div><a href="{{ route('courseday.start', $course->hashid()) }}">{{ __('start course day') }}</a></div>
                                    </div>
                                @elseif(
                                    $course->running
                                    && \Laratrust::isAbleTo('course.perform-electronically', session('company_id'))
                                    && $user_in
                                )
                                    <div class="form-group col-lg">
                                        <label for="course_day">{{ __('course day') }}</label>
                                        <div><a href="{{ route('courseday.end', $course->hashid()) }}">{{ __('end course day') }}</a></div>
                                    </div>
                                @endif
                            </div>
                            @if($course->running)
                                <div class="row">
                                    <div class="form-group col-lg">
                                        <label for="inputInternalNumber">{{ __('internal number') }}</label>
                                        <div>{{ $course->internal_number }}</div>
                                    </div>
                                    <div class="form-group col-lg">
                                        <label for="inputZipcode">{{ __('Code') }}</label>
                                        <div>{{ \Vinkla\Hashids\Facades\Hashids::encode($course->running) }}</div>
                                    </div>
                                    <div class="form-group col-lg">
                                        <label for="inputLocation">{{ __('start participant registration') }}</label>
                                        <div>REGISTRATION LINK</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <!-- /.card-body -->

                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection
