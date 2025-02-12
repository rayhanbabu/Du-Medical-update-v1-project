@extends('teacher.layout')
@section('page_title','Teacher Panel')
@section('teacher_manage','active')
@section('content')


@if($role=="admin")
<div class="row mt-4 mb-0">

    <div class="row mt-2 mb-0 mx-1 shadow p-1">
      <h5> Teacher Access </h5>
       <div class="col-sm-1 my-2">
           <form  method="get" enctype="multipart/form-data">   
           <label> Batch </label>
              <select name="batch_id" id="batch_id" class="js-example-disabled-results" style="width:100px;" aria-label="Default select example" required>
                     <option value=""> Batch </option>
                      @foreach($batch as $row)  
                          @if($row->id==($batch_id?$batch_id->id:0))
                                <option  value="{{$row->id}}" selected> 
                               {{$row->batch_name}}</option>
                           @else
                             <option value="{{$row->id}}">{{$row->batch_name}}</option>
                           @endif
                      @endforeach
              </select>


      </div>
      <div class="col-sm-1 my-2">
              <label>Year</label>
               <select name="year_id" id="year_id" class="js-example-disabled-results" style="width:100px;" aria-label="Default select example" required>
                          @foreach($year as $row)  
                             @if($row->id==($year_id?$year_id->id:0))
                                <option  value="{{$row->id}}" selected> 
                               {{$row->year_name}}</option>
                             @endif
                          @endforeach
               </select>   
                
    </div>

        <div class="col-sm-1 my-2">
             <label>Programe</label>
               <select  name="programe_id" id="programe_id" class="js-example-disabled-results" style="width:100px;" aria-label="Default select example" required>
                      @foreach($programe as $row)  
                             @if($row->id==($programe_id?$programe_id->id:0))
                                <option  value="{{$row->id}}" selected> 
                               {{$row->programe_name}}</option>
                             @endif
                          @endforeach
              </select>
        </div>

        <div class="col-sm-2 my-2">
             <label>Programe Year</label>
              <select  name="proyear_id" id="proyear_id" class="js-example-disabled-results" style="width:200px;" aria-label="Default select example" required>
                      @foreach($proyear as $row)  
                             @if($row->id==($proyear_id?$proyear_id->id:0))
                                <option  value="{{$row->id}}" selected> 
                               {{$row->proyear_name}}</option>
                             @endif
                          @endforeach
            </select>
        </div>

      <div class="col-sm-2 my-2">
            <label>Semester</label>
             <select class="js-example-disabled-results" style="width:200px;" name="semester_id" id="semester_id" aria-label="Default select example" >
                        @foreach($semester as $row)  
                             @if($row->id==($semester_id?$semester_id->id:0))
                                <option  value="{{$row->id}}" selected> 
                               {{$row->semester_name}}</option>
                             @endif
                          @endforeach
             </select>
        </div>


    
    <div class="col-sm-1 my-2">
        <div class="d-grid gap-3 d-flex justify-content-start">
            <button type="submit" name="search" class="btn btn-primary">Search</button>
        </div>
    </div>
    </form>
</div>
@else

<div class="row mt-4 mb-0">
   <div class="row mt-3 mb-0 mx-2 shadow p-2">
      <div class="col-sm-2 my-2">
           <form  method="get" enctype="multipart/form-data">   
            <div class="d-grid gap-3 d-flex justify-content-end">
               <select class="js-example-disabled-results" style="width:200px;" name="year_id" id="year_id" aria-label="Default select example" required>
                     <option value="">Select Year</option>
                     @foreach($adminaccess as $row)  
                          @if($row->year_id==($year_id?$year_id->id:0))
                               <option  value="{{$row->year_id}}" selected> 
                               {{$row->year_name}}</option>
                           @else
                             <option value="{{$row->year_id}}">{{$row->year_name}}</option>
                           @endif
                     @endforeach
              </select>
         </div>
     </div>

  
    <div class="col-sm-2 my-2">
        <div class="d-grid gap-3 d-flex justify-content-end">
            <select class="js-example-disabled-results" style="width:200px;" name="programe_id" id="programe_id" aria-label="Default select example" required>
                     <option value="">Select Programe</option>
                     @foreach($adminaccess as $row)  
                          @if($row->programe_id==($programe_id?$programe_id->id:0))
                               <option  value="{{$row->programe_id}}" selected> 
                               {{$row->programe_name}}</option>
                           @else
                               <option value="{{$row->programe_id}}">{{$row->programe_name}}</option>
                           @endif    
                     @endforeach
            </select>
        </div>
    </div>


    <div class="col-sm-2 my-2">
        <div class="d-grid gap-3 d-flex justify-content-end">
            <select class="js-example-disabled-results" style="width:200px;" name="proyear_id" id="proyear_id" aria-label="Default select example" required>
                     <option value="">Select Programe Year</option>
                     @foreach($adminaccess as $row)  
                          @if($row->proyear_id==($proyear_id?$proyear_id->id:0))
                               <option  value="{{$row->proyear_id}}" selected> 
                               {{$row->proyear_name}}</option>
                           @else
                               <option value="{{$row->proyear_id}}">{{$row->proyear_name}}</option>
                           @endif    
                     @endforeach
            </select>
        </div>
    </div>


     <div class="col-sm-2 my-2">
         <div class="d-grid gap-3 d-flex justify-content-end">
             <select class="js-example-disabled-results" style="width:200px;" name="semester_id" id="semester_id" aria-label="Default select example" required>
                     <option value="">Select Semester</option>
                     @foreach($semester as $row)  
                           @if($row->id==($semester_id?$semester_id->id:0))
                               <option  value="{{$row->id}}" selected> 
                                {{$row->semester_name}}</option>
                           @else
                               <option value="{{$row->id}}">{{$row->semester_name}}</option>
                           @endif    
                          
                     @endforeach
               </select>
            </div>
        </div>

    
    <div class="col-sm-1 my-2">
        <div class="d-grid gap-3 d-flex justify-content-start">
            <button type="submit" name="search" class="btn btn-primary">Search</button>
        </div>
    </div>
    </form>
</div>

@endif
                       
            @if(Session::has('success'))
                      <div class="sufee-alert alert with-close alert-primary alert-dismissible fade show">
                           {{Session('success')}}
			    	  </div>
            @endif

             @if(Session::has('fail'))
                     <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                           {{Session('fail')}}
			    	 </div>
             @endif
        

     <h4 class="mx-2">Examiner Course  Access : @if($semester_id!='') {{$year_id->year_name}} - {{$proyear_id->proyear_name}} - {{$programe_id->programe_name}} - {{$semester_id->semester_name}}
          
       @endif</h4>
     
    @if($semester_id!='')       
        <form action="{{url('teacher/teacher_auth_store')}}" method="post" enctype="multipart/form-data">
           @csrf     

           <input type="hidden" name="year_id" value="{{$year_id->id}}"/>
           <input type="hidden" name="programe_id" value="{{$programe_id->id}}"/>
           <input type="hidden" name="semester_id" value="{{$semester_id->id}}"/>
           <input type="hidden" name="proyear_id" value="{{$proyear_id->id}}"/>
     

           <div class="col-lg-12 mx-4 pb-3 bg-light"  id="teacher_attr_box">                            
                      <div class="row">
                             <div class="col-lg-2 mx-2">
                                <label class=""><b>Teacher <span style="color:red;"> * </span></b></label>
                             </div>

                              <div class="col-lg-2 mx-2">
                                <label class=""><b>Examiner <span style="color:red;"> * </span></b></label>
                             </div>

                             <div class="col-lg-1 mx-2">
                                <label class=""><b>Section</b> <span> </span></label>
                             </div>

                             <div class="col-lg-3 mx-2">
                                <label class=""><b>Course Name<span style="color:red;"> * </span></b></label>
                             </div>

                             <div class="col-lg-2 mx-2">
                                <label class=""><b><span style="color:red;">  </span></b></label>
                             </div>
                         </div>
                            @php
                               $loop_count_num=1;
                               $loop_count_prev=$loop_count_num;
                            @endphp

                        @foreach($teacherattr as $key=>$val)
                             @php
                                $loop_count_prev=$loop_count_num;
                                $tArr=(array)$val;
                            @endphp
                       
                            @if($inmedicineArr['medicine_id']==$list->id)
                        <option  value="{{$list->id}}" selected> 
                               {{$list->medicine_name}} </option>
                                 @else
                         <option  value="{{$list->id}}" > 
                             {{$list->medicine_name}} </option>
                              @endif
                           <!-- <input id="inmedicineid_{{$loop->index}}" name="inmedicineid[]" type="hidden" value="{{$inmedicineArr['id']}}"> -->
                 <input id="taid" name="taid[]"  type="hidden" value="{{$tArr['id']}}"  ></span>                             
                   <div class="row" id="teacher_attr_{{$loop_count_num++}}">

                          <div class="col-lg-2 mx-2 mt-2">
                                            <select id="teacher" class="form-control"  name="teacher[]"  required>
                                                 <option value="">Select Teacher </option>
                                                    @foreach($teacher as $list)
                                                          @if($tArr['teacher_id']==$list->id)
                                                            <option  value="{{$list->id}}" selected> 
                                                            {{$list->teacher_name}} </option>
                                                          @else
                                                           <option  value="{{$list->id}}" > 
                                                               {{$list->teacher_name}} </option>
                                                         @endif
                                                    @endforeach
                                                </select> 
                                         </div>

                                     <div class="col-lg-2 mx-2 mt-2">
                                            <select id="examiner" class="form-control"  name="examiner[]"  required>
                                                 <option value="">Select Examiner </option>
                                                    @foreach($examiner as $list)
                                                          @if($tArr['examiner_id']==$list->exam_id)
                                                            <option  value="{{$list->exam_id}}" selected> 
                                                            {{$list->examiner_name}} </option>
                                                          @else
                                                           <option  value="{{$list->exam_id}}" > 
                                                               {{$list->examiner_name}} </option>
                                                           @endif
                                                    @endforeach
                                                </select> 
                                         </div>


                                     <div class="col-lg-1 mx-2 mt-2">
                                          <select id="section" class="form-control"  name="section[]"  >  
                                               <option value=""> All </option>                                   
                                                      @foreach($section as $list)
                                                         @if($tArr['section_id']==$list->id)
                                                           <option  value="{{$list->id}}" selected> 
                                                           {{$list->section_name}} </option>
                                                       @else
                                                         <option  value="{{$list->id}}" > 
                                                             {{$list->section_name}} </option>
                                                          @endif
                                                       @endforeach
                                             </select> 
                                     </div>


                             <div class="col-lg-3 mx-2 mt-2">
                                    <select id="course" class="form-control"  name="course[]"  required>
                                               <option value="">Select Subjecct </option>
                                     @foreach($course as $row)            
                                             @if($tArr['course_id']==$row->id)
                                                <option  value="{{$row->id}}" selected> 
                                                {{$row->course_code}} - {{$row->course_name}} - {{$row->coyear_name}}-{{$row->programe_name}}-{{$row->proyear_name}}-{{$row->semester_name}} </option>
                                             @else
                                          <option value="{{$row->id}}"> {{$row->course_code}} - {{$row->course_name}} -{{$row->coyear_name}}-{{$row->programe_name}}-{{$row->proyear_name}}-{{$row->semester_name}}</option>
                                              @endif
                                     @endforeach	 
                                    </select>         
                            </div>
                               

                             <div class="col-lg-2 mx-2 mt-2"> 
                                     @if($loop_count_num==2)
                                         <button type="button" onClick="add_more()" class="btn btn-primary">
                                               <i class="fa fa-plus"></i>&nbsp; Add </button>                                         
                                               @else
                                        <a class="btn btn-danger" 
                                        onclick="return confirm('Are you sure you want to Delete this status')"    href="{{url('teacher/teacher_auth_delete/')}}/{{$tArr['id']}}" role="button"><i class="fa fa-minus"></i>Delete</a>                                     
                                              @endif
                              </div>  
                        </div>

                        @endforeach
                     </div>
             </from>


                           <br>
                          <div>
                                 <button id="payment-button" type="submit" class="btn btn-lg btn-success btn-block mx-5">
                                      <span id="payment-button-amount">Submit</span>
                              </button>
                          </div>
            @endif
            <br><br>

         <script>
     $(".js-example-disabled-results").select2();

                 var loop_count=1;
                  function add_more(){
                        loop_count++;
                          var   html=' <input id="taid" name="taid[]"  type="hidden"   ></span>\
                          <div class="col-lg-12 mt-2">\
                                     <div class="row"  id="teacher_attr_'+loop_count+'">';


                            var teacher_html=jQuery('#teacher').html();   
                                     teacher_html=teacher_html.replace("selected","");
                     
                               html+='<div class="col-lg-2 mx-2">\
                                        <div class="form-group has-success">\
                                            <select   class="form-control" name="teacher[]" required\
                                           >'+teacher_html+'</select></div>\
                                 </div>';                


                             var examiner_html=jQuery('#examiner').html();   
                                  examiner_html=examiner_html.replace("selected","");
                     
                               html+='<div class="col-lg-2 mx-2">\
                                        <div class="form-group has-success">\
                                            <select   class="form-control" name="examiner[]" required\
                                           >'+examiner_html+'</select></div>\
                                 </div>';         
                          
                               var section_html=jQuery('#section').html();   
                                section_html=section_html.replace("selected","");
                     
                                html+='<div class="col-lg-1 mx-2">\
                                        <div class="form-group has-success">\
                                            <select   class="form-control" name="section[]" \
                                           >'+section_html+'</select></div>\
                                 </div>';  


                                

                                 var course_html=jQuery('#course').html();   
                                 course_html=course_html.replace("selected","");
                     
                                 html+='<div class="col-lg-3 mx-2">\
                                        <div class="form-group has-success">\
                                            <select   class="form-control" name="course[]" required\
                                           >'+course_html+'</select></div>\
                                 </div>';  
     
                                     
                            html+=' <div class="col-lg-2 mx-2">\
                                          <button type="button" onclick=remove_more("'+loop_count+'") class="btn btn-danger">\
                                            <i class="fa fa-minus"></i>&nbsp;Remove</button>\
                             </div>';   

                             html+='</div> </div> ';
                       
                    jQuery('#teacher_attr_box').append(html);
                     }


              function remove_more(loop_count){
                   jQuery('#teacher_attr_'+loop_count).remove();
                         //alert(loop_count);
               }

        </script>    
        
        
    <script type="text/javascript">
           $(document).ready(function (){
              $('#batch_id').on('change', function () {
                 var nameId = this.value;
                   $('#year_id').html('');
                 $.ajax({
                     url:'/batch_year-fetch?batch_id='+nameId,
                     type:'get',
                     success: function (res) {
                         $('#year_id').html('<option value="" selected disabled>Select Year</option>');
                          $.each(res, function (key, value) {
                              $('#year_id').append('<option data-custom_batch_id="1" value="' + value
                                 .year_id + '">' + value.year_name + '</option>');
                        });
                    }
                });
            });
          });



          $(document).ready(function (){
            $('#year_id').on('change', function () {
                var yearId = this.value;
                var batch_id = $('#batch_id').val(); 
                $.ajax({
                      url:'/batch_status-fetch?batch_id='+batch_id+'?year_id='+yearId,
                      type:'get',
                      success: function(res){
                           $.each(res,function (key,value) {
                              $('#programe_id').append('<option value="' + value
                                 .programe_id + '">' + value.programe_name + '</option>');
                           });

                           $.each(res,function (key,value) {
                            $('#proyear_id').append('<option value="' + value
                               .proyear_id + '">' + value.proyear_name + '</option>');
                           });


                           $.each(res,function (key,value) {
                            $('#semester_id').append('<option value="' + value
                               .semester_id + '">' + value.semester_name + '</option>');
                           });
                     }
                 });
              });
           });

        </script>




@endsection 