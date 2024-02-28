@extends('layouts.admin.master')
@section('css')
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><a href="{{ route('admin.time-table') }}">Time Table</a></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('admin.time-table') }}">Schedule
                                Time Table</a></li>
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
                                    <div class="input-group-append">
                                        <a href="{{ route('admin.add-time-table') }}">
                                            <button type="button" class="btn btn-primary">
                                                Import Timetable
                                            </button>
                                        </a>
                                    </div>
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
                                        <th>Day</th>
                                        <th>Time</th>
                                        <th>Class Name</th>
                                        <th>Sem</th>
                                        {{-- <th>Subject Name</th> --}}
                                        <th>Faculty Name</th>
                                        <th>Term Start Date</th>
                                        <th>Term End Date</th>
                                        <th>Edit</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($timetables as $timetable)
                                        <tr>
                                            <td>{{ getDay($timetable->weekday) }}</td>
                                            <td>{{ $timetable->start_time }} - {{ $timetable->end_time }}</td>
                                            <td>{{ $timetable->division->department->department_name }} -
                                                {{ $timetable->division->division_name }} -
                                                {{ $timetable->division->admission_year }}
                                            </td>
                                            <td>{{ $timetable->sem }}</td>
                                            @php
                                                $faculties = $timetable->getFaculties($timetable->id, $timetable->is_lab);
                                            @endphp
                                            <td>
                                                @if ($timetable->is_lab)
                                                    @foreach ($faculties as $faculty)
                                                        {{ $timetable->subject->short_name ?? '' }} -
                                                        {{ $faculty->lab_name }} -
                                                        {{ $faculty->short_name }}<br>
                                                    @endforeach
                                                @else
                                                    {{ $timetable->subject->short_name ?? '' }} -
                                                    {{ $faculties->short_name }}
                                                @endif
                                            </td>
                                            <td>{{ $timetable->term_start_date }}</td>
                                            <td>{{ $timetable->term_end_date }}</td>
                                            <td>
                                                <a
                                                    href="{{ route('admin.edit-time-table') }}?timetable={{ $timetable->id }}">
                                                    <button type="button" class="btn btn-block btn-info">Edit</button>
                                                </a>
                                            </td>
                                            <td>
                                                <a
                                                    href="{{ route('admin.view-time-table') }}?division={{ $timetable->division->id }}&sem={{ $timetable->sem }}">
                                                    <button type="button" class="btn btn-block btn-info">View</button>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end pr-2">
                            {!! $timetables->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
