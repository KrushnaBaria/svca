<?php
$userInfo = $user_info ?? [];
$centers  = $centers ?? [];

$userId = (int) ($userInfo['user_id'] ?? 0);
$center = (string) ($userInfo['center'] ?? '');
$first  = old('first_name') ?? ($userInfo['first_name'] ?? '');
$last   = old('last_name') ?? ($userInfo['last_name'] ?? '');
$dob    = old('dob') ?? ($userInfo['dob'] ?? '');
?>

<div class="row justify-content-center">
    <div class="col-12 col-xl-8">
        <?php if (session('error') !== null) : ?>
            <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
        <?php elseif (session('errors') !== null) : ?>
            <div class="alert alert-danger" role="alert">
                <?php if (is_array(session('errors'))) : ?>
                    <?php foreach (session('errors') as $error) : ?>
                        <?= esc($error) ?><br>
                    <?php endforeach ?>
                <?php else : ?>
                    <?= esc(session('errors')) ?>
                <?php endif ?>
            </div>
        <?php endif ?>

        <div class="card shadow-sm border-0">
            <div class="card-header text-bg-primary d-flex justify-content-between align-items-center">
                <h4 class="mb-0 text-white">Edit User</h4>
                <a href="<?= base_url('user/admin-list') ?>" class="btn btn-light btn-sm">Back</a>
            </div>
            <div class="card-body">
                <form action="<?= base_url('user/update') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="user_id" value="<?= esc($userId) ?>">

                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Center</label>
                            <select class="form-select" name="center" required>
                                <option value="" disabled <?= $center === '' ? 'selected' : '' ?>>Select Center</option>
                                <?php foreach ($centers as $c): ?>
                                    <option value="<?= esc($c['id']) ?>" <?= (string) $c['id'] === (string) $center ? 'selected' : '' ?>>
                                        <?= esc($c['center']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" name="dob" value="<?= esc($dob) ?>">
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" name="first_name" value="<?= esc($first) ?>" required>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="last_name" value="<?= esc($last) ?>" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

