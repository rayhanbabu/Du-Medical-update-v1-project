<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Prescription & Dispensary Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            display: flex;
            justify-content: center;
        }
        
        .box {
            border: 1px solid #000;
            width: 600px;
            margin-top: 15px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #000;
            padding: 8px;
        }
        .header div {
            flex: 1;
        }
        .header div:last-child {
            border-left: 1px solid #000;
            padding-left: 10px;
        }
        .content {
            display: flex;
            border-top: 1px solid #000;
        }
        .content div {
            flex: 1;
            height: 200px;
            padding: 8px;
            border-right: 1px solid #000;
        }
        .content div:last-child {
            border-right: none;
        }
        .bold {
            font-weight: bold;
        }
        .dispensary-header {
            border-bottom: 1px solid #000;
            padding: 10px;
            text-align: center;
        }
        .dispensary-header p {
            margin: 5px 0;
        }
        .dispensary-content {
            text-align: center;
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Medical Prescription -->
    <div class="box">
        <div class="header">
            <div>
                <p><span class="bold">Appointment ID:</span> 1122</p>
                <p><span class="bold">Patient Name:</span> Palash Roy</p>
                <p><span class="bold">Registration/Employee ID:</span> 123456</p>
            </div>
            <div>
                <p><span class="bold">Date:</span> 15-05-2025</p>
                <p><span class="bold">Age:</span> 21 Year</p>
                <p><span class="bold">Gender:</span> Male</p>
            </div>
            <div>
                <p><span class="bold">Room No:</span> 205</p>
                <p><span class="bold">Service Type:</span> Outdoor</p>
            </div>
        </div>
        <div class="content">
            <div>
                <p class="bold">C/C</p>
            </div>
            <div>
                <p class="bold">RX</p>
            </div>
        </div>
    </div>

    <!-- Dispensary Report -->
    <div class="box">
        <div class="dispensary-header">
            <p class="bold">Shahid Buddhijibi Dr. Muhammad Mortaza Medical Center</p>
            <p>Appointment ID: 1122, Date: 10-01-2025, Registration/Employee ID: 11223344</p>
        </div>
        <div class="dispensary-content">
            <p class="bold">Dispensary Report</p>
        </div>
    </div>
</div>

</body>
</html>
