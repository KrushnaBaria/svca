<div>
    <div class="card">
        <div class="card-header text-bg-primary">
            <h4 class="mb-0 text-white">Edit Student Info</h4>
        </div>
        <div class="card-body">
            <form action="">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="s_name" class="form-label">Student Name</label>
                            <input type="text" class="form-control" id="s_name" placeholder="Enter Student Name" value="<?php echo isset($student['name']) ? $student['name'] : ''; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="f_name" class="form-label">Father Name</label>
                            <input type="text" class="form-control" id="f_name" placeholder="Enter Father Name" value="<?php echo isset($student['fname']) ? $student['fname'] : '' ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="m_name" class="form-label">Mother Name</label>
                            <input type="text" class="form-control" id="m_name" placeholder="Enter Mother Name" value="<?php echo isset($student['mname']) ? $student['mname'] : '' ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="dob" class="form-label">Date of Birth</label>
                            <input type="text" class="form-control" id="dob" placeholder="DD/MM/YYYY" maxlength="10" pattern="\d{2}/\d{2}/\d{4}" inputmode="numeric" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 47;" value="<?php echo isset($student['dob']) ? date('d/m/Y', strtotime($student['dob'])) : '' ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="p_number" class="form-label">Mobile Number</label>
                            <input type="text" class="form-control" id="p_number" placeholder="Enter Mobile Numbers" inputmode="numeric" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 47;" maxlength="10" value="<?php echo isset($student['pnumber']) ? $student['pnumber'] : '' ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="ap_number" class="form-label">Alternative Number</label>
                            <input type="text" class="form-control" id="ap_number" placeholder="Enter Alternative Numbers" inputmode="numeric" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 47;" maxlength="10" value="<?php echo isset($student['apnumber']) ? $student['apnumber'] : '' ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <div class="d-flex align-items-center">
                                <div class="form-check me-3">
                                    <input type="radio" id="male" name="gender" value="M" class="form-check-input" <?php echo ($student['gender'] ?? '') === 'M' ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="female" name="gender" value="F" class="form-check-input" <?php echo ($student['gender'] ?? '') === 'F' ? 'checked' : '' ?>>
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
                                    <input type="radio" id="single" name="marital_sts" value="S" class="form-check-input" <?php echo ($student['marital_status'] ?? '') === 'S' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="single">Single</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="married" name="marital_sts" value="M" class="form-check-input" <?php echo ($student['marital_status'] ?? '') === 'M' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="married">Married</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="lst_qulifi" class="form-label">Last Qualification</label>
                            <select class="form-select" name="lst_qulifi" id="lst_qulifi">
                                <option value="10" <?php echo ($student['lqualifi'] ?? '') === '10' ? 'selected' : '' ?>>10th</option>
                                <option value="11" <?php echo ($student['lqualifi'] ?? '') === '11' ? 'selected' : '' ?>>11th</option>
                                <option value="12" <?php echo ($student['lqualifi'] ?? '') === '12' ? 'selected' : '' ?>>12th</option>
                                <option value="diploma" <?php echo ($student['lqualifi'] ?? '') === 'diploma' ? 'selected' : '' ?>>Diploma</option>
                                <option value="ug" <?php echo ($student['lqualifi'] ?? '') === 'ug' ? 'selected' : '' ?>>Undergraduate</option>
                                <option value="pg" <?php echo ($student['lqualifi'] ?? '') === 'pg' ? 'selected' : '' ?>>Postgraduate</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="per" class="form-label">Percentage</label>
                            <div class="input-group">
                                <input class="form-control" type="number" id="per" value="<?php echo isset($student['per']) ? $student['per'] : '' ?>">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="course" class="form-label">Course</label>
                            <select class="form-select" name="course" id="course">
                                <?php foreach ($courses as $course): ?>
                                    <option value="<?php echo $course['id']; ?>" <?php echo (($student['course'] ?? '') == $course['id']) ? 'selected' : ''; ?>><?php echo $course['course']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="cast" class="form-label">Cast</label>
                            <select class="form-select" name="cast" id="cast">
                                <option value="sc" <?php echo ($student['cast'] ?? '') === 'sc' ? 'selected' : ''; ?>>SC</option>
                                <option value="st" <?php echo ($student['cast'] ?? '') === 'st' ? 'selected' : ''; ?>>ST</option>
                                <option value="obc" <?php echo ($student['cast'] ?? '') === 'obc' ? 'selected' : ''; ?>>OBC</option>
                                <option value="general" <?php echo ($student['cast'] ?? '') === 'general' ? 'selected' : ''; ?>>General</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="b_time" class="form-label">Batch Time</label>
                            <div class="col-5 d-flex">
                                <?php
                                    $batch_time = $student['batch_time'] ?? '';
                                    $b_time1 = '';
                                    $b_time2 = '';
                                    if (!empty($batch_time) && strpos($batch_time, '-') !== false) {
                                        $btimes = explode('-', $batch_time);
                                        $b_time1 = isset($btimes[0]) ? trim($btimes[0]) : '';
                                        $b_time2 = isset($btimes[1]) ? trim($btimes[1]) : '';
                                    }
                                ?>
                                <input class="form-control col-1" type="time" id="b_time1" value="<?php echo $b_time1 ?>">
                                <label class="form-label m-2">TO</label>
                                <input class="form-control col-1" type="time" id="b_time2" value="<?php echo $b_time2 ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="adhar" class="form-label">Adhar Number</label>
                            <input type="text" class="form-control" id="adhar" placeholder="Enter Adhar Number" inputmode="numeric" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 47;" maxlength="12" value="<?php echo isset($student['adhar']) ? $student['adhar'] : '' ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="dist" class="form-label">District</label>
                            <select class="form-select" name="dist" id="dist">
                                <?php foreach($districts as $district){ ?>
                                    <option value="<?php echo $district['id']; ?>" <?php echo (($student['district'] ?? '') == $district['id']) ? 'selected' : ''; ?>><?php echo $district['name']; ?></option>
                               <?php  } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="center" class="form-label">Center</label>
                            <select class="form-select" name="center" id="center">
                                <?php foreach ($centers as $center): ?>
                                    <option value="<?php echo $center['id'] ?>" <?php echo ($student['center'] ?? '') == $center['id'] ? 'selected' : '' ?>><?php echo $center['center'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" rows="1" placeholder="Enter Address"><?php echo isset($student['address']) ? $student['address'] : '' ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="ref_by" class="form-label">Referred By</label>
                            <input type="text" class="form-control" id="ref_by" placeholder="Enter Referred By" value="<?php echo isset($student['referred_by']) ? $student['referred_by'] : '' ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="adm_date" class="form-label">Admission Date</label>
                            <input type="text" class="form-control" id="adm_date" inputmode="none" onkeydown="return false;">
                            <input type="hidden" id="adm_date_db" value="<?php echo isset($student['admi_date']) ? date('Y-m-d', strtotime($student['admi_date'])) : '' ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="remark" class="form-label">Remark</label>
                            <textarea class="form-control" id="remark" rows="2" placeholder="Enter Remark"><?php echo isset($student['remark']) ? $student['remark'] : '' ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <input type="hidden" id="student_id" value="<?php echo $student['id'] ?>">
                        <button type="submit" class="btn btn-primary" id="update-stu">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>