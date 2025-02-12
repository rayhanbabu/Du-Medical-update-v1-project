<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Test Report </title>
  <style>
    
    body {
      font-family: 'Arial', sans-serif;
      margin: 0;
      padding: 20px;
      box-sizing: border-box;
      /* background-color: #f0f4f7; */
    }

    .container {
      margin: 0 auto;
      height: 850px;
      padding: 20px;
      background-color: #fff;
      /* border: 1px solid #ddd;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); */
      font-size: 12px;
    }

  

    .header h1 {
      margin: 0;
      font-size: 24px;
      text-transform: uppercase;
    }


    /* Added border below the patient and doctor info */
    .border-row {
      border-top: 1px solid #ddd;
      padding: 10px 0;
    }

    .data-row {
      display: flex;
      justify-content: space-between;
      padding: 10px 0;
      border-bottom: 1px solid #ddd;
    }

    .content {
      display: flex;
      justify-content: space-between;
      margin-top: 10px;
      margin: 0 30px;
    }

    .column {
      width: 100%;
      margin-top: 20px;
    }

    .column h3 {
      margin-bottom: 10px;
      font-size: 14px;
      font-weight: normal;
      text-transform: none;
      text-decoration: underline;
      font-family: 'Verdana', sans-serif;
      color: #555;
    }

    .column ul {
      list-style-type: none;
      padding: 0;
    }

    .column ul li {
      margin-bottom: 6px;
      font-family: 'Tahoma', sans-serif;
    }

    .rx {
      text-align: left;
    }

    .rx h3 {
      font-size: 15px;
      font-weight: bold;
      font-family: 'Arial', sans-serif;
    }

    .rx table {
      width: 100%;
      margin-bottom: 20px;
      border-collapse: collapse;
    }

    .rx th, .rx td {
      padding: 8px;
      font-family: 'Verdana', sans-serif;
    }

    .rx tr {
      border-top: 1px dotted #000;
    }

    .rx th {
      text-align: left;
    }

    .footer {
      text-align: center;
      margin-top: 40px;
      font-size: 12px;
      color: #666;
      font-family: 'Verdana', sans-serif;
    }

   
  
    .column {
      margin-top: 0px;
    }

    /* New spacing around left and right column */
   

 
       .header_table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto; /* Centers the table */
            border: 1px solid gray;
        }

        .header_table th {
            border: 1px solid gray;
            padding: 5px;
            text-align: left;
        }

        .header_table th {
            background-color: #f2f2f2;
        }

        .header_table td {
            padding: 5px;
            text-align: left;
        }

    
   	

     .signature_left {
       position: absolute;
       left:455px;
       top:960px;
       z-index: -1;
     }	

  </style>
</head>
<body>



  <div class="container">

       <div class="rayhan_header">
          <img src="{{ public_path("/images/header.jpg")}}" style="width:600px"/>
       </div>


    <table class="header_table">

    <tbody>

      @if(empty($data->family_member_name))
          <tr>
             <td style="width: 40%;"> Appointment Id: <b>  {{ $data->id }} </b> </td>
             <td style="width: 20%;"> Date : <b>  {{$data->date}} </b> </td>
             <td style="width: 40%;">  Service Type : <b>  {{$data->service_name}} </b>  </td>
          </tr>

           <tr>
             <td style="width:40%;"> Patient Name : <b> {{ $data->member_name }} </b> </td>
             <td style="width:20%;"> Age : <b>  {{ $data->age }} </b> </td>
             <td style="width:40%;"> Room No : <b>  {{$data->room}} </b>   </td>
          </tr>

           <tr>
             <td> Registration/Employee Id : <b> {{ $data->registration }} </b> </td>
             <td> Gender: <b> {{ $data->gender }} </b></td>
             <td>   </td>
          </tr>
        @else

        <tr>
             <td style="width: 40%;"> Appointment Id: <b>  {{ $data->id }} </b> </td>
             <td style="width: 20%;"> Date :<b> {{$data->date}} </b> </td>
             <td style="width: 40%;"> Service Type : <b>  {{$data->service_name}} </b> </td>
          </tr>

           <tr>
             <td style="width: 40%;"> Employee Name: <b> {{ $data->member_name }} </b> </td>
             <td style="width: 20%;"> Age : <b> {{ $data->age }} </b> </td>
             <td style="width: 40%;"> Room No : <b>  {{$data->room}} </b> </td>
          </tr>

           <tr>
             <td> Employee Id : <b> {{ $data->registration }} </b> </td>
             <td> Gender: <b> {{ $data->gender }} </b></td>
             <td>   </td>
          </tr>

          <tr>
             <td> Careof & Patient Name : <b> {{ $data->family_member_name }} </b> </td>
             <td> Relation Type : <b> {{ $data->relation_type }}  </b>  </td>
             <td>   </td>
          </tr>

        @endif
        
       <tr>
       
             <th> C/C </th>
             <th colspan="2">RX </th>
            
          </tr>

          <tr>
             <td> </td>
             <td>  </td>
             <td>  </td>
          </tr>

          <tr>
             <td> </td>
             <td>  </td>
             <td>  </td>
          </tr>

          <tr>
             <td> </td>
             <td>  </td>
             <td>  </td>
          </tr>

    </tbody>
</table>
       
   












   
  </div>

  
  
  

</body>
</html>
