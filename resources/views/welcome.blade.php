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
                        <p class="card-text">{{ __("Tired of using Excel, Word and Paper? Annoyed by expensive software, that doesn't really fit? We too!") }}</p>
                        <p class="card-text">{!! html_entity_decode( __('Therefore we are :name. The first and only free course management and planning software in the world (as far as we know).', ['name' => '<strong>ausbilder.org</strong>']) ) !!}</p>
                    </div>
                </div>

                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <h5 class="card-title"><strong>{{ __('100% open source / 100% free') }}</strong></h5>

                        <p class="card-text">
                            {{ __('ausbilder.org is proud to be 100% open source and 100% free, in the meaning of free as in freedom, licensed under the GNU AGPLv3. Our texts, documentation and other content are published under the creative commons by-sa 4.0 license.') }}
                        </p>
                        <p class="card-text">
                            {{ __('Everyone can help and is encouraged to make ausbilder.org better, easier and more extensive. No matter whether this is done through coding, suggestions, error messages, translations, donations or in another way.') }}
                        </p>
                        <p class="card-text" align="middle">
                            <strong>{!! __('Together we can make the free course management and planning software :name the best course management and planning software in the world!', ['name' => '<a href="https://ausbilder.org">ausbilder.org</a>']) !!}</strong>
                        </p>
                        <p align="center">
                            <a href="https://github.com/prevplan/ausbilder.org" class="card-link">GitHub</a>
                            <a href="https://ausbilder-forum.org/c/ausbilder-org/" class="card-link">{{ __('Forum') }}</a>
                            <a href="https://poeditor.com/join/project/kXQkobGIoI" class="card-link">{{ __('Translations') }}</a>
                        </p>
                    </div>
                </div><!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
@endsection
