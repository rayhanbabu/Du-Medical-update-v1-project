$(document).ready(function(){ 
	$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });


  $(document).on('submit', '#email_form', function(e){
        e.preventDefault();
        let emailData=new FormData($('#email_form')[0]);

		$.ajax({
             type:'POST',
             url:'/member/login-insert',
             data:emailData,
             contentType: false,
             processData:false,
             beforeSend : function()
              {
                  $("#add_employee_btn").prop('disabled',true);
              },
             success:function(response){ 
                  //console.log(response);
			     $("#add_employee_btn").prop('disabled', false);
				    if(response.status == 200){
					    	$('#verify_email').val(response.email);
						    $('.error_phone').text("");
						    $('.error_password').text("");
							$('.loginform').hide();
							$('.verifyform').show();
				    }else if(response.status == 300){
					     $('.error_email').text(response.message);
				    }else if(response.status == 700){
					     $('.error_email').text(response.validate_err.email);
						
				     }
              }
          });
	});



	$(document).on('submit', '#verify_form', function(e){
        e.preventDefault();
        let verifyData=new FormData($('#verify_form')[0]);

		$.ajax({
             type:'POST',
             url:'/member/login-verify',
             data:verifyData,
             contentType: false,
             processData:false,
             beforeSend : function()
              {
                  $("#add_verify_btn").prop('disabled',true);
              },
             success:function(response){ 
                  //console.log(response);
			     $("#add_verify_btn").prop('disabled', false);
				      if(response.status == 200){
						    $('.error_otp').text("");
							location.href='/member/dashboard';
				        }else if(response.status == 300){
					         $('.error_otp').text(response.message);
                        }else if(response.status == 700){
					         $('.error_otp').text(response.message.otp);
				        }
				}
          });
	});


   
});

