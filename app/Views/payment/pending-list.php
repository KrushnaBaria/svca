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
                <div class="col-md-2 col-10">
                    <label class="form-label" for="course-ftr">Course</label>
                    <select type="text" class="form-control" id="course-ftr">
                        <option value="">Select Course</option>
                        
                    </select>
                </div>
                <div class="col-md-2 col-10">
                    <label class="form-label" for="duration-ftr">Duration</label>
                    <select type="text" class="form-control" id="duration-ftr">
                        <option value="">Select Duration</option>
                        <option value="">Last Month</option>
                        <option value="">Last 3 Months</option>
                        <option value="">Last 6 Months</option>
                        <option value="">Last Year</option>
                    </select>
                </div>
                <div class="col-md-3 col-10">
                    <label class="form-label" for="date-ftr">Date</label>
                    <input type="text" class="form-control" id="date-ftr" placeholder="Select Date Range">
                </div>
                
                <div class="col-md-1 col-10 d-flex justify-content-center align-items-center mt-0 mt-md-6 pt-3">
                    <!-- <button class="btn btn-primary mx-1" id="expense-search-btn">Search</button> -->
                    <button class="btn btn-secondary mx-1" id="payment-clear-btn">Clear</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table id="pending-payment-list" class="table table-bordered table-striped">
            <thead>
                <?php if(auth()->user()->getGroups()[0] == 'superadmin'){ ?>
                    <th> Id </th>
                <?php }else{ ?>
                    <th>No</th>
                <?php }?>
                <th>Name</th>
                <th>Course</th>
                <th>Center</th>
                <th>Total Fees</th>
                <th>Paid Fees</th>
                <th>Pending Fees</th>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>