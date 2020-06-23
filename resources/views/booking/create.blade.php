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
                    <form action="{{ route('booking.store', ['company' => $company, 'course' => $course]) }}"
                          id="form"
                          method="post"
                          onsubmit="submit.disabled = true; submit.innerText='{{ __('booking') }}…'; return true;"
                          role="form">
                        @csrf
                        @honeypot
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
                            </div>
                            <hr>
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
                            <div class="row">
                                <div class="form-group col-lg">
                                    <input id="checkboxTerms" name="terms" required
                                           type="checkbox" {{ (old('terms') ? 'checked="checked"' : '') }}>
                                    <label for="checkboxTerms">{!! html_entity_decode( __('I have read and accept the :tac.', ['tac' => '<a href="' . ($company->terms ?? '#') . '" target="_blank">' . __('terms and conditions') . '</a>'])) !!}</label>
                                </div>
                            </div>
                            @if($course->start < \Carbon\Carbon::now()->addDays(14))
                                <div class="row">
                                    <div class="form-group col-lg">
                                            <input id="checkboxCancellationPolicy" name="cancellationPolicy" required
                                                   type="checkbox" {{ (old('cancellationPolicy') ? 'checked="checked"' : '') }}>
                                            <label for="checkboxCancellationPolicy">{!! html_entity_decode( __('I hereby waive my :roc if the service is performed before the deadline.', ['roc' => '<a href="' . ($company->cpolicy ?? '#') . '" target="_blank">' . __('right of cancellation') . '</a>'])) !!}</label>
                                    </div>
                                </div>
                            @else
                                <div class="row">
                                    <div class="form-group col-lg">
                                        <input id="checkboxCancellationPolicy" name="cancellationPolicy" required
                                               type="checkbox" {{ (old('cancellationPolicy') ? 'checked="checked"' : '') }}>
                                        <label for="checkboxCancellationPolicy">{!! html_entity_decode( __('I have taken note of the :cp.', ['cp' => '<a href="' . ($company->cpolicy ?? '#') . '" target="_blank">' . __('cancellation policy') . '</a>'])) !!}</label>
                                    </div>
                                </div>
                            @endif
                            <div class="row">
                                <div class="form-group col-lg">
                                    <input id="checkboxDataProtection" name="dataProtection" required
                                           type="checkbox" {{ (old('dataProtection') ? 'checked="checked"' : '') }}>
                                    <label for="checkboxDataProtection">
                                        {!! html_entity_decode( __(
                                                'I agree that my details from the booking form will be collected and processed to process my booking. You can find detailed information on handling user data in the :dataProtectionDeclaration.',
                                            ['dataProtectionDeclaration' => '<a href="' . route('data-protection') . '" target="_blank">' . __('data protection declaration') . '</a>']
                                        )) !!}
                                    </label>
                                </div>
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