@extends('layouts.faculty.master')
@section('css')
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        /* Hide default HTML checkbox */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
@endsection
@section('content')
    <link rel="stylesheet" href="{{ asset('custom/faculty/calender.css') }}">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><a href="{{ route('faculty.dashboard') }}">Today's Lecture</a></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('faculty.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('faculty.dashboard') }}">Dashboard</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- Content Header (Page header) -->
    <!-- /.content-header -->
    <div class="container-fluid">
        <div class="Calendar">
            <div class="Calendar-day">
                <header class="Calendar-dayHeader">
                    <div class="Calendar-date">
                        <div class="Calendar-dateMo">{{ date('d M', strtotime($date_of_lecture)) }}</div>
                        <div class="Calendar-dateWk">{{ date('D', strtotime($date_of_lecture)) }}</div>
                    </div>
                </header>

                <ul class="Calendar-entries">
                    @foreach ($lectures as $lecture)
                        @php
                            $timetable = getTimeTable($lecture->time_table_id);
                        @endphp

                        <li class="Calendar-entry">
                            <div style="display: flex;justify-content: space-between;">
                                <div class="Calendar-entryTime">
                                    <h2>
                                        {{ date('h:i a', strtotime($lecture->start_time)) }} &ndash;
                                        {{ date('h:i a', strtotime($lecture->end_time)) }}
                                    </h2>
                                </div>

                                <div>
                                    <label class="switch">
                                        <input type="checkbox" {{ $lecture->is_open == 1 ? 'checked' : '' }}
                                            lecture-id="{{ $lecture->id }}" class="vribtn">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="Calendar-entryDesc">
                                {{ $timetable->subject->name }}({{ $timetable->subject->code }})</div>
                            <div class="Calendar-entryDesc">
                                {{ $timetable->division->department->department_name }} -
                                {{ $timetable->division->current_sem }}{{ $timetable->division->division_name }}
                                -
                                {{ $timetable->division->admission_year }}
                            </div>

                            <div class="Calendar-entryDesc">
                                OTP : {{ $lecture->otp }}
                            </div>
                            

                            @if ($timetable->is_lab)
                                <div class="Calendar-entryDesc">
                                    Lab : {{ $lecture->lab_name }}
                                </div>
                            @endif
                            <br>
                            <div class="flex">
                                <a href="{{ route('faculty.rescheduled-lecture') }}?lecture={{ $lecture->slug }}">
                                    <button class="btn btn-primary">Reschedule Lecture</button>
                                </a>
                                {{-- <a href="{{ route('faculty.take-attendance') }}?lecture={{ $lecture->slug }}">
                                    <button class="btn btn-primary">Fill Attendance</button>
                                </a> --}}
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $('.vribtn').click(function() {
            var id = $(this).attr('lecture-id');

            var rote = "{{ route('faculty.control-lecture') }}?lecture_id=" + id;

            $.ajax({
                url: rote,
                success: function(result) {
                    window.location.href = '';
                }
            });
        });
    </script>
@endsection

{{-- <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><a href="{{ route('faculty.dashboard') }}">Today's Lecture</a></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('faculty.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('faculty.dashboard') }}">Dashboard</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->

        <div class="container-fluid mt-4">
            <div class="row">
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box bg-info">
                            <span class="info-box-icon"><i class="far fa-bookmark"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Bookmarks</span>
                                <span class="info-box-number">41,410</span>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 70%"></div>
                                </div>
                                <span class="progress-description">
                                    70% Increase in 30 Days
                                </span>
                            </div>

                        </div>

                    </div>

                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box bg-success">
                            <span class="info-box-icon"><i class="far fa-thumbs-up"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Likes</span>
                                <span class="info-box-number">41,410</span>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 70%"></div>
                                </div>
                                <span class="progress-description">
                                    70% Increase in 30 Days
                                </span>
                            </div>

                        </div>

                    </div>
                    @foreach ($lectures as $lecture)
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3 style="font-size: 23px;">{{ $lecture->timetable->subject->name }}</h3>
                                <p>{{ $lecture->timetable->division->department->department_name }}
                                    {{ $lecture->timetable->division->division_name }} -
                                    {{ $lecture->timetable->division->admission_year }}</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-ban fa-2x text-gray-300"></i>
                            </div>
                            <a href="" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                @endforeach
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box bg-warning">
                            <span class="info-box-icon"><i class="far fa-calendar-alt"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Events</span>
                                <span class="info-box-number">41,410</span>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 70%"></div>
                                </div>
                                <span class="progress-description">
                                    70% Increase in 30 Days
                                </span>
                            </div>

                        </div>

                    </div>

                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box bg-danger">
                            <span class="info-box-icon"><i class="fas fa-comments"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Comments</span>
                                <span class="info-box-number">41,410</span>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 70%"></div>
                                </div>
                                <span class="progress-description">
                                    70% Increase in 30 Days
                                </span>
                            </div>

                        </div>

                    </div>

                </div>
               
            </div>
        </div>
    </div> --}}
