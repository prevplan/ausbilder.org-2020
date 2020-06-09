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

@section('title', __('add participant'))
@section('site_title', __('add participant'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">ausbilder.org</a></li>
    <li class="breadcrumb-item">{{ __('courses') }}</li>
    <li class="breadcrumb-item active">{{ __('add participant') }}</li>
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
                            <h3 class="card-title">{{ __('add participant') }}</h3>
                        </div>
                        @include('layouts.error')
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="{{ route('participant.store', ['course' => $course]) }}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-lg">
                                        <label for="inputCourseType">{{ __('price') }}</label>
                                        <select class="custom-select" name="price" required>
                                            <option selected disabled>{{ __('select price') }}</option>
                                            @foreach ($course->prices as $price)
                                                <option value="{{ $price->id }}" {{ ($price->id == old('price')) ? 'selected' : ''  }}>{{ __($price->title) }} - {{ Str::of($price->price)->replace('.', ',') }} &euro;</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-lg">
                                        <label for="inputMail">{{ __('e-mail') }}</label>
                                        <input type="email" class="form-control" id="inputMail" name="mail" value="{{ old('mail') }}" placeholder="{{ __('e-mail') }}" required>
                                    </div>
                                    <div class="form-group col-lg">
                                        <label for="inputPhone">{{ __('phone number') }}</label>
                                        <input type="text" class="form-control" id="inputPhone" name="phone" value="{{ old('phone') }}" placeholder="{{ __('phone number') }}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg">
                                        <label for="inputFirstname">{{ __('firstname') }}</label>
                                        <input type="text" class="form-control" id="inputFirstname" name="firstname" value="{{ old('firstname') }}" placeholder="{{ __('firstname') }}" required>
                                    </div>
                                    <div class="form-group col-lg">
                                        <label for="inputLastname">{{ __('lastname') }}</label>
                                        <input type="text" class="form-control" id="inputLastname" name="lastname" value="{{ old('lastname') }}" placeholder="{{ __('lastname') }}" required>
                                    </div>
                                    <div class="form-group col-lg-2">
                                        <label for="inputDateOfBirth">{{ __('date of birth') }}</label>
                                        <input type="date" class="form-control" name="date_of_birth" value="{{ old('date_of_birth') ?? \Carbon\Carbon::now()->format('Y-m-d') }}" required="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg">
                                        <label for="inputStreet">{{ __('street') }}</label>
                                        <input type="text" class="form-control" id="inputStreet" name="street" value="{{ old('street') }}" placeholder="{{ __('street') }}" required>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="inputZipcode">{{ __('zipcode') }}</label>
                                        <input type="text" class="form-control" id="inputZipcode" name="zipcode" value="{{ old('zipcode') }}" placeholder="{{ __('zipcode') }}" required>
                                    </div>
                                    <div class="form-group col-lg">
                                        <label for="inputLocation">{{ __('location') }}</label>
                                        <input type="text" class="form-control" id="inputLocation" name="location" value="{{ old('location')  }}" placeholder="{{ __('location') }}" required>
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