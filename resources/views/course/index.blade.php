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

@section('title', __('course overview'))
@section('site_title', __('course overview'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">ausbilder.org</a></li>
    <li class="breadcrumb-item">{{ __('courses') }}</li>
    <li class="breadcrumb-item active">{{ __('overview') }}</li>
@endsection

@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('vendors/datatables/css/dataTables.bootstrap4.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('course overview') }}</h3>
                        &nbsp; {{ __('current courses') }} - <a href="{{ route('course.old') }}">{{ __('show old courses') }}</a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="courses" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>{{ __('seminar location') }}</th>
                                <th>{{ __('street') }}</th>
                                <th>{{ __('location') }}</th>
                                <th>{{ __('start date') }}</th>
                                <th>{{ __('course type') }}</th>
                                <th>{{ __('internal number') }}</th>
                                <th>{{ __('trainer') }}</th>
                                <th>{{ __('responsible') }}</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($courses as $course)
                                <tr>
                                    <td>{{ $course->seminar_location }}</td>
                                    <td>{{ $course->street }}</td>
                                    <td>{{ $course->zipcode }} {{ $course->location }}</td>
                                    <td data-sort="{{ Carbon\Carbon::parse($course->start) }}">{{ \Carbon\Carbon::parse($course->start)->format('d.m.Y H:i') }} Uhr</td>
                                    <td>{{ __($course->course_types[0]->name) }}</td>
                                    <td>{{ $course->internal_number }}</td>
                                    <td>
                                        @foreach($course->user as $trainer)
                                            {{ $trainer->name }}{!! !$loop->last ? ',<br />' : '' !!}
                                        @endforeach
                                    </td>
                                    <td>{{ $course->responsibility->name }}</td>
                                    <td align="center">
                                        @if( $course->running )
                                            <i class="fas fa-toggle-on"></i>
                                        @else
                                            <i class="fas fa-toggle-off"></i>
                                        @endif
                                    </td>
                                    <td align="center">
                                        <a href="{{ route('course.show', ['course' => $course->hashid()]) }}" style="text-decoration: none; color: inherit;">
                                            <i class="far fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>{{ __('seminar location') }}</th>
                                <th>{{ __('street') }}</th>
                                <th>{{ __('location') }}</th>
                                <th>{{ __('start date') }}</th>
                                <th>{{ __('course type') }}</th>
                                <th>{{ __('internal number') }}</th>
                                <th>{{ __('trainer') }}</th>
                                <th>{{ __('responsible') }}</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
@endsection

@section('js')
    <!-- DataTables -->
    <script src="{{ asset('vendors/datatables/js/datatables.js') }}"></script>

    <!-- page script -->
    <script>
        $(function () {
            $('#courses').DataTable({
                "language": {
                    "lengthMenu": "{{ __('view _MENU_ entries') }}",
                },
                "paging": true,
                "lengthChange": true,
                "pageLength": 10,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "order":[[3,'asc']]
            });
        });
    </script>
@endsection