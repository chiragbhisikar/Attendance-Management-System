@extends('layouts.student.master') @section('content')
    <!-- Content Header (Page header) -->
    <div class="container-fluid">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">
                            <a href="">Give Attendance Of
                                {{ $lectureDetail->timetable->subject->name }}</a>
                        </h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Home</a></li>
                            <li class="breadcrumb-item active">
                                <a href="">Give Attendance</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <a href="">{{ $lectureDetail->date_of_lecture }} : </a>
                            </li>
                        </ol>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <style>
            /* body {
                                                margin: 0;
                                                font-family: "Poppins", sans-serif;
                                                display: flex;
                                                justify-content: center;
                                                align-items: center;
                                                flex-direction: column;
                                                background: #282a36;
                                                height: 100vh;
                                                color: #fff;
                                            } */

            .otp-field {
                display: flex;
            }

            .otp-field input {
                width: 50px;
                font-size: 32px;
                padding: 10px;
                text-align: center;
                border-radius: 5px;
                margin: 2px;
                border: 2px solid #55525c;
                background: #21232d;
                font-weight: bold;
                color: #fff;
                outline: none;
                transition: all 0.1s;
            }

            .otp-field input:focus {
                border: 2px solid #a527ff;
                box-shadow: 0 0 2px 2px #a527ff6a;
            }

            .disabled {
                opacity: 0.5;
            }

            .space {
                margin-right: 1rem !important;
            }
        </style>
        <!-- Content Row -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <!-- Card Body -->
                    <div class="card-body">
                        <form action="{{ route('student.save-attendance') }}" method="POST">
                            @csrf
                            <h1>Enter OTP</h1>
                            <div class="otp-field">
                                <input type="text" maxlength="1" />
                                <input type="text" maxlength="1" />
                                <input class="space" type="text" maxlength="1" />
                                <input type="text" maxlength="1" />
                                <input type="text" maxlength="1" />
                                <input type="text" maxlength="1" />
                            </div>
                            <input type="none" name="lecture" value="{{ $lectureDetail->slug }}" style="display: none" />
                            <input type="none" name="otp" id="otp" style="display: none" />
                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const inputs = document.querySelectorAll(".otp-field input");

        inputs.forEach((input, index) => {
            input.dataset.index = index;
            input.addEventListener("keyup", handleOtp);
            input.addEventListener("paste", handleOnPasteOtp);
        });

        function handleOtp(e) {
            /**
             * <input type="text" 👉 maxlength="1" />
             * 👉 NOTE: On mobile devices `maxlength` property isn't supported,
             * So we to write our own logic to make it work. 🙂
             */
            const input = e.target;
            let value = input.value;
            let isValidInput = value.match(/[0-9a-z]/gi);
            input.value = "";
            input.value = isValidInput ? value[0] : "";

            let fieldIndex = input.dataset.index;
            if (fieldIndex < inputs.length - 1 && isValidInput) {
                input.nextElementSibling.focus();
            }

            if (e.key === "Backspace" && fieldIndex > 0) {
                input.previousElementSibling.focus();
            }

            if (fieldIndex == inputs.length - 1 && isValidInput) {
                submit();
            }
        }

        function handleOnPasteOtp(e) {
            const data = e.clipboardData.getData("text");
            const value = data.split("");
            if (value.length === inputs.length) {
                inputs.forEach((input, index) => (input.value = value[index]));
                submit();
            }
        }

        function submit() {
            console.log("Submitting...");
            // 👇 Entered OTP
            let otp = "";
            inputs.forEach((input) => {
                otp += input.value;
                input.disabled = true;
                document.getElementById("otp").setAttribute("value", otp);
                // input.classList.add("disabled");
            });
            console.log(otp);
            // 👉 Call API below
        }
    </script>
@endsection
