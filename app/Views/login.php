<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SVCA - Login</title>
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>assets/images/logos/favicon.svg" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/styles.min.css" />
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="<?php echo base_url(); ?>assets/images/logos/favicon.svg" width="180" alt="">
                                </a>
                                <div>
                                    <?php if (session('error') !== null) : ?>
                                        <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
                                    <?php elseif (session('errors') !== null) : ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?php if (is_array(session('errors'))) : ?>
                                                <?php foreach (session('errors') as $error) : ?>
                                                    <?= $error ?>
                                                    <br>
                                                <?php endforeach ?>
                                            <?php else : ?>
                                                <?= session('errors') ?>
                                            <?php endif ?>
                                        </div>
                                    <?php endif ?>
                                </div>

                                <form action="<?php echo base_url('process'); ?>" method="post">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control" id="password" required>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked" checked>
                                            <label class="form-check-label text-dark" for="flexCheckChecked">
                                                Remeber this Device
                                            </label>
                                        </div>
                                        <a class="text-primary fw-bold" href="./reset.php">Forgot Password ?</a>
                                    </div>
                                    <input type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2"></a>
                                    <!-- <div class="d-flex align-items-center justify-content-center">
                                        <p class="fs-4 mb-0 fw-bold">New to URLv.in</p>
                                        <a class="text-primary fw-bold ms-2" href="<?php echo base_url('registration'); ?>">Create an account</a>
                                    </div> -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>