<h1>Inquery</h1>
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header text-bg-primary">
                <h4 class="mb-0 text-white">Student Inquery</h4>
            </div>
            <div class="card-body">
                <form action="">
                    <div class="mb-3">
                        <label class="form-label">Student Name</label>
                        <input type="text" id="s_name" class="form-control" placeholder="Enter Student Name">
                    </div>
                    <div class="mb-3">
                        <label for="p_number" class="form-label">Mobile Number</label>
                        <input type="text" class="form-control" id="p_number" placeholder="Enter Mobile Numbers" inputmode="numeric" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 47;" maxlength="10">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
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
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="course" class="form-label">Preferred Course</label>
                                <select class="form-select" name="course" id="course">
                                    <?php foreach ($courses as $course): ?>
                                        <option value="<?= $course['id'] ?>"><?= $course['course'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="center" class="form-label">Center</label>
                        <select class="form-select" name="center" id="center">
                            <?php foreach ($centers as $center): ?>
                                <option value="<?= $center['id'] ?>"><?= $center['center'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="d-flex justify-content-center">
                        <input type="hidden" id="inqury_id" value="">
                        <button class="btn btn-primary col-md-4" id="smt-inqury">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <table id="inqury-tbl" class="table table-striped" style="width:100%">
                    <thead>
                        <th>No</th>
                        <th>Name</th>
                        <th>M Number</th>
                        <th>Course</th>
                        <th>Center</th>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>