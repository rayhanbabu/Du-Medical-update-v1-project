$(document).ready(function(){ 

    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });


    //  Appointment Search
    $("#search_form").submit(function(e) {
        e.preventDefault();
 
     const fd = new FormData(this);
        $.ajax({
           type: 'POST',
           url: '/ward/search',
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
              window.location.href = "/ward/setup?appointment_id=" + response.appointment_id;
           }else if((response.status == 'fail')){
               $('.error_search').text(response.message);
       
            } 
           }
        });
     });
     // End Appointment Search
 
 
    
        // add new employee ajax request
        $("#add_employee_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $.ajax({
              type:'POST',
              url:"/ward/insert",
              data: fd,
              cache: false,
              contentType: false,
              processData: false,
              dataType: 'json',
              beforeSend : function()
                   {
                   $('.loader').show();
                   $("#add_employee_btn").prop('disabled', true);
                   },
              success: function(response){
               $('.loader').hide();
               $("#add_employee_btn").prop('disabled', false);
             if(response.status==200){
                   $("#add_employee_form")[0].reset();
                   $("#addEmployeeModal").modal('hide');
                   Swal.fire("Success",response.message,"success"); 
                   $('.error_registration').text('');
                   $('.error_member_name').text('');
                   fetchAll();
                }else if(response.status == 400){
                    $('.error_service_type').text(response.message.servise_type);
                    $('.error_comment').text(response.message.comment);
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
              url: '/ward/edit/' + view_id,
              success: function(response) {
                //console.log(response);
                if (response.status == 404) {
                  $('#success_message').html("");
                  $('#success_message').addClass('alert alert-danger');
                  $('#success_message').text(response.message);
                } else {
                  $('#edit_id').val(response.value.id);
                  $('#edit_bed_no').val(response.value.bed_no);
                  $('#edit_disease').val(response.value.disease);
                  $('#edit_ward_no').val(response.value.ward_no);
                  $('#edit_comment').val(response.value.comment);
                  $('#edit_isolation_status').val(response.value.isolation_status);
                 
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
    url: '/ward/update',
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
           $(document).on('click','.delete', function(e) {
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
                  url:'/ward/delete',
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