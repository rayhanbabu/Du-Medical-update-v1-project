$(document).ready(function(){ 
	$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });

      
     $(document).on('submit', '#appointment_search_form', function(e){
             e.preventDefault();

       let appointment_search_form=new FormData($('#appointment_search_form')[0]);
       let date = appointment_search_form.get('date');
       let service = appointment_search_form.get('service');


       
		


	  });
   
 });