(function($, conf, viewInit){
    "use strict";

    var Svca = {

        initDashboard: function() {
            // Initialize dashboard specific functionality
            console.log("Dashboard initialized");
        },

        initSettings: function(){
            let dtable = $('#centers-tbl');
            let centerTbl = new DataTable('#centers-tbl', {
                responsive: true,
                searching: typeof dtable.data('dt-searching') === 'undefined' ? true : dtable.data('dt-searching'),
                lengthChange: typeof dtable.data('dt-lengthchange') === 'undefined' ? true : dtable.data('dt-lengthchange'),
                processing: true,
                serverSide: true,
                bSortable: true,
                bFilter: true,
                pagingType: "full_numbers",
                ajax: {
                    url: conf.baseUrl + "/settings/getCenters",
                    type: 'post',
                },
                lengthMenu: [
                    [2, 5, 10, 20],
                    [2, 5, 10, 20]
                ],
                pageLength: (typeof dtable.data('dt-pagelength') === 'undefined' || dtable.data('dt-pagelength') === '-1') ? 2 : dtable.data('dt-pagelength'),
                paging: true,
                ordering: false,
                columnDefs: [
                    {
                        targets: [0],
                        orderable: false,
                        data: function (row) {  
                            return row.id;
                        }
                    },
                    {
                        targets: [1],
                        orderable: true,
                        data: function (row) {
                            return row.center;
                        }
                    },
                    {
                        targets: [2],
                        orderable: false,
                        data: function (row) {
                            return '<button class="btn btn-danger btn-sm delete-center" data-id="' + row.id + '">Delete</button>';
                        }
                    }
                ],
            });

            $("#sbt-center").on("click", function(e){
                e.preventDefault();
                if($("#center_name").val() === "") {
                    alert("Please enter a center name.");
                    return;
                }

                $.ajax({
                    url: conf.baseUrl + "/settings/add-center",
                    type: "POST",
                    dataType: "json",
                    data: {
                        center_name: $("#center_name").val()
                    },
                    success: function(res) {
                        if(res.success == 1) {
                            $("#center_name").val(""); // Clear the input field
                            alert("Center Added Successfully.");
                            centerTbl.ajax.reload(); // Reload the table data
                        } else {
                            alert("Error updating center name");
                        }
                    },
                    error: function() {
                        alert("An error occurred while updating the center name.");
                    }
                });
            });

            let coursetbl = $('#course-tbl');
            let courseTbl = new DataTable('#course-tbl', {
                responsive: true,
                select: {
                    style: 'single',
                },
                searching: typeof coursetbl.data('dt-searching') === 'undefined' ? true : coursetbl.data('dt-searching'),
                lengthChange: typeof coursetbl.data('dt-lengthchange') === 'undefined' ? true : coursetbl.data('dt-lengthchange'),
                processing: true,
                serverSide: true,
                bSortable: true,
                bFilter: true,
                pagingType: "full_numbers",
                ajax: {
                    url: conf.baseUrl + "/settings/getCourses",
                    type: 'post',
                },
                lengthMenu: [
                    [5, 10, 20, -1],
                    [5, 10, 20, "All"]
                ],
                pageLength: (typeof coursetbl.data('dt-pagelength') === 'undefined' || coursetbl.data('dt-pagelength') === '-1') ? 5 : coursetbl.data('dt-pagelength'),
                paging: true,
                ordering: false,
                columnDefs: [
                    {
                        targets: [0],
                        orderable: false,
                        data: function (row) {  
                            return row.id;
                        }
                    },
                    {
                        targets: [1],
                        orderable: true,
                        data: function (row) {
                            return row.course;
                        }
                    },
                    {
                        targets: [2],
                        orderable: true,
                        data: function (row) {
                            return row.price;
                        }
                    },
                    {
                        targets: [3],
                        orderable: false,
                        data: function (row) {
                            return '<button class="btn btn-danger btn-sm delete-center" data-id="' + row.id + '">Delete</button>';
                        }
                    }
                ],
            }).on('select', function(e, dt, type, indexes) {
                let data = courseTbl.rows(indexes).data().toArray();
                if(data.length > 0) {
                    $("#course_name").val(data[0].course);
                    $("#course_price").val(data[0].price);
                    $("#course_id").val(data[0].id);
                    $("#sbt-course").text("Update");
                }
            }).on('deselect', function(e, dt, type, indexes){
                $("#course_name").val("");
                $("#course_price").val("");
                $("#sbt-course").text("Submit");
            });

            $("#sbt-course").on("click", function(e){
                e.preventDefault();
                if($("#course_name").val() === "") {
                    alert("Please enter a course name.");
                    return;
                }

                if($("#course_price").val() === ""){
                    alert("Plaese enter a course price.");
                    return;
                }

                if($("#course_id").val()){
                    $.ajax({
                        url: conf.baseUrl + "/settings/update-course",
                        type: "POST",
                        dataType: "json",
                        data: {
                            id: $("#course_id").val(),
                            course_name: $("#course_name").val(),
                            course_price: $("#course_price").val()
                        },
                        success: function(res) {
                            if(res.success == 1) {
                                $("#course_name").val(""); // Clear the input field
                                alert("Course Updated Successfully.");
                                courseTbl.ajax.reload(); // Reload the table data
                            } else {
                                alert("Error updating course");
                            }
                        },
                        error: function() {
                            alert("An error occurred while updating the course.");
                        }
                    });
                }else{
                    $.ajax({
                        url: conf.baseUrl + "/settings/add-course",
                        type: "POST",
                        dataType: "json",
                        data: {
                            course_name: $("#course_name").val(),
                            course_price: $("#course_price").val()
                        },
                        success: function(res) {
                            if(res.success == 1) {
                                $("#course_name").val(""); // Clear the input field
                                alert("Course Added Successfully.");
                                courseTbl.ajax.reload(); // Reload the table data
                            } else {
                                alert("Error updating course");
                            }
                        },
                        error: function() {
                            alert("An error occurred while updating the course.");
                        }
                    });
                }

                
            });

            let districttbl = $('#district-tbl');
            let districtTbl = new DataTable('#district-tbl', {
                responsive: true,
                searching: typeof districttbl.data('dt-searching') === 'undefined' ? true : districttbl.data('dt-searching'),
                lengthChange: typeof districttbl.data('dt-lengthchange') === 'undefined' ? true : districttbl.data('dt-lengthchange'),
                processing: true,
                serverSide: true,
                bSortable: true,
                bFilter: true,
                pagingType: "full_numbers",
                ajax: {
                    url: conf.baseUrl + "/settings/get-districts",
                    type: 'post',
                },
                lengthMenu: [
                    [5, 10, 20, -1],
                    [5, 10, 20, "All"]
                ],
                pageLength: (typeof districttbl.data('dt-pagelength') === 'undefined' || districttbl.data('dt-pagelength') === '-1') ? 5 : districttbl.data('dt-pagelength'),
                paging: true,
                ordering: false,
                columnDefs: [
                    {
                        targets: [0],
                        orderable: false,
                        data: function (row) {  
                            return row.id;
                        }
                    },
                    {
                        targets: [1],
                        orderable: true,
                        data: function (row) {
                            return row.name;
                        }
                    },
                    {
                        targets: [2],
                        orderable: false,
                        data: function (row) {
                            return '<button class="btn btn-danger btn-sm delete-center" data-id="' + row.id + '">Delete</button>';
                        }
                    }
                ],
            });

            $("#sbt-district").on("click", function(e){
                e.preventDefault();
                if($("#district_name").val() === ""){
                    alert("Please enter a district name.");
                    return;
                }

                $.ajax({
                    url: conf.baseUrl + "/settings/add-district",
                    type: "POST",
                    dataType: "json",
                    data: {
                        dist_name: $("#district_name").val()
                    },
                    success: function(res) {
                        if(res.success == 1) {
                            $("#district_name").val(""); // Clear the input field
                            alert("District Added Successfully.");
                            districtTbl.ajax.reload(); // Reload the table data
                        } else {
                            alert("Error updating District");
                        }
                    },
                    error: function() {
                        alert("An error occurred while updating the District.");
                    }
                });
            });
        },

        initAddStudent: function(){
            document.getElementById('dob').addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '').slice(0,8);
                if (value.length >= 5)
                    value = value.replace(/(\d{2})(\d{2})(\d{1,4})/, '$1/$2/$3');
                else if (value.length >= 3)
                    value = value.replace(/(\d{2})(\d{1,2})/, '$1/$2');
                e.target.value = value;
            });

            $('#adm_date').datepicker({
                maxDate: new Date(),
                dateFormat: "dd/mm/yy"
            });

            $('#sbt-student').on('click', function(e){
                e.preventDefault();
                if($('#s_name').val() == ''){
                    $('#s_name').focus();
                    return false;
                }

                if($('#f_name').val() == ''){
                    $('#f_name').focus();
                    return false;
                }

                if($('#dob').val() == ''){
                    $('#dob').focus();
                    return false;
                }

                if($('#dob').val() == ''){
                    $('#dob').focus();
                    return false;
                }

                if($('#p_number').val() == ''){
                    $('#p_number').focus();
                    return false;
                }

                if($('#per').val() == ''){
                    $('#per').focus();
                    return false;
                }

                if($('#b_time1').val() == ''){
                    $('#b_time1').focus();
                    return false;
                }

                if($('#b_time2').val() == ''){
                    $('#b_time2').focus();
                    return false;
                }

                if($('#adhar').val() == ''){
                    $('#adhar').focus();
                    return false;
                }

                let gender = $('input[name="gender"]:checked').val();
                if (!gender) {
                    $('input[name="gender"]').first().focus();
                    return false;
                }

                let m_sts = $('input[name="marital_sts"]:checked').val();
                if (!m_sts) {
                    $('input[name="marital_sts"]').first().focus();
                    return false;
                }

                if($('#adm_date').val() == ''){
                    $('#adm_date').focus();
                    return false;
                }
                
                let from = $('#b_time1').val();
                let to = $('#b_time2').val();
                let b_time = from + ' - ' + to;
                
                //eturn false;
                $.ajax({
                    url: conf.baseUrl + "student/add",
                    type: "POST",
                    dataType: "json",
                    data: {
                        s_name: $('#s_name').val(),
                        f_name: $('#f_name').val(),
                        m_name: $('#m_name').val() ? $('#m_name').val() : '',
                        p_number: $('#p_number').val() ? $('#p_number').val() : '',
                        ap_number: $('#ap_number').val() ? $('#ap_number').val() : '',
                        dob: $('#dob').val(),
                        gender: gender,
                        marital_sts: m_sts,
                        lst_qulifi: $('#lst_qulifi').val() ? $('#lst_qulifi').val() : '',
                        per: $('#per').val() ? $('#per').val() : '',
                        course: $('#course').val() ? $('#course').val() : '',
                        cast: $('#cast').val() ? $('#cast').val() : '',
                        b_time: b_time ? b_time : '',
                        adhar: $('#adhar').val() ? $('#adhar').val() : '',
                        dist: $('#dist').val() ? $('#dist').val() : '',
                        center: $('#center').val() ? $('#center').val() : '',
                        address: $('#address').val() ? $('#address').val() : '',
                        ref_by: $('#ref_by').val() ? $('#ref_by').val() : '',
                        adm_date: $('#adm_date').val() ? $('#adm_date').val() : '',
                    },
                    success: function(res) {
                        if(res.success == 1) {
                            alert("Student Added Successfully.");
                            //window.location.href = conf.baseUrl + "/student/list";
                        } else {
                            alert("Error adding student");
                        }
                    },
                    error: function() {
                        alert("An error occurred while adding the student.");
                    }
                });
            });
        },

        initStudentList: function() {
            let studentTbl = new DataTable('#student-tbl', {
                responsive: true,
                scrollX: true,
                searching: true,
                lengthChange: true,
                processing: true,
                serverSide: true,
                bSortable: true,
                bFilter: true,
                pagingType: "full_numbers",
                ajax: {
                    url: conf.baseUrl + "/student/getStudents",
                    type: 'post',
                },
                lengthMenu: [
                    [5, 10, 20, -1],
                    [5, 10, 20, "All"]
                ],
                pageLength: 5,
                paging: true,
                ordering: false,
                columnDefs: [
                    {
                        targets: [0],
                        orderable: false,
                        data: function (row, type, val, meta) {  
                            return meta.row + 1;
                        }
                    },
                    {
                        targets: [1],
                        orderable: true,
                        data: function (row) {
                            return row.id;
                        }
                    },
                    {
                        targets: [2],
                        orderable: false,
                        data: function (row) {
                            return row.name;
                        }
                    },
                    {
                        targets: [3],
                        orderable: true,
                        data: function (row) {
                            return row.center_name;
                        }
                    },
                    {
                        targets: [4],
                        orderable: true,
                        data: function (row) {
                            return row.pnumber;
                        }
                    },
                    {
                        targets: [5],
                        orderable: true,
                        data: function (row) {
                            return (row.apnumber && row.apnumber.length > 1) ? row.apnumber : '-';
                        }
                    },
                    {
                        targets: [6],
                        orderable: true,
                        data: function (row) {
                            return row.course_name;
                        }
                    },
                    {
                       targets: [7],
                        orderable: false,
                        data: function (row) {
                            return row.referred_by ? row.referred_by : '-';
                        } 
                    },
                    {
                        targets: [8],
                        orderable: false,
                        data: function (row) {
                            return '<a class="text-primary btn" href="'+ conf.baseUrl +'payment/'+ row.id +'"><i class="ti ti-currency-dollar fs-6"></i></i></a>';
                        }
                    }
                ],
            });

            $('#student-tbl').on('click', '.delete-student', function() {
                let studentId = $(this).data('id');
                
                if(confirm("Are you sure you want to delete this student?")) {
                    $.ajax({
                        url: conf.baseUrl + "/student/delete/" + studentId,
                        type: "POST",
                        success: function(res) {
                            if(res.success == 1) {
                                alert("Student deleted successfully.");
                                studentTbl.ajax.reload();
                            } else {
                                alert("Error deleting student");
                            }
                        },
                        error: function() {
                            alert("An error occurred while deleting the student.");
                        }
                    });
                }
            });
        },

        initAddPayment: function(){
        
            let payhistorytbl = $('#pay-historytbl');
            let payhistoryTbl = new DataTable('#pay-historytbl', {
                responsive: true,
                searching: typeof payhistorytbl.data('dt-searching') === 'undefined' ? true : payhistorytbl.data('dt-searching'),
                lengthChange: typeof payhistorytbl.data('dt-lengthchange') === 'undefined' ? true : payhistorytbl.data('dt-lengthchange'),
                processing: true,
                serverSide: true,
                bSortable: true,
                bFilter: true,
                pagingType: "full_numbers",
                ajax: {
                    url: conf.baseUrl + "/payment/get-payhistory",
                    type: 'post',
                },
                lengthMenu: [
                    [5, 10, 20, -1],
                    [5, 10, 20, "All"]
                ],
                pageLength: (typeof payhistorytbl.data('dt-pagelength') === 'undefined' || payhistorytbl.data('dt-pagelength') === '-1') ? 5 : payhistorytbl.data('dt-pagelength'),
                paging: true,
                ordering: false,
                columnDefs: [
                    {
                        targets: [0],
                        orderable: false,
                        data: function (row) {  
                            return row.id;
                        }
                    },
                    {
                        targets: [1],
                        orderable: true,
                        data: function (row) {
                            return row.name;
                        }
                    },
                    {
                        targets: [2],
                        orderable: false,
                        data: function (row) {
                            return '<button class="btn btn-danger btn-sm delete-center" data-id="' + row.id + '">Delete</button>';
                        }
                    }
                ],
            });
        },

        init: function(calltoinit) {
            if(typeof this[calltoinit] === "function"){
                this[calltoinit]();
            }
        }
    };

    Svca.init(viewInit);

})(window.jQuery, window.SvcaConfig, window.SvcaViewInit);
