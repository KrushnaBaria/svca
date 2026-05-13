<!-- <div class="card">
    <div class="card-body">
        <h3 class="text-primary">Payment List</h3>
    </div>
</div> -->

<div class="col-12">
    <div class="card">
        <div class="card-header bg-primary">
            <h4 class="text-white mb-0">Fees Filter</h4>
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
                    <button class="btn btn-secondary mx-1" id="payment-clear-btn">Clear</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table id="payment-list" class="table table-bordered table-striped">
            <thead>
                <?php if(auth()->user()->getGroups()[0] == 'superadmin'){ ?>
                    <th> Id </th>
                <?php }else{ ?>
                    <th>No</th>
                <?php }?>
                <th>Name</th>
                <th>Amount</th>
                <th>Remark</th>
                <th>Center</th>
                <th>Added By</th>
                <th>Date</th>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>