<div class="row">
    <div class="col-12 col-lg-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header text-bg-primary">
                <h4 class="mb-0 text-white">Import Students From CSV</h4>
            </div>
            <div class="card-body">
                <p class="mb-3 text-muted">
                    Select a <strong>.csv</strong> file with columns like:
                    <em>No, Student Name, Father Name, Center, Course, Admission Date, Phone Number, Alternative Number</em>.
                </p>

                <form id="student-import-form" enctype="multipart/form-data" method="post" action="<?php echo base_url('student/import-csv'); ?>">
                    <div class="mb-3">
                        <label for="csv_file" class="form-label">CSV File</label>
                        <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv" required>
                        <div class="form-text">Only CSV files are allowed.</div>
                    </div>

                    <div id="upload-spinner" class="text-center my-3 d-none">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Uploading...</span>
                        </div>
                        <div class="mt-2 small text-muted">Uploading &amp; importing, please wait...</div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?php echo base_url('/student/list');?>" class="btn btn-secondary">Back to List</a>
                        <button type="submit" id="student-import-submit" class="btn btn-primary">
                            Import Students
                        </button>
                    </div>
                </form>

                <div id="import-result" class="mt-3 d-none">
                </div>
            </div>
        </div>
    </div>
</div>

