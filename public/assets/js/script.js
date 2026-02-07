(function($, conf, viewInit){
    "use strict";

    var Svca = {

        getCourseAmt: function(courseId){
            $.ajax({
                url: conf.baseUrl + "/course/get-course-fee",
                type: "POST",
                dataType: "json",
                data: {
                    course_id: courseId
                },
                success: function(res) {
                    if(res.success == 1) {
                        $('.course-fee').val(res.fee);
                    } else {
                        alert("Error fetching course fee");
                    }
                },
                error: function() {
                    alert("An error occurred while fetching the course fee.");
                }
            });
        },

        getCourseType: function(centerId, preSelected){
            $.ajax({
                url: conf.baseUrl + "/course/get-course-type",
                type: "POST",
                dataType: "json",
                data: {
                    center_id: centerId
                },
                success: function(res) {
                    if(res.success == 1) {
                        var options = '<option value="">Select Type</option>';
                        $.each(res.types, function(index, type) {
                            if(preSelected){
                                if(preSelected == type.type){
                                    options += '<option value="' + type.type + '" selected>' + type.type + '</option>';
                                    return;
                                }
                            }
                            options += '<option value="' + type.type + '">' + type.type + '</option>';
                        });
                        $('#type').html(options).trigger('change');
                    } else {
                        alert("Error fetching course types");
                    }
                },
                error: function() {
                    alert("An error occurred while fetching the course types.");
                }
            });
        },

        getCourseByType: function(centerId, type, preSelected){
            $.ajax({
                url: conf.baseUrl + "/course/get-courses-by-type",
                type: "POST",
                dataType: "json",
                data: {
                    center_id: centerId,
                    type: type
                },
                success: function(res) {
                    if(res.success == 1) {
                        var options = '<option value="">Select Course</option>';
                        $.each(res.courses, function(index, course) {
                            if(preSelected){
                                if(preSelected == course.id){
                                    options += '<option value="' + course.id + '" selected>' + course.course + '</option>';
                                    return;
                                }
                            }
                            options += '<option value="' + course.id + '">' + course.course + '</option>';
                        });
                        $('#course').html(options);
                    } else {
                        alert("Error fetching courses");
                    }
                },
                error: function() {
                    alert("An error occurred while fetching the courses.");
                }
            });
        },

        getCounts: function(){
            const fp = $('#date-filter')[0]._flatpickr
            setTimeout(() => {
                $.ajax({
                    url: conf.baseUrl + "dashboard/get-PRE",
                    type: "POST",
                    dataType: "json",
                    data: {
                        f_date : fp.formatDate(fp.selectedDates[0], "Y-m"),
                        center_id : $('#center-filter').val()
                    },
                    success: function(res) {
                        $('#revenue-count').html(res.data[0].revenue);
                        $('#expense-count').html(res.data[1].expenses);
                        $('#profit-count').html(res.data[0].revenue - res.data[1].expenses);
                    },
                    error: function() {
                        alert("An error occurred while fwtching data.");
                    }
                });
            });

            setTimeout(() => {
                $.ajax({
                    url: conf.baseUrl + "dashboard/get-student-count",
                    type: "POST",
                    dataType: "json",
                    data: {
                        f_date : fp.formatDate(fp.selectedDates[0], "Y-m"),
                        center_id : $('#center-filter').val()
                    },
                    success: function(res) {
                        $('#admission-count').html(res.data.AdmiCount);
                        $('#inquiry-count').html(res.data.InqCount);
                    },
                    error: function() {
                        alert("An error occurred while fwtching data.");
                    }
                });
            });
        },

        initDashboard: function() {
            let SVCAobj = this;

            $('#date-filter').flatpickr({
                disableMobile: true,
                defaultDate: new Date(),
                altFormat: "F Y",
                dateFormat: "Y-m",
                altInput: true,
                plugins: [
                    new monthSelectPlugin({
                    shorthand: true
                    })
                ]
            });

            $('#date-filter,#center-filter').on('change', function(){
                SVCAobj.getCounts();
            });

            SVCAobj.getCounts();

            let recInqurytbl = $('#recent-inquries-tbl');
            let recInquryTbl = new DataTable('#recent-inquries-tbl', {
                responsive: true,
                searching: typeof recInqurytbl.data('dt-searching') === 'undefined' ? true : recInqurytbl.data('dt-searching'),
                lengthChange: typeof recInqurytbl.data('dt-lengthchange') === 'undefined' ? true : recInqurytbl.data('dt-lengthchange'),
                processing: true,
                serverSide: true,
                bSortable: true,
                bFilter: true,
                pagingType: "full_numbers",
                ajax: {
                    url: conf.baseUrl + "/inquery/recent-list",
                    data: function (d) {
                        d.student_id = $('#stu_id').val();
                    },
                    type: 'post',
                },
                lengthMenu: [
                    [5, 10, 20, -1],
                    [5, 10, 20, "All"]
                ],
                pageLength: (typeof recInqurytbl.data('dt-pagelength') === 'undefined' || recInqurytbl.data('dt-pagelength') === '-1') ? 5 : recInqurytbl.data('dt-pagelength'),
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
                            return row.name;
                        }
                    },
                    {
                        targets: [2],
                        orderable: false,
                        data: function (row) {
                            return row.pnumber;
                        }
                    },
                    {
                        targets: [3],
                        orderable: true,
                        data: function (row) {
                            return row.course_name;
                        }
                    },
                    {
                        targets: [4],
                        orderable: true,
                        data: function (row) {
                            return row.center_name;
                        }
                    },{
                        targets: [5],
                        orderable: true,
                        data: function (row) {
                            return row.add_date;
                        }
                    },
                ],
            });

            $.ajax({
                url: conf.baseUrl + "/dashboard/get-main-report-chart-data",
                type: "POST",
                dataType: "json",
                success: function(res) {
                    // Prepare the data for ApexCharts
                    var months = res.data.map(function(item) { return item.month; });
                    var revenue = res.data.map(function(item) { return item.revenue; });
                    var expenses = res.data.map(function(item) { return item.expenses; });
                    var profit = res.data.map(function(item) { return item.profit; });

                    var options = {
                        series: [{
                            name: 'Revenue',
                            data: revenue
                        }, {
                            name: 'Expenses',
                            data: expenses
                        }, {
                            name: 'Net Profit',
                            data: profit
                        }],
                        chart: {
                            type: 'bar',
                            height: 350
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '55%',
                                borderRadius: 5,
                                borderRadiusApplication: 'end'
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            show: true,
                            width: 2,
                            colors: ['transparent']
                        },
                        xaxis: {
                            categories: months,
                        },
                        yaxis: {
                            title: {
                                text: '₹ (Rupees)'
                            }
                        },
                        fill: {
                            opacity: 1
                        },
                        tooltip: {
                            y: {
                                formatter: function (val) {
                                    return "₹ " + val + " Rupees"
                                }
                            }
                        }
                    };
              
                      var chart = new ApexCharts(document.querySelector("#main-report-chart"), options);
                      chart.render();
                }
            });
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

            $(document).on("click", ".delete-center", function(e){
                e.preventDefault();
                if(!confirm("Are you sure you want to delete this center?")) {
                    return;
                }
                var centerId = $(this).data('id');
                if(!centerId) {
                    alert("Some error occurred.");
                    return;
                }

                $.ajax({
                    url: conf.baseUrl + "/settings/delete-center",
                    type: "POST",
                    dataType: "json",
                    data: {
                        center_id: centerId
                    },
                    success: function(res) {
                        if(res.success == 1) {
                            $("#center_name").val(""); // Clear the input field
                            centerTbl.ajax.reload(); // Reload the table data
                        } else {
                            alert("Error deleting center");
                        }
                    },
                    error: function() {
                        alert("An error occurred while deleting the center.");
                    }
                });
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
                    selector: 'td:not(:last-child)'
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
                    [10, 20, 50, -1],
                    [10, 20, 50, "All"]
                ],
                pageLength: (typeof coursetbl.data('dt-pagelength') === 'undefined' || coursetbl.data('dt-pagelength') === '-1') ? 10 : coursetbl.data('dt-pagelength'),
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
                            return row.type.charAt(0).toUpperCase() + row.type.slice(1);
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
                            return row.price;
                        }
                    },
                    {
                        targets: [5],
                        orderable: false,
                        data: function (row) {
                            return '<button class="btn btn-danger btn-sm delete-course" data-id="' + row.id + '">Delete</button>';
                        }
                    }
                ],
            }).on('select', function(e, dt, type, indexes) {
                let data = courseTbl.rows(indexes).data().toArray();
                if(data.length > 0) {
                    $("#course_name").val(data[0].course);
                    $("#course_price").val(data[0].price);
                    $("#course_center").val(data[0].center);
                    $("#course_type").val(data[0].type);
                    $("#course_id").val(data[0].id);
                    $("#sbt-course").text("Update");
                }
            }).on('deselect', function(e, dt, type, indexes){
                $("#course_name").val("");
                $("#course_price").val("");
                $("#course_center").val("");
                $("#course_type").val("");
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

                if($("#course_center").val() === ""){
                    alert("Please select a center.");
                    return;
                }

                if($("#course_type").val() === ""){
                    alert("Please select a course type.");
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
                            course_price: $("#course_price").val(),
                            center: $("#course_center").val(),
                            type: $("#course_type").val()
                        },
                        success: function(res) {
                            if(res.success == 1) {
                                $("#course_name").val(""); // Clear the input field
                                $("#course_price").val("");
                                $("#course_center").val("");
                                $("#course_type").val("");
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
                            course_price: $("#course_price").val(),
                            center: $("#course_center").val(),
                            type: $("#course_type").val()
                        },
                        success: function(res) {
                            if(res.success == 1) {
                                $("#course_name").val(""); // Clear the input field
                                $("#course_price").val("");
                                $("#course_center").val("");
                                $("#course_type").val("");
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

            $(document).on("click", ".delete-course", function(e){
                e.preventDefault();
                if(!confirm("Are you sure you want to delete this course?")) {
                    return;
                }
                var courseId = $(this).data('id');
                if(!courseId) {
                    alert("Some error occurred.");
                    return;
                }

                $.ajax({
                    url: conf.baseUrl + "/settings/delete-course",
                    type: "POST",
                    dataType: "json",
                    data: {
                        course_id: courseId
                    },
                    success: function(res) {
                        if(res.success == 1) {
                            $("#course_name").val(""); // Clear the input field
                            courseTbl.ajax.reload(); // Reload the table data
                        } else {
                            alert("Error deleting course");
                        }
                    },
                    error: function() {
                        alert("An error occurred while deleting the course.");
                    }
                });
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
                            return '<button class="btn btn-danger btn-sm delete-district" data-id="' + row.id + '">Delete</button>';
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

            $(document).on("click", ".delete-district", function(e){
                e.preventDefault();
                if(!confirm("Are you sure you want to delete this district?")) {
                    return;
                }
                var districtId = $(this).data('id');
                if(!districtId) {
                    alert("Some error occurred.");
                    return;
                }

                $.ajax({
                    url: conf.baseUrl + "/settings/delete-district",
                    type: "POST",
                    dataType: "json",
                    data: {
                        district_id: districtId
                    },
                    success: function(res) {
                        if(res.success == 1) {
                            $("#district_name").val(""); // Clear the input field
                            districtTbl.ajax.reload(); // Reload the table data
                        } else {
                            alert("Error deleting district");
                        }
                    },
                    error: function() {
                        alert("An error occurred while deleting the district.");
                    }
                });
            });
        },

        initAddStudent: function(){
            let SVCAobj = this;

            // setTimeout(function(){
            //     $('#course').trigger('change');
            // }, 300);

            $("#center").on('change', function() {
                let centerId = $(this).val();
                if(centerId){
                    setTimeout(function(){
                        SVCAobj.getCourseType(centerId, '');
                    }, 300);
                }else{
                    $('#type').html('<option value="">Select Type</option>');
                    $('#course').html('<option value="">Select Course</option>');
                }
            });

            $("#type").on('change', function() {
                setTimeout(function(){
                    let courseType = $('#type').val();
                    if($("#center").val() && courseType){
                        SVCAobj.getCourseByType($("#center").val(), courseType, $('#selected_course').val());
                    }else{
                        $('#course').html('<option value="">Select Course</option>');
                    }
                }, 300);
            });

            $('#course').on('change', function() {
                SVCAobj.getCourseAmt($(this).val());
            });

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

                if($('#center').val() == ''){
                    $('#center').focus();
                    return false;
                }

                if($('#type').val() == ''){
                    $('#type').focus();
                    return false;
                }

                if($('#course').val() == ''){
                    $('#course').focus();
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

                if($('#c-amount').val() == ''){
                    alert('Something Wants To Wrong Please Reload This Page');
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
                        course_amt: $('#c-amount').val() ? $('#c-amount').val() : '',
                        discount: $('#discount').val() ? $('#discount').val() : '',
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
                            window.location.href = conf.baseUrl + "/student/list";
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

        initEditStudent: function(){
            let SVCAobj = this;

            setTimeout(function(){
                $('#center').trigger('change');
            }, 300);

            $("#center").on('change', function() {
                let centerId = $(this).val();
                if(centerId){
                    setTimeout(function(){
                        SVCAobj.getCourseType(centerId, $('#selected_type').val());
                    }, 300);
                }else{
                    $('#type').html('<option value="">Select Type</option>');
                    $('#course').html('<option value="">Select Course</option>');
                }
            });

            $("#type").on('change', function() {
                setTimeout(function(){
                    let courseType = $('#type').val();
                    if($("#center").val() && courseType){
                        SVCAobj.getCourseByType($("#center").val(), courseType, $('#selected_course').val());
                    }else{
                        $('#course').html('<option value="">Select Course</option>');
                    }
                }, 300);
            });

            $('#course').on('change', function() {
                SVCAobj.getCourseAmt($(this).val());
            });

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
                dateFormat: "dd/mm/yy", 
            }).datepicker('setDate', $('#adm_date_db').val() ? new Date($('#adm_date_db').val()) : '');

            $('#update-stu').on('click', function(e){
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

                if($('#student_id').val() == ''){
                    alert('Something Wants To Wrong Please Reload This Page');
                    return false;
                }

                if($('#remark').val() == '' && $('#status').val() == '1'){
                    $('#remark').focus();
                    return false;
                }

                if($('#c-amount').val() == ''){
                    alert('Something Wants To Wrong Please Reload This Page');
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
                        studentId: $('#student_id').val(),
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
                        course_amt: $('#c-amount').val() ? $('#c-amount').val() : '',
                        discount: $('#discount').val() ? $('#discount').val() : '',
                        cast: $('#cast').val() ? $('#cast').val() : '',
                        b_time: b_time ? b_time : '',
                        adhar: $('#adhar').val() ? $('#adhar').val() : '',
                        dist: $('#dist').val() ? $('#dist').val() : '',
                        center: $('#center').val() ? $('#center').val() : '',
                        address: $('#address').val() ? $('#address').val() : '',
                        ref_by: $('#ref_by').val() ? $('#ref_by').val() : '',
                        adm_date: $('#adm_date').val() ? $('#adm_date').val() : '',
                        remark: $('#remark').val() ? $('#remark').val() : '' 
                    },
                    success: function(res) {
                        if(res.success == 1) {
                            window.location.href = conf.baseUrl + "/student/list";
                        } else {
                            alert("Error updating student");
                        }
                    },
                    error: function() {
                        alert("An error occurred while updating the student.");
                    }
                });
            });
        },

        initStudentList: function() {
            let datePicker = flatpickr("#date-ftr", {
                mode: "range",
                altInput: true,
                altFormat: "d-m-Y",
                dateFormat: "Y-m-d",
                maxDate: new Date(),
            });

            var center_ftr = '', 
                date_ftr = '',
                user_ftr = '',
                type_ftr = '';

            $('#student-search-btn').on('click', function(){
                center_ftr = $('#center-ftr').val();
                date_ftr = $('#date-ftr').val();
                user_ftr = $('#user-ftr').val();
                type_ftr = $('#type-ftr').val();
                studentTbl.ajax.reload();
            });

            $('#student-clear-btn').on('click', function(){
                center_ftr = date_ftr = user_ftr = '';
                $('#center-ftr').val('');
                $('#date-ftr').val('');
                $('#user-ftr').val('');
                $('#type-ftr').val('');
                datePicker.clear();
                studentTbl.ajax.reload();
            })

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
                    data: function (d) {
                        d.center_ftr = center_ftr;
                        d.date_ftr = date_ftr;
                        d.user_ftr = user_ftr;
                        d.type_ftr = type_ftr;
                    }
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
                            return '<a class="text-primary p-0 ms-1" href="' + conf.baseUrl + 'student/view/' + row.id + '" title="View Details"><i class="ti ti-eye fs-6"></i></a> '
                                + '<a class="text-secondary p-0 ms-1" href="' + conf.baseUrl + 'payment/' + row.id + '" title="Add Payment"><i class="ti ti-coin-rupee fs-6"></i></a> '
                                + '<a class="text-primary p-0 ms-1" href="' + conf.baseUrl + 'student/edit/' + row.id + '" title="Edit"><i class="ti ti-edit fs-6"></i></a>'
                                + '<a class="text-danger delete-student p-0 ms-1" href="javascript:void(0)" data-id="' + row.id + '" title="Delete"><i class="ti ti-trash fs-6"></i></a>';
                        }
                    }
                ],
            });

            $('#student-tbl').on('click', '.delete-student', function() {
                if(confirm("Are you sure you want to delete this student?")) {
                    $.ajax({
                        url: conf.baseUrl + "/student/update-del-sts",
                        type: "POST",
                        dataType: "json",
                        data: {
                            id: $(this).data('id')
                        },
                        success: function(res) {
                            if(res.success == 1) {
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

        initInquery: function() {
            let SVCAobj = this;

            let datePicker = flatpickr("#date-ftr", {
                mode: "range",
                altInput: true,
                altFormat: "d-m-Y",
                dateFormat: "Y-m-d",
                maxDate: new Date(),
            });

            var center_ftr = '', 
                date_ftr = '',
                user_ftr = '',
                type_ftr = '';

            $('#inquery-search-btn').on('click', function(){
                center_ftr = $('#center-ftr').val();
                date_ftr = $('#date-ftr').val();
                user_ftr = $('#user-ftr').val();
                type_ftr = $('#type-ftr').val();
                inquiryTbl.ajax.reload();
            });

            $('#inquery-clear-btn').on('click', function(){
                center_ftr = date_ftr = user_ftr = '';
                $('#center-ftr').val('');
                $('#date-ftr').val('');
                $('#user-ftr').val('');
                $('#type-ftr').val('');
                datePicker.clear();
                inquiryTbl.ajax.reload();
            })

            $("#center").on('change', function() {
                let centerId = $(this).val();
                if(centerId){
                    setTimeout(function(){
                        SVCAobj.getCourseType(centerId, $('#selected_type').val());
                    }, 300);
                }else{
                    $('#type').html('<option value="">Select Type</option>');
                    $('#course').html('<option value="">Select Course</option>');
                }
            });

            $("#type").on('change', function() {
                setTimeout(function(){
                    let courseType = $('#type').val();
                    if($("#center").val() && courseType){
                        SVCAobj.getCourseByType($("#center").val(), courseType, $('#selected_course').val());
                    }else{
                        $('#course').html('<option value="">Select Course</option>');
                    }
                }, 300);
            });

            $('#smt-inqury').on('click', function(e){
                e.preventDefault();
                
                if($('#s_name').val() == ''){
                    $('#s_name').focus();
                    return false;
                }

                if($('#p_number').val() == ''){
                    $('#p_number').focus();
                    return false;
                }

                if($('#center').val() == ''){
                    $('#center').focus();
                    return false;
                }

                if($('#course').val() == ''){
                    $('#course').focus();
                    return false;
                }

                if($('#inqury_id').val()){
                    $.ajax({
                        url: conf.baseUrl + "/inquery/add",
                        type: "POST",
                        dataType: "json",
                        data: { 
                            id: $('#inqury_id').val(),
                            s_name: $('#s_name').val(),
                            p_number: $('#p_number').val(),
                            qulification: $('#lst_qulifi').val(),
                            course: $('#course').val(),
                            center: $('#center').val()
                        },
                        success: function(res) {
                            if (res.success == 1) {
                                $('#s_name, #p_number, #inqury_id').val('');
                                inquiryTbl.ajax.reload();
                            } else {
                                alert(res.message || "Error updating inquiry");
                            }
                        },
                        error: function() {
                            alert("An error occurred while updating the inquiry.");
                        }
                    });
                }else{
                    $.ajax({
                        url: conf.baseUrl + "/inquery/add",
                        type: "POST",
                        dataType: "json",
                        data: {
                            s_name: $('#s_name').val(),
                            p_number: $('#p_number').val(),
                            qulification: $('#lst_qulifi').val(),
                            course: $('#course').val(),
                            center: $('#center').val(),
                            //ref_by: $('#ref_by').val() ? $('#ref_by').val() : '',
                            //remark: $('#remark').val() ? $('#remark').val() : ''
                        },
                        success: function(res) {
                            if (res.success == 1) {
                                $('#s_name, #p_number').val('');
                                inquiryTbl.ajax.reload();
                            } else {
                                alert(res.message || "Error saving inquiry");
                            }
                        },
                        error: function() {
                            alert("An error occurred while saving the inquiry.");
                        }
                    });
                }
            });

            let inquiryTbl = new DataTable('#inqury-tbl', {
                responsive: true,
                select: {
                    style: 'single',
                    selector: 'td:not(:last-child)' // disable selection on button column
                },
                scrollX: true,
                searching: true,
                lengthChange: true,
                processing: true,
                serverSide: true,
                bSortable: true,
                bFilter: true,
                pagingType: "full_numbers",
                ajax: {
                    url: conf.baseUrl + "/inquery/list",
                    type: 'post',
                    data: function (d) {
                        d.center_ftr = center_ftr;
                        d.date_ftr = date_ftr;
                        d.user_ftr = user_ftr;
                        d.type_ftr = type_ftr;
                    }
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
                            return row.name;
                        }
                    },
                    {
                        targets: [2],
                        orderable: false,
                        data: function (row) {
                            return row.pnumber;
                        }
                    },
                    {
                        targets: [3],
                        orderable: true,
                        data: function (row) {
                            return row.course_name;
                        }
                    },
                    {
                        targets: [4],
                        orderable: true,
                        data: function (row) {
                            return row.center_name;
                        }
                    },
                    {
                        targets: [5],
                        orderable: false,
                        data: function (row) {
                            return '<a href="' + conf.baseUrl + '/inquery/follow-up/' + row.id + '" class="admit-stu btn btn-secondary" data-id="' + row.id + '">Follow Up</a>'
                            + '<a href="' + conf.baseUrl + '/student/edit/' + row.id + '" class="admit-stu btn btn-primary ms-1" data-id="' + row.id + '">Admit</a>'
                        + '<button class="btn btn-danger delete-inquiry ms-1" data-id="' + row.id + '"><i class="ti ti-trash fs-6"></i></button>';  
                        }
                    }
                ],
            }).on('select', function(e, dt, type, indexes) {
                let data = inquiryTbl.rows(indexes).data().toArray();
                if(data.length > 0) {
                    $('#s_name').val(data[0].name);
                    $('#p_number').val(data[0].pnumber);
                    $('#lst_qulifi').val(data[0].lqualifi).trigger('change');
                    $('#center').val(data[0].center).trigger('change');
                    $('#inqury_id').val(data[0].id);
                    $('#selected_type').val(data[0].course_type);
                    $('#selected_course').val(data[0].course);
                    $('#smt-inqury').text('Update');
                }
            }).on('deselect', function(e, dt, type, indexes){
                $('#s_name').val('');
                $('#p_number').val('');
                // $('#lst_qulifi').val('').trigger('change');
                $('#course').val('').trigger('change');
                $('#center').val('').trigger('change');
                $('#inqury_id').val('');
                $('#selected_type').val('');
                $('#selected_course').val('');
                $('#smt-inqury').text('Submit');
            });

            $(document).on('click', '.delete-inquiry', function(e) {
                e.stopPropagation(); // Prevent row selection
                var res = confirm("Are you sure you want to delete this inquiry?");
                if(res){
                    $.ajax({
                        url: conf.baseUrl + "/inquery/update-del-sts",
                        type: "POST",
                        data: {
                            id: $(this).data('id')
                        },
                        dataType: "json",
                        success: function(res) {
                            if(res.success == 1) {
                                inquiryTbl.ajax.reload();
                            }else {
                                alert("Error admitting student");
                            }
                        }
                    });
                }
            });
        },

        initFollowUp: function(){

            $('#follow-up-date').datepicker({
                minDate: new Date(),
                dateFormat: "dd/mm/yy", 
            }).datepicker('setDate', $('#adm_date_db').val() ? new Date($('#adm_date_db').val()) : '');

            var followUptbl = $('#follow-up-table');
            var followUpTbl = new DataTable('#follow-up-table', {
                responsive: true,
                select: {
                    style: 'single'
                },
                searching: typeof followUptbl.data('dt-searching') === 'undefined' ? true : followUptbl.data('dt-searching'),
                lengthChange: typeof followUptbl.data('dt-lengthchange') === 'undefined' ? true : followUptbl.data('dt-lengthchange'),
                processing: true,
                serverSide: true,
                bSortable: true,
                bFilter: true,
                pagingType: "full_numbers",
                ajax: {
                    url: conf.baseUrl + "/inquery/follow-up-list",
                    type: 'post',
                    data: function (d) {
                        d.student_id = $('#stu_id').val();
                    }
                },
                lengthMenu: [
                    [5, 10, 20, -1],
                    [5, 10, 20, "All"]
                ],
                pageLength: (typeof followUptbl.data('dt-pagelength') === 'undefined' || followUptbl.data('dt-pagelength') === '-1') ? 5 : followUptbl.data('dt-pagelength'),
                paging: true,
                ordering: false,
                columnDefs: [
                    {
                        targets: [0],
                        data: function (row, type, val, meta) {  
                            return meta.row + 1;
                        }
                    }, {
                        targets: [1],
                        data: function (row) {
                            return row.note;
                        }
                    }, {
                        targets: [2],
                        data: function (row) {
                            return row.status.charAt(0).toUpperCase() + row.status.slice(1);
                        }
                    }, {
                        targets: [3],
                        data: function (row) {
                            return row.follow_date;
                        }
                    }, {
                        targets: [4],
                        data: function (row) {
                            return row.added_date;
                        }
                    }, {
                        targets: [5],
                        data: function (row) {
                            return row.added_by;
                        }
                    }
                ],
            });

            $('#sbt-follow-up').on('click', function(e){
                e.preventDefault();

                if($('#follow-up-notes').val() == ''){
                    $('#follow-up-notes').focus();
                    return false;
                }

                if($('#follow-up-date').val() == ''){
                    $('#follow-up-date').focus();
                    return false;
                }

                if($('#follow-up-status').val() == ''){
                    $('#follow-up-status').focus();
                    return false;
                }
                
                $.ajax({
                    url: conf.baseUrl + "/inquery/add-follow-up",
                    type: "POST",
                    data: {
                        note : $('#follow-up-notes').val(),
                        follow_up_date : $('#follow-up-date').val(),
                        status : $('#follow-up-status').val(),
                        student_id : $('#stu_id').val()
                    },
                    dataType: "json",
                    success: function(res) {
                        if(res.success == 1) {
                            $('#follow-up-notes').val('');
                            $('#follow-up-date').val('');
                            followUpTbl.ajax.reload();   
                        }else {
                            alert("Error adding follow-up");
                        }
                    }
                });
            });
        },

        initAddPayment: function(){
        
            let payhistorytbl = $('#pay-historytbl');
            let payhistoryTbl = new DataTable('#pay-historytbl', {
                responsive: true,
                select: {
                    style: 'single'
                },
                searching: typeof payhistorytbl.data('dt-searching') === 'undefined' ? true : payhistorytbl.data('dt-searching'),
                lengthChange: typeof payhistorytbl.data('dt-lengthchange') === 'undefined' ? true : payhistorytbl.data('dt-lengthchange'),
                processing: true,
                serverSide: true,
                bSortable: true,
                bFilter: true,
                pagingType: "full_numbers",
                ajax: {
                    url: conf.baseUrl + "/payment/get-payhistory",
                    data: function (d) {
                        d.student_id = $('#stu_id').val();
                    },
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
                        data: function (row, type, val, meta) {  
                            return meta.row + 1;
                        }
                    },
                    {
                        targets: [1],
                        orderable: true,
                        data: function (row) {
                            return row.amount;
                        }
                    },
                    {
                        targets: [2],
                        orderable: false,
                        data: function (row) {
                            return row.remark ? row.remark : '-';
                        }
                    },
                    {
                        targets: [3],
                        orderable: false,
                        data: function (row) {
                            return row.updated_by;
                        }
                    },
                    {
                        targets: [4],
                        orderable: false,
                        data: function (row) {
                            return row.add_date;
                        }
                    }
                ],
            }).on('select', function(e, dt, type, indexes) {
                let data = payhistoryTbl.rows(indexes).data().toArray();
                if(data.length > 0) {
                    $('#paymentAmount').val(data[0].amount);
                    $('#remark').val(data[0].remark);
                    $('#transaction_id').val(data[0].id);
                    $('#acceptPayment').text('Update');
                    $('#paymentModal').modal('show');
                }
            }).on('deselect', function(e, dt, type, indexes){
                
            }).on('xhr.dt', function (e, settings, json, xhr) {
                // Calculate the total sum of 'amount' in data rows
                var total = 0;
                if (json && json.data && Array.isArray(json.data)) {
                    total = json.data.reduce(function(acc, curr) {
                        var amt = parseFloat(curr.amount);
                        if (!isNaN(amt)) acc += amt;
                        return acc;
                    }, 0);
                }
                var totalFees = parseFloat($('#total-fees').data('total-fees'));
                var pending = isNaN(totalFees) ? 0 : totalFees - total;
                $('#pending-fees').text('₹' + pending.toLocaleString(undefined, { maximumFractionDigits: 0, minimumFractionDigits: 0 }));
                $('#paid-fees').text('₹' + total.toLocaleString(undefined, { maximumFractionDigits: 0, minimumFractionDigits: 0 }));
            });

            $('#paymentModal').on('hide.bs.modal', function () {
                $('#paymentAmount').val('');
                $('#remark').val('');
                $('#transaction_id').val('');
                $('#acceptPayment').text('Accept');
                payhistoryTbl.rows().deselect();
            });


            $('#paymentModal').on('click', '#acceptPayment', function(e){
                e.preventDefault();
                if($('#paymentAmount').val() == ''){
                    $('#paymentAmount').focus();
                    return false;
                }
                
                $.ajax({
                    url: conf.baseUrl + "/payment/add",
                    type: "POST",
                    dataType: "json",
                    data: {
                        amount: $('#paymentAmount').val(),
                        remark: $('#remark').val(),
                        student_id: $('#stu_id').val(),
                        transaction_id: $('#transaction_id').val()
                    },
                    success: function(res) {
                        if(res.success == 1) {
                            $('#paymentAmount').val('');
                            $('#remark').val('');
                            payhistoryTbl.ajax.reload();
                            $('#paymentModal').modal('hide');
                        } else {
                            alert("Error accepting payment");
                        }
                    },
                    error: function() {
                        alert("An error occurred while accepting the payment.");
                    }
                });
            });
        },

        initLogs: function(){
            let editlogtbl = $('#student-log-tbl');
            let editlogTbl = new DataTable('#student-log-tbl', {
                responsive: true,
                searching: typeof editlogtbl.data('dt-searching') === 'undefined' ? true : editlogtbl.data('dt-searching'),
                lengthChange: typeof editlogtbl.data('dt-lengthchange') === 'undefined' ? true : editlogtbl.data('dt-lengthchange'),
                processing: true,
                serverSide: true,
                bSortable: true,
                bFilter: true,
                pagingType: "full_numbers",
                ajax: {
                    url: conf.baseUrl + "logs/student-edit",
                    type: 'post',
                },
                lengthMenu: [
                    [5, 10, 20, -1],
                    [5, 10, 20, "All"]
                ],
                pageLength: (typeof editlogtbl.data('dt-pagelength') === 'undefined' || editlogtbl.data('dt-pagelength') === '-1') ? 5 : editlogtbl.data('dt-pagelength'),
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
                            return row.remark;
                        }
                    },
                    {
                        targets: [2],
                        orderable: false,
                        data: function (row) {
                            return `<a href="${conf.baseUrl}student/edit/${row.student_id}">${row.student_id}</a>`;
                        }
                    },
                    {
                        targets: [3],
                        orderable: false,
                        data: function (row) {
                            return row.updated_date;
                        }
                    },
                    {
                        targets: [4],
                        orderable: false,
                        data: function (row) {
                            return row.updated_by;
                        }
                    }
                ],
            });
        },

        initExpense: function(){

            var center_ftr = '', 
                date_ftr = '',
                user_ftr = '';

            let datePicker = flatpickr("#date-ftr", {
                mode: "range",
                altInput: true,
                altFormat: "d-m-Y",
                dateFormat: "Y-m-d",
                maxDate: new Date(),
            });

            $('#expense-search-btn').on('click', function(){
                center_ftr = $('#center-ftr').val();
                date_ftr = $('#date-ftr').val();
                user_ftr = $('#user-ftr').val();
                expenseTbl.ajax.reload();
            });

            $('#expense-clear-btn').on('click', function(){
                center_ftr = date_ftr = user_ftr = '';
                $('#center-ftr').val('');
                $('#date-ftr').val('');
                $('#user-ftr').val('');
                datePicker.clear();
                expenseTbl.ajax.reload();
            })

            let expensetbl = $('#expense-tbl');
            let expenseTbl = new DataTable('#expense-tbl', {
                responsive: true,
                select: {
                    style: 'single'
                },
                searching: typeof expensetbl.data('dt-searching') === 'undefined' ? true : expensetbl.data('dt-searching'),
                lengthChange: typeof expensetbl.data('dt-lengthchange') === 'undefined' ? true : expensetbl.data('dt-lengthchange'),
                processing: true,
                serverSide: true,
                bSortable: true,
                bFilter: true,
                pagingType: "full_numbers",
                ajax: {
                    url: conf.baseUrl + "/expense/list",
                    type: 'post',
                    data: function (d) {
                        d.center_ftr = center_ftr;
                        d.date_ftr = date_ftr;
                        d.user_ftr = user_ftr;
                    }
                },
                lengthMenu: [
                    [5, 10, 20, -1],
                    [5, 10, 20, "All"]
                ],
                pageLength: (typeof expensetbl.data('dt-pagelength') === 'undefined' || expensetbl.data('dt-pagelength') === '-1') ? 5 : expensetbl.data('dt-pagelength'),
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
                            return row.exp;
                        }
                    },
                    {
                        targets: [2],
                        orderable: false,
                        data: function (row) {
                            return row.center_name;
                        }
                    },
                    {
                        targets: [3],
                        orderable: false,
                        data: function (row) {
                            return row.amount;
                        }
                    },
                    {
                        targets: [4],
                        orderable: false,
                        data: function (row) {
                            return row.add_date;
                        }
                    },{
                        targets: [5],
                        orderable: false,
                        data: function (row) {
                            return row.updated_by;
                        }
                    },{
                        targets: [6],
                        orderable: false,
                        data: function (row) {
                            return row.updated_date;
                        }
                    }
                ],
            }).on('select', function(e, dt, type, indexes) {
                let data = expenseTbl.rows(indexes).data().toArray();
                if(data.length > 0) {
                    $('#exp').val(data[0].exp);
                    $('#center').val(data[0].center).trigger('change');;
                    $('#amount').val(data[0].amount);
                    $('#expense-id').val(data[0].id);
                    $('#sbt-expence').text('Update');
                }
            }).on('deselect', function(e, dt, type, indexes){
                $('#exp').val('');
                $('#center').val('').trigger('change');;
                $('#amount').val('');
                $('#expense-id').val('');
                $('#sbt-expence').text('Submit');
            });

            $('#sbt-expence').on('click', function(e){
                e.preventDefault();
                if($('#exp').val() == ''){
                    $('#exp').focus();
                    return false;
                }
                
                if($('#center').val() == ''){
                    $('#center').focus();
                    return false;
                }
                
                if($('#amount').val() == ''){
                    $('#amount').focus();
                    return false;
                }

                if($('#expense-id').val()){
                    $.ajax({
                        url: conf.baseUrl + "/expense/add",
                        type: "POST",
                        dataType: "json",
                        data: {
                            exp_id: $('#expense-id').val(),
                            exp: $('#exp').val(),
                            center: $('#center').val(),
                            amount: $('#amount').val(),
                        },
                        success: function(res) {
                            if(res.success == 1) {
                                $('#expense-id').val('');
                                $('#exp').val('');
                                $('#center').val('');
                                $('#amount').val('');
                                expenseTbl.ajax.reload();
                            } else {
                                alert("Error updating expense");
                            }
                        },
                        error: function() {
                            alert("An error occurred while updating the expense.");
                        }
                    });
                }else{
                    $.ajax({
                        url: conf.baseUrl + "/expense/add",
                        type: "POST",
                        dataType: "json",
                        data: {
                            exp: $('#exp').val(),
                            center: $('#center').val(),
                            amount: $('#amount').val(),
                        },
                        success: function(res) {
                            if(res.success == 1) {
                                $('#exp').val('');
                                $('#center').val('');
                                $('#amount').val('');
                                expenseTbl.ajax.reload();
                            } else {
                                alert("Error adding expense");
                            }
                        },
                        error: function() {
                            alert("An error occurred while adding the expense.");
                        }
                    });
                }
            });
        },

        initRecycleBin: function(){
            let deletedStudenttbl = $('#deleted-student-tbl');
            let deletedStudenTbl = new DataTable('#deleted-student-tbl', {
                responsive: true,
                searching: typeof deletedStudenttbl.data('dt-searching') === 'undefined' ? true : deletedStudenttbl.data('dt-searching'),
                lengthChange: typeof deletedStudenttbl.data('dt-lengthchange') === 'undefined' ? true : deletedStudenttbl.data('dt-lengthchange'),
                processing: true,
                serverSide: true,
                bSortable: true,
                bFilter: true,
                pagingType: "full_numbers",
                ajax: {
                    url: conf.baseUrl + "/bin/get-deleted-students",
                    data: function (d) {
                        d.student_id = $('#stu_id').val();
                    },
                    type: 'post',
                },
                lengthMenu: [
                    [5, 10, 20, -1],
                    [5, 10, 20, "All"]
                ],
                pageLength: (typeof deletedStudenttbl.data('dt-pagelength') === 'undefined' || deletedStudenttbl.data('dt-pagelength') === '-1') ? 5 : deletedStudenttbl.data('dt-pagelength'),
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
                            return row.name + row.fname;
                        }
                    },
                    {
                        targets: [3],
                        orderable: false,
                        data: function (row) {
                            return row.center_name;
                        }
                    },
                    {
                        targets: [4],
                        orderable: false,
                        data: function (row) {
                            return row.course_name;
                        }
                    },{
                        targets: [5],
                        orderable: false,
                        data: function (row) {
                            return row.deleted_by;
                        }
                    },{
                        targets: [6],
                        orderable: false,
                        data: function (row) {
                            return row.deleted_at;
                        }
                    },{
                        targets: [7],
                        orderable: false,
                        data: function (row) {
                            return `<a href="javascript:void(0)" class="restore-student text-success p-0 ms-1" data-id="${row.id}" title="Restore"><i class="ti ti-refresh fs-6"></i></a>` +
                            `<a href="javascript:void(0)" class="delete-student text-danger p-0 ms-1" data-id="${row.id}" title="Delete"><i class="ti ti-trash fs-6"></i></a>`;
                        }
                    }
                ],
            });

            $(document).on('click', '.restore-student', function() {
                var res = confirm("Are you sure you want to restore this student?");
                if(res){
                    $.ajax({
                        url: conf.baseUrl + "/bin/restore-student",
                        type: "POST",
                        dataType: "json",
                        data: {
                            student_id: $(this).data('id'),
                        },
                        success: function(res) {
                            if(res.success == 1) {
                                deletedStudenTbl.ajax.reload();
                            } else {
                                alert("Error restoring student");
                            }
                        },
                        error: function() {
                            alert("An error occurred while restoring the student.");
                        }
                    });
                }
            });

            $(document).on('click', '.delete-student', function() {
                var res = confirm("Are you sure you want to delete this student?");
                if(res){
                    $.ajax({
                        url: conf.baseUrl + "/bin/delete-student",
                        type: "POST",
                        dataType: "json",
                        data: {
                            student_id: $(this).data('id'),
                        },
                        success: function(res) {
                            if(res.success == 1) {
                                deletedStudenTbl.ajax.reload();
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

            let deletedInquirytbl = $('#deleted-inquiries-tbl');
            let deletedInquiryTbl = new DataTable('#deleted-inquiries-tbl', {
                responsive: true,
                searching: typeof deletedInquirytbl.data('dt-searching') === 'undefined' ? true : deletedInquirytbl.data('dt-searching'),
                lengthChange: typeof deletedInquirytbl.data('dt-lengthchange') === 'undefined' ? true : deletedInquirytbl.data('dt-lengthchange'),
                processing: true,
                serverSide: true,
                bSortable: true,
                bFilter: true,
                pagingType: "full_numbers",
                ajax: {
                    url: conf.baseUrl + "/bin/get-deleted-inquiries",
                    data: function (d) {
                        d.student_id = $('#stu_id').val();
                    },
                    type: 'post',
                },
                lengthMenu: [
                    [5, 10, 20, -1],
                    [5, 10, 20, "All"]
                ],
                pageLength: (typeof deletedInquirytbl.data('dt-pagelength') === 'undefined' || deletedInquirytbl.data('dt-pagelength') === '-1') ? 5 : deletedInquirytbl.data('dt-pagelength'),
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
                            return row.name + row.fname;
                        }
                    },
                    {
                        targets: [3],
                        orderable: false,
                        data: function (row) {
                            return row.center_name;
                        }
                    },
                    {
                        targets: [4],
                        orderable: false,
                        data: function (row) {
                            return row.course_name;
                        }
                    },{
                        targets: [5],
                        orderable: false,
                        data: function (row) {
                            return row.deleted_by;
                        }
                    },{
                        targets: [6],
                        orderable: false,
                        data: function (row) {
                            return row.deleted_at;
                        }
                    },{
                        targets: [7],
                        orderable: false,
                        data: function (row) {
                            return `<a href="javascript:void(0)" class="restore-inquiry text-success p-0 ms-1" data-id="${row.id}" title="Restore"><i class="ti ti-refresh fs-6"></i></a>` +
                            `<a href="javascript:void(0)" class="delete-inquiry text-danger p-0 ms-1" data-id="${row.id}" title="Delete"><i class="ti ti-trash fs-6"></i></a>`;
                        }
                    }
                ],
            });

            $(document).on('click', '.restore-inquiry', function() {
                var res = confirm("Are you sure you want to restore this inquiry?");
                if(res){
                    $.ajax({
                        url: conf.baseUrl + "/bin/restore-inquiry",
                        type: "POST",
                        dataType: "json",
                        data: {
                            inquiry_id: $(this).data('id'),
                        },
                        success: function(res) {
                            if(res.success == 1) {
                                deletedInquiryTbl.ajax.reload();
                            } else {
                                alert("Error restoring inquiry");
                            }
                        },
                        error: function() {
                            alert("An error occurred while restoring the inquiry.");
                        }
                    });
                }
            });

            $(document).on('click', '.delete-inquiry', function() {
                var res = confirm("Are you sure you want to delete this inquiry?");
                if(res){
                    $.ajax({
                        url: conf.baseUrl + "/bin/delete-inquiry",
                        type: "POST",
                        dataType: "json",
                        data: {
                            inquiry_id: $(this).data('id'),
                        },
                        success: function(res) {
                            if(res.success == 1) {
                                deletedInquiryTbl.ajax.reload();
                            } else {
                                alert("Error deleting inquiry");
                            }
                        },
                        error: function() {
                            alert("An error occurred while deleting the inquiry.");
                        }
                    });
                }
            });
        },

        initAdminList: function(){
            var adminListtbl = $('#admin-list-tbl');
            var adminListTbl = new DataTable('#admin-list-tbl', {
                responsive: true,
                select: false,
                searching: typeof adminListtbl.data('dt-searching') === 'undefined' ? true : adminListtbl.data('dt-searching'),
                lengthChange: typeof adminListtbl.data('dt-lengthchange') === 'undefined' ? true : adminListtbl.data('dt-lengthchange'),
                processing: true,
                serverSide: true,
                bSortable: true,
                bFilter: true,
                pagingType: "full_numbers",
                ajax: {
                    url: conf.baseUrl + "/user/get-admin-list",
                    data: function (d) {
                        d.student_id = $('#stu_id').val();
                    },
                    type: 'post',
                },
                lengthMenu: [
                    [5, 10, 20, -1],
                    [5, 10, 20, "All"]
                ],
                pageLength: (typeof adminListtbl.data('dt-pagelength') === 'undefined' || adminListtbl.data('dt-pagelength') === '-1') ? 5 : adminListtbl.data('dt-pagelength'),
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
                            if(row.first_name && row.last_name){
                                return row.first_name + ' ' + row.last_name;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {
                        targets: [2],
                        orderable: false,
                        data: function (row) {
                            return row.email;
                        }
                    },
                    {
                        targets: [3],
                        orderable: false,
                        data: function (row) {
                            return row.user_group === 'superadmin' ? 'Super Admin' : 'Admin';
                        }
                    },
                    {
                        targets: [4],
                        orderable: false,
                        data: function (row) {
                            return row.register_on;
                        }
                    },
                    {
                        targets: [5],
                        orderable: false,
                        data: function (row) {
                            return '<a href="' + conf.baseUrl + 'user/change-password/' + row.id + '" class="btn btn-warning btn-sm" title="Change Password"><i class="ti ti-key fs-6"></i></a> ' +
                                '<button class="btn btn-danger btn-sm delete-user" data-id="' + row.id + '">Delete</button>'
                        }
                    }
                ],
            });

            $(document).on('click', '.delete-user', function() {
                var conform = confirm("Are you sure you want to delete this user?");
                if(conform){
                    $.ajax({
                        url: conf.baseUrl + "/user/delete",
                        type: "POST",
                        dataType: "json",
                        data: {
                            user_id: $(this).data('id')
                        },
                        success: function(res) {
                            if(res.success == 1) {
                                adminListTbl.ajax.reload();
                            } else {
                                alert(res.message || "Error deleting user");
                            }
                        },
                        error: function() {
                            alert("An error occurred while deleting the user.");
                        }
                    });
                }
            });
        },

        initChangePassword: function(){
            $('#update_btn').on('click', function(e){
                e.preventDefault();
                if($('#new_password').val() == ''){
                    $('#new_password').focus();
                    return false;
                }
                if($('#confirm_password').val() == ''){
                    $('#confirm_password').focus();
                    return false;
                }

                if($('#new_password').val() != $('#confirm_password').val()){
                    alert("Password and confirm password do not match");
                    return false;
                }

                if(!validatePassword($('#new_password').val())){
                    alert("Password must contain at least 8 characters, 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character");
                    return false;
                }

                $.ajax({
                    url: conf.baseUrl + "/user/update-password",
                    type: "POST",
                    dataType: "json",
                    data: {
                        new_password: $('#new_password').val(),
                        confirm_password: $('#confirm_password').val(),
                        user_id: $('#user_id').val()
                    },
                    success: function(res) {
                        if(res.success == 1) {
                            window.location.href = conf.baseUrl + "user/admin-list";
                        } else {
                            alert("Error updating password");
                        }
                    },
                    error: function() {
                        alert("An error occurred while updating the password.");
                    }
                });

                function validatePassword(password) {
                    const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
                    return regex.test(password);
                }
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
