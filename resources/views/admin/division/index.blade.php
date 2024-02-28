@extends('layouts.admin.master')
@section('css')
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><a href="{{ route('admin.division') }}">Classes</a></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('admin.division') }}">Class</a></li>
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
                            <h3 class="card-title">Class</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 120px;">

                                    <div class="input-group-append">
                                        <a href="{{ route('admin.add-division') }}">
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#exampleModal">
                                                Add Class
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
                                        <th>Class ID</th>
                                        <th>Class Name</th>
                                        <th>Department Name</th>
                                        <th>Admission Year</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($divisions as $division)
                                        <tr>
                                            <td>{{ $division->id }}</td>
                                            <td>{{ $division->division_name }}</td>
                                            <td>{{ $division->department->department_name }}</td>
                                            <td>{{ $division->admission_year }}</td>
                                            <td>
                                                <a
                                                    href="{{ route('admin.edit-division') }}?division_id={{ $division->id }}">
                                                    <button type="button" class="btn btn-block btn-info">Edit</button>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end pr-2">
                            {!! $divisions->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
