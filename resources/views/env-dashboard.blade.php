<!DOCTYPE html>
<html>

<head>

    <title>ENV Health Dashboard</title>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"
        rel="stylesheet">

    <style>
        body {
            background: #f4f7fc;
            font-family: Arial, sans-serif;
        }

        .main-title {
            font-size: 35px;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .card-box {

            border: none;

            border-radius: 18px;

            padding: 30px;

            background: white;

            box-shadow:
                0 5px 25px rgba(0, 0, 0, .08);

            transition: .4s;
        }

        .card-box:hover {

            transform: translateY(-5px);

        }

        .count {

            font-size: 40px;

            font-weight: bold;

            margin-top: 15px;

        }

        .status-good {

            color: green;

            font-size: 18px;

            font-weight: 600;

        }

        .status-bad {

            color: red;

            font-size: 18px;

            font-weight: 600;

        }

        .key-box {

            padding: 10px;

            border-radius: 10px;

            background: #ffeaea;

            margin-bottom: 10px;

        }

        .scan-box {

            background: #edf3ff;

            padding: 15px;

            border-radius: 12px;

        }
    </style>

</head>

<body>

    <div class="container py-5">

        <h1 class="text-center main-title">

            ENV Health Dashboard

        </h1>


        <div class="row g-4">

            <div class="col-md-4">

                <div class="card-box text-center">

                    <i class="bi bi-file-earmark fs-1"></i>

                    <div class="count">

                        {{ $total }}

                    </div>

                    <p>Total Keys</p>

                </div>

            </div>



            <div class="col-md-4">

                <div class="card-box text-center">

                    <i class="bi bi-check-circle fs-1"></i>

                    <div class="count text-success">

                        {{ $present }}

                    </div>

                    <p>Present Keys</p>

                </div>

            </div>



            <div class="col-md-4">

                <div class="card-box text-center">

                    <i class="bi bi-exclamation-triangle fs-1"></i>

                    <div class="count text-danger">

                        {{ $missingCount }}

                    </div>

                    <p>Missing Keys</p>

                </div>

            </div>

        </div>


        <div class="row mt-5">

            <div class="col-md-8">

                <div class="card-box">

                    <h3>

                        Missing Key Report

                    </h3>

                    <hr>


                    @if($missingCount>0)

                    @foreach($missingKeys as $key)

                    <div class="key-box">

                        <i class="bi bi-x-circle"></i>

                        {{ $key }}

                    </div>

                    @endforeach

                    @else

                    <div
                        class="alert alert-success">

                        All Environment Keys Found

                    </div>

                    @endif


                    <a href="/export-report"
                        class="btn btn-primary mt-3">

                        <i class="bi bi-download"></i>

                        Download Report

                    </a>

                </div>

            </div>



            <div class="col-md-4">

                <div class="card-box">

                    <h4>Environment Status</h4>

                    <hr>

                    @if($missingCount>0)

                    <p class="status-bad">

                        ⚠ Missing Configuration Found

                    </p>

                    @else

                    <p class="status-good">

                        ✔ Environment Healthy

                    </p>

                    @endif


                    <div class="scan-box mt-4">

                        <b>Last Scan</b>

                        <br><br>

                        {{ $scanTime }}

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>