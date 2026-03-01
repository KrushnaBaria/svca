<div class="d-flex justify-content-center align-items-center">
    <div class="card col-md-6">
        <div class="card-header text-bg-primary">
            <h4 class="mb-0 text-white">Add Certificate Information</h4>
        </div>
        <div class="card-body">
            <div class="">
                <form action="">
                    <div class="mb-3">
                        <label for="student-name" class="form-label">Name</label>
                        <input type="text" name="student_name" id="student-name" class="form-control" value="<?php echo isset($student['id']) ? $student['name'] : ''; ?>" required <?php echo isset($student['id']) ? 'readonly' : ''; ?>>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col">
                                <label for="center" class="form-label">Center</label>
                                <select name="center" id="center" class="form-select" <?php echo (isset($student['id']) ? 'disabled' : ''); ?> required>
                                    <option value="" >Select Center</option>
                                    <?php foreach($centers as $center){?>
                                        <option value="<?php echo $center['id'];?>" <?php echo (isset($student['center']) && $student['center'] == $center['id']) ? 'selected' : ''; ?>><?php echo $center['center'];?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="col">
                                <label for="certificate_no" class="form-label">Certificate No</label>
                                <input type="text" name="certificate_no" id="certificate_no" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col">
                                <label for="fees" class="form-label">Fees</label>
                                <input type="number" name="fees" id="fees" class="form-control" value = "<?php echo (isset($student['id']) ? 0 : ''); ?>" <?php echo (isset($student['id']) ? 'readonly' : ''); ?> required>
                            </div>
                            <div class="col">
                                <label for="issued_date" class="form-label">Issued Date</label>
                                <input type="text" name="issued_date" id="issued_date" class="form-control" required>
                            </div>
                            <div class="col">
                                <label for="tel-number" class="form-label">Phone</label>
                                <input type="tel" name="tel_number" id="tel-number" value = "<?php echo (isset($student['id']) ? $student['pnumber'] : ''); ?>" class="form-control" maxlength="10" pattern="[0-9]{10}" <?php echo (isset($student['id']) ? 'readonly' : ''); ?> required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-0 mt-3 text-center">
                        <input type="hidden" name="student_id" id="stu_id" value="<?php echo (isset($student['id']) ? $student['id'] : ''); ?>">
                        <button id="sbt-btn" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>       
        </div>
    </div>
</div>