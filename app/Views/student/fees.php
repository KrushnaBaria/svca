<h1>Payment</h1>

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
            <a href="/student/add_payment/<?php echo $student['id']; ?>" class="btn btn-success">Add Payment</a>
        </div>
    </div>
    <div class="card-header">
        <div class="card-body">
            <table id="pay-historytbl">
                <thead>
                    <th>Id</th>
                    <th>SVCA Id</th>
                    <th>Amount</th>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>