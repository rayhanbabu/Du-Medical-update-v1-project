<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Appointment Slip </title>
  <style>
    .appointment-card {
      max-width: 300px;
      margin: 50px auto;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }
    .appointment-title {
      font-size: 12px;
      font-weight: bold;
      text-align: center;
      margin-bottom: 20px;
      text-transform: uppercase;
    }
    .appointment-btn {
      background-color: #fff;
      border: 2px solid #007bff;
      border-radius: 5px;
      color: #007bff;
      text-align: center;
      width: 100%;
      margin-top: 20px;
    }
    .info-section {
      margin-top: 20px;
    }
    .info-section p {
      font-size: 10px;
      font-weight: bold;
    }

     /* Print-specific styles */
  @media print {
    body * {
      visibility: hidden;
    }

    .container, .container * {
      visibility: visible;
    }

    .container {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      border: none;
    }

    .appointment-btn {
      display: none; /* Hide the button during print */
    }
  }


  </style>
</head>
<body>

<div class="container">
  <div class="card appointment-card border-primary">
    <div class="card-body">
      <div class="appointment-title">
        Shahid Buddhijibe Dr. Mohammad Mortoza Medical Center<br>
        Dhaka University
      </div>

      <button class="btn appointment-btn">
        Appointment Slip
      </button>

      <div class="row info-section">
        <div class="col-md-6">
          <p>Name: Md Rayhan Babu</p>
          <p>Appointment ID: 11223344</p>
          <p>Appointment Date: June 30, 2024</p>
          <p>Time: 08:00 - 08:15</p>
        </div>
        <div class="col-md-6">
          <p>Age: 26</p>
          <p>Gender: Female</p>
          <p>Chamber No.: 05</p>
          <p>Room No.: 02</p>
        </div>
      </div>
    </div>
  </div>
</div>





</body>
</html>
