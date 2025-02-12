$(document).ready(function(){ 
      $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });
       fetchAll();

      function fetchAll() {
          // Destroy existing DataTable if it exists
          if ($.fn.DataTable.isDataTable('.data-table')) {
             $('.data-table').DataTable().destroy();
          }

        // Initialize DataTable
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/pharmacy/medicine_list",
                error: function(xhr, error, code) {
                    console.log(xhr.responseText);
                }
            },
            order: [[0, 'desc']],
            columns: [
                {data: 'appointment_id', name: 'appointment_id'},
                {data: 'date', name: 'date'},
                {data: 'member_name', name: 'member_name'},
                {data: 'family_member_name', name: 'family_member_name'},
                {data: 'registration', name: 'registration'},
                {data: 'generic_name', name: 'generic_name'},
                {data: 'medicine_name', name: 'medicine_name'},
                {data: 'total_piece', name: 'total_piece'},
                {data: 'total_amount', name: 'total_amount'},
                {data: 'status', name: 'status'},
                { data: 'delete', name: 'delete', orderable: false, searchable: false }
            ]
         });
      }
       

           // delete employee ajax request
           $(document).on('click', '.delete', function(e) {
            e.preventDefault();
            var id = $(this).data('id'); 
            var provide_status = $(this).data('provide_status'); 
            Swal.fire({
              title: 'Are you sure?',
              text: "You want to delivery this item!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes'
            }).then((result) => {
              if (result.isConfirmed) {
                $.ajax({
                  url:'/pharmacy/medicine_status',
                  method:'delete',
                  data: {
                    id: id,
                    provide_status:provide_status
                  },
                   success: function(response) {
                      console.log(provide_status);
                     if(response.status == 400){
                        Swal.fire("Warning",response.message, "warning");
                     }else if(response.status == 200)
                        Swal.fire("Updated",response.message, "success");
                       fetchAll();
                  }
                });
              }
            })
          });

});