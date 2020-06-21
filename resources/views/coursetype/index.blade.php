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

@section('title', __('course types'))
@section('site_title', __('course types'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">ausbilder.org</a></li>
    <li class="breadcrumb-item">{{ __('Company') }}</li>
    <li class="breadcrumb-item active">{{ __('course types') }}</li>
@endsection

@section('css')
    <link href="{{ asset('vendors/icheckbootstrap/css/icheck-bootstrap.min.css') }}" rel="stylesheet">
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
                            <h3 class="card-title">{{ __('edit offered course types for :company', ['company' => session('company')]) }}</h3>
                        </div>
                        @include('layouts.status')
                        <form action="{{ route('course-types.update', ['company' => \Vinkla\Hashids\Facades\Hashids::encode(session('company_id'))]) }}"
                              method="post"
                              onsubmit="submit.disabled = true; submit.innerText='{{ __('saving') }}…'; return true;"
                              role="form">
                            @csrf
                            @method('patch')
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($types as $group)
                                        <div class="col-12 col-md-4 m-t-35">
                                            <h5 class="checkbox_header_bottom">{{ __($group[0]->group) }}</h5>
                                            <div class="form-group clearfix">
                                                @foreach ($group as $course)
                                                    {{-- will be used later!
                                                   @php
                                                       // TODO clean up this work around ...
                                                       $cert = false;
                                                       $list = false;
                                                   @endphp
                                                 @foreach( $course->templates as $template)
                                                       @if ($template->type == 'cert')
                                                           @php($cert = true)
                                                       @elseif ($template->type == 'list')
                                                           @php($list = true)
                                                       @endif

                                                       @if ($cert && $list)
                                                           @break
                                                       @endif
                                                   @endforeach  --}}

                                                    <div class="{{ $loop->parent->iteration %2 ? 'icheck-success' : 'icheck-warning' }} d-inline">
                                                        <input
                                                                type="checkbox"
                                                                name="types[]"
                                                                id="checkbox-{{ $course->id }}"
                                                                value="{{ $course->id }}"
                                                                {{ $course->companies->count() ? 'checked' : '' }}
                                                                {{ !Auth::user()->permissions('course-types.edit') ? 'disabled' : '' }}
                                                        >
                                                        <label for="checkbox-{{ $course->id }}">
                                                            {{ __($course->name) }}&nbsp;
                                                            <a href="#"><i class="fas fa-certificate text-danger"></i></a>&nbsp;
                                                            <a href="#"><i class="far fa-file-alt text-danger"></i></a>
                                                        </label>
                                                   {{--  old and maybe used later
                                                        <span class="custom-control-label {{ $loop->parent->iteration %2 ? 'custom_checkbox_success' : 'custom_checkbox_warning' }}"></span>
                                                        <span class="custom-control-description {{ $loop->parent->iteration %2 ? 'text-success' : 'text-warning' }}">{{ $course->name }} @can('manage.templates')<a href="{{ route('coursetemplate.edit', ['id' => $course])  }}"><i class="far fa-file-certificate {{$cert ? 'text-success' : 'text-danger'}}"></i>&nbsp;<i class="far fa-file-alt {{$list ? 'text-success' : 'text-danger'}}"></i></a>@endcan</span> --}}
                                                    </div><br />
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
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
    </section>
@endsection