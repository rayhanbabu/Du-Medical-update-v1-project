<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width , initial-scale=1.0">
    <title> Medicine Report </title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .header {
            text-align: center;
        }

        .header h5,h3 {
            margin: 0;
        }

        .header p {
            margin: 0;
            font-size: 12px;
        }

        .report-title {
            text-align: center;
            margin: 10px 0;
        }


        .results {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }


       .results table, th, td {
            border: 0.5px solid gray;
            border-collapse: collapse; /* Ensures borders don't double up */
        }

        .results td {
            padding: 5px;
        }

      
    </style>
</head>

<body>

       <div class="rayhan_header">
           <img src="{{ public_path("/images/header.jpg")}}" style="width:600px"/>
        </div>

     <div class="header">
          <h5 class="report-title"> Medicine Provide Report  </h5>
          <p>  Date : {{$data['date1']}} to {{$data['date2']}} </p>

        </div>

      <br>
    <table class="results">
        <thead>
            <tr>
                 <th> AP Id</th>
                 <th> Date</th>
                 <th> Patient Name</th>
                 <th> Reg/Employee Id</th>
                 <th> Medicine Name</th>
                 <th> Piece/ Unit</th>
                 <th> Price</th>
                
            </tr>
        </thead>
        <tbody>
        @foreach($medicineprovide as $row)
            <tr>
                 <td>{{$row->appointment_id}}</td>
                 <td>{{$row->date}} </td>
                 <td>{{$row->member_name}} </td>
                 <td>{{$row->registration}} </td>
                 <td>{{$row->medicine_name}} </td>
                 <td>{{$row->total_piece}} </td>
                 <td>{{$row->total_amount}} </td>
            </tr>
         @endforeach
        </tbody>
    </table>

    
</body>

</html>
