<?php
$s = $student ?? [];
$stuId = $s['id'] ?? null;

// Resolve lookups
$ccourse = '-';
if (!empty($s['course']) && !empty($courses)) {
    foreach ($courses as $course) {
        if ($course['id'] == $s['course']) {
            $ccourse = $course['course'];
            break;
        }
    }
}
$dname = '-';
if (!empty($s['district']) && !empty($districts)) {
    foreach ($districts as $district) {
        if ($district['id'] == $s['district']) {
            $dname = $district['name'];
            break;
        }
    }
}
$cename = '-';
if (!empty($s['center']) && !empty($centers)) {
    foreach ($centers as $center) {
        if ($center['id'] == $s['center']) {
            $cename = $center['center'];
            break;
        }
    }
}

$genderLabel = ($s['gender'] ?? '') == 'M' ? 'Male' : (($s['gender'] ?? '') == 'F' ? 'Female' : '-');
$maritalLabel = ($s['marital_sts'] ?? '') == 'S' ? 'Single' : (($s['marital_sts'] ?? '') == 'M' ? 'Married' : '-');
$quals = ['10' => '10th', '11' => '11th', '12' => '12th', 'diploma' => 'Diploma', 'ug' => 'Undergraduate', 'pg' => 'Postgraduate'];
$qualLabel = $quals[$s['lqualifi'] ?? ''] ?? '-';
$casts = ['sc' => 'SC', 'st' => 'ST', 'obc' => 'OBC', 'general' => 'General'];
$castLabel = $casts[$s['cast'] ?? ''] ?? '-';

$batchDisplay = '-';
if (!empty($s['batch_time']) && strpos($s['batch_time'], '-') !== false) {
    $btimes = explode('-', $s['batch_time']);
    $batchDisplay = trim($btimes[0] ?? '') . ' to ' . trim($btimes[1] ?? '');
}

$initials = strtoupper(substr($s['name'] ?? 'S', 0, 1));
?>
<div class="row">
    <div class="col-12">
        <!-- Header Card -->
        <div class="card shadow-sm border-0 mb-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="bg-primary bg-opacity-10 py-4 py-md-5 px-3 px-md-4">
                    <div class="row align-items-center g-3 g-md-4">
                        <div class="col-auto">
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white fw-bold fs-2" style="width: 72px; height: 72px;">
                                <?= esc($initials) ?>
                            </div>
                        </div>
                        <div class="col">
                            <div class="d-flex flex-wrap align-items-center gap-2 gap-md-3 mb-1">
                                <h1 class="h4 mb-0 fw-semibold">
                                    <?= esc($s['name'] ?? '-') ?>
                                </h1>
                                <?php if (!empty($s['id'])): ?>
                                    <span class="badge bg-light text-secondary border">SVCA-<?= (int)$s['id'] ?></span>
                                <?php endif; ?>
                            </div>
                            <p class="text-muted mb-0 small">
                                <?= esc($ccourse) ?> &bull; <?= esc($cename) ?>
                            </p>
                        </div>
                        <div class="col-12 col-md-auto ms-md-auto">
                            <div class="d-flex flex-wrap gap-2">
                                <a href="<?= base_url('student/edit/' . $stuId) ?>" class="btn btn-primary">
                                    <i class="ti ti-edit me-1"></i> Edit
                                </a>
                                <a href="<?= base_url('payment/' . $stuId) ?>" class="btn btn-success">
                                    <i class="ti ti-cash me-1"></i> Fees
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Personal Information -->
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-semibold d-flex align-items-center gap-2">
                            <i class="ti ti-user-circle text-primary"></i>
                            Personal Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0 g-3">
                            <div class="col-12 col-sm-6">
                                <dt class="small text-muted text-uppercase fw-semibold mb-1">Father Name</dt>
                                <dd class="mb-0"><?= esc($s['fname'] ?? '-') ?></dd>
                            </div>
                            <div class="col-12 col-sm-6">
                                <dt class="small text-muted text-uppercase fw-semibold mb-1">Mother Name</dt>
                                <dd class="mb-0"><?= esc($s['mname'] ?? '-') ?></dd>
                            </div>
                            <div class="col-12 col-sm-6">
                                <dt class="small text-muted text-uppercase fw-semibold mb-1">Date of Birth</dt>
                                <dd class="mb-0"><?= !empty($s['dob'] && $s['dob'] !== '0000-00-00') ? esc(date('d M Y', strtotime($s['dob']))) : '-' ?></dd>
                            </div>
                            <div class="col-12 col-sm-6">
                                <dt class="small text-muted text-uppercase fw-semibold mb-1">Gender</dt>
                                <dd class="mb-0"><?= esc($genderLabel) ?></dd>
                            </div>
                            <div class="col-12 col-sm-6">
                                <dt class="small text-muted text-uppercase fw-semibold mb-1">Marital Status</dt>
                                <dd class="mb-0"><?= esc($maritalLabel) ?></dd>
                            </div>
                            <div class="col-12 col-sm-6">
                                <dt class="small text-muted text-uppercase fw-semibold mb-1">Caste</dt>
                                <dd class="mb-0"><?= esc($castLabel) ?></dd>
                            </div>
                            <div class="col-12">
                                <dt class="small text-muted text-uppercase fw-semibold mb-1">Aadhaar Number</dt>
                                <dd class="mb-0"><?= esc($s['adhar'] ?? '-') ?></dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Contact & Academic -->
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-semibold d-flex align-items-center gap-2">
                            <i class="ti ti-device-mobile text-primary"></i>
                            Contact & Academic
                        </h5>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0 g-3">
                            <div class="col-12 col-sm-6">
                                <dt class="small text-muted text-uppercase fw-semibold mb-1">Mobile Number</dt>
                                <dd class="mb-0"><?= esc($s['pnumber'] ?? '-') ?></dd>
                            </div>
                            <div class="col-12 col-sm-6">
                                <dt class="small text-muted text-uppercase fw-semibold mb-1">Alternative Number</dt>
                                <dd class="mb-0"><?= esc($s['apnumber'] ?? '-') ?></dd>
                            </div>
                            <div class="col-12 col-sm-6">
                                <dt class="small text-muted text-uppercase fw-semibold mb-1">Last Qualification</dt>
                                <dd class="mb-0"><?= esc($qualLabel) ?></dd>
                            </div>
                            <div class="col-12 col-sm-6">
                                <dt class="small text-muted text-uppercase fw-semibold mb-1">Percentage</dt>
                                <dd class="mb-0"><?= isset($s['per']) && $s['per'] !== '' ? esc($s['per']) . '%' : '-' ?></dd>
                            </div>
                            <div class="col-12">
                                <dt class="small text-muted text-uppercase fw-semibold mb-1">Course</dt>
                                <dd class="mb-0"><?= esc($ccourse) ?></dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Batch & Center -->
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-semibold d-flex align-items-center gap-2">
                            <i class="ti ti-building text-primary"></i>
                            Batch & Center
                        </h5>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0 g-3">
                            <div class="col-12 col-sm-6">
                                <dt class="small text-muted text-uppercase fw-semibold mb-1">Batch Time</dt>
                                <dd class="mb-0"><?= esc($batchDisplay) ?></dd>
                            </div>
                            <div class="col-12 col-sm-6">
                                <dt class="small text-muted text-uppercase fw-semibold mb-1">Center</dt>
                                <dd class="mb-0"><?= esc($cename) ?></dd>
                            </div>
                            <div class="col-12 col-sm-6">
                                <dt class="small text-muted text-uppercase fw-semibold mb-1">District</dt>
                                <dd class="mb-0"><?= esc($dname) ?></dd>
                            </div>
                            <div class="col-12 col-sm-6">
                                <dt class="small text-muted text-uppercase fw-semibold mb-1">Admission Date</dt>
                                <dd class="mb-0"><?= !empty($s['admi_date']) ? esc(date('d M Y', strtotime($s['admi_date']))) : '-' ?></dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Address & Reference -->
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-semibold d-flex align-items-center gap-2">
                            <i class="ti ti-map-pin text-primary"></i>
                            Address & Reference
                        </h5>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0 g-3">
                            <div class="col-12">
                                <dt class="small text-muted text-uppercase fw-semibold mb-1">Address</dt>
                                <dd class="mb-0"><?= !empty($s['address']) ? nl2br(esc($s['address'])) : '-' ?></dd>
                            </div>
                            <div class="col-12">
                                <dt class="small text-muted text-uppercase fw-semibold mb-1">Referred By</dt>
                                <dd class="mb-0"><?= esc($s['referred_by'] ?? '-') ?></dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Remark -->
            <?php if (!empty($s['remark'])): ?>
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-semibold d-flex align-items-center gap-2">
                            <i class="ti ti-notes text-primary"></i>
                            Remark
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0"><?= nl2br(esc($s['remark'])) ?></p>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
