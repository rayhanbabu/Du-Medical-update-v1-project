@extends('layouts/dashboardheader')
@section('page_title','Admin Dashboard')
@section('stock','active')
@section('content')

<div class="card mt-2 mb-2 shadow-sm">
   <div class="card-header">
       <div class="row ">
               <div class="col-8"> <h5 class="mt-0">Product Store @if(!$id) Add @else Edit @endif </h5></div>
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                             
                                     
                         </div>
                     </div>

                    

                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex ">
                           <a class="btn btn-primary btn-sm" href="{{url('admin/stock')}}" role="button"> Back </a>
                         </div>
                     </div> 
         </div>

       @if ($errors->any())
          <div class="alert alert-danger">
             <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
           </div>
       @endif

            @if(Session::has('fail'))
                <div  class="alert alert-danger"> {{Session::get('fail')}}</div>
            @endif
                           
             @if(Session::has('success'))
                   <div  class="alert alert-success"> {{Session::get('success')}}</div>
             @endif

  </div>

  <div class="card-body">    
  <form method="post" action="{{url('admin/stock/insert')}}"  class="myform"  enctype="multipart/form-data" >
  {!! csrf_field() !!}

     <input type="hidden" name="id"  value="{{$id}}" class="form-control" >

     <div class="row px-2">


       <div class="form-group col-sm-3 my-2">
               <label class=""><b> Generic/ Product category <span style="color:red;"> * </span></b> </label> <br>
                 <select name="generic_id" id="generic_id"  class="form-control js-example-disabled-results" style="max-width:300px;" required>
                  <option value="">Select Generic Name </option>
                   @foreach($generic as $row)
                      <option value="{{ $row->id }}" {{ $row->id == $generic_id ? 'selected' : '' }}>
                          {{ $row->generic_name }}
                      </option>
                   @endforeach
                 </select>
           </div> 



           <div class="form-group col-sm-2 my-2">
               <label class=""><b> Brand Name <span style="color:red;"> * </span></b></label><br>
                 <select name="brand_id" id="brand_id"  class="form-control js-example-disabled-results" style="max-width:300px;" required>
                  <option value="">Select Brand Name </option>
                   @foreach($brand as $row)
                      <option value="{{ $row->id }}" {{ $row->id == $brand_id ? 'selected' : '' }}>
                          {{ $row->brand_name }}
                      </option>
                   @endforeach
                 </select>
           </div> 



          <div class="form-group col-sm-3 my-2">
               <label class=""><b>Medicine Name <span style="color:red;"> * </span></b></label>
               <input type="text" name="medicine_name" class="form-control form-control-sm" value="{{$medicine_name}}" required>
          </div> 

          <div class="form-group col-sm-2 my-2">
               <label class=""><b> Strength </b></label>
               <input type="text" name="strength" class="form-control form-control-sm" value="{{$strength}}" >
          </div> 

          <div class="form-group col-sm-2 my-2">
               <label class=""><b> No of Box  <span style="color:red;"> * </span></b></label>
               <input type="text" name="box" class="form-control form-control-sm" value="{{$box}}" pattern="^[1-9][0-9]*$" required>
          </div> 

          <div class="form-group col-sm-2 my-2">
               <label class=""><b> Box Per Unit  <span style="color:red;"> * </span></b></label>
               <input type="text" name="piece_per_box" class="form-control form-control-sm" value="{{$piece_per_box}}" pattern="^[1-9][0-9]*$" required>
          </div> 

         
          <div class="form-group col-sm-2 my-2">
               <label class=""><b> Cost Per Unit  <span style="color:red;"> * </span></b></label>
               <input type="text" name="cost_per_piece" class="form-control form-control-sm" value="{{$cost_per_piece}}" pattern="^[0-9]*\.?[0-9]+$" required>
          </div> 

           <div class="form-group col-sm-2 my-2">
                <label class=""><b> Expired Date <span style="color:red;"> * </span></b></label>
                <input type="date" name="expired_date" class="form-control form-control-sm" value="{{$expired_date}}"  required>
           </div> 

           <div class="form-group col-sm-2 my-2">
                <label class=""><b> Mgf Date  </b></label>
                <input type="date" name="mgf_date" class="form-control form-control-sm" value="{{$mgf_date}}"  >
           </div> 

           <div class="form-group col-sm-2 my-2">
               <label class=""><b> Batch No </b></label>
               <input type="text" name="batch_no" class="form-control form-control-sm" value="{{$batch_no}}" >
          </div> 
         
            <div class="form-group col-sm-2  my-2">
                <label class=""><b>stock Status </b></label>
                 <select class="form-select form-select-sm" name="stock_status"  aria-label="Default select example">
                      <option value="1" {{ $stock_status == '1' ? 'selected' : '' }}> Active </option>
                      <option value="0" {{ $stock_status == '0' ? 'selected' : '' }}> Inactive </option>
                </select>
           </div> 

           

       </div>
           <br>
        <input type="submit"   id="insert" value="Submit" class="btn btn-success" />
	  
              
     </div>

     </form>

  </div>
</div>





<script type="text/javascript">
      $(".js-example-disabled-results").select2();
</script>



   


@endsection