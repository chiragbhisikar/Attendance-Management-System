@extends('layouts.admin.master')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="container-fluid">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><a href="{{ route('admin.faculty') }}">Faculties</a></h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('admin.faculty') }}">Faculty</a></li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <!-- Card Body -->
                    <div class="card-body">
                        <form action="{{ route('admin.update-password-faculty') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="text" name="faculty_id" value="{{ $faculty->id }}" style="display: none;">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter Password"
                                    required>
                            </div>
                            @if ($errors->has('password'))
                                <div class="error">{{ $errors->first('password') }}</div>
                            @endif

                            <div class="form-group">
                                <label for="password">Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control" placeholder="Enter Password"
                                    required>
                            </div>
                            @if ($errors->has('confirm_password'))
                                <div class="error">{{ $errors->first('confirm_password') }}</div>
                            @endif

                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
