<div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <!-- <div class="card-header">
                    <h4 class="card-title">Expense</h4>
                </div> -->
                <div class="card-body">
                    <div id="main-report-chart"></div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <table id="recent-inquries-tbl" class="table table-striped" style="width:100%">
            <thead class="text-dark fs-4">
                <th><h6 class="fs-3 fw-semibold">No</h6></th>
                <th><h6 class="fs-3 fw-semibold">Student Name</h6></th>
                <th><h6 class="fs-3 fw-semibold">Phone</h6></th>
                <th><h6 class="fs-3 fw-semibold">Course</h6></th>
                <th><h6 class="fs-3 fw-semibold">Center</h6></th>
                <th><h6 class="fs-3 fw-semibold">Date</h6></th>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<?php if (session()->getFlashdata('welcome')): ?>
<!-- Toast -->
<div class="toast toast-onload align-items-center text-bg-success border-0 fade" id="welcomeToast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="4000" style="position: fixed; top: 1rem; right: 1rem; z-index: 1080;">
    <div class="toast-body hstack align-items-start gap-6">
      <i class="ti ti-alert-circle fs-6"></i>
      <div>
        <h5 class="text-white fs-3 mb-1">Welcome to SVCA</h5>
        <h6 class="text-white fs-2 mb-0"><?= session()->getFlashdata('welcome') ?></h6>
      </div>
      <button type="button" class="btn-close btn-close-white fs-2 m-0 ms-auto shadow-none" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var toastEl = document.getElementById('welcomeToast');
        var toast = new bootstrap.Toast(toastEl);
        toast.show();
    });
</script>
<?php endif; ?>
