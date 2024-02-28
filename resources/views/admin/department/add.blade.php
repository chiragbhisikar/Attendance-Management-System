@extends('layouts.admin.master')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="container-fluid">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><a href="{{ route('admin.branch') }}">Subjects</a></h1>
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

        <!-- Content Row -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <!-- Card Body -->
                    <div class="card-body">
                        <form action="{{ route('admin.save-branch') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="department">Department Name</label>
                                <select name="department_type_id" class="form-control" required>
                                    <option value="" selected>Select Department</option>

                                    @foreach ($department_types as $department_type)
                                        <option value="{{ $department_type->id }}">
                                            {{ $department_type->department_type_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('department_type_id'))
                                <div class="error">{{ $errors->first('department_type_id') }}</div>
                            @endif


                            <div class="form-group">
                                <label for="code">Branch Code</label>
                                <input type="number" class="form-control" placeholder="Enter Branch Code"
                                    name="branch_code" required>
                            </div>
                            @if ($errors->has('branch_code'))
                                <div class="error">{{ $errors->first('branch_code') }}</div>
                            @endif

                            <div class="form-group">
                                <label for="name">Branch Name</label>
                                <input type="text" class="form-control" placeholder="Enter Branch Name"
                                    name="branch_name" required>
                            </div>
                            @if ($errors->has('branch_name'))
                                <div class="error">{{ $errors->first('branch_name') }}</div>
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
