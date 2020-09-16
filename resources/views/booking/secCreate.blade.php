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

@extends('layouts.no-header')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('book course') }}</h3>
                    </div>
                @include('layouts.error')
                <!-- /.card-header -->
                    <!-- form start -->
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <div><strong>{{ __($course->course_types[0]->name) }}</strong></div>
                                </div>
                                <div class="form-group col-md-2">
                                    <div>{{ \Carbon\Carbon::parse($course->start)->format('d.m.Y H:i') }} Uhr - {{ \Carbon\Carbon::parse($course->end)->format('H:i') }} Uhr</div>
                                </div>
                                <div class="form-group col-lg">
                                    <div><strong>{{ __('address') }}:</strong> {{ $course->seminar_location }}, {{ $course->street }}, {{ $course->zipcode }} {{ $course->location }}</div>
                                </div>
                                <form action="{{ route('booking.sendLink', ['company' => $company, 'course' => $course]) }}"
                                      id="smsForm"
                                      method="post"
                                      onsubmit="submit.disabled = true; submit.innerText='{{ __('sending') }}…'; return true;"
                                      role="form">
                                    @csrf
                                    @honeypot
                                    <div class="form-group col-lg">
                                        <strong>{{ __('send link by sms') }}</strong>
                                        <input  id="inputNumber" name="number" placeholder="{{ __('mobile number') }}" required type="text"><button class="btn btn-primary" name="submit" type="submit">{{ __('send overview') }}</button>
                                    </div>
                                </form>
                            </div>
                            <hr>
                            <form action="{{ route('booking.store', ['company' => $company, 'course' => $course]) }}"
                                  id="form"
                                  method="post"
                                  onsubmit="submit.disabled = true; submit.innerText='{{ __('booking') }}…'; return true;"
                                  role="form">
                                @csrf
                                @honeypot
                            <div class="row">
                                <div class="form-group col-lg">
                                    @foreach($course->prices as $price)
                                        <div class="row">
                                            <input id="{{ $price->id }}" name="price" required
                                                   type="radio" value="{{ $price->id }}" {{ ((old('price') == $price->id) ? 'checked="checked"' : '') }}>
                                            <div class="form-group col-md-2">
                                                <label for="{{ $price->id }}">{{ $price->title }}</label>
                                            </div>
                                            <div class="form-group col-sm-1">
                                                {{ $price->price }} {{ $price->currency }}
                                            </div>
                                            <div class="form-group col-lg">
                                                {{ $price->description }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg">
                                    <label for="inputMail">{{ __('e-mail') }}</label>
                                    <input class="form-control" id="inputMail" name="email"
                                           placeholder="{{ __('e-mail') }}" required type="email" value="{{ old('email') }}">
                                </div>
                                <div class="form-group col-lg">
                                    <label for="inputPhone">{{ __('phone number') }}</label>
                                    <input class="form-control" id="inputPhone" name="phone" placeholder="{{ __('phone number') }}"
                                           required type="text" value="{{ old('phone') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg">
                                    <label for="inputFirstname">{{ __('firstname') }}</label>
                                    <input class="form-control" id="inputFirstname" name="firstname" placeholder="{{ __('firstname') }}"
                                           required type="text" value="{{ old('firstname') }}">
                                </div>
                                <div class="form-group col-lg">
                                    <label for="inputLastname">{{ __('lastname') }}</label>
                                    <input class="form-control" id="inputLastname" name="lastname" placeholder="{{ __('lastname') }}"
                                           required type="text" value="{{ old('lastname') }}">
                                </div>
                                <div class="form-group col-lg-2">
                                    <label for="inputDateOfBirth">{{ __('date of birth') }}</label>
                                    <input class="form-control" id="inputDateOfBirth" name="date_of_birth" required=""
                                           type="date"
                                           value="{{ old('date_of_birth') ?? \Carbon\Carbon::now()->subDecade(2)->format('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg">
                                    <label for="inputStreet">{{ __('street') }}</label>
                                    <input class="form-control" id="inputStreet" name="street"
                                           placeholder="{{ __('street') }}"
                                           required type="text" value="{{ old('street') }}">
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="inputNumber">{{ __('house number') }}</label>
                                    <input class="form-control" id="inputNumber" name="number"
                                           placeholder="{{ __('house number') }}"
                                           required type="text" value="{{ old('house number') }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputZipcode">{{ __('zipcode') }}</label>
                                    <input class="form-control" id="inputZipcode" name="zipcode"
                                           placeholder="{{ __('zipcode') }}"
                                           required type="text" value="{{ old('zipcode') }}">
                                </div>
                                <div class="form-group col-lg">
                                    <label for="inputLocation">{{ __('location') }}</label>
                                    <input class="form-control" id="inputLocation" name="location"
                                           placeholder="{{ __('location') }}"
                                           required type="text" value="{{ old('location')  }}">
                                </div>
                            </div>


                            <div id="my_name_DE4DFKvJVIqfaH7y_wrap" style="display:none;">
                                <input id="checkboxTerms" name="terms" required
                                       type="checkbox" checked="checked">

                                <input id="checkboxCancellationPolicy" name="cancellationPolicy" required
                                       type="checkbox" checked="checked">

                                <input id="checkboxDataProtection" name="dataProtection" required
                                               type="checkbox" checked="checked">
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button class="btn btn-primary" name="submit" type="submit">{{ __('book course') }}</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
@endsection
