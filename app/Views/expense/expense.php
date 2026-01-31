<div class="col-12">
    <div class="card">
        <div class="card-header bg-primary">
            <h4 class="text-white mb-0">Expense Filter</h4>
        </div>
        <div class="card-body">
            <div class="d-flex flex-wrap justify-content-md-start justify-content-center gap-2">
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
                <div class="col-md-2 col-10 d-flex justify-content-center align-items-center mt-0 mt-md-6 pt-3">
                    <button class="btn btn-primary mx-1" id="expense-search-btn">Search</button>
                    <button class="btn btn-secondary mx-1" id="expense-clear-btn">Clear</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header text-bg-primary">
                <h4 class="mb-0 text-white">Add Expense</h4>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-center align-items-center">
                    <div class="m-2 col-md-12">
                        <label class="form-label" for="exp">Expense Description</label>
                        <input type="text" class="form-control" id="exp" placeholder="Enter Expense Description">
                    </div>
                    <div class="m-2 col-md-5 col-12">
                        <label class="form-label" for="center">Center</label>
                        <select type="text" class="form-control" id="center">
                            <option value="">Select Center</option>
                            <?php foreach($centers as $center): ?>
                                <option value="<?php echo $center['id']; ?>"><?= $center['center'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="m-2 col-md-5 col-12">
                        <label class="form-label" for="amount">Amount</label>
                        <input type="number" class="form-control" id="amount" placeholder="Enter Amount" min="0" step="any" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="text-center">
                        <input type="hidden" id="expense-id" value="">
                        <button class="btn btn-primary" id="sbt-expence">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <!-- <div class="card-header text-bg-primary">
                <h4 class="mb-0 text-white">Expense List</h4>
            </div> -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="expense-tbl">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Description</th>
                                <th>Center</th>
                                <th>Amount</th>
                                <th>Added Date</th>
                                <th>Updated By</th>
                                <th>Updated Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>