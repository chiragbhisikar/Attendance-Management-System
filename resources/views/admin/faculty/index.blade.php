@extends('layouts.admin.master')
@section('css')
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><a href="{{ route('admin.faculty') }}">Faculties</a></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right mb-2">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('admin.faculty') }}">Faculty</a></li>
                    </ol>
                    <div class="form-group mt-4">
                        <form action="{{ route('admin.filter-faculty') }}" method="get">
                            <select class="form-control select2 " style="width: 100%;" data-select2-id="1" tabindex="-1"
                                aria-hidden="true" name="department" onchange="filterData()" id="department">
                                <option selected="selected">Select Department</option>
                                @foreach ($departments as $department)
                                    @if ($department_id == $department->id)
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
                            <input type="submit" value="submit" style="display: none;" id="submit-btn">
                        </form>
                    </div>
                </div><!-- /.col -->
            </div><!-- /.container-fluid -->
        </div><!-- /.row -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Faculties</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 120px;">

                                    <div class="input-group-append">
                                        <a href="{{ route('admin.add-faculty') }}">
                                            <button type="button" class="btn btn-primary">
                                                Add Faculty
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Edit</th>
                                        <th>Password</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($faculties as $faculty)
                                        <tr>
                                            <td>{{ $faculty->first_name }} {{ $faculty->middle_name }}
                                                {{ $faculty->last_name }} </td>
                                            <td>{{ $faculty->department->department_name }}</td>
                                            <td>{{ $faculty->email }}</td>
                                            <td>{{ $faculty->phone_number }}</td>
                                            <td>
                                                <a
                                                    href="{{ route('admin.edit-faculty') }}?faculty_id={{ $faculty->id }}">
                                                    <button type="button" class="btn btn-block btn-info">Edit</button>
                                                </a>
                                            </td>
                                            <td>
                                                <a
                                                    href="{{ route('admin.forget-password-faculty') }}?faculty_id={{ $faculty->id }}">
                                                    <button type="button" class="btn btn-block btn-danger">Change
                                                        Password</button>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end pr-2">
                            {!! $faculties->links() !!}
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
