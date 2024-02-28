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
                        <form action="{{ route('admin.update-subject') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="text" name="subject_id" value="{{ $subject->id }}" style="display: none;">
                            <div class="form-group">
                                <label for="code">Subject Code</label>
                                <input type="number" class="form-control" placeholder="Enter Subject Code" name="code"
                                    value="{{ $subject->code }}" required>
                            </div>
                            @if ($errors->has('code'))
                                <div class="error">{{ $errors->first('code') }}</div>
                            @endif

                            <div class="form-group">
                                <label for="name">Subject Name</label>
                                <input type="text" class="form-control" placeholder="Enter Subject Code" name="name"
                                    value="{{ $subject->name }}" required>
                            </div>
                            @if ($errors->has('name'))
                                <div class="error">{{ $errors->first('name') }}</div>
                            @endif

                            <div class="form-group">
                                <label for="name">Subject Short Name</label>
                                <input type="text" class="form-control" placeholder="Enter Subject Short Name"
                                    name="name" value="{{ $subject->short_name }}" required>
                            </div>
                            @if ($errors->has('short_name'))
                                <div class="error">{{ $errors->first('short_name') }}</div>
                            @endif

                            <div class="form-group">
                                <label for="department">Department</label>
                                <select class="form-control select2 select2" style="width: 100%;" data-select2-id="1"
                                    tabindex="-1" aria-hidden="true" name="department_id">
                                    @foreach ($departments as $department)
                                        @if ($department->id == $subject->department_id)
                                            <option value="{{ $department->id }}" selected>
                                                {{ $department->department_name }}
                                                ({{ $department->department_type->department_type_name }})
                                            </option>
                                        @else
                                            <option value="{{ $department->id }}">
                                                {{ $department->department_name }}
                                                ({{ $department->department_type->department_type_name }})
                                            </option>
                                        @endif
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

                                    @for ($i = 1; $i <= 8; $i++)
                                        @if ($i == $subject->sem)
                                            <option selected="selected" value="{{ $i }}" selected>
                                                {{ $i }}
                                            </option>
                                        @else
                                            <option value="{{ $i }}">
                                                {{ $i }}
                                            </option>
                                        @endif
                                    @endfor
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
