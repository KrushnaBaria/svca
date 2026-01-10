<div class="card">
    <div class="card-header">
        <div class="card-body">
            <h3><?php echo $student['name'] ?></h3>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header text-bg-primary">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-white">Payment History</h5>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#paymentModal">Add Payment</button>
        </div>
    </div>
    <div class="card-header">
        <div class="card-body">
            <table id="pay-historytbl" class="table table-bordered table-striped">
                <thead>
                    <th>Id</th>
                    <th>Amount</th>
                    <th>Date</th>
                </thead>
                <tbody></tbody>
            </table>
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
                    <label for="paymentAmount">Payment Amount</label>
                    <input type="number" class="form-control" id="paymentAmount" name="paymentAmount" required>
                </div>
            </div>
        </form>
        <div class="modal-footer d-flex justify-content-center align-items-center">
            <input type="hidden" id="stu_id" value="<?php echo $student['id'];  ?>">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="acceptPayment">Accept</button>
        </div>
    </div>
</div>