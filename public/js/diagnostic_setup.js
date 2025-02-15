
var tiloop_count=2;
function tiadd_more() {
    tiloop_count++;
 var html = '<div class="row shadow p-2" id="intest_attr_'+tiloop_count+'">\
           <input id="intestid" name="intestid[]" type="hidden">';

   var test_html = jQuery('#test_id').html();   
    test_html = test_html.replace("selected", "");
              
      html += '<div class="col-md-9 p-2">\
          <select class="form-control js-example-disabled-results" name="test_id[]" >'+test_html+'</select>\
      </div>';                
        
      html += '<div class="col-md-3 p-2">\
          <button type="button" onclick=tiremove_more("'+tiloop_count+'") class="btn btn-danger">\
              <i class="fa fa-minus"></i></button>\
      </div>';   

   html += '</div>';
                
     jQuery('#intest_attr_box').append(html);
     jQuery('.js-example-disabled-results').select2();
 }

   function tiremove_more(tiloop_count){
         jQuery('#intest_attr_'+tiloop_count).remove();
         //alert(tiloop_count);
    }

 
 
 $(document).ready(function(){ 
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });



    //  Appointment Search
    $("#search_form").submit(function(e) {
      e.preventDefault();

       const fd = new FormData(this);
     $.ajax({
          type: 'POST',
          url: '/diagnostic/search',
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
              $('.error_search').text('');
               window.location.href = "/diagnostic/setup?appointment_id=" + response.appointment_id;
         }else if((response.status == 'fail')){
             $('.error_search').text(response.message);
          
          } 
          }
       });
    });
    // End Appointment Search


    //  Diagnostic Setup
    $("#diagnostic_setup_form").submit(function(e) {
      e.preventDefault();
       const fd = new FormData(this);

      $.ajax({
         type: 'POST',
         url: '/diagnostic/setup/update',
         data: fd,
         cache: false,
         contentType: false,
         processData: false,
         dataType: 'json',
        beforeSend: function() {
          $('.loader').show();
          $("#diagonostic_btn").prop('disabled', true);
        },
        success: function(response) {
          $("#diagonostic_btn").prop('disabled', false);
          if (response.status == "success") {
             // console.log(response);
              Swal.fire("Success",response.message, "success");
               location.reload();
          } else  {
               Swal.fire("Warning","Something Error", "warning");
          }

          $('.loader').hide();
        }

      });
    });

    // End Diagnostic Setup


        



    

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