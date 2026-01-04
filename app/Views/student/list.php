<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Student List</h5>
        <div class="d-flex justify-content-end">
            <a href="<?php echo base_url('/student');?>" class="btn btn-primary">Add Student</a>
        </div>
    </div>
    <div class="card-body">
        <table id="student-tbl" class="display responsive nowrap dataTable w-100">
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