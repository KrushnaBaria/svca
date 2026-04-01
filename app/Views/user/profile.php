<?php
$userInfo = $user_info ?? null;
$authUser = $auth_user ?? null;
$centerName = $center_name ?? '';
$fullName = $userInfo ? trim(($userInfo['first_name'] ?? '') . ' ' . ($userInfo['last_name'] ?? '')) : '';
$initials = $fullName ? strtoupper(substr($userInfo['first_name'] ?? '', 0, 1) . substr($userInfo['last_name'] ?? '', 0, 1)) : ($authUser ? strtoupper(substr($authUser->email ?? 'U', 0, 1)) : 'U');
?>
<div class="row justify-content-center">
    <div class="col-12 col-xl-10">
        <div class="card shadow-sm border-0 overflow-hidden mb-4">
            <div class="card-body p-0">
                <div class="bg-primary bg-opacity-10 py-4 py-md-5 px-3 px-md-4">
                    <div class="row align-items-center g-3">
                        <div class="col-auto">
                            <div class="rounded-circle bg-primary bg-opacity-25 d-flex align-items-center justify-content-center text-primary fw-bold fs-2" style="width: 80px; height: 80px;">
                                <?= esc($initials) ?>
                            </div>
                        </div>
                        <div class="col">
                            <h1 class="h3 mb-1 fw-semibold">
                                <?= $fullName ? esc($fullName) : (($authUser->username ?? $authUser->email) ? esc($authUser->username ?? $authUser->email) : 'My Profile') ?>
                            </h1>
                            <?php if ($authUser && !empty($authUser->email)): ?>
                                <p class="text-muted mb-0 d-flex align-items-center gap-1">
                                    <i class="ti ti-mail fs-5"></i>
                                    <?= esc($authUser->email) ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-semibold d-flex align-items-center gap-2">
                    <i class="ti ti-user-circle text-primary"></i>
                    Profile Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label small text-muted text-uppercase fw-semibold">First Name</label>
                        <p class="form-control-plaintext mb-0 py-2 px-3 rounded bg-light">
                            <?= $userInfo && isset($userInfo['first_name']) ? esc($userInfo['first_name']) : '—' ?>
                        </p>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label small text-muted text-uppercase fw-semibold">Last Name</label>
                        <p class="form-control-plaintext mb-0 py-2 px-3 rounded bg-light">
                            <?= $userInfo && isset($userInfo['last_name']) ? esc($userInfo['last_name']) : '—' ?>
                        </p>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label small text-muted text-uppercase fw-semibold">Date of Birth</label>
                        <p class="form-control-plaintext mb-0 py-2 px-3 rounded bg-light">
                            <?php
                            if ($userInfo && !empty($userInfo['dob'])) {
                                echo esc(date('d M Y', strtotime($userInfo['dob'])));
                            } else {
                                echo '—';
                            }
                            ?>
                        </p>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label small text-muted text-uppercase fw-semibold">Center</label>
                        <p class="form-control-plaintext mb-0 py-2 px-3 rounded bg-light">
                            <?= $centerName ? esc($centerName) : '—' ?>
                        </p>
                    </div>
                    <div class="col-12">
                        <label class="form-label small text-muted text-uppercase fw-semibold">Email</label>
                        <p class="form-control-plaintext mb-0 py-2 px-3 rounded bg-light">
                            <?= $authUser && !empty($authUser->email) ? esc($authUser->email) : '—' ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-3 text-center">
            <a href="<?= base_url('user/edit/' . $authUser->id) ?>" class="btn btn-outline-primary">
                <i class="ti ti-edit me-1"></i> Edit Profile
            </a>
        </div>


        <?php if (false): ?>
        <div class="mt-3 text-center">
            <a href="<?= base_url('user/change-password/' . $authUser->id) ?>" class="btn btn-outline-primary">
                <i class="ti ti-lock me-1"></i> Change Password
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>
