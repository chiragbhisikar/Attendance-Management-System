@extends('layouts.faculty.master')
@section('css')
@endsection
@section('content')
    <div class="container-fluid">
        @if (Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ Session::get('error') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="content-header">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><a href="{{ route('faculty.rescheduled-lecture') }}">Reschedule Lecture</a></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('faculty.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('faculty.rescheduled-lecture') }}">Reschedule
                                Lecture</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.content-header -->



        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <!-- Card Body -->
                    <h1 class="m-2">{{ $lecture->timetable->division->department->department_name }} -
                        {{ $lecture->timetable->division->division_name }} -
                        {{ $lecture->timetable->division->admission_year }}
                        - {{ $lecture->timetable->subject->name }}
                    </h1>
                    <div class="card-body">
                        <form action="{{ route('faculty.save-reschedule-lecture') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="text" name="lecture" style="display: none;" value="{{ $lecture->slug }}">
                            <div class="form-group">
                                <label for="lecture_start_time">Enter Lecture Start Time</label>
                                <input type="time" class="form-control" placeholder="Enter Lecture Start Time"
                                    name="lecture_start_time" value="{{ $lecture->start_time }}" required>
                            </div>
                            @if ($errors->has('lecture_start_time'))
                                <div class="error">{{ $errors->first('lecture_start_time') }}</div>
                            @endif

                            <div class="form-group">
                                <label for="lecture_end_time">Enter Lecture End Time</label>
                                <input type="time" class="form-control" placeholder="Enter Lecture End Time"
                                    name="lecture_end_time" value="{{ $lecture->end_time }}" required>
                            </div>
                            @if ($errors->has('lecture_end_time'))
                                <div class="error">{{ $errors->first('lecture_end_time') }}</div>
                            @endif

                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-primary">Reschedule Lecture</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
@endsection
