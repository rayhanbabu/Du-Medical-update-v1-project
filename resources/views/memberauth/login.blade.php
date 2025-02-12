@extends('layouts/memberheader')
@section('page_title','Diagnostic Dashboard')
@section('diagnostic_test','active')
@section('content')


   <style>
        .verifyform{
            display:none;
         }	
   </style>

  <div class="loginform"> 

     <div class="login-container">
       <h3 class="text-center login-header">Login</h3>
        <form method="post"  id="email_form"  class="myform"  enctype="multipart/form-data" >
        <div class="mb-3">
          <label for="email" class="form-label">Your Email address</label>

          <input type="email"
            class="form-control"
            id="email"
			      name="email"
            placeholder="Enter your Academic E-mail" required />
         </div>
		 <p class="text-danger error_email"> </p>
       
             <button type="submit" id="add_employee_btn" class="btn btn-primary mt-3">Login</button>
        </form>
    </div>

  </div>



  <div class="verifyform"> 

    <div class="login-container">
       <h3 class="text-center login-header">Login</h3>
         <form method="post"  id="verify_form"  class="myform"  enctype="multipart/form-data" >
            <div class="mb-3">
			
            <label for="email" class="form-label"> Send OTP Your E-mail </label>
               <input type="text"
                 class="form-control"
                 id="otp"
			           name="otp"
                 placeholder="Enter OTP" required/>
           </div>

		       <p class="text-danger error_otp"> </p>
		       <input type="hidden" id="verify_email"  name="verify_email">
       
           <button type="submit" id="add_verify_btn"  class="btn btn-primary mt-3"> Submit </button>
        </form>
    </div>

  </div>


  
	<script src="{{ asset('frontend/js/memberauth.js') }}"></script>


@endsection