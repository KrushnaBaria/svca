<div class="mb-3 text-end">
    <a href="<?= base_url('esamaj/add') ?>" class="btn btn-primary">Add Student</a>
</div>
<div class="card">
    <div class="card-body">
        <table id="estudent-list" class="table table-bordered table-striped">
            <thead>
                <?php if(auth()->user()->getGroups()[0] == 'superadmin'){ ?>
                    <th> Id </th>
                <?php }else{ ?>
                    <th>No</th>
                <?php }?>
                <th>Name</th>
                <th>User Id</th>
                <th>Password</th>
                <th>Phone</th>
                <th>Phone</th>
                <th>Cheque</th>
                <th>Address</th>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>