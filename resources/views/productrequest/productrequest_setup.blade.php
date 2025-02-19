@extends('layouts/dashboardheader')
@section('page_title','Admin Dashboard')
@section('test_list','active')
@section('content')
 
 <div class="card mt-2 mb-2 shadow-sm">
   <div class="card-header">
      <div class="row">
        <div class="col-4">
            <h4> Product Request Application  </h4> 
       </div>
     
   
       <div class="col-4">
    
          <div class="d-grid gap-2 d-md-flex ">
      
          </div>
      </div>
     
     

      <div class="col-4">
      <div class="d-grid gap-2 d-md-flex justify-content-center">
          
            <a class="btn btn-primary btn-sm" href="{{url('/diagnostic/test_list')}}" role="button"> Back </a>
          
        </div>
      </div>


     <div class="text-center">
        <p class="text-danger error_search"> </p>
    </div>
      

    </div>


    @if(Session::has('fail'))
    <div class="alert alert-danger"> {{Session::get('fail')}}</div>
    @endif

    @if(Session::has('success'))
    <div class="alert alert-success"> {{Session::get('success')}}</div>
    @endif


  </div>


  <form method="POST" id="productrequest_setup_form" enctype="multipart/form-data">
     <div class="card-body">
   
    <div class="row g-1">
       
      

   

   <!-- Medicine In Start -->
   <div class="col-md-6 mt-2 p-1">
      <div class="shadow p-3">
          <b> Medicine in Pharmacy </b>
       <hr>

     <div class="" id="inmedicine_attr_box">
                    @php
                          $loop_count_num=1;
                   @endphp
     
        
          @php
                   $loop_count_prev=$loop_count_num;    
          @endphp   
         
     <div class="row shadow p-2" id="inmedicine_attr_{{$loop_count_num++}}">              
         <div class="col-md-7 p-2">
            <select name="generic_id[]" id="generic_id" class="form-control js-example-disabled-results me-3" >
              <option value="">Select Medicine </option>
                      @foreach($generic as $list)
                           <option  value="{{$list->id}}" > 
                                {{$list->generic_name}} </option>
                       @endforeach
                                              
             </select>
        </div>
       <div class="col-md-3 p-2">
            <input type="text" id="total_piece" name="total_piece[]" value="" placeholder="Quantity" class="form-control form-control-sm" >
       </div>


      




        <div class="col-md-2 p-2"> 
           @if($loop_count_num==2)
                  <button type="button" onClick="add_more()" class="btn btn-primary">
                <i class="fa fa-plus"></i> </button>  
           @else
                  
           @endif  
        </div>

      </div>
     

      </div>

   
     </div>

  </div>

 <!-- Medicine In END -->



  <div class="loader">
            <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
          </div>

         <div class="mt-4">
             <button type="submit" id="productrequest_btn" class="btn btn-success"> Save  </button>
          </div>
            
    </div>
  
    </form>


 
</div>

<script src="{{ asset('js/productrequest_setup.js') }}"></script>
<script type="text/javascript">
  
    $(".js-example-disabled-results").select2();
    $('.js-example-basic-multiple').select2();

  
  </script>


@endsection



