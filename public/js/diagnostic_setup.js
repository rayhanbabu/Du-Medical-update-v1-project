
 $(document).ready(function(){ 
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });

    $("#edit_test_setup_form").submit(function(e) {
        e.preventDefault();
         const fd = new FormData(this);
        $.ajax({
           type: 'POST',
           url: '/diagnostic/test_report/update',
           data: fd,
           cache: false,
           contentType: false,
           processData: false,
           dataType: 'json',
          beforeSend: function() {
            $('.loader').show();
            $("#edit_appointment_btn").prop('disabled', true);
          },
          success: function(response) {
            $("#edit_appointment_btn").prop('disabled', false);
            if (response.status == "success") {
                //console.log(response);
                Swal.fire("Success",response.message, "success");
                 // $('#success_message').html("");
                 // $("#appoinment_form")[0].reset();
            } else if (response.status == 400) {
                $('.edit_error_registration').text(response.message.registration);
                $('.edit_error_phone').text(response.message.phone);
                $('.edit_error_email').text(response.message.email);
                $('.edit_error_member_name').text(response.message.member_name);
            }
  
            $('.loader').hide();
          }
  
        });
      
    });


 });