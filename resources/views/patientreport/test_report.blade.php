<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Prescription </title>
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
      font-size: 16px;
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

    .page_break { page-break-before: always; }

    /* .signature {
  font-size: 14px;
  position: absolute;
 
  top: 800px;
  display: flex;
  align-items: center;
  justify-content: space-around;
  width: 80%;
} */

    .footer {
      text-align: center;
      margin-top: 40px;
      font-size: 12px;
      color: #666;
      font-family: 'Verdana', sans-serif;
    }

    /* Added spacing before and after the columns */
    .divider {
      width: 1%;
      border-left: 1px solid #ddd;
    }

    .column {
      margin-top: 0px;
    }

    /* New spacing around left and right column */
    .content {
      padding-left: 20px;
      padding-right: 20px;
    }

 


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

        @media print {
            body * {
                visibility: hidden; /* Hides everything */
            }
            .container, .container * {
                visibility: visible; /* Shows the container and its content */
            }
            .container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%; /* Ensures full page width on print */
            }
        }

    .signature_right {
       position: absolute;
       left:25px;
       top:900px;
       z-index: -1;
     }	

     .signature_left {
       position: absolute;
       left:455px;
       top:900px;
       z-index: -1;
     }	

  </style>
</head>
<body>

@php
    $totalItems = count($testprovide); // Assuming $items is the array/data you are looping through
@endphp

@foreach($testprovide as $index => $item)

  <div class="container">
     <div class="rayhan_header">
          <img src="{{ public_path("/images/header.jpg")}}" style="width:600px"/>
      </div>


    <table class="header_table">
       <thead>
         <tr>
            <th colspan="2"> Patient Info </th>
            <th>  Referred By  </th>
          </tr>
       </thead>
    <tbody>

      @if(empty($data->family_member_name))
          <tr>
             <td style="width: 40%;"> Appointment Id: <b>  {{ $data->id }} </b> </td>
             <td style="width: 20%;"> Date :<b> {{$data->date}} </b> </td>
             <td style="width: 40%;">  {{$data->name}} </td>
          </tr>

           <tr>
             <td style="width:40%;"> Patient Name : <b> {{ $data->member_name }} </b> </td>
             <td style="width:20%;"> Age : <b> {{ $data->age }} </b> </td>
             <td style="width:40%;"> {{ $data->user_designation }} </td>
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
             <td style="width: 40%;">  {{$data->name}} </td>
          </tr>

           <tr>
             <td style="width: 40%;"> Employee Name: <b> {{ $data->member_name }} </b> </td>
             <td style="width: 20%;"> Age : <b> {{ $data->age }} </b> </td>
             <td style="width: 40%;"> {{ $data->user_designation }} </td>
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


    </tbody>
</table>
       
   
    <div class="content">
        <div class="column rx">
             <h3 style="text-align:center"> {{$item->testcategory_name}}  REPORT </h3>
           <table>   
            @php
               $counter = 1;
            @endphp

            <tr>
                 <td style="width: 50%;"> <b> INVESTIGATION  </b> </td>
                 <td style="width: 15%;">  <b> RESULT  </b> </td>
                 <td style="width: 35%;"> <b>  REFERENCE VALUE  </b> </td>
               
            </tr>

            @foreach(test_report($item->appointment_id,$item->testcategory_id) as $row)
               <tr > 
                     <td colspan="3" > <b> {{$row->test_name}} </b>  </td>
              </tr>
                  @foreach(diagnostic_report($row->id) as $record)
                  <tr> 
                     <td>  {{$record->diagnostic_name}}  </td>
                     <td>  {{$record->result}}  </td>
                     <td>  {{$record->reference_range}}  </td>
                  </tr>
                  @endforeach
            @endforeach

        </table>
      </div>
    </div>

    <div class="signature_right">
        <p><strong>Patient's Signature</strong></p>
        <p>Patirnt's Signature</p>
    </div>


    <div class="signature_left">
        <p><strong>Doctor's Signature</strong></p>
        <p>Doctor's Signature</p>
    </div>

   
  </div>

  
        @if($index < $totalItems - 1)
          <div class="page_break"></div>
        @else
           <div class="last-page"></div>
         @endif

  @endforeach
  

</body>
</html>
