@extends('layouts/memberheader')
@section('page_title','Diagnostic Dashboard')
@section('diagnostic_test','active')
@section('content')

  
<div class="container p-3">
      <div class="card rating-card">
        <div class="card-body">
          <div class="rating-title">
            Based on your recent experience, please rate your satisfaction with
            the following:
          </div>

          <table class="table table-bordered">
            <thead>
              <tr>
                <th></th>
                <th>Highly Satisfied</th>
                <th>Satisfied</th>
                <th>Neutral</th>
                <th>Dissatisfied</th>
                <th>Highly Dissatisfied</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Doctor</td>
                <td>
                  <input type="radio" name="doctor" class="radio-input" />
                </td>
                <td>
                  <input type="radio" name="doctor" class="radio-input" />
                </td>
                <td>
                  <input type="radio" name="doctor" class="radio-input" />
                </td>
                <td>
                  <input type="radio" name="doctor" class="radio-input" />
                </td>
                <td>
                  <input type="radio" name="doctor" class="radio-input" />
                </td>
              </tr>
              <tr>
                <td> Pharmacist </td>
                <td><input type="radio" name="staff" class="radio-input" /></td>
                <td><input type="radio" name="staff" class="radio-input" /></td>
                <td><input type="radio" name="staff" class="radio-input" /></td>
                <td><input type="radio" name="staff" class="radio-input" /></td>
                <td><input type="radio" name="staff" class="radio-input" /></td>
              </tr>

              <tr>
                <td>Nursing</td>
                <td>
                  <input type="radio" name="cleanliness" class="radio-input" />
                </td>
                <td>
                  <input type="radio" name="cleanliness" class="radio-input" />
                </td>
                <td>
                  <input type="radio" name="cleanliness" class="radio-input" />
                </td>
                <td>
                  <input type="radio" name="cleanliness" class="radio-input" />
                </td>
                <td>
                  <input type="radio" name="cleanliness" class="radio-input" />
                </td>
              </tr>

              <tr>
                <td> pathologist </td>
                <td>
                  <input type="radio" name="waiting" class="radio-input" />
                </td>
                <td>
                  <input type="radio" name="waiting" class="radio-input" />
                </td>
                <td>
                  <input type="radio" name="waiting" class="radio-input" />
                </td>
                <td>
                  <input type="radio" name="waiting" class="radio-input" />
                </td>
                <td>
                  <input type="radio" name="waiting" class="radio-input" />
                </td>
              </tr>

              <tr>
                <td> Isolation </td>
                <td>
                  <input type="radio" name="experience" class="radio-input" />
                </td>
                <td>
                  <input type="radio" name="experience" class="radio-input"  />
                </td>
                <td>
                  <input type="radio" name="experience" class="radio-input" />
                </td>
                <td>
                  <input type="radio" name="experience" class="radio-input" />
                </td>
                <td>
                  <input type="radio" name="experience" class="radio-input" />
                </td>
              </tr>


              <tr>
                <td> Ambulance </td>
                <td>
                  <input type="radio" name="experience" class="radio-input" />
                </td>
                <td>
                  <input type="radio" name="experience" class="radio-input"  />
                </td>
                <td>
                  <input type="radio" name="experience" class="radio-input" />
                </td>
                <td>
                  <input type="radio" name="experience" class="radio-input" />
                </td>
                <td>
                  <input type="radio" name="experience" class="radio-input" />
                </td>
              </tr>
                  
            </tbody>
          </table>

             <button type="button" class="btn btn-info btn-sm">  Submit</button>
      
          </div>
      </div>
    </div>






@endsection