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
                        <h1 class="m-0"><a href="{{ route('admin.time-table') }}">Lecture</a></h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('admin.time-table') }}">Lecture</a>
                            </li>
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
                        <form action="{{ route('admin.save-time-table') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="division">Select Division</label>
                                <select name="division_id" id="division"class="form-control" required>
                                    <option value="" selected>Select Division</option>
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division->id }}">{{ $division->department->department_name }} -
                                            {{ $division->division_name }} - {{ $division->admission_year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('division_id'))
                                <div class="error">{{ $errors->first('division_id') }}</div>
                            @endif

                            @php
                                $days = getDayList();
                            @endphp

                            <div class="form-group">
                                <label for="subject">Select Day</label>
                                <select name="day_id" class="form-control" required>
                                    <option value="" selected>Select Day</option>
                                    @foreach ($days as $day)
                                        <option value="{{ $day['id'] }}">{{ $day['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('day_id'))
                                <div class="error">{{ $errors->first('day_id') }}</div>
                            @endif


                            <div class="form-group">
                                <label for="faculty">Select Faculty</label>
                                <select name="faculty_id" id="faculty"class="form-control" required>
                                    <option value="" selected>Select Faculty</option>
                                    @foreach ($faculties as $faculty)
                                        <option value="{{ $faculty->id }}">{{ $faculty->first_name }}
                                            {{ $faculty->middle_name }}
                                            {{ $faculty->last_name }}
                                            ({{ $faculty->email }})
                                            -({{ $faculty->department->department_name }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('faculty_id'))
                                <div class="error">{{ $errors->first('faculty_id') }}</div>
                            @endif


                            <div class="form-group">
                                <label for="sem">Sem</label>
                                <select class="form-control select2 select2" id = "sem" style="width: 100%;"
                                    data-select2-id="1" tabindex="-1" aria-hidden="true" name="sem" required>
                                    <option value="" selected>Select Sem</option>
                                    @for ($i = 1; $i <= 8; $i++)
                                        <option value="{{ $i }}">
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            @if ($errors->has('sem'))
                                <div class="error">{{ $errors->first('sem') }}</div>
                            @endif


                            <div class="form-group">
                                <label for="subject">Select Subject</label>
                                <select name="subject_id" id="subject"class="form-control" required>
                                    <option value="" selected>Select Subject</option>
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }} ({{ $subject->code }})
                                            ({{ $subject->department->department_name }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('subject_id'))
                                <div class="error">{{ $errors->first('subject_id') }}</div>
                            @endif


                            <div class="form-group">
                                <label for="start_time">Enter Lecture Starting Time</label>
                                <div class="input-group date" id="stimePicker">
                                    <input type="time" id="start_time" class="form-control timePicker"
                                        placeholder="Enter Lecture Starting Time" name="start_time" required>
                                    <span class="input-group-addon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                                </div>
                            </div>
                            @if ($errors->has('start_time'))
                                <div class="error">{{ $errors->first('start_time') }}</div>
                            @endif


                            <div class="form-group">
                                <label for="end_time">Enter Lecture Ending Time</label>
                                <div class="input-group date" id="etimePicker">
                                    <input type="time" class="form-control timePicker"
                                        placeholder="Enter Lecture Ending Time" name="end_time" required>
                                    <span class="input-group-addon">
                                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                            @if ($errors->has('end_time'))
                                <div class="error">{{ $errors->first('end_time') }}</div>
                            @endif


                            <div class="form-group">
                                <label for="term_start_date	">Enter Term Start Date</label>
                                <input type="date" class="form-control" placeholder="Enter Term Start Date"
                                    name="term_start_date" required>
                            </div>
                            @if ($errors->has('term_start_date'))
                                <div class="error">{{ $errors->first('term_start_date') }}</div>
                            @endif

                            <div class="form-group">
                                <label for="term_end_date	">Enter Term End Date</label>
                                <input type="date" class="form-control" placeholder="Enter Term End Date"
                                    name="term_end_date" required>
                            </div>
                            @if ($errors->has('term_end_date'))
                                <div class="error">{{ $errors->first('term_end_date') }}</div>
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

    <script>
        document.getElementById("division").addEventListener("change", getFaculty);
        document.getElementById("sem").addEventListener("change", getSubject);

        function getFaculty() {
            var division = document.getElementById('division').value;

            if (division != '') {
                $.ajax({
                    url: '{{ route('admin.get-faculty') }}',
                    data: {
                        'division': division,
                    },
                    cache: false,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // console.log(response);
                        document.getElementById('faculty').innerHTML = '';
                        let faculties = response.faculties;
                        let facultyhtml = '<option value="" selected>Select Faculty</option>';
                        for (let index = 0; index < faculties.length; index++) {
                            let str = '';
                            str =
                                `<option value="${faculties[index].id}">${faculties[index].first_name} ${faculties[index].middle_name} ${faculties[index].last_name} (${faculties[index].email})-(${faculties[index].department.department_name})</option>`;
                            facultyhtml = facultyhtml + str;
                        }
                        document.getElementById('faculty').innerHTML = facultyhtml;
                    }
                })
            }
        }

        function getSubject() {
            var division = document.getElementById('division').value;
            var sem = document.getElementById('sem').value;

            if (division != '') {
                $.ajax({
                    url: '{{ route('admin.get-subject') }}',
                    data: {
                        'division': division,
                        'sem': sem,
                    },
                    cache: false,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // console.log(response);

                        document.getElementById('subject').innerHTML = '';
                        let subjects = response.subjects;
                        let subjecthtml = '<option value="" selected>Select Subject</option>';
                        for (let index = 0; index < subjects.length; index++) {
                            let str = '';
                            str =
                                `<option value="${subjects[index].id}">${subjects[index].name} (${subjects[index].code}) (${subjects[index].department.department_name})</option>`;
                            subjecthtml = subjecthtml + str;
                        }
                        document.getElementById('subject').innerHTML = subjecthtml;
                    }
                })
            }
        }
    </script>

    <!-- Bootstrap Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js">
    </script>

    <script id="rendered-js">
        var firstOpen = true;
        var time;

        $("#stimePicker")
            .datetimepicker({
                useCurrent: false,
                format: "HH:mm",
                stepping: 15,
            })
            .on("dp.show", function() {
                if (firstOpen) {
                    time = moment().startOf("time");
                    firstOpen = false;
                } else {
                    time = "01:00";
                }

                $(this).data("DateTimePicker").date(time);
            });
    </script>

    <script id="rendered-js">
        var firstOpen = true;
        var time;

        $("#etimePicker")
            .datetimepicker({
                useCurrent: false,
                format: "HH:mm",
                stepping: 15,
            })
            .on("dp.show", function() {
                if (firstOpen) {
                    time = moment().startOf("day");
                    firstOpen = false;
                } else {
                    time = "01:00";
                }
                console.log(document.getElementById('start_time').value);
                $(this).data("DateTimePicker").date(time);
            });
    </script>
@endsection
