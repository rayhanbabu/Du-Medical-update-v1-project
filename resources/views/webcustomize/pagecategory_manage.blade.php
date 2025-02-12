@extends('layouts/dashboardheader')
@section('page_title','Admin Dashboard')
@section('pagecategory','active')
@section('content')


   <div class="card mt-2 mb-2 shadow-sm">
      <div class="card-header">
          <div class="row ">
               <div class="col-8"> <h5 class="mt-0"> Page  @if(!$id) Add @else Edit @endif </h5></div>
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                             
                                     
                         </div>
                     </div>

                    

                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex ">
                           <a class="btn btn-primary btn-sm" href="{{url('admin/pagecategory')}}" role="button"> Back </a>
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
  <form method="post" action="{{url('admin/pagecategory/insert')}}"  class="myform"  enctype="multipart/form-data" >
  {!! csrf_field() !!}

     <input type="hidden" name="id"  value="{{$id}}" class="form-control" >

     <div class="row px-2">

       <div class="form-group col-sm-5 my-2">
               <label class=""><b>Page Id (not spaces) <span style="color:red;"> * </span></b></label>
               <input type="text" name="page_id" class="form-control"  pattern="^[^\s\-]+$" 
               title="The Page ID must not contain spaces or hyphens."  value="{{$page_id}}" required>
          </div> 

          <div class="form-group col-sm-5 my-2">
               <label class=""><b>Page Name <span style="color:red;"> * </span></b></label>
               <input type="text" name="page_name" class="form-control" value="{{$page_name}}" required>
          </div> 
            
            <div class="form-group col-sm-2  my-2">
                <label class=""><b> Status </b></label>
                 <select class="form-select" name="pagecategory_status"  aria-label="Default select example">
                      <option value="1" {{ $pagecategory_status == '1' ? 'selected' : '' }}> Active </option>
                      <option value="0" {{ $pagecategory_status == '0' ? 'selected' : '' }}> Inactive </option>
                </select>
           </div> 

           

       </div>
           <br>
        <input type="submit"   id="insert" value="Submit" class="btn btn-success" />
	  
              
     </div>

     </form>

  </div>
</div>








   


@endsection