
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
                {data: 'member.member_name', name: 'member.member_name'},
                {data: 'careof', name: 'careof'},
                {data: 'member.registration', name: 'memner.registration'},
                {data: 'view', name: 'view'},
                {data: 'delete', name: 'delete', orderable: false, searchable: false },
                {data: 'create.name', name: 'create.name'},
               
            ]
         });
      }



      //  Appointment Search
    $("#search_form").submit(function(e) {
      e.preventDefault();

       const fd = new FormData(this);
     $.ajax({
          type: 'POST',
          url: '/pharmacy/search',
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
              window.location.href = "/pharmacy/setup?appointment_id=" + response.appointment_id;
         }else if((response.status == 'fail')){
             $('.error_search').text(response.message);
          
          } 
          }
       });
    });
    // End Appointment Search



         //  Pharmacy  Setup
    $("#pharmacy_setup_form").submit(function(e) {
      e.preventDefault();
       const fd = new FormData(this);

      $.ajax({
         type: 'POST',
         url: '/pharmacy/setup/update',
         data: fd,
         cache: false,
         contentType: false,
         processData: false,
         dataType: 'json',
        beforeSend: function() {
          $('.loader').show();
          $("#pharmacy_btn").prop('disabled', true);
        },
        success: function(response) {
          $("#pharmacy_btn").prop('disabled', false);
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

    // End Pharmacy Setup
       

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