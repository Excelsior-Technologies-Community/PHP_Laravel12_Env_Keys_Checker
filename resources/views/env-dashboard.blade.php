<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ENV Health Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <meta http-equiv="refresh" content="20">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #0f172a;
            font-family: Arial, sans-serif;
            color: white;
        }

        .dashboard-title {
            font-size: 42px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 40px;
            background: linear-gradient(to right, #38bdf8, #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            border-radius: 22px;
            padding: 30px;
            transition: 0.4s;
            height: 100%;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.3);
        }

        .glass-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 40px rgba(56, 189, 248, 0.2);
        }

        .icon-box {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin: auto;
            margin-bottom: 18px;
        }

        .blue {
            background: rgba(59, 130, 246, .2);
            color: #60a5fa;
        }

        .green {
            background: rgba(34, 197, 94, .2);
            color: #4ade80;
        }

        .red {
            background: rgba(239, 68, 68, .2);
            color: #f87171;
        }

        .count {
            font-size: 42px;
            font-weight: bold;
        }

        .sub-text {
            color: #cbd5e1;
            margin-top: 8px;
            font-size: 15px;
        }

        .section-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 25px;
        }

        .progress {
            height: 28px;
            border-radius: 30px;
            background: #1e293b;
        }

        .progress-bar {
            border-radius: 30px;
            font-weight: bold;
        }

        .search-input {
            background: #1e293b;
            border: none;
            color: white;
            border-radius: 14px;
            padding: 14px;
        }

        .search-input::placeholder {
            color: #94a3b8;
            opacity: 1;
        }

        .search-input:focus {
            background: #1e293b;
            color: white;
            box-shadow: none;
        }

        .key-item {
            background: #1e293b;
            border-left: 5px solid #ef4444;
            padding: 14px;
            border-radius: 12px;
            margin-bottom: 12px;
            font-weight: 600;
            transition: .3s;
        }

        .key-item:hover {
            transform: translateX(5px);
        }

        .btn-custom {
            border: none;
            padding: 12px 22px;
            border-radius: 14px;
            font-weight: 600;
            transition: .3s;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
        }

        .status-box {
            padding: 18px;
            border-radius: 15px;
            font-weight: bold;
            text-align: center;
        }

        .healthy {
            background: rgba(34, 197, 94, .15);
            color: #4ade80;
        }

        .danger-status {
            background: rgba(239, 68, 68, .15);
            color: #f87171;
        }

        .scan-box {
            background: #1e293b;
            border-radius: 15px;
            padding: 18px;
        }

        .badge-level {
            font-size: 15px;
            padding: 10px 18px;
            border-radius: 30px;
        }

        .footer-text {
            color: #94a3b8;
            text-align: center;
            margin-top: 40px;
        }
    </style>

</head>

<body>

    <div class="container py-5">

        <h1 class="dashboard-title">
            ENV Health Dashboard
        </h1>

        @if(session('success'))

            <div class="alert alert-success border-0 shadow-sm">
                {{ session('success') }}
            </div>

        @endif

        <div class="row g-4">

            <div class="col-md-4">

                <div class="glass-card text-center">

                    <div class="icon-box blue">
                        <i class="bi bi-file-earmark-code"></i>
                    </div>

                    <div class="count">
                        {{ $total }}
                    </div>

                    <div class="sub-text">
                        Total Environment Keys
                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="glass-card text-center">

                    <div class="icon-box green">
                        <i class="bi bi-check-circle"></i>
                    </div>

                    <div class="count text-success">
                        {{ $present }}
                    </div>

                    <div class="sub-text">
                        Present & Verified Keys
                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="glass-card text-center">

                    <div class="icon-box red">
                        <i class="bi bi-shield-exclamation"></i>
                    </div>

                    <div class="count text-danger">
                        {{ $missingCount }}
                    </div>

                    <div class="sub-text">
                        Missing Environment Keys
                    </div>

                </div>

            </div>

        </div>

        <div class="glass-card mt-5">

            <div class="d-flex justify-content-between align-items-center">

                <h3 class="section-title mb-0">
                    Environment Security Health
                </h3>

                <span class="badge bg-info badge-level">
                    {{ $healthPercentage }}% Secure
                </span>

            </div>

            <div class="progress mt-4">

                <div class="progress-bar
                {{ $healthPercentage >= 80 ? 'bg-success' : ($healthPercentage >= 50 ? 'bg-warning' : 'bg-danger') }}"
                    style="width: {{ $healthPercentage }}%">

                    {{ $healthPercentage }}%

                </div>

            </div>

        </div>

        <div class="row mt-5 g-4">

            <div class="col-lg-8">

                <div class="glass-card">

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <h3 class="section-title mb-0">
                            Missing Key Report
                        </h3>

                        <form method="GET">

                            <input type="text" name="search" placeholder="Search missing key..."
                                class="form-control search-input" value="{{ request('search') }}">

                        </form>

                    </div>

                    @if($missingCount > 0)

                        @foreach($missingKeys as $key)

                            <div class="key-item">

                                <i class="bi bi-x-circle-fill text-danger"></i>

                                {{ $key }}

                            </div>

                        @endforeach

                    @else

                        <div class="status-box healthy">

                            <i class="bi bi-check-circle-fill"></i>

                            All Environment Keys Found Successfully

                        </div>

                    @endif

                    <div class="mt-4 d-flex gap-3 flex-wrap">

                        <a href="/export-report" class="btn btn-primary btn-custom">

                            <i class="bi bi-download"></i>

                            Export Report

                        </a>

                        <a href="/auto-add-keys" class="btn btn-success btn-custom">

                            <i class="bi bi-plus-circle"></i>

                            Auto Add Keys

                        </a>

                    </div>

                </div>

            </div>

            <div class="col-lg-4">

                <div class="glass-card">

                    <h3 class="section-title">
                        Environment Status
                    </h3>

                    @if($missingCount > 0)

                        <div class="status-box danger-status">

                            ⚠ Missing Configuration Found

                        </div>

                    @else

                        <div class="status-box healthy">

                            ✔ Environment Healthy

                        </div>

                    @endif

                    <div class="scan-box mt-4">

                        <h5>
                            <i class="bi bi-clock-history"></i>
                            Last Scan
                        </h5>

                        <p class="mt-3 mb-0">
                            {{ $scanTime }}
                        </p>

                    </div>

                    <div class="mt-4">

                        <h5 class="mb-3">
                            Security Level
                        </h5>

                        @if($healthPercentage >= 80)

                            <span class="badge bg-success badge-level">
                                HIGH SECURITY
                            </span>

                        @elseif($healthPercentage >= 50)

                            <span class="badge bg-warning badge-level">
                                MEDIUM SECURITY
                            </span>

                        @else

                            <span class="badge bg-danger badge-level">
                                LOW SECURITY
                            </span>

                        @endif

                    </div>

                </div>

            </div>

        </div>

        <div class="footer-text">

            Laravel 12 ENV Monitoring System • Real-Time Security Dashboard

        </div>

    </div>

</body>

</html>