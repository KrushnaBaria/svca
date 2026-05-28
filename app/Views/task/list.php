<div class="card">
    <div class="card-header text-bg-primary">
        <h4 class="mb-0 text-white">User Filter</h4>
    </div>
    <div class="card-body">
        <div class="d-flex flex-wrap justify-content-center gap-2">
            <div class="col-md-3 col-10">
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
                <label class="form-label" for="date-ftr">Date</label>
                <input type="text" class="form-control" id="date-ftr" placeholder="Select Date Range">
            </div>
            <div class="col-md-2 col-10 d-flex align-items-end gap-2">
                <button class="btn btn-primary mt-4" id="search-btn">Search</button>
                <button class="btn btn-secondary mt-4" id="clear-btn">Clear</button>
            </div>
        </div>
        
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-bg-primary">
                <h5 class="card-title text-white mb-0">All Users Task List</h5>
            </div>
            <div class="card-body">
                <table id="task-list-tbl" class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th><h6 class="fs-3 fw-semibold">No</h6></th>
                            <th><h6 class="fs-3 fw-semibold">Name</h6></th>
                            <th><h6 class="fs-3 fw-semibold">Center</h6></th>
                            <th><h6 class="fs-3 fw-semibold">Task</h6></th>
                            <th><h6 class="fs-3 fw-semibold">Updated Date</h6></th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

