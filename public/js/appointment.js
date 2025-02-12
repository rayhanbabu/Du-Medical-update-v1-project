$(document).ready(function(){ 
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });


 // update employee ajax request
 $("#search_form").submit(function(e) {
    e.preventDefault();

  const fd = new FormData(this);
  $.ajax({
    type: 'POST',
    url: '/admin/appointment/search',
    data: fd,
    cache: false,
    contentType: false,
    processData: false,
    dataType: 'json',
    beforeSend: function() {
        $("#search_button").prop('disabled', true).text('Processing...');
     },
    success: function(response) {
        $("#search_button").prop('disabled', false).text('Search');
       
          if (response.status == 'success') {
                $('.error_registration').text('');
                window.location.href = "/admin/appointment?member_id=" + response.member_id;
          }else if((response.status == 'fail')){
              $('.error_registration').text(response.message);
              
         } 
     }
  });
});

   

   $(document).on('click','.appointment_delete', function(e) {
    e.preventDefault();
    var appointment_id = $(this).data('appointment_id');
   
    if (confirm("Are you sure you want to delete this?")) {
      $.ajax({
         type: 'GET',
         url: '/admin/appointment_delete/' + appointment_id,
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
      $("#appointment_form").submit(function(e) {
          e.preventDefault();
  
        const fd = new FormData(this);
        $.ajax({
          type: 'POST',
          url: '/admin/appointment/update',
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
                    $('.appintment_print').text(''); 
               }else if((response.status == 200)){
                     $('.appointment_print').html('Appointment Created. <a href="/prescription/'+response.appointment_id+'" target="_blank">Print Appointment</a>');
                     $('#appointment_form')[0].reset();
                    //   $('#data-table tbody').empty();
                   // $('#appointment_id').val("");
                  //  window.location.reload();
               } 
           }
        });
      });
  

   
 });


