@extends('layouts.admin.master')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="container-fluid">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><a href="{{ route('admin.faculty') }}">Faculties</a></h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('admin.faculty') }}">Faculty</a></li>
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
                        <form action="{{ route('admin.update-faculty') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="text" name="faculty_id" value="{{ $faculty->id }}" style="display: none;">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" name="first_name" class="form-control" placeholder="Enter First Name"
                                    required value={{ $faculty->first_name }}>
                                @if ($errors->has('first_name'))
                                    <div class="error">{{ $errors->first('first_name') }}</div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" name="last_name" class="form-control" placeholder="Enter Last Name"
                                    required value={{ $faculty->last_name }}>
                                @if ($errors->has('last_name'))
                                    <div class="error">{{ $errors->first('last_name') }}</div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="middle_name">Middle Name</label>
                                <input type="text" name="middle_name" class="form-control"
                                    placeholder="Enter Middle Name" required value={{ $faculty->middle_name }}>
                                @if ($errors->has('middle_name'))
                                    <div class="error">{{ $errors->first('middle_name') }}</div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="email" class="form-control" placeholder="Enter Email" required
                                    value={{ $faculty->email }}>
                                @if ($errors->has('email'))
                                    <div class="error">{{ $errors->first('email') }}</div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="email">Short Name</label>
                                <input type="text" name="short_name" class="form-control" placeholder="Enter Short Name"
                                    required value={{ $faculty->short_name }}>
                                @if ($errors->has('short_name'))
                                    <div class="error">{{ $errors->first('short_name') }}</div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="phone_number">Phone Number</label>
                                <input type="text" name="phone_number" class="form-control"
                                    placeholder="Enter Phone Number" required value={{ $faculty->phone_number }}>
                                @if ($errors->has('phone_number'))
                                    <div class="error">{{ $errors->first('phone_number') }}</div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="department">Department Name</label>
                                <select name="department_id" class="form-control" required>
                                    <option value="">Select Department</option>

                                    @foreach ($departments as $department)
                                        @if ($department->id == $faculty->department_id)
                                            <option value="{{ $department->id }}" selected>
                                                {{ $department->department_name }}</option>
                                        @else
                                            <option value="{{ $department->id }}" selected>
                                                {{ $department->department_name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('department_id'))
                                    <div class="error">{{ $errors->first('department_id') }}</div>
                                @endif
                            </div>
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
