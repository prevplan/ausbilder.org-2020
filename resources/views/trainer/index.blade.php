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

@section('title', __('trainer overview'))
@section('site_title', __('trainer overview'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">ausbilder.org</a></li>
    <li class="breadcrumb-item">{{ __('trainer') }}</li>
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
                        <h3 class="card-title">{{ __('trainer overview') }}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="trainer" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>E-Mail</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>
                                        @if($user['pivot']['company_active'] && $user['pivot']['user_active'])
                                            {{ $user->email }}
                                        @else
                                            <i class="far fa-eye-slash"></i> <i class="far fa-paper-plane"></i>
                                        @endif
                                    </td>
                                    <td class="project-state">
                                        @if(!$user['pivot']['company_active'])
                                            <span class="badge badge-danger">
                                                gesperrt&nbsp;
                                                <i class="fas fa-user-lock"></i>
                                            </span>
                                        @elseif(!$user['pivot']['user_active'])
                                            <span class="badge badge-warning">
                                                nicht bestätigt&nbsp;
                                                <i class="fas fa-user-times"></i>
                                            </span>
                                            &nbsp;<i class="fas fa-ban text-danger"></i>
                                        @else
                                            <a href="#">
                                                <span class="badge badge-success">
                                                    aktiv&nbsp;
                                                    <i class="fas fa-user-check"></i>
                                                </span>
                                                &nbsp;<i class="fas fa-ban text-danger"></i>
                                            </a>
                                        @endif
                                        @permission('permissions.edit', session('company_id'))
                                            <a
                                                    href="{{ route('permission.edit', ['user' => $user->id]) }}"
                                                    class="fas fa-key"
                                                    style="text-decoration: none; color: inherit;"
                                            ></a>
                                        @endpermission
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>E-Mail</th>
                                <th>Status</th>
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
            $('#trainer').DataTable({
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
            });
        });
    </script>
@endsection