<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
     <link href="https://cdn.datatables.net/2.1.2/css/dataTables.bootstrap5.min.css" rel="stylesheet">
 
     <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
     <script src="https://cdn.datatables.net/2.1.2/js/dataTables.min.js"></script>
     <script src="https://cdn.datatables.net/2.1.2/js/dataTables.bootstrap5.min.js"></script>
     <title>Document</title>
</head>
<body>

   <div class="container">
      
       <div class="row">
          <div class="col-md-12 mt-5">
                 <table class="table  table-bordered data-table">
                    <thead>
                      <tr>
                         <td> S No</td>
                         <td> Name</td>
                         <td> Email</td>
                         <td> Action</td>
                       </tr>
                    </thead>
                    <tbody>

                    </tbody>

                 </table>
          </div>
       </div>
   </div>

    <script>
        $(function() {
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('users.index') }}",
            error: function(xhr, error, code) {
                console.log(xhr.responseText);
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
});

    </script>
    
</body>
</html>