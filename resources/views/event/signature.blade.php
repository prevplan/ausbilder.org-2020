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

@section('css')
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="initial-scale=1.0, target-densitydpi=device-dpi" /><!-- this is for mobile (Android) Chrome -->
    <meta name="viewport" content="initial-scale=1.0, width=device-height"><!--  mobile Safari, FireFox, Opera Mobile  -->

    <link type="text/css" rel="stylesheet" href="{{ asset('css/sign.css') }}"/>
@endsection

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

                <form method="post" action="{{ route('event.finish') }}">
                    @csrf
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <p align="center">
                                <div class="row" id="content">
                                    <div class="col-lg-12" id="signatureparent">
                                        <div id="signature"></div>
                                    </div>
                                </div>
                            </p>
                            <br />
                            <div class="row">
                                <div class="col-lg">
                                    <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 col-6 m-t-15">
                                        <button type="input" class="btn btn-primary" onclick="signature()">{{ __('next') }}
                                        </button>
                                        <button type="button" class="btn btn-warning" onclick="$('#signature').jSignature('clear')">{{ __('reset signature') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.card -->
                    <input type="hidden" name="sign" id="sign" />
                    <input type="hidden" name="img" id="img" />
                    @csrf
                </form>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
@endsection

@section('js')
    <script src="{{ asset('vendors/jsignature/jsign.js') }}"></script>

@endsection
