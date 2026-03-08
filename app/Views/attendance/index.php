<div class="card">
    <div class="card-header text-bg-primary">
        <h4 class="mb-0 text-white">Attendance Filter</h4>
    </div>
    <div class="card-body">
        <div class="d-flex flex-wrap justify-content-center gap-2">
            <div class="col-md-2 col-10">
                <label class="form-label" for="center-ftr">Center</label>
                <select class="form-control" id="center-ftr">
                    <option value="">Select Center</option>
                    <?php foreach ($centers as $center): ?>
                        <option value="<?= $center['id'] ?>"><?= $center['center'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3 col-10">
                <label class="form-label" for="type-ftr">Type</label>
                <select class="form-control" id="type-ftr">
                    <option value="">Select Type</option>
                    <option value="computer">Computer</option>
                    <option value="academy">Academy</option>
                </select>
            </div>
            <div class="col-md-2 col-10">
                <label class="form-label" for="stu-sts-ftr">Student</label>
                <select type="text" class="form-control" id="stu-sts-ftr">
                    <option value="0">Current</option>
                    <option value="1">Old</option>
                </select>
            </div>
            <div class="col-md-3 col-10">
                <label class="form-label" for="att-date">Date</label>
                <input type="text" class="form-control" id="att-date" placeholder="Select Date">
            </div>
        </div>
        <div class="col-12 d-flex justify-content-center align-items-center mt-0 mt-md-6 pt-3 gap-3">
            <button class="btn btn-primary mx-1" id="attendance-search-btn">Search</button>
            <button class="btn btn-secondary mx-1" id="attendance-clear-btn">Clear</button>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header text-bg-light">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Student Attendance</h4>
            <button type="button" class="btn btn-success" id="attendance-save-btn">Save Attendance</button>
        </div>
    </div>
    <div class="card-body">
        <table id="attendance-tbl" class="table" style="width:100%">
            <thead class="text-dark fs-4">
                <tr>
                    <th><h6 class="fs-3 fw-semibold">No</h6></th>
                    <th><h6 class="fs-3 fw-semibold">SVCA Id</h6></th>
                    <th><h6 class="fs-3 fw-semibold">Name</h6></th>
                    <th><h6 class="fs-3 fw-semibold">Center</h6></th>
                    <th><h6 class="fs-3 fw-semibold">Course</h6></th>
                    <th><h6 class="fs-3 fw-semibold">Status</h6></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

