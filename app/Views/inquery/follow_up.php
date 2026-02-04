<div class="card">
    <div class="card-header text-bg-primary">
        <h4 class="text-white mb-0">Inquiry Follow-up</h4>
    </div>
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
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-4">
        <div class="card">
            <div class="card-header text-bg-secondary">
                <h5 class="text-white mb-0">Add Follow-up</h5>
            </div>
            <div class="card-body">
                <form id="follow-up-form">
                    <div>
                        <label for="follow-up-notes" class="form-label">Follow-up Notes</label>
                        <textarea name="notes" id="follow-up-notes" class="form-control" rows="2" placeholder="Enter follow-up notes..."></textarea>
                    </div>
                    <div>
                        <label for="follow-up-date" class="form-label mt-3">Follow-up Date</label>
                        <input type="text" name="follow_up_date" id="follow-up-date" class="form-control" onkeydown="return false;">
                    </div>
                    <div>
                        <label for="follow-up-status" class="form-label mt-3">Status</label>
                        <select name="status" id="follow-up-status" class="form-select">
                            <option value="pending">Pending</option>
                            <option value="called">Called</option>
                            <option value="interested">Interested</option>
                            <option value="not interested">Not Interested</option>
                        </select>
                    </div>
                    <div class="text-center">
                        <input type="hidden" name="stu_id" id="stu_id" value="<?php echo $student['id']; ?>">
                        <button type="submit" id="sbt-follow-up" class="btn btn-primary mt-4">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-8 ">
        <div class="card">
            <div class="card-header text-bg-secondary">
                <h5 class="text-white mb-0">Follow-up History</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped" id="follow-up-table">
                    <thead>
                        <tr>
                            <th>Notes</th>
                            <th>Status</th>
                            <th>Follow-up Date</th>
                            <th>Created Date</th>
                            <th>Added By</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
