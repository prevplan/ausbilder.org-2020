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

@extends('layouts.frontend')

@section('title', 'ausbilder.org')
@section('site_title', 'ausbilder.org')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">ausbilder.org</a></li>
    <li class="breadcrumb-item active">Home</li>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title m-0"><strong>{{ __('the free course management and planning software') }}</strong></h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{ __("please enter the following data") }}</p>
                    </div>
                </div>

                @include('layouts.error')

                <form method="post" action="{{ route('event.validate') }}">
                    @csrf
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <fieldset>
                                <!-- Name input-->
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label for="first_name" class="col-form-label form-group-horizontal">
                                            {{ __('first name') }}
                                        </label>
                                        <div class="input-group input-group-prepend">
                                                        <span class="input-group-text border-right-0 rounded-left">
                                                            <i class="fas fa-user"></i>
                                                        </span>
                                            <input type="text" class="form-control form_lay_input1" id="first_name" name="first_name" placeholder="{{ __('first name') }}" value="{{ old('firstname') ?? ucfirst(session('firstname')) }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label for="last_name" class="col-form-label form-group-horizontal">
                                            {{ __('last name') }}
                                        </label>
                                        <div class="input-group input-group-prepend">
                                            <input type="text" id="last_name" class="form-control" name="last_name" placeholder="{{ __('last name') }}" value="{{ old('lastname') ?? ucfirst(session('lastname')) }}" required>
                                            <span class="input-group-text border-left-0 rounded-right">
                                                <i class="fas fa-user"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label for="date_of_birth" class="col-form-label form-group-horizontal">
                                            {{ __('date of birth') }}
                                        </label>
                                        <div class="input-group input-group-prepend">
                                            <span class="input-group-text border-right-0 rounded-left">
                                                <i class="fas fa-birthday-cake"></i>
                                            </span>
                                            <input type="text" class="form-control" placeholder="tt.mm.jjjj"
                                               data-date-format="dd.mm.yyyy" id="dp2" name="date_of_birth"
                                               value="{{ old('date_of_birth') ?? \Carbon\Carbon::parse(session('date_of_birth'))->format('d.m.Y') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label for="Company" class="col-form-label form-group-horizontal">
                                            {{ __('Company name') }}
                                        </label>
                                        <div class="input-group input-group-prepend">
                                            <span class="input-group-text border-right-0 rounded-left">
                                                <i class="fas fa-building"></i>
                                            </span>
                                            <input type="text" class="form-control" id="company" name="company" placeholder="{{ __('Company name') }}" value="{{ old('company') ?? ucfirst(session('company')) }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label for="zipcode" class="col-form-label form-group-horizontal">
                                            {{ __('zipcode') }} {{ __('(optional)') }}
                                        </label>
                                        <div class="input-group input-group-prepend">
                                            <span class="input-group-text border-right-0 rounded-left">
                                                <i class="fas fa-building"></i>
                                            </span>
                                            <input type="number" class="form-control" id="zipcode" name="zipcode" placeholder="{{ __('zipcode') }} {{ __('(optional)') }}" value="{{ old('zipcode') ?? session('zipcode') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label for="location" class="col-form-label form-group-horizontal">
                                            {{ __('location') }}
                                        </label>
                                        <div class="input-group input-group-prepend">
                                            <span class="input-group-text border-right-0 rounded-left">
                                                <i class="fas fa-city"></i>
                                            </span>
                                            <input type="text" class="form-control" id="location" name="location" placeholder="{{ __('location') }}" value="{{ old('location') ?? session('location') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label for="payee" class="col-form-label form-group-horizontal">
                                            {{ __('invoice recipient') }}
                                        </label>
                                        <div class="input-group input-group-prepend">
                                            <select class="form-control chzn-select" name="payee" required>
                                                <option disabled>{{ __('invoice recipient') }}</option>
                                                <option value="{{ __('Company') }}" {{ old('payee') == __('Company') ? 'selected' : (session('payee') == __('Company') ? 'selected' : '') }}>{{ __('Company') }}</option>
                                                <optgroup label="Berufsgenossenschaft">
                                                    <option value="BG-BAU" {{ old('payee') == 'BG-BAU' ? 'selected' : (session('payee') == 'BG-BAU' ? 'selected' : '') }}>BG BAU - Berufsgenossenschaft der Bauwirtschaft</option>
                                                    <option value="BG-ETEM"{{ old('payee') == 'BG-ETEM' ? 'selected' : (session('payee') == 'BG-ETEM' ? 'selected' : '') }}>BG ETEM - Berufsgenossenschaft Energie Textil Elektro Medienerzeugnisse</option>
                                                    <option value="BG-RIC" {{ old('payee') == 'BG-RIC' ? 'selected' : (session('payee') == 'BG-RIC' ? 'selected' : '') }}>BG RCI - Berufsgenossenschaft Rohstoffe und chemische Industrie</option>
                                                    <option value="BG-Verkehr" {{ old('payee') == 'BG-Verkehr' ? 'selected' : (session('payee') == 'BG-Verkehr' ? 'selected' : '') }}>BG Verkehr - Berufsgenossenschaft Verkehrswirtschaft Post-Logistik Telekommunikation</option>
                                                    <option value="BGHM" {{ old('payee') == 'BGHM' ? 'selected' : (session('payee') == 'BGHM' ? 'selected' : '') }}>BGHM - Berufsgenossenschaft Holz und Metall</option>
                                                    <option value="BGHW" {{ old('payee') == 'BGHW' ? 'selected' : (session('payee') == 'BGHW' ? 'selected' : '') }}>BGHW - Berufsgenossenschaft Handel und Warenlogistik</option>
                                                    <option value="BGN" {{ old('payee') == 'BGN' ? 'selected' : (session('payee') == 'BGN' ? 'selected' : '') }}>BGN - Berufsgenossenschaft Nahrungsmittel und Gastgewerbe</option>
                                                    <option value="BGW" {{ old('payee') == 'BGW' ? 'selected' : (session('payee') == 'BGW' ? 'selected' : '') }}>BGW - Berufsgenossenschaft für Gesundheitsdienst und Wohlfahrtspflege</option>
                                                    <option value="VBG" {{ old('payee') == 'VBG' ? 'selected' : (session('payee') == 'VBG' ? 'selected' : '') }}>VBG - Verwaltungs-Berufsgenossenschaft</option>
                                                </optgroup>
                                                <optgroup label="Unfallkassen">
                                                    <option value="Bayer-LUK" {{ old('payee') == 'Bayer-LUK' ? 'selected' : (session('payee') == 'Bayer-LUK' ? 'selected' : '') }}>Bayer LUK - Bayerische Landesunfallkasse</option>
                                                    <option value="BS-GUV" {{ old('payee') == 'BS-GUV' ? 'selected' : (session('payee') == 'BS-GUV' ? 'selected' : '') }}>BS GUV - Braunschweigischer Gemeinde-Unfallversicherungsverband</option>
                                                    <option value="FUBB" {{ old('payee') == 'FUBB' ? 'selected' : (session('payee') == 'FUBB' ? 'selected' : '') }}>FUBB - Feuerwehr-Unfallkasse Brandenburg</option>
                                                    <option value="FUK" {{ old('payee') == 'FUK' ? 'selected' : (session('payee') == 'FUK' ? 'selected' : '') }}>FUK - Feuerwehr-Unfallkasse Niedersachsen</option>
                                                    <option value="FUK-Mitte" {{ old('payee') == 'FUK-Mitte' ? 'selected' : (session('payee') == 'FUK-Mitte' ? 'selected' : '') }}>FUK Mitte - Feuerwehr-Unfallkasse Mitte</option>
                                                    <option value="GUV-OL" {{ old('payee') == 'GUV-OL' ? 'selected' : (session('payee') == 'GUV-OL' ? 'selected' : '') }}>GUV OL - Gemeinde-Unfallversicherungsverband Oldenburg</option>
                                                    <option value="GUVH" {{ old('payee') == 'GUVH' ? 'selected' : (session('payee') == 'GUVH' ? 'selected' : '') }}>GUVH - Gemeinde-Unfallversicherungsverband Hannover</option>
                                                    <option value="HFUK-Nord" {{ old('payee') == 'HFUK-Nord' ? 'selected' : (session('payee') == 'HFUK-Nord' ? 'selected' : '') }}>HFUK Nord - Hanseatische Feuerwehr-Unfallkasse Nord</option>
                                                    <option value="KUVB" {{ old('payee') == 'KUVB' ? 'selected' : (session('payee') == 'KUVB' ? 'selected' : '') }}>KUVB - Kommunale Unfallversicherung Bayern</option>
                                                    <option value="LUKN" {{ old('payee') == 'LUKN' ? 'selected' : (session('payee') == 'LUKN' ? 'selected' : '') }}>LUKN - Landesunfallkasse Niedersachsen</option>
                                                    <option value="SVLFG" {{ old('payee') == 'SVLFG' ? 'selected' : (session('payee') == 'SVLFG' ? 'selected' : '') }}>SVLFG - Sozialversicherung für Landwirtschaft, Forsten und Gartenbau</option>
                                                    <option value="UK-Bremen" {{ old('payee') == 'UK-Bremen' ? 'selected' : (session('payee') == 'UK-Bremen' ? 'selected' : '') }}>UK Bremen - Unfallkasse Freie Hansestadt Bremen</option>
                                                    <option value="UK-MV" {{ old('payee') == 'UK-MV' ? 'selected' : (session('payee') == 'UK-MV' ? 'selected' : '') }}>UK MV - Unfallkasse Mecklenburg-Vorpommern</option>
                                                    <option value="UK-Nord" {{ old('payee') == 'UK-Nord' ? 'selected' : (session('payee') == 'UK-Nord' ? 'selected' : '') }}>UK Nord - Unfallkasse Nord</option>
                                                    <option value="UK-NRW" {{ old('payee') == 'UK-NRW' ? 'selected' : (session('payee') == 'UK-NRW' ? 'selected' : '') }}>UK NRW - Unfallkasse Nordrhein-Westfalen</option>
                                                    <option value="UK-RLP" {{ old('payee') == 'UK-RLP' ? 'selected' : (session('payee') == 'UK-RLP' ? 'selected' : '') }}>UK RLP - Unfallkasse Rheinland-Pfalz</option>
                                                    <option value="UK-Sachsen" {{ old('payee') == 'UK-Sachsen' ? 'selected' : (session('payee') == 'UK-Sachsen' ? 'selected' : '') }}>UK Sachsen - Unfallkasse Sachsen</option>
                                                    <option value="UKB" {{ old('payee') == 'UKB' ? 'selected' : (session('payee') == 'UKB' ? 'selected' : '') }}>UKB - Unfallkasse Berlin</option>
                                                    <option value="UKBB" {{ old('payee') == 'UKBB' ? 'selected' : (session('payee') == 'UKBB' ? 'selected' : '') }}>UKBB - Unfallkasse Brandenburg</option>
                                                    <option value="UKBW" {{ old('payee') == 'UKBW' ? 'selected' : (session('payee') == 'UKBW' ? 'selected' : '') }}>UKBW - Unfallkasse Baden-Württemberg</option>
                                                    <option value="UKH" {{ old('payee') == 'UKH' ? 'selected' : (session('payee') == 'UKH' ? 'selected' : '') }}>UKH - Unfallkasse Hessen</option>
                                                    <option value="UKS" {{ old('payee') == 'UKS' ? 'selected' : (session('payee') == 'UKS' ? 'selected' : '') }}>UKS - Unfallkasse Saarland</option>
                                                    <option value="UKST" {{ old('payee') == 'UKST' ? 'selected' : (session('payee') == 'UKST' ? 'selected' : '') }}>UKST - Unfallkasse Sachsen-Anhalt</option>
                                                    <option value="UKT" {{ old('payee') == 'UKT' ? 'selected' : (session('payee') == 'UKT' ? 'selected' : '') }}>UKT - Unfallkasse Thüringen</option>
                                                    <option value="UVB" {{ old('payee') == 'UVB' ? 'selected' : (session('payee') == 'UVB' ? 'selected' : '') }}>UVB - Unfallversicherung Bund und Bahn</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="text-center custom-controls-stacked">
                                            <label class="col-form-label form-group-horizontal">
                                                <strong>{{ __('The personal data is processed on the basis of Art. 6 Para. 1 lit. c and e GDPR, Section 199 (1) No. 5 in conjunction with § 23 SGV VII processed.') }}</strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="left_align custom-controls-stacked">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="approval" {{ old('approval') ? ' checked' : '' }} value="1" required>
                                                <span class="custom-control-label custom_checkbox_success"></span>
                                                <span class="custom-control-description text-success">{{ __('I agree that the data collected will be recorded for the course documentation and used to create the certificate of attendance.') }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-11">
                                        <button class="btn btn-success button-rounded" type="submit">Weiter</button>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div><!-- /.card -->
                </form>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
@endsection
