<div class="card">
    <div class="card-header text-bg-primary">
        <h4 class="mb-0 text-white">Student Filter</h4>
    </div>
    <div class="card-body">
        <div class="d-flex flex-wrap justify-content-center gap-2">
            <div class="col-md-2 col-10">
                <label class="form-label" for="center-ftr">Center</label>
                <select type="text" class="form-control" id="center-ftr">
                    <option value="">Select Center</option>
                    <?php foreach($centers as $center): ?>
                        <option value="<?= $center['id'] ?>"><?= $center['center'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3 col-10">
                <label class="form-label" for="user-ftr">User</label>
                <select type="text" class="form-control" id="user-ftr">
                    <option value="">Select User</option>
                    <?php foreach($users as $user): ?>
                        <option value="<?= $user['email'] ?>"><?= $user['email'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3 col-10">
                <label class="form-label" for="type-ftr">Type</label>
                <select type="text" class="form-control" id="type-ftr">
                    <option value="">Select Type</option>
                    <option value="computer">Computer</option>
                    <option value="academy">Academy</option>
                </select>
            </div>
            <div class="col-md-3 col-10">
                <label class="form-label" for="date-ftr">Date</label>
                <input type="text" class="form-control" id="date-ftr" placeholder="Select Date Range">
            </div>
        </div>
        <div class="col-12 d-flex justify-content-center align-items-center mt-0 mt-md-6 pt-3 gap-3">
            <button class="btn btn-primary mx-1" id="student-search-btn">Search</button>
            <button class="btn btn-secondary mx-1" id="student-clear-btn">Clear</button>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header text-bg-light">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0 ">Student List</h4>
            <a href="<?php echo base_url('/student');?>" class="btn btn-secondary">Add Student</a>
        </div>
    </div>
    <div class="card-body">
        <table id="student-tbl" class="table" style="width:100%">
            <thead class="text-dark fs-4">
                <tr>
                    <th><h6 class="fs-3 fw-semibold">No</h6></th>
                    <th><h6 class="fs-3 fw-semibold">SVCA Id</h6></th>
                    <th><h6 class="fs-3 fw-semibold">Name</h6></th>
                    <th><h6 class="fs-3 fw-semibold">Center</h6></th>
                    <th><h6 class="fs-3 fw-semibold">Number</h6></th>
                    <th><h6 class="fs-3 fw-semibold">Phone</h6></th>
                    <th><h6 class="fs-3 fw-semibold">Course</h6></th>
                    <th><h6 class="fs-3 fw-semibold">Referred by</h6></th>
                    <th><h6 class="fs-3 fw-semibold">Action</h6></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>