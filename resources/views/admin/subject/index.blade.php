@extends('layouts.admin.master')
@section('css')
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><a href="{{ route('admin.subject') }}">Subjects</a></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    </ol>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
    {{-- <div class="col-sm-6 ">
        <div class="form-group ">
            <form action="{{ route('admin.filter-subject') }}" method="get">
                <select class="form-control select2 " style="width: 100%;" data-select2-id="1" tabindex="-1"
                    aria-hidden="true" name="department" onchange="filterData()" id="department">
                    <option selected="selected">Select Department</option>
                    @foreach ($departments as $department)
                        @if ($department_id ?? '' == $department->id)
                            <option value="{{ $department->id }}" selected>
                                {{ $department->department_name }}
                            </option>
                        @else
                            <option value="{{ $department->id }}">
                                {{ $department->department_name }}
                            </option>
                        @endif
                    @endforeach
                </select>

                <select class="form-control select2 select2" style="width: 100%;" data-select2-id="1" tabindex="-1"
                    aria-hidden="true" name="sem">
                    <option selected="selected" value="" selected>Select Sem</option>

                    @for ($i = 1; $i <= 8; $i++)
                        <option value="{{ $i }}">
                            {{ $i }}
                        </option>
                    @endfor
                </select>
                <input type="submit" value="submit" style="display: none;" id="submit-btn">
            </form>
        </div>
    </div> --}}

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Subjects</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 120px;">

                                    <div class="input-group-append">
                                        <a href="{{ route('admin.add-subject') }}">
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#exampleModal">
                                                Add Subject
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
                                        <th>Subject Code</th>
                                        <th>Department</th>
                                        <th>Subject Name</th>
                                        <th>Sem</th>
                                        <th>Edit</th>
                                        {{-- <th>Delete</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subjects as $subject)
                                        <tr>
                                            <td>{{ $subject->code }}</td>
                                            <td>{{ $subject->department->department_name }}</td>
                                            <td>{{ $subject->name }} ({{ $subject->short_name }})</td>
                                            <td><span class="tag tag-success">{{ $subject->sem }}</span></td>
                                            <td>
                                                <a href="{{ route('admin.edit-subject') }}?subject_id={{ $subject->id }}">
                                                    <button type="button" class="btn btn-block btn-info">Edit</button>
                                                </a>
                                            </td>
                                            {{-- <td><button type="button" class="btn btn-block btn-danger">Delete</button></td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end pr-2">
                            {!! $subjects->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.getElementById("department").addEventListener("change", filterData);

        function filterData() {
            document.getElementById('submit-btn').click();
        }
    </script>
@endsection
