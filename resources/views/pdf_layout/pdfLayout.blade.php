<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ public_path('pdf/style.css') }}">
    <title>Generate Report</title>
</head>

<body>
    <div class="report-form-container">
        <div class="report-content container">
            <div class="header">
                <img src="{{ public_path('img/logo.png') }}" alt="School Logo" style="float:left;">
                <img src="{{ public_path('img/logo2.png') }}" alt="Second Logo" style="float:right;">
                <h4>Republic of the Philippines</h4>
                <h4>Region III</h4>
                <h4>Division of Nueva Ecija</h4>
                <h3>Bongabon National High School</h3>
                <h4>Bongabon, Nueva Ecija</h4>
            </div>
            <br>
            <div class="content">
                @yield('page-content')
            </div>
        </div>
    </div>
</body>

</html>
