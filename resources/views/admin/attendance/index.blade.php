@extends('layouts.admin.master')
@section('css')
@endsection
@section('content')
    <div class="content-header">
        @if (Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ Session::get('error') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><a href="{{ route('admin.dashboard') }}">Attendance</a></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('admin.attendance') }}">Attendance</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- Content Header (Page header) -->

    <!-- /.content-header -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Body -->
                <div class="card-body">
                    <form action="{{ route('admin.export-attendance') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="division">Select Class</label>
                            <select name="division" class="form-control" required>
                                <option value="" selected>Select Class</option>
                                @foreach ($divisions as $division)
                                    <option value="{{ $division->id }}">{{ $division->department->department_name }} -
                                        {{ $division->division_name }} - {{ $division->admission_year }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('division'))
                            <div class="error">{{ $errors->first('division') }}</div>
                        @endif

                        <div class="form-group">
                            <label for="subject">Select Subject</label>
                            <select name="subject" class="form-control" required>
                                <option value="" selected>Select Subject</option>

                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}({{ $subject->code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('subject'))
                            <div class="error">{{ $errors->first('subject') }}</div>
                        @endif


                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
