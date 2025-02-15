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
                url: "/ambulance/ambulance",
                error: function(xhr, error, code) {
                     console.log(xhr.responseText);
                }
            },
            columns: [
                {data: 'appointment_id', name: 'appointment_id'},
                {data: 'date', name: 'date'},
                {data: 'member.member_name', name: 'member.member_name'},
                {data: 'member.phone', name: 'member.phone'},
                {data: 'to_address', name: 'to_address'},
                {data: 'driver.name', name: 'driver.name'},
                {data: 'doctor.name', name: 'doctor.name'},
                {data: 'status', name: 'status'},
                { data: 'edit', name: 'edit', orderable: false, searchable: false },
                { data: 'delete', name: 'delete', orderable: false, searchable: false },
                {data: 'created_at', name: 'created_at'},
                {data: 'completed_at', name: 'completed_at'},
            ]
        });
    }
       


    $(document).on('submit','#add_form', function(e){
         e.preventDefault();

        let formData = new FormData($('#add_form')[0]);

       $.ajax({
          type: 'POST',
          url: '/ambulance/insert',
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
          } if (response.status == 401) {
            $('#add_form_errlist').html("");
            $('#add_form_errlist').removeClass('d-none');
            $('#add_form_errlist').append('<li>' + response.message + '</li>');

          }
          else {
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
        url: '/ambulance/edit/' + view_id,
        success: function(response) {
          //console.log(response);
          if (response.status == 404) {
            $('#success_message').html("");
            $('#success_message').addClass('alert alert-danger');
            $('#success_message').text(response.message);
          } else {
            $('#edit_id').val(response.value.id);
            $('#edit_driver_id').val(response.value.driver_id);
            $('#edit_doctor_id').val(response.value.doctor_id);
            $('#edit_to_address').val(response.value.to_address);
            $('#edit_disease').val(response.value.disease);
            $('#edit_status').val(response.value.status);
            $('#edit_distance').val(response.value.distance);
           
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
    url: '/ambulance/update',
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
            url:'/ambulance/delete',
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