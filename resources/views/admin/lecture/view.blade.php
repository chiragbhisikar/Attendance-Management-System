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

    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Calendar
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table class="table table-bordered">
                            <thead>
                                <th width="125">Time</th>
                                @foreach ($weekDays as $day)
                                    <th>{{ $day }}</th>
                                @endforeach
                            </thead>
                            <tbody>
                                @foreach ($calendarData as $time => $days)
                                    <tr>
                                        <td>
                                            {{ $time }}
                                        </td>
                                        @foreach ($days as $value)
                                            @if (is_array($value))
                                                <td rowspan="{{ $value['rowspan'] }} ?? 0" class="align-middle text-center"
                                                    style="background-color:#f0f0f0">
                                                    {{ $value['subject']->name }}
                                                    <br>
                                                    Teacher: {{ $value['faculty']->first_name }}
                                                    {{ $value['faculty']->middle_name }} {{ $value['faculty']->last_name }}
                                                </td>
                                            @elseif ($value === 1)
                                                <td></td>
                                            @endif
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
