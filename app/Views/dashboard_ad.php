<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary pb-1">
                <div class="d-flex justify-content-end gap-2">
                    <div class="col-3">
                        <input type="text" class="form-control text-white" id="date-filter">
                    </div>
                </div>
            </div>
            <div class="card-body row pb-0">
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
                                <h5 class="fw-semibold text-success mb-0">0</h5>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary pb-3">
                <div class="d-flex justify-content-end gap-2">
                    <h4 class="text-white mb-0">Total Student</h4>
                </div>
            </div>
            <div class="card-body row pb-0">
                <div class="owl-carousel owl-theme col-md-6" id="dashboard-carousel">
                    <div class="item">
                        <div class="card border-0 zoom-in bg-warning-subtle shadow-none">
                            <div class="card-body">
                            <div class="text-center">
                                <img src="<?php echo base_url(); ?>/assets/images/svgs/icon-briefcase.svg" width="50" height="50" class="mb-3" alt="modernize-img">
                                <p class="fw-semibold fs-3 text-warning mb-1">Total Student</p>
                                <h5 class="fw-semibold text-warning mb-0" id="total-admission-count">0</h5>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="owl-carousel owl-theme col-md-6" id="dashboard-carousel">
                    <div class="item">
                        <div class="card border-0 zoom-in bg-info-subtle shadow-none">
                            <div class="card-body">
                            <div class="text-center">
                                <img src="<?php echo base_url(); ?>/assets/images/svgs/icon-connect.svg" width="50" height="50" class="mb-3" alt="modernize-img">
                                <p class="fw-semibold fs-3 text-info mb-1">Total Inquiries</p>
                                <h5 class="fw-semibold text-info mb-0" id="total-inquiry-count">0</h5>
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