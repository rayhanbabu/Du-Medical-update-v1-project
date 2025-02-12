$(document).ready(function(){ 
     $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });
          fetchAll();

       function fetchAll() {
            // Destroy existing DataTable if it exists
            if($.fn.DataTable.isDataTable('.data-table')) {
                 $('.data-table').DataTable().destroy();
             }

        // Initialize DataTable
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/oncall/oncall",
                error: function(xhr, error, code) {
                     console.log(xhr.responseText);
                }
            },
            columns: [
                {data: 'created_at', name: 'created_at'},
                {data: 'member_name', name: 'member_name'},
                {data: 'registration', name: 'registration'},
                {data: 'phone', name: 'phone'},
                {data: 'disease', name: 'disease'},
                {data: 'name', name: 'name'},
                {data: 'ref_teacher', name: 'ref_teacher'},
                {data: 'address', name: 'address'},
                {data: 'comment', name: 'comment'},
                {data: 'status', name: 'status'},
                { data: 'edit', name: 'edit', orderable: false, searchable: false },
                { data: 'delete', name: 'delete', orderable: false, searchable: false }
            ]
        });
    }
       


    $(document).on('submit','#add_form', function(e){
         e.preventDefault();

      let formData = new FormData($('#add_form')[0]);

       $.ajax({
          type: 'POST',
          url: '/oncall/insert',
          data: formData,
          contentType: false,
          processData: false,
        beforeSend: function() {
          $("#add_btn").prop('disabled', true).text('Processing...');
        },
        success: function(response) {
          //console.log(response);
          $("#add_btn").prop('disabled', false).text('Submit');
          if (response.status == 400) {
            $('#add_form_errlist').html("");
            $('#add_form_errlist').removeClass('d-none');
            $.each(response.message, function(key, err_values) {
              $('#add_form_errlist').append('<li>' + err_values + '</li>');
            });
          } else {
            //console.log(response.message);
            $('#add_form_errlist').html("");
            $('#add_form_errlist').addClass('d-none');
            $('#success_message').html("");
            $('#success_message').addClass('alert alert-success alert-sm');
            $('#success_message').text(response.message)
            $('#add_form')[0].reset();
            $('.bazar-entry-show').hide();
            fetchAll();
          }
        }
      });

    });


    $(document).on('click', '.edit', function(e) {
      e.preventDefault();
      var view_id = $(this).data('id'); 
      $('#EditModal').modal('show');
         // console.log(view_id);         
      $.ajax({
        type: 'GET',
        url: '/oncall/edit/' + view_id,
        success: function(response) {
          //console.log(response);
          if (response.status == 404) {
            $('#success_message').html("");
            $('#success_message').addClass('alert alert-danger');
            $('#success_message').text(response.message);
          } else {
            $('#edit_id').val(response.value.id);
            $('#edit_user_id').val(response.value.user_id);
            $('#edit_disease').val(response.value.disease);
            $('#edit_address').val(response.value.address);
            $('#edit_comment').val(response.value.comment);
            $('#edit_status').val(response.value.status);
           
          }
        }
      });

    });


// update employee ajax request
$("#edit_employee_form").submit(function(e) {
  e.preventDefault();

  const fd = new FormData(this);

  $.ajax({
    type: 'POST',
    url: '/oncall/update',
    data: fd,
    cache: false,
    contentType: false,
    processData: false,
    dataType: 'json',
    beforeSend: function() {
      $('.loader').show();
      $("#edit_employee_btn").prop('disabled', true);
    },
    success: function(response) {
      $("#edit_employee_btn").prop('disabled', false);
      if (response.status == 200) {
          Swal.fire("Success",response.message, "success");
          $("#EditModal").modal('hide');
          $("#edit_employee_form")[0].reset();
          fetchAll();
      } else if (response.status == 400) {
          $('.edit_error_driver_id').text(response.message.driver_id);
      }

      $('.loader').hide();
    }

  });

});


     // delete employee ajax request
     $(document).on('click', '.delete', function(e) {
      e.preventDefault();
      var id = $(this).data('id'); 
      Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete this item!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url:'/oncall/delete',
            method:'delete',
            data: {
              id: id,
            },
             success: function(response) {
                //console.log(response);
               if(response.status == 400){
                  Swal.fire("Warning",response.message, "warning");
               }else if(response.status == 200)
                  Swal.fire("Deleted",response.message, "success");
                 fetchAll();
            }
          });
        }
      })
    });

});