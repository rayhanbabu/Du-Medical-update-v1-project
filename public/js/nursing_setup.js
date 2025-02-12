$(document).ready(function(){ 

    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });

    
        // add new employee ajax request
        $("#add_employee_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $.ajax({
              type:'POST',
              url:"/nursing/insert",
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
              url: '/admin/member_view/' + view_id,
              success: function(response) {
                //console.log(response);
                if (response.status == 404) {
                  $('#success_message').html("");
                  $('#success_message').addClass('alert alert-danger');
                  $('#success_message').text(response.message);
                } else {
                  $('#edit_id').val(response.value.id);
                  $('#edit_member_name').val(response.value.member_name);
                  $('#edit_designation').val(response.value.designation);
                  $('#edit_registration').val(response.value.registration);
                  $('#edit_email').val(response.value.email);
                  $('#edit_phone').val(response.value.phone);
                  $('#edit_member_category').val(response.value.member_category);
                  $('#edit_member_status').val(response.value.member_status);
                  $('#edit_gender').val(response.value.gender);
                  $('#edit_dobirth').val(response.value.dobirth);
                }
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
                  url:'/nursing/delete',
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