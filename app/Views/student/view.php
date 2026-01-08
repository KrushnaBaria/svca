<div>
    <div class="card">
        <div class="card-header text-bg-primary">
            <h4 class="mb-0 text-white">Student Details</h4>
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-4 mb-2">
                    <strong>Student Name:</strong>
                    <div><?php echo isset($student['name']) ? $student['name'] : '-'; ?></div>
                </div>
                <div class="col-md-4 mb-2">
                    <strong>Father Name:</strong>
                    <div><?php echo isset($student['fname']) ? $student['fname'] : '-'; ?></div>
                </div>
                <div class="col-md-4 mb-2">
                    <strong>Mother Name:</strong>
                    <div><?php echo isset($student['mname']) ? $student['mname'] : '-'; ?></div>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-4 mb-2">
                    <strong>Date of Birth:</strong>
                    <div><?php echo isset($student['dob']) ? date('d/m/Y', strtotime($student['dob'])) : '-'; ?></div>
                </div>
                <div class="col-md-4 mb-2">
                    <strong>Mobile Number:</strong>
                    <div><?php echo isset($student['pnumber']) ? $student['pnumber'] : '-'; ?></div>
                </div>
                <div class="col-md-4 mb-2">
                    <strong>Alternative Number:</strong>
                    <div><?php echo isset($student['apnumber']) ? $student['apnumber'] : '-'; ?></div>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-2 mb-2">
                    <strong>Gender:</strong>
                    <div>
                        <?php
                            if (($student['gender'] ?? '') == 'M') echo 'Male';
                            elseif (($student['gender'] ?? '') == 'F') echo 'Female';
                            else echo '-';
                        ?>
                    </div>
                </div>
                <div class="col-md-2 mb-2">
                    <strong>Marital Status:</strong>
                    <div>
                        <?php
                            if (($student['marital_status'] ?? '') == 'S') echo 'Single';
                            elseif (($student['marital_status'] ?? '') == 'M') echo 'Married';
                            else echo '-';
                        ?>
                    </div>
                </div>
                <div class="col-md-2 mb-2">
                    <strong>Last Qualification:</strong>
                    <div>
                        <?php
                            $qual = $student['lqualifi'] ?? '';
                            $quals = [
                                '10' => '10th',
                                '11' => '11th',
                                '12' => '12th',
                                'diploma' => 'Diploma',
                                'ug' => 'Undergraduate',
                                'pg' => 'Postgraduate'
                            ];
                            echo $quals[$qual] ?? '-';
                        ?>
                    </div>
                </div>
                <div class="col-md-2 mb-2">
                    <strong>Percentage:</strong>
                    <div><?php echo isset($student['per']) && $student['per'] !== '' ? $student['per'] . '%' : '-'; ?></div>
                </div>
                <div class="col-md-2 mb-2">
                    <strong>Course:</strong>
                    <div>
                        <?php
                        $sc = $student['course'] ?? '';
                        $ccourse = '-';
                        foreach ($courses as $course) {
                            if ($course['id'] == $sc) {
                                $ccourse = $course['course'];
                                break;
                            }
                        }
                        echo $ccourse;
                        ?>
                    </div>
                </div>
                <div class="col-md-2 mb-2">
                    <strong>Caste:</strong>
                    <div>
                        <?php
                            $cast = $student['cast'] ?? '';
                            $casts = [
                                'sc' => 'SC',
                                'st' => 'ST',
                                'obc' => 'OBC',
                                'general' => 'General'
                            ];
                            echo $casts[$cast] ?? '-';
                        ?>
                    </div>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-4 mb-2">
                    <strong>Batch Time:</strong>
                    <div>
                        <?php
                            $batch_time = $student['batch_time'] ?? '';
                            if (!empty($batch_time) && strpos($batch_time, '-') !== false) {
                                $btimes = explode('-', $batch_time);
                                $b_time1 = isset($btimes[0]) ? trim($btimes[0]) : '';
                                $b_time2 = isset($btimes[1]) ? trim($btimes[1]) : '';
                                echo $b_time1 . ' to ' . $b_time2;
                            } else {
                                echo '-';
                            }
                        ?>
                    </div>
                </div>
                <div class="col-md-4 mb-2">
                    <strong>Adhar Number:</strong>
                    <div><?php echo isset($student['adhar']) ? $student['adhar'] : '-'; ?></div>
                </div>
                <div class="col-md-2 mb-2">
                    <strong>District:</strong>
                    <div>
                        <?php
                            $dist_id = $student['district'] ?? '';
                            $dname = '-';
                            foreach($districts as $district) {
                                if ($district['id'] == $dist_id) {
                                    $dname = $district['name'];
                                    break;
                                }
                            }
                            echo $dname;
                        ?>
                    </div>
                </div>
                <div class="col-md-2 mb-2">
                    <strong>Center:</strong>
                    <div>
                        <?php
                            $cent_id = $student['center'] ?? '';
                            $cename = '-';
                            foreach ($centers as $center) {
                                if ($center['id'] == $cent_id) {
                                    $cename = $center['center'];
                                    break;
                                }
                            }
                            echo $cename;
                        ?>
                    </div>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-4 mb-2">
                    <strong>Address:</strong>
                    <div><?php echo isset($student['address']) ? nl2br(htmlspecialchars($student['address'])) : '-'; ?></div>
                </div>
                <div class="col-md-4 mb-2">
                    <strong>Referred By:</strong>
                    <div><?php echo isset($student['referred_by']) ? $student['referred_by'] : '-'; ?></div>
                </div>
                <div class="col-md-4 mb-2">
                    <strong>Admission Date:</strong>
                    <div><?php echo isset($student['admi_date']) ? date('d/m/Y', strtotime($student['admi_date'])) : '-'; ?></div>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-12 mb-2">
                    <strong>Remark:</strong>
                    <div><?php echo isset($student['remark']) ? nl2br(htmlspecialchars($student['remark'])) : '-'; ?></div>
                </div>
            </div>
        </div>
    </div>
</div>