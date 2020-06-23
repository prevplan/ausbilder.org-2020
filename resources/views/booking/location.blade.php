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

@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('vendors/datatables/css/dataTables.bootstrap4.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $company->name }} {{ __('courses') }} - {{ $location }}</h3>

                        {{--
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>

                                </div>
                            </div>
                        </div>
                        --}}
                    </div>
                    @include('layouts.error')
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0" style="height: 500px;">
                        <table class="table table-head-fixed text-nowrap">
                            <thead>
                            <tr>
                                <th>{{ __('start') }}</th>
                                <th>{{ __('course type') }}</th>
                                <th>{{ __('street') }}</th>
                                <th>{{ __('location') }}</th>
                                <th>{{ __('free seats') }}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($courses as $course)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($course->start)->format('d.m.Y H:i') }} Uhr</td>
                                    <td>{{ __($course['course_types'][0]['name']) }}</td>
                                    <td>{{ $course->street }}</td>
                                    <td>{{ $course->zipcode }} {{ $course->location }}</td>
                                    <td>{{ $course->seats - count($course->participants) }}</td>
                                    @if(($course->seats - count($course->participants)) > 0)
                                        <td><a href="{{ route('booking.create', ['company' => $company, 'course' => $course]) }}">{{ __('book course') }}</a></td>
                                    @else
                                        <td>
                                            {{ __('booked up') }}
                                        </td>
                                    @endif
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
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
             //   "pageLength": 10,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "order":[[3,'asc']],
            });
        });
    </script>
@endsection