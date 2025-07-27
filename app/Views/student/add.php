<h1>Students</h1>
<div>
    <div class="card">
        <div class="card-header text-bg-primary">
            <h4 class="mb-0 text-white">Student Admission</h4>
        </div>
        <div class="card-body">
            <form action="">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="s_name" class="form-label">Student Name</label>
                            <input type="text" class="form-control" id="s_name" placeholder="Enter Student Name">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="f_name" class="form-label">Father Name</label>
                            <input type="text" class="form-control" id="f_name" placeholder="Enter Father Name">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="m_name" class="form-label">Mother Name</label>
                            <input type="text" class="form-control" id="m_name" placeholder="Enter Mother Name">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="dob" class="form-label">Date of Birth</label>
                            <input type="text" class="form-control" id="dob" placeholder="DD/MM/YYYY" maxlength="10" pattern="\d{2}/\d{2}/\d{4}" inputmode="numeric" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 47;">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="p_number" class="form-label">Mobile Number</label>
                            <input type="text" class="form-control" id="p_number" placeholder="Enter Mobile Numbers" inputmode="numeric" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 47;" maxlength="10">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="ap_number" class="form-label">Alternative Number</label>
                            <input type="text" class="form-control" id="ap_number" placeholder="Enter Alternative Numbers" inputmode="numeric" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 47;" maxlength="10">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <div class="d-flex align-items-center">
                                <div class="form-check me-3">
                                    <input type="radio" id="male" name="gender" value="M" class="form-check-input">
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="female" name="gender" value="F" class="form-check-input">
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="marital_sts" class="form-label">Marital Status</label>
                            <div class="d-flex align-items-center">
                                <div class="form-check me-3">
                                    <input type="radio" id="single" name="marital_sts" value="S" class="form-check-input">
                                    <label class="form-check-label" for="single">Single</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="married" name="marital_sts" value="M" class="form-check-input">
                                    <label class="form-check-label" for="married">Married</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="lst_qulifi" class="form-label">Last Qualification</label>
                            <select class="form-select" name="lst_qulifi" id="lst_qulifi">
                                <option value="10">10th</option>
                                <option value="11">11th</option>
                                <option value="12">12th</option>
                                <option value="diploma">Diploma</option>
                                <option value="ug">Undergraduate</option>
                                <option value="pg">Postgraduate</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="per" class="form-label">Percentage</label>
                            <div class="input-group">
                                <input class="form-control" type="number" id="per">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="course" class="form-label">Course</label>
                            <select class="form-select" name="course" id="course">
                                <?php foreach ($courses as $course): ?>
                                    <option value="<?= $course['id'] ?>"><?= $course['course'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="cast" class="form-label">Cast</label>
                            <select class="form-select" name="cast" id="cast">
                                <option value="sc">SC</option>
                                <option value="st">ST</option>
                                <option value="obc">OBC</option>
                                <option value="general">General</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="b_time" class="form-label">Batch Time</label>
                            <div class="col-5 d-flex">
                                <input class="form-control col-1" type="time" value="" id="b_time1">
                                <label class="form-label m-2">TO</label>
                                <input class="form-control col-1" type="time" value="" id="b_time2">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="adhar" class="form-label">Adhar Number</label>
                            <input type="text" class="form-control" id="adhar" placeholder="Enter Adhar Number" inputmode="numeric" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 47;" maxlength="12">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="dist" class="form-label">District</label>
                            <select class="form-select" name="dist" id="dist">
                                <?php foreach($districts as $district){ ?>
                                    <option value="<?php echo $district['id'] ?>"> <?php echo $district['name'] ?> </option>
                               <?php  } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="center" class="form-label">Center</label>
                            <select class="form-select" name="center" id="center">
                                <?php foreach ($centers as $center): ?>
                                    <option value="<?= $center['id'] ?>"><?= $center['center'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" rows="1" placeholder="Enter Address"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="ref_by" class="form-label">Referred By</label>
                            <input type="text" class="form-control" id="ref_by" placeholder="Enter Referred By">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="adm_date" class="form-label">Admission Date</label>
                            <input type="text" class="form-control" id="adm_date" inputmode="none" onkeydown="return false;">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-primary" id="sbt-student">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>