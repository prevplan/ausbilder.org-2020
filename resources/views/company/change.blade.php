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

@section('title', __('change Company'))
@section('site_title', __('change Company'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">ausbilder.org</a></li>
    <li class="breadcrumb-item">{{ __('Company') }}</li>
    <li class="breadcrumb-item active">{{ __('change') }}</li>
@endsection

@section('content')
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('Company overview') }}</h3>

            </div>
            <div class="card-body p-0">
                <table class="table table-striped projects">
                    <thead>
                    <tr>
                        <th style="width: 1%">
                            #
                        </th>
                        <th style="width: 20%">
                            {{ __('Company name') }}
                        </th>
                        <th style="width: 30%">
                            {{ __('company logo') }}
                        </th>
                        <th style="width: 8%" class="text-center">

                        </th>
                        <th style="width: 8%" class="text-center">

                        </th>
                        <th style="width: 20%">
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $companies as $company )
                        <tr>
                            <td>
                                #
                            </td>
                            <td>
                                <a>
                                    {{ $company->name }}
                                </a>
                            </td>
                            <td>
                                <ul class="list-inline">
                                    <li class="list-inline-item">
                                        <img alt="Logo" class="table-avatar" src="{{ asset('img/logo_128.png') }}">
                                    </li>
                                </ul>
                            </td>
                            <td class="project-state">
                                @if(!$company->pivot['company_active'])
                                    <span class="badge badge-danger">{{ __('blocked') }}</span>
                                @elseif(!$company->pivot['user_active'])
                                    <a href="{{ route('company.activate', ['company' => $company->hashid()]) }}">
                                        <span class="badge badge-warning">{{ __('not active') }}&nbsp;
                                            <i class="fas fa-unlock"></i>
                                        </span>
                                    </a>
                                @else
                                    <a href="{{ route('company.deactivate', ['company' => $company->hashid()]) }}">
                                        <span class="badge badge-success">{{ __('active') }}&nbsp;
                                            <i class="fas fa-lock"></i>
                                        </span>
                                    </a>
                                @endif
                            </td>
                            <td class="project-state">
                                @if( $company-> id == session('company_id'))
                                    <span class="badge badge-primary">{{ __('selected') }}</span>
                                @endif
                            </td>
                            <td class="project-actions text-right">
                                @if(!$company->pivot['company_active'])
                                    <div class="btn btn-danger btn-sm">
                                        <i class="fas fa-ban"></i>
                                        {{ __('blocked') }}
                                    </div>
                                @elseif(!$company->pivot['user_active'])
                                    <a class="btn btn-warning btn-sm" href="{{ route('company.activate', ['company' => $company->hashid()]) }}">
                                        <i class="fas fa-unlock"></i>
                                        {{ __('activate') }}
                                    </a>
                                @else
                                    <a class="btn btn-primary btn-sm" href="{{ route('company-change-id', ['company' => $company->hashid()]) }}">
                                        <i class="fas fa-exchange-alt"></i>
                                        {{ __('change') }}
                                    </a>
                                @endif
                            {{--     <a class="btn btn-info btn-sm" href="#">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                    Edit
                                </a>
                                <a class="btn btn-danger btn-sm" href="#">
                                    <i class="fas fa-trash">
                                    </i>
                                    Delete
                                </a>  --}}
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td class="project-actions text-right">
                            <a class="btn btn-success btn-sm" href="{{ route('company-register') }}">
                                <i class="fas fa-plus"></i>
                                {{ __('Register Company') }}
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
@endsection