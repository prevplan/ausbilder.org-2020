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

@section('title', __('add course'))
@section('site_title', __('add course'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">ausbilder.org</a></li>
    <li class="breadcrumb-item">{{ __('courses') }}</li>
    <li class="breadcrumb-item active">{{ __('add course') }}</li>
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
                            <h3 class="card-title">{{ __('add course') }}</h3>
                        </div>
                        @include('layouts.error')
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('course.store') }}" method="post"
                              onsubmit="submit.disabled = true; submit.innerText='{{ __('saving') }}…'; return true;"
                              role="form">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6 form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="inputCourseType">{{ __('course type') }}</label>
                                                <select class="custom-select" name="type" required>
                                                    <option {{ (!old('type')) ? 'selected' : ''  }} disabled>{{ __('select course type') }}</option>
                                                    @foreach ($types as $group => $value)
                                                        <optgroup label="{{ __($group) }}">
                                                            @foreach ($value as $foo)
                                                                <option value="{{ $foo->id }}" {{ ($foo->id == old('type')) ? 'selected' : ''  }}>{{ __($foo->name) }}</option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 form-group">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group" id="item_table">
                                                    <label class="col-5">{{ __('position') }}</label>
                                                    <label class="col-5">{{ __('trainer') }}</label>

                                                    @if( null !== old('trainer') )
                                                        @foreach( old('trainer')  as $trainer)
                                                            <div>
                                                                <select class="custom-select col-5" name="position[]" required>
                                                                    <option disabled>{{ __('select position') }}</option>
                                                                    @foreach ($positions as $position)
                                                                        <option {{ (old('position')[$loop->parent->index] == $position->id ? 'selected' : '') }} value="{{ $position->id }}">{{ __($position->name) }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <select class="custom-select col-5" name="trainer[]" required>
                                                                    <option selected disabled>{{ __('select trainer') }}</option>
                                                                    @foreach ($company->users as $user)
                                                                        <option {{ (old('trainer')[$loop->parent->index] == $user->id ? 'selected' : '') }} value="{{ $user->id }}">{{ $user->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @if( $loop->first )
                                                                    <button type="button" name="add" class="btn btn-success btn-sm add"><i class="fas fa-user-plus"></i></button>
                                                                @else
                                                                    <button type="button" name="remove" class="btn btn-danger btn-sm remove"><i class="fas fa-user-minus"></i></button>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <select class="custom-select col-5" name="position[]" required>
                                                            <option selected disabled>{{ __('select position') }}</option>
                                                            @foreach ($positions as $position)
                                                                <option {{ ($position->id == 1 ? 'selected' : 'disabled') }} value="{{ $position->id }}">{{ __($position->name) }}</option>
                                                            @endforeach
                                                        </select>
                                                        <select class="custom-select col-5" name="trainer[]" required>
                                                            <option selected disabled>{{ __('select trainer') }}</option>
                                                            @foreach ($company->users as $user)
                                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <button class="btn btn-success btn-sm add" name="add"
                                                                type="button">
                                                            <i class="fas fa-user-plus"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-2">
                                        <label for="inputZipcode">{{ __('start') }}</label>
                                        <input type="date" class="form-control" name="start_date" value="{{ old('start_date') ?? \Carbon\Carbon::now()->format('Y-m-d') }}" required="">
                                    </div>
                                    <div class="col-1"></div>
                                    <div class="form-group col-lg-1">
                                        <label for="inputZipcode">{{ __('time') }}</label>
                                        <input type="time" class="form-control" name="start_time" value="{{ old('start_time') ?? '09:00' }}" required="">
                                    </div>
                                    <div class="col-4"></div>
                                    <div class="form-group col-lg-2">
                                        <label for="inputZipcode">{{ __('end') }}</label>
                                        <input type="date" class="form-control" name="end_date" value="{{ old('end_date') ?? \Carbon\Carbon::now()->format('Y-m-d') }}" required="">
                                    </div>
                                    <div class="col-1"></div>
                                    <div class="form-group col-lg-1">
                                        <label for="inputZipcode">{{ __('time') }}</label>
                                        <input type="time" class="form-control" name="end_time" value="{{ old('end_time') ?? '16:30' }}" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputCourseTypeSuffix">{{ __('location / company') }}</label>
                                    <input type="text" class="form-control" id="inputCourseTypeSuffix" name="seminar_location" value="{{ old('seminar_location') }}" placeholder="{{ __('location / company') }}" required>
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
                                <div class="row">
                                    <div class="form-group col-lg">
                                        <label for="inputIntenNumber">{{ __('internal number') }}</label>
                                        <input type="text" class="form-control" id="inputInternNumber" name="internal_number" value="{{ old('internal_number') }}" placeholder="{{ __('internal number') }}">
                                    </div>
                                    <div class="form-group col-md-1" align="center">
                                        {{ __('and / or') }}
                                    </div>
                                    <div class="form-group col-lg">
                                        <label for="inputRegistrationNumber">{{ __('QSEH registration number') }}</label>
                                            @if( Auth::user()->isAbleTo('course.register', session('company_id')) && $company->qseh_password)
                                                {{ __('- automatically register at QSEH?') }} &nbsp;
                                                <input
                                                    data-bootstrap-switch
                                                    data-off-color="danger"
                                                    data-off-text="{{ __('No') }}"
                                                    data-on-color="success"
                                                    data-on-text="{{ __('Yes') }}"
                                                    id="reg_nr_hide"
                                                    name="auto_register"
                                                    onchange="hideReg()"
                                                    type="checkbox"
                                                >
                                                <div id="reg_nr_hint" style="{{ old('auto_register') ? 'display:block' : 'display:none' }}">
                                                    {{ __('The course will be automatically registered at the QSEH.') }}
                                                </div>
                                            @endif
                                        <div id="reg_nr_field" style="{{ old('auto_register') ? 'display:none' : 'display:block' }}">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="inputRegistrationNumber"
                                                name="registration_number"
                                                value="{{ old('registration_number')  }}"
                                                placeholder="123456/{{ \Carbon\Carbon::now()->format('Y') }}"
                                            >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <label for="inputBookable">{{ __('bookable') }}</label>
                                        <div>
                                            <input
                                                    {{ (!count($prices) ? 'disabled' : '') }}
                                                    data-bootstrap-switch
                                                    data-off-color="danger"
                                                    data-off-text="{{ __('No') }}"
                                                    data-on-color="success"
                                                    data-on-text="{{ __('Yes') }}"
                                                    id="price_hide"
                                                    name="bookable"
                                                    onchange="hidePrice()"
                                                    type="checkbox"
                                            >
                                        </div>
                                    </div>
                                    @if(count($prices))
                                        <div class="col-2" id="seats" style="{{ $errors->any() && !old('bookable') ? 'display:none' : 'display:block' }}">
                                            <div class="form-group">
                                                <label for="inputMaxSeats">{{ __('maximum seats') }}</label>
                                                <input class="form-control" id="inputMaxSeats" name="max_seats"
                                                       placeholder="{{ __('maximum seats') }}"
                                                       required
                                                       type="number"
                                                       value="{{ old('max_seats') ?? '20'}}">
                                            </div>
                                        </div>
                                        <div class="col-6" id="prices" style="{{ $errors->any() && !old('bookable') ? 'display:none' : 'display:block' }}">
                                            <div class="form-group" id="price_table">
                                                <label class="col-6">{{ __('price') }}</label>
                                                @if( null !== old('price') )
                                                    @foreach( old('price')  as $price)
                                                        <div>
                                                            <select class="custom-select col-6" name="price[]">
                                                                <option disabled selected>{{ __('select price') }}</option>
                                                                @foreach ($prices as $price)
                                                                    <option {{ (old('price')[$loop->parent->index] == $price->id ? 'selected' : '') }} value="{{ $price->id }}">{{ __($price->title) }} - {{ $price->price }} {{ $price->currency }}</option>
                                                                @endforeach
                                                            </select>
                                                            @if( $loop->first )
                                                                <button class="btn btn-success btn-sm add-price" name="add-price"
                                                                        type="button"><i class="fas fa-plus"></i></button>
                                                            @else
                                                                <button class="btn btn-danger btn-sm remove" name="remove"
                                                                        type="button"><i class="fas fa-minus"></i></button>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <select class="custom-select col-6" name="price[]">
                                                        <option disabled selected>{{ __('select price') }}</option>
                                                        @foreach ($prices as $price)
                                                            <option value="{{ $price->id }}">{{ __($price->title) }} - {{ $price->price }} {{ $price->currency }}</option>
                                                        @endforeach
                                                    </select>

                                                    <button class="btn btn-success btn-sm add-price" name="add-price"
                                                            type="button"><i class="fas fa-plus"></i></button>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                    <div class="form-group col-lg">
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button class="btn btn-primary" name="submit" type="submit">{{ __('add') }}
                                </button>
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

@section('js')
    <script>
        $(document).ready(function(){

            $(document).on('click', '.add', function(){
                var html = '';

                html += '<div>';
                html += '<select class="custom-select col-5" name="position[]" required>';
                html += '<option selected disabled>{{ __('select position') }}</option>';
                @foreach ($positions as $position)
                    html += '<option value="{{ $position->id }}">{{ __($position->name) }}</option>';
                @endforeach
                html += '</select>';

                html += '<select class="custom-select col-5" name="trainer[]" required>';
                html += '<option selected disabled>{{ __('select trainer') }}</option>';
                @foreach ($company->users as $user)
                    html += '<option value="{{ $user->id }}">{{ $user->name }}</option>';
                @endforeach
                html += '</select>';
                html += ' <button type="button" name="remove" class="btn btn-danger btn-sm remove"><i class="fas fa-user-minus"></i></button>';
                html += '</div>';

                $('#item_table').append(html);

            });

            $(document).on('click', '.remove', function(){
                $(this).closest('div').remove();
            });

        });
    </script>

    <script>
        $(document).ready(function(){

            $(document).on('click', '.add-price', function(){
                var html = '';

                html += '<div>';
                html += '<select class="custom-select col-6" name="price[]" required>';
                html += '<option selected disabled>{{ __('select price') }}</option>';
                @foreach ($prices as $price)
                    html += '<option value="{{ $price->id }}">{{ __($price->title) }} - {{ $price->price }} {{ $price->currency }}</option>';
                @endforeach
                html += '</select>';
                html += ' <button type="button" name="remove" class="btn btn-danger btn-sm remove"><i class="fas fa-minus"></i></button>';
                html += '</div>';

                $('#price_table').append(html);

            });

            $(document).on('click', '.remove', function(){
                $(this).closest('div').remove();
            });

        });
    </script>

    <!-- Bootstrap Switch -->
    <script src="{{ asset('vendors/bootstrap-switch/js/switch.js') }}"></script>

    <script>
        $(function () {
            $("input[data-bootstrap-switch]").each(function(){
                $(this).bootstrapSwitch('state', $(this).prop('unchecked'));
            });

        })

        @if(old('auto_register'))
            $("[name='auto_register']").bootstrapSwitch('state',true)();
        @else
            $("[name='auto_register']").bootstrapSwitch('state',false)();
        @endif

    </script>

    <script>
        $(function () {
            $("input[data-bootstrap-switch]").each(function(){
                $(this).bootstrapSwitch('state', $(this).prop('unchecked'));
            });

        })

        @if($errors->any() && !old('bookable'))
            $("[name='bookable']").bootstrapSwitch('state',false)();
        @else
            $("[name='bookable']").bootstrapSwitch('state',true)();
        @endif

    </script>

    <script>
        function hideReg() {
            var checkBox = document.getElementById("reg_nr_hide");
            var text = document.getElementById("reg_nr_field");
            if (checkBox.checked === true){
                text.style.display = "none";
            } else {
                text.style.display = "block";
            }
            var text = document.getElementById("reg_nr_hint");
            if (checkBox.checked === true){
                text.style.display = "block";
            } else {
                text.style.display = "none";
            }
        }

        function hidePrice() {
            var checkBox = document.getElementById("price_hide");
            var text = document.getElementById("prices");
            if (checkBox.checked === true){
                text.style.display = "block";
            } else {
                text.style.display = "none";
            }

            var text = document.getElementById("seats");
            if (checkBox.checked === true){
                text.style.display = "block";
            } else {
                text.style.display = "none";
            }
        }

        function hideFunc() {
            var checkBox = document.getElementById("hide");
            var text = document.getElementById("default_company");
            if (checkBox.checked === true){
                text.style.display = "block";
            } else {
                text.style.display = "none";
            }
        }
    </script>

@endsection