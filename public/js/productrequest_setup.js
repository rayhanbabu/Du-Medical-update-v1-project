
var loop_count=2;
function add_more() {
loop_count++;
var html = '<div class="row shadow p-2" id="inmedicine_attr_' + loop_count + '">';

var generic_html = jQuery('#generic_id').html();   
generic_html = generic_html.replace("selected", "");
                 
html += '<div class="col-md-7 p-2">\
             <select class="form-control js-example-disabled-results" name="generic_id[]" >' + generic_html + '</select>\
         </div>';                

html += '<div class="col-md-3 p-2">\
             <input type="text" id="total_piece" name="total_piece[]" placeholder="Quantity" class="form-control form-control-sm" >\
         </div>';                  
                                      
       
 
     html += '<div class="col-md-2 p-2">\
             <button type="button" onclick=remove_more("' + loop_count + '") class="btn btn-danger">\
                 <i class="fa fa-minus"></i></button>\
         </div>';   

    html += '</div>';                   
       jQuery('#inmedicine_attr_box').append(html);
       jQuery('.js-example-disabled-results').select2();
  }

     function remove_more(loop_count){
           jQuery('#inmedicine_attr_'+loop_count).remove();
      //alert(loop_count);
        }

 
 
 $(document).ready(function(){ 
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });





    $(document).on('click', '.view', function(e) {
      e.preventDefault();
      var view_id = $(this).data('id'); 
      $('#EditModal').modal('show');
         // console.log(view_id);         
      $.ajax({
        type: 'GET',
        url: '/admin/product_request/view/' + view_id,
        success: function(response) {
          //console.log(response);
          if (response.status == 404) {
            $('#success_message').html("");
            $('#success_message').addClass('alert alert-danger');
            $('#success_message').text(response.message);
          } else {
            $('#edit_id').val(view_id);

               // Clear previous table content
               $('.product_table tbody').empty();

               // Check if response.data is not empty
               if (response.value.length > 0) {
                   $.each(response.value, function(index, product) {
                       $('.product_table tbody').append(
                           `<tr>
                               <td>${product.request_from}</td>
                                <td>${product.generic.generic_name}</td>
                                 <td>${product.stock.medicine_name}</td>
                                  <td>${product.total_unit}</td>
                           </tr>`
                       );
                   });
               } else {
                   $('.product_table tbody').append(
                       `<tr>
                           <td colspan="1" class="text-center">No products found</td>
                       </tr>`
                   );
               }
           
          }
        }
      });

    });


    


    //  Diagnostic Setup
    $("#productrequest_setup_form").submit(function(e) {
      e.preventDefault();
       const fd = new FormData(this);

      $.ajax({
         type: 'POST',
         url: '/productrequest/setup/update',
         data: fd,
         cache: false,
         contentType: false,
         processData: false,
         dataType: 'json',
        beforeSend: function() {
          $('.loader').show();
          $("#productrequest_btn").prop('disabled', true);
        },
        success: function(response) {
          $("#productrequest_btn").prop('disabled', false);
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