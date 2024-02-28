@extends('layouts.admin.master')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="container-fluid">
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

        <!-- Content Row -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <!-- Card Body -->
                    <div class="card-body">
                        <form action="{{ route('admin.update-branch') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="text" name="department_id" value="{{ $department->id }}" style="display: none;">


                            <div class="form-group">
                                <label for="department">Department</label>
                                <select class="form-control select2 select2" style="width: 100%;" data-select2-id="1"
                                    tabindex="-1" aria-hidden="true" name="department_type_id">
                                    <option value="">
                                        Select Department Type
                                    </option>
                                    @foreach ($department_types as $department_type)
                                        @if ($department_type->id == $department->department_type_id)
                                            <option value="{{ $department_type->id }}" selected>
                                                {{ $department_type->department_type_name }}
                                            </option>
                                        @else
                                            <option value="{{ $department_type->id }}">
                                                {{ $department_type->department_name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('department_type_id'))
                                <div class="error">{{ $errors->first('department_type_id') }}</div>
                            @endif



                            <div class="form-group">
                                <label for="branch_code">Branch Code</label>
                                <input type="number" class="form-control" placeholder="Enter Branch Code"
                                    name="branch_code" value="{{ $department->department_code }}" required>
                            </div>
                            @if ($errors->has('code'))
                                <div class="error">{{ $errors->first('code') }}</div>
                            @endif


                            <div class="form-group">
                                <label for="branch_name">Branch Name</label>
                                <input type="text" class="form-control" placeholder="Enter Branch Code"
                                    name="branch_name" value="{{ $department->department_name }}" required>
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
