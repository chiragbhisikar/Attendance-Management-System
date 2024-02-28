@extends('layouts.admin.master')
@section('content')
    <style>
        .ui-datepicker-calendar {
            display: none;
        }
    </style>

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css">


    <!-- Content Header (Page header) -->
    <div class="container-fluid">
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

        <!-- Content Row -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <!-- Card Body -->
                    <div class="card-body">
                        <form action="{{ route('admin.save-division') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="department">Department Name</label>
                                <select name="department_id" class="form-control" required>
                                    <option value="" selected>Select Department</option>

                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('department_id'))
                                <div class="error">{{ $errors->first('department_id') }}</div>
                            @endif


                            <div class="form-group">
                                <label for="division_name">Class Name</label>
                                <input type="text" class="form-control" placeholder="Enter Class Name"
                                    name="division_name" required maxlength="1" onkeyup="validate(this);">
                            </div>
                            @if ($errors->has('division_name'))
                                <div class="error">{{ $errors->first('division_name') }}</div>
                            @endif

                            <div class="form-group">
                                <label for="admission_year">Admission Year</label>
                                <input type="text" class="date-own form-control"
                                    style="width: 100%;"placeholder="Enter Admission Year" name="admission_year">
                            </div>
                            @if ($errors->has('admission_year'))
                                <div class="error">{{ $errors->first('admission_year') }}</div>
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

    <script type="text/javascript">
        function validate(input) {
            input.value = input.value.replace(/\W|\d/g, '').substr(0, 1).toUpperCase();
        }
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>

    <script>
        $('.date-own').datepicker({
            minViewMode: 2,
            format: 'yyyy'
        });
    </script>
@endsection
