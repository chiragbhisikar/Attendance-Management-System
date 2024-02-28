@extends('layouts.admin.master')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="container-fluid">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><a href="{{ route('admin.subject') }}">Subjects</a></h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('admin.subject') }}">Subject</a></li>
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
                        <form action="{{ route('admin.save-subject') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="code">Subject Code</label>
                                <input type="number" class="form-control" placeholder="Enter Subject Code" name="code"
                                    required>
                            </div>
                            @if ($errors->has('code'))
                                <div class="error">{{ $errors->first('code') }}</div>
                            @endif

                            <div class="form-group">
                                <label for="name">Subject Name</label>
                                <input type="text" class="form-control" placeholder="Enter Subject Name" name="name"
                                    required>
                            </div>
                            @if ($errors->has('name'))
                                <div class="error">{{ $errors->first('name') }}</div>
                            @endif

                            <div class="form-group">
                                <label for="name">Subject Short Name</label>
                                <input type="text" class="form-control" placeholder="Enter Subject Short Name" name="short_name"
                                    required>
                            </div>
                            @if ($errors->has('short_name'))
                                <div class="error">{{ $errors->first('short_name') }}</div>
                            @endif
                            
                            <div class="form-group">
                                <label for="department">Department</label>
                                <select class="form-control select2 select2" style="width: 100%;" data-select2-id="1"
                                    tabindex="-1" aria-hidden="true" name="department_id">
                                    
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">
                                            {{ $department->department_name }}
                                            ({{ $department->department_type->department_type_name }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('department_id'))
                                <div class="error">{{ $errors->first('department_id') }}</div>
                            @endif

                            <div class="form-group">
                                <label for="sem">Sem</label>
                                <select class="form-control select2 select2" style="width: 100%;" data-select2-id="1"
                                    tabindex="-1" aria-hidden="true" name="sem">
                                    <option selected="selected" value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                </select>
                            </div>

                            @if ($errors->has('sem'))
                                <div class="error">{{ $errors->first('sem') }}</div>
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
