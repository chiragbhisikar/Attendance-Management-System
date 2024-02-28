@extends('layouts.admin.master')
@section('css')
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><a href="{{ route('admin.branch') }}">Departments</a></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('admin.branch') }}">Department</a></li>
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
                            <h3 class="card-title">Department</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 120px;">

                                    <div class="input-group-append">
                                        <a href="{{ route('admin.add-branch') }}">
                                            <button type="button" class="btn btn-primary">
                                                Add Department
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
                                        <th>Branch Code</th>
                                        <th>Branch Name</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($departments as $department)
                                        <tr>
                                            <td>{{ $department->department_code }}</td>
                                            <td>{{ $department->department_name }}</td>
                                            <td>
                                                <a href="{{ route('admin.edit-branch') }}?branch_id={{ $department->id }}">
                                                    <button type="button" class="btn btn-block btn-info">Edit</button>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end pr-2">
                            {!! $departments->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
