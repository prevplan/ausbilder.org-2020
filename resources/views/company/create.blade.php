@extends('layouts.backend')

@section('title', __('Register Company'))
@section('site_title', __('Register Company'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">ausbilder.org</a></li>
    <li class="breadcrumb-item">{{ __('Company') }}</li>
    <li class="breadcrumb-item active">{{ __('Register') }}</li>
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
                            <h3 class="card-title">{{ __('Register Company') }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="{{ route('company-store') }}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="inputCompanyName">{{ __('Company name') }}</label>
                                    <input type="text" class="form-control" id="inputCompanyName" name="name" value="{{ old('name') }}" placeholder="{{ __('Company name') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputCompanyNameSuffix">{{ __('Company name suffix') }}</label>
                                    <input type="text" class="form-control" id="inputCompanyNameSuffix" name="name_suffix" value="{{ old('name_suffix') }}" placeholder="{{ __('Company name suffix') }}">
                                </div>
                                <div class="form-group">
                                    <label for="inputStreet">{{ __('street') }}</label>
                                    <input type="text" class="form-control" id="inputStreet" name="street" value="{{ old('street') }}" placeholder="{{ __('street') }}" required>
                                </div>
                                <div class="row">
                                    <div class="form-group col-3">
                                        <label for="inputZipcode">{{ __('zipcode') }}</label>
                                        <input type="text" class="form-control" id="inputZipcode" name="zipcode" value="{{ old('zipcode') }}" placeholder="{{ __('zipcode') }}" required>
                                    </div>
                                    <div class="form-group col-9">
                                        <label for="inputLocation">{{ __('location') }}</label>
                                        <input type="text" class="form-control" id="inputLocation" name="location" value="{{ old('location') }}" placeholder="{{ __('location') }}" required>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ __('Register') }}</button>
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