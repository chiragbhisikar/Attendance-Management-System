@extends('layouts.admin.master')
@section('css')
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><a href="{{ route('admin.lecture') }}">Time Table</a></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('admin.lecture') }}">Lecture</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Time Table</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 120px;">
                                    {{-- <div class="input-group-append">
                                        <a href="{{ route('admin.add-lecture') }}">
                                            <button type="button" class="btn btn-primary">
                                                Add Lecture In Time Table
                                            </button>
                                        </a>
                                    </div> --}}
                                    {{-- <input type="text" name="table_search" class="form-control float-right"
                                        placeholder="Search">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div> --}}
                                </div>
                            </div>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Class Name</th>
                                        <th>Sem</th>
                                        <th>Start - End</th>
                                        <th>Faculty Name</th>
                                        <th>OTP</th>
                                        <th>View TimeTable</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lectures as $lecture)
                                        <tr>
                                            <td>{{ $lecture->date_of_lecture }}</td>
                                            <td>
                                                {{ $lecture->timetable->division->department->department_name }} -
                                                {{ $lecture->timetable->division->division_name }} -
                                                {{ $lecture->timetable->division->admission_year }}</td>
                                            </td>
                                            <td>{{ $lecture->timetable->sem }}</td>
                                            <td>{{ $lecture->timetable->start_time }} -
                                                {{ $lecture->timetable->end_time }}</td>

                                            @php
                                                $faculties = $timetable->getFaculties($lecture->timetable->id, $lecture->timetable->is_lab);
                                            @endphp
                                            <td>
                                                @if ($lecture->timetable->is_lab)
                                                    @foreach ($faculties as $faculty)
                                                        {{ $lecture->timetable->subject->short_name }} -
                                                        {{ $faculty->lab_name }} -
                                                        {{ $faculty->short_name }}<br>
                                                    @endforeach
                                                @else
                                                    {{ $lecture->timetable->subject->short_name }} -
                                                    {{ $faculties->short_name }}
                                                @endif
                                            </td>
                                            <td>{{ $lecture->otp }}</td>
                                            <td>
                                                <a
                                                    href="{{ route('admin.view-time-table') }}?division={{ $lecture->timetable->division->id }}&sem={{ $lecture->timetable->sem }}">
                                                    <button type="button" class="btn btn-block btn-info">View
                                                        Timetable</button>
                                                </a>
                                                <br>
                                                {{-- <a
                                                    href="{{ route('admin.view-attendance') }}?division={{ $lecture->timetable->division->id }}&lecture={{ $lecture->id }}">
                                                    <button type="button" class="btn btn-block btn-info">View
                                                        Attendance</button>
                                                </a> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end pr-2">
                            {!! $lectures->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
