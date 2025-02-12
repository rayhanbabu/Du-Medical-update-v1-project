$(document).ready(function(){ 
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });

    

   $(document).on('click','.appointment_cart', function(e) {
        e.preventDefault();
        var slot_id = $(this).data('slot_id');
        var slot_time = $(this).data('slot_time');
        var date = $(this).data('date');
     $.ajax({
         type: 'GET',
         url: '/member/appointment_cart/' + slot_id+'/' +date,
         beforeSend: function() {
             $("#add_employee_btn_" + slot_id).prop('disabled', true).text('Processing...');
         },
        success: function(response) {
            $("#add_employee_btn_" + slot_id).prop('disabled', false).text(slot_time);
            if (response.status == 400) {
                 Swal.fire("Warning",response.message,"warning");
            } else {
                 var item = response.slot;
                 // Clear the table before appending new rows (optional)
                 $('#data-table tbody').empty();
                 // Assuming response.value is a single object              
                 $('#appointment_id').val(item.id);

                 var newRow = $('<tr>');
                  // Assuming the object has 'slot_time' and 'id'
                  newRow.append('<td>' + item.slot_time + '</td>');
                  newRow.append('<td><a href="javascript:void(0);" data-appointment_id="' + item.id + '"  id="delete_employee_btn" class="appointment_delete btn btn-danger btn-sm">Delete</a></td>');
                 $('#data-table tbody').append(newRow);
            }    
        },
        complete: function() {
            $("#add_employee_btn_" + slot_id).prop('disabled', false);
        },
        error: function() {
            // Handle any errors that occur during the AJAX request
            alert("An error occurred while processing the request.");
        }
       });
   });


   

   $(document).on('click','.appointment_delete', function(e) {
    e.preventDefault();
    var appointment_id = $(this).data('appointment_id');
   
    if (confirm("Are you sure you want to delete this?")) {
      $.ajax({
         type: 'GET',
         url: '/member/appointment_delete/' + appointment_id,
         beforeSend: function() {
             $("#delete_employee_btn").prop('disabled', true).text('Processing...');
         },
        success: function(response) {
              if (response.status == 400) {
                    Swal.fire("Warning",response.message,"warning");
               } else {
                    // Clear the table before appending new rows (optional)
                    $('#data-table tbody').empty();
                    $('#appointment_id').val("");
                }  
        }
        });

      }
   });


      // update employee ajax request
      $("#appointment_form").submit(function(e){
          e.preventDefault();
  
        const fd = new FormData(this);
        $.ajax({
          type: 'POST',
          url: '/member/appointment/update',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          beforeSend: function() {
              $('.loader').show();
              $("#appointment_button").prop('disabled', true).text('Processing...');
           },
          success: function(response) {
              $("#appointment_button").prop('disabled', false).text('Confirm Appointment');
              $('.loader').hide();
               if (response.status == 400) {
                     Swal.fire("Warning",response.message,"warning");    
               }else if((response.status == 200)){
                     Swal.fire("Success",response.message,"success"); 
                     $('#appointment_form')[0].reset();
                     $('#data-table tbody').empty();
                     $('#appointment_id').val("");
                     window.location.reload();
               } 
           }
        });
      });
  

   
 });


