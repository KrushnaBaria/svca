<div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary d-flex">
                    <h4 class="card-title text-white">Ex Chart</h4>
                    <div class="col-md-2 col-3 ms-auto float-end mb-0">
                        <input type="text" class="form-control text-white" id="year-filter" onkeydown="return false;">
                    </div>
                </div>
                <div class="card-body">
                    <div id="main-report-chart"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary">
                    <div class="d-flex justify-content-end gap-2">
                        <div class="col-3">
                            <input type="text" class="form-control text-white" id="date-filter">
                        </div>
                        <div class="col-3">
                            <select class="form-control text-white" id="center-filter">
                                <option class="text-primary" value="">Select Center</option>
                                <?php foreach($centers as $center): ?>
                                    <option class="text-primary" value="<?= $center['id'] ?>"><?= $center['center'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body row">
                    <div class="owl-carousel owl-theme col-md-4" id="dashboard-carousel">
                        <div class="item">
                            <div class="card border-0 zoom-in bg-warning-subtle shadow-none">
                                <div class="card-body">
                                <div class="text-center">
                                    <img src="<?php echo base_url(); ?>/assets/images/svgs/icon-briefcase.svg" width="50" height="50" class="mb-3" alt="modernize-img">
                                    <p class="fw-semibold fs-3 text-warning mb-1">Admission</p>
                                    <h5 class="fw-semibold text-warning mb-0" id="admission-count">0</h5>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="owl-carousel owl-theme col-md-4" id="dashboard-carousel">
                        <div class="item">
                            <div class="card border-0 zoom-in bg-info-subtle shadow-none">
                                <div class="card-body">
                                <div class="text-center">
                                    <img src="<?php echo base_url(); ?>/assets/images/svgs/icon-connect.svg" width="50" height="50" class="mb-3" alt="modernize-img">
                                    <p class="fw-semibold fs-3 text-info mb-1">Inquiries</p>
                                    <h5 class="fw-semibold text-info mb-0" id="inquiry-count">0</h5>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="owl-carousel owl-theme col-md-4" id="dashboard-carousel">
                        <div class="item">
                            <div class="card border-0 zoom-in bg-success-subtle shadow-none">
                                <div class="card-body">
                                <div class="text-center">
                                    <img src="<?php echo base_url(); ?>/assets/images/svgs/icon-speech-bubble.svg" width="50" height="50" class="mb-3" alt="modernize-img">
                                    <p class="fw-semibold fs-3 text-success mb-1">Follow Up</p>
                                    <h5 class="fw-semibold text-success mb-0" id="followup-count">0</h5>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="owl-carousel owl-theme col-md-4" id="dashboard-carousel">
                        <div class="item">
                            <div class="card border-0 zoom-in bg-info-subtle shadow-none">
                                <div class="card-body">
                                <div class="text-center">
                                    <p class="fw-semibold fs-3 text-info mb-1">Revenue</p>
                                    <h5 class="fw-semibold text-info mb-0" id="revenue-count">0</h5>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="owl-carousel owl-theme col-md-4" id="dashboard-carousel">
                        <div class="item">
                            <div class="card border-0 zoom-in bg-success-subtle shadow-none">
                                <div class="card-body">
                                <div class="text-center">
                                    <p class="fw-semibold fs-3 text-success mb-1">Expense</p>
                                    <h5 class="fw-semibold text-success mb-0" id="expense-count">0</h5>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="owl-carousel owl-theme col-md-4" id="dashboard-carousel">
                        <div class="item">
                            <div class="card border-0 zoom-in bg-warning-subtle shadow-none">
                                <div class="card-body">
                                <div class="text-center">
                                    <p class="fw-semibold fs-3 text-warning mb-1">Profit</p>
                                    <h5 class="fw-semibold text-warning mb-0" id="profit-count">0</h5>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-primary">
            <h4 class="card-title text-white">Today's Follow Up</h4>
        </div>
        <div class="card-body table-responsive">
            <table id="today-follow-up-tbl" class="table table table-bordered" style="width:100%">
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

    <div class="card">
        <div class="card-header bg-primary">
            <h4 class="card-title text-white">Recent Inquiries</h4>
        </div>
        <div class="card-body table-responsive">
            <table id="recent-inquries-tbl" class="table table table-bordered" style="width:100%">
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
