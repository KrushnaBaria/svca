<div class="card">
    <div class="card-body">
        <h3 class="text-primary">Payment List</h3>
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
                <th>Added By</th>
                <th>Date</th>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>