@extends('layouts.student.master')
@section('css')
@endsection
@section('content')
    <link rel="stylesheet" href="{{ asset('custom/faculty/calender.css') }}" />
    <div class="content-header">
        @if (Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ Session::get('error') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ Session::get('success') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <a href="{{ route('student.dashboard') }}">Today's Lecture</a>
                    </h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('student.dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ route('student.dashboard') }}">Dashboard</a>
                        </li>
                    </ol>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- Content Header (Page header) -->
    <!-- /.content-header -->
    <div class="container-fluid">
        <div class="Calendar">
            <div class="Calendar-day">
                <header class="Calendar-dayHeader">
                    <div class="Calendar-date">
                        <div class="Calendar-dateMo">
                            {{ date('d M', strtotime($date_of_lecture ?? '')) }}
                        </div>
                        <div class="Calendar-dateWk">
                            {{ date('D', strtotime($date_of_lecture ?? '')) }}
                        </div>
                    </div>
                </header>

                <ul class="Calendar-entries">
                    @foreach ($lectures ?? '' as $lecture)
                        @if ($lecture ?? '')
                            <li class="Calendar-entry">
                                <div class="Calendar-entryTime">
                                    {{ date('h:i a', strtotime($lecture->start_time)) }}&ndash;
                                    {{ date('h:i a', strtotime($lecture->end_time)) }}
                                </div>
                                <div class="Calendar-entryDesc">
                                    {{ $lecture->timetable->subject->name }}({{ $lecture->timetable->subject->code }})
                                </div>
                                @if ($lecture->is_open)
                                    @if (checkAttended($lecture->id, $student->id))
                                        <button class="btn btn-primary my-2">
                                            Attended Lecture
                                        </button>
                                    @else
                                        <a href="{{ route('student.give-attendance') }}?lecture={{ $lecture->slug }}">
                                            <button class="btn btn-primary my-2">
                                                Give Attendance
                                            </button>
                                        </a>
                                    @endif
                                @endif
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
