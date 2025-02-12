$(document).ready(function () {

    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    // add new employee ajax request
    $("#add_appointment_form").submit(function (e) {
        e.preventDefault();
        const fd = new FormData(this);
        $.ajax({
            type: 'POST',
            url: "/patientreport/appointment_show",
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                $("#add_appointment_btn").prop('disabled', true).text('Searching..');
            },
            success: function (response) {
                $("#add_appointment_btn").prop('disabled', false).text('Search');
                if (response.status=="success") {

                    var items = response.data; // Assuming response.slot is an array of objects
                 
                    // Clear the table before appending new rows
                    $('#data-table tbody').empty();

                    // Loop through each item in the array
                    $.each(items, function (index, item) {
                        var newRow = $('<tr>');
                        // Assuming the object has 'slot_time' and 'id'
                        newRow.append('<td>' + item.date + '</td>');
                        newRow.append('<td>' + item.id + '</td>');
                        newRow.append('<td>' + item.member_name + '</td>');
                        newRow.append('<td>' + item.registration + '</td>');
                        newRow.append('<td>' + item.disease_problem + '</td>');
                        newRow.append('<td><a href="/prescription/' + item.id + '" class="btn btn-success btn-sm">View Details</a></td>');
                        // Append the new row to the table
                        $('#data-table tbody').append(newRow);

                        // Set the appointment_id value (if necessary)
                       
                    });
                } else {
                    var item = response.data;
                    // Clear the table before appending new rows (optional)
                    $('#data-table tbody').empty();
                    // Assuming response.value is a single object              
                    var newRow = $('<tr>');
                     // Assuming the object has 'slot_time' and 'id'
                     newRow.append('<td colspan="6">' + item + '</td>');
                     $('#data-table tbody').append(newRow);
                 }

            }
        });

    });




     // add new employee ajax request
    $("#add_diagnostic_form").submit(function (e) {
        e.preventDefault();
        const fd = new FormData(this);
        $.ajax({
            type: 'POST',
            url: "/patientreport/diagnostic_show",
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                $("#add_diagnostic_btn").prop('disabled', true).text('Searching..');
            },
            success: function (response) {
                $("#add_diagnostic_btn").prop('disabled', false).text('Search');
                if (response.status=="success") {

                    var items = response.data; // Assuming response.slot is an array of objects
                 
                    // Clear the table before appending new rows
                    $('#data-table tbody').empty();

                    // Loop through each item in the array
                    $.each(items, function (index, item) {
                        var newRow = $('<tr>');
                        // Assuming the object has 'slot_time' and 'id'
                        newRow.append('<td>' + item.date + '</td>');
                        newRow.append('<td>' + item.appointment_id + '</td>');
                        newRow.append('<td>' + item.member_name + '</td>');
                        newRow.append('<td>' + item.registration + '</td>');
                        newRow.append('<td>' + item.test_name + '</td>');
                        newRow.append('<td> <a href="javascript:void(0);" data-id="' + item.id + '" class="edit btn btn-primary btn-sm">View Result</a></td>');
                        // Append the new row to the table
                        $('#data-table tbody').append(newRow);
                    // Set the appointment_id value (if necessary)      
                    });


                } else {
                    var item = response.data;
                    // Clear the table before appending new rows (optional)
                    $('#data-table tbody').empty();
                    // Assuming response.value is a single object              
                    var newRow = $('<tr>');
                     // Assuming the object has 'slot_time' and 'id'
                     newRow.append('<td colspan="6">' + item + '</td>');
                     $('#data-table tbody').append(newRow);
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
          url: '/patientreport/diagnostic_result/' + view_id,
          success: function(response) {
            console.log(response);
            if (response.status == 'success') {
            

                   var items = response.data; // Assuming response.slot is an array of objects
                 
                    // Clear the table before appending new rows
                    $('#result-table tbody').empty();

                    // Loop through each item in the array
                    $.each(items, function (index, item) {
                        var newRow = $('<tr>');
                        // Assuming the object has 'slot_time' and 'id'
                        newRow.append('<td>' + item.diagnostic_name + '</td>');
                        newRow.append('<td>' + item.result + '</td>');
                        newRow.append('<td>' + item.reference_range + '</td>');
                      
                      
                        // Append the new row to the table
                        $('#result-table tbody').append(newRow);
                    // Set the appointment_id value (if necessary)      
                    });


            } else {
            
              $('#success_message').html("");
              $('#success_message').addClass('alert alert-danger');
              $('#success_message').text(response.message);
             
            }
          }
        });
  
      });







      // add new employee ajax request
      $("#add_pharmacy_form").submit(function (e) {
        e.preventDefault();
        const fd = new FormData(this);
        $.ajax({
            type: 'POST',
            url: "/patientreport/pharmacy_show",
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                $("#add_pharmacy_btn").prop('disabled', true).text('Searching..');
            },
            success: function (response) {
                $("#add_pharmacy_btn").prop('disabled', false).text('Search');
                if (response.status=="success") {

                    var items = response.data; // Assuming response.slot is an array of objects
                 
                    // Clear the table before appending new rows
                    $('#data-table tbody').empty();

                    // Loop through each item in the array
                    $.each(items, function (index, item) {
                        var newRow = $('<tr>');
                        // Assuming the object has 'slot_time' and 'id'
                        newRow.append('<td>' + item.date + '</td>');
                        newRow.append('<td>' + item.id + '</td>');
                        newRow.append('<td>' + item.member_name + '</td>');
                        newRow.append('<td>' + item.registration + '</td>');
                        newRow.append('<td>' + item.generic_name + '</td>');
                        newRow.append('<td>' + item.medicine_name + '</td>');
                        newRow.append('<td>' + item.total_piece + '</td>');
                        newRow.append('<td>' + item.total_amount + '</td>');
                        // Append the new row to the table
                        $('#data-table tbody').append(newRow);

                        // Set the appointment_id value (if necessary)
                       
                    });
                } else {
                    var item = response.data;
                    // Clear the table before appending new rows (optional)
                    $('#data-table tbody').empty();
                    // Assuming response.value is a single object              
                    var newRow = $('<tr>');
                     // Assuming the object has 'slot_time' and 'id'
                     newRow.append('<td colspan="6">' + item + '</td>');
                     $('#data-table tbody').append(newRow);
                 }

            }
        });

    });








});