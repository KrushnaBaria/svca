<div class="card shadow-sm">
    <div class="card-body">
        <div class="row g-2 mb-4">
            <div class="col-lg-4">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                        <i class="bi bi-person-fill text-primary fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted text-uppercase fw-bold d-block mb-1">Student Name</small>
                        <h6 class="mb-0"><?php echo $student['name']. ' ' . $student['fname']; ?></h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="d-flex align-items-center">
                    <div class="bg-info bg-opacity-10 rounded-circle p-3 me-3">
                        <i class="bi bi-journal-bookmark-fill text-info fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted text-uppercase fw-medium d-block mb-1">Course</small>
                        <h6 class="mb-0"><?php echo $student['course_name']; ?></h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="d-flex align-items-center">
                    <div class="bg-secondary bg-opacity-10 rounded-circle p-3 me-3">
                        <i class="bi bi-building text-secondary fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted text-uppercase fw-medium d-block mb-1">Center</small>
                        <h6 class="mb-0"><?php echo $student['center_name']; ?></h6>
                    </div>
                </div>
            </div>
        </div>
        
        <hr class="my-4">
        
        <h6 class="text-uppercase text-muted mb-3">Fee Summary</h6>
        <div class="row text-center">
            <div class="col-md-4">
                <div class="card mb-md-0 mb-2">
                    <div class="card-body p-2">
                        <h6 class="text-muted text-uppercase small">Total Fees</h6>
                        <h3 class="text-primary mb-0" id="total-fees" data-total-fees="<?php echo $student['fees']; ?>">₹<?php echo number_format($student['fees']); ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-md-0 mb-2">
                    <div class="card-body p-2">
                        <h6 class="text-muted text-uppercase small">Paid Fees</h6>
                        <h3 class="text-success mb-0" id="paid-fees">₹0</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-md-0 mb-2">
                    <div class="card-body p-2">
                        <h6 class="text-muted text-uppercase small">Pending Fees</h6>
                        <h3 class="text-warning mb-0" id="pending-fees">₹0</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="card">
    <div class="card-header text-bg-primary">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-white">Payment History</h5>
            <div class="d-flex align-items-center">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#paymentModal">Add Payment</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <table id="pay-historytbl" class="table table-bordered table-striped">
            <thead>
                <th>Id</th>
                <th>Amount</th>
                <th>Remark</th>
                <th>Added By</th>
                <th>Date</th>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-center">
            <?php if($student['old_stu'] == 0): ?>
             <button type="button" class="btn btn-secondary" id="make-old-stu" data-stuid="<?php echo $student['id']; ?>">Mark As Old Student</button>
            <?php endif; ?>
            <a href="<?php echo base_url('payment/invoice/' . $student['id']); ?>" target="_blank" class="btn btn-primary ms-auto">Print Receipt</a>
        </div>
    </div>
</div>

<!-- Modal for accept payment-->
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Accept Payment</h5>
        </div>
        <form id="paymentForm">
            <div class="modal-body">
                <div class="form-group">
                    <label for="paymentAmount" class="form-label">Payment Amount</label>
                    <input type="number" class="form-control" id="paymentAmount" name="paymentAmount" required>
                    <label for="remark" class="form-label">Remark</label>
                    <textarea type="text" class="form-control" id="remark" name="remark"></textarea>
                </div>
            </div>
        </form>
        <div class="modal-footer d-flex justify-content-center align-items-center">
            <input type="hidden" id="stu_id" value="<?php echo $student['id'];  ?>">
            <input type="hidden" id="transaction_id" value="">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="acceptPayment">Accept</button>
        </div>
    </div>
</div>