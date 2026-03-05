<!--  Body Wrapper -->
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="" class="text-nowrap logo-img text-center">
                <!-- <img src="<?php echo base_url('public/assets/images/logos/logo.svg');?>" alt="" /> -->
                 <h1 class="mb-0 fs-8 fw-semibold text-primary">SVCA</h1>
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-6"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="sidebar-item">
                    <a class="sidebar-link" href="<?php echo base_url('/dashboard');?>" aria-expanded="false">
                        <i class="ti ti-layout-dashboard"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <?php if ($user_group == 'superadmin'){?>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="<?php echo base_url('/profit-share');?>" aria-expanded="false">
                            <i class="ti ti-brand-4chan"></i>
                            <span class="hide-menu">P Share</span>
                        </a>
                    </li>
                <?php } ?>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="<?php echo base_url('/expense');?>" aria-expanded="false">
                        <i class="ti ti-currency-dollar"></i>
                        <span class="hide-menu">Expense</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="<?php echo base_url('/student/list');?>" aria-expanded="false">
                        <i class="ti ti-school"></i>
                        <span class="hide-menu">Student</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="<?php echo base_url('/student/import');?>" aria-expanded="false">
                        <i class="ti ti-file-upload"></i>
                        <span class="hide-menu">Import Students</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="<?php echo base_url('/inquery');?>" aria-expanded="false">
                        <i class="ti ti-phone-call"></i>
                        <span class="hide-menu">Inquery</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="<?php echo base_url('/certificate');?>" aria-expanded="false">
                        <i class="ti ti-certificate"></i>
                        <span class="hide-menu">Certificate</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="<?php echo base_url('/attendance');?>" aria-expanded="false">
                        <i class="ti ti-user-check"></i>
                        <span class="hide-menu">Attendance</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="<?php echo base_url('/student/birthday-buzz');?>" aria-expanded="false">
                        <i class="ti ti-cake"></i>
                        <span class="hide-menu">Birthday Buzz</span>
                    </a>
                </li>
                <?php if ($user_group == 'superadmin'){?>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="<?php echo base_url('/user/admin-list');?>" aria-expanded="false">
                            <i class="ti ti-user"></i>
                            <span class="hide-menu"> Admin List</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="<?php echo base_url('/logs');?>" aria-expanded="false">
                            <i class="ti ti-file-stack"></i>
                            <span class="hide-menu">Edit Logs</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="<?php echo base_url('/bin');?>" aria-expanded="false">
                            <i class="ti ti-trash"></i>
                            <span class="hide-menu">Recycle Bin</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="<?php echo base_url('/settings');?>" aria-expanded="false">
                            <i class="ti ti-settings"></i>
                            <span class="hide-menu">Setting</span>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
        <div class="sidebar-footer p-3 text-center border-top">
            <a class="text-muted small mb-0" target="_blank" href="https://krushnabaria.github.io/portfolio/">Made With &#x2764; By Krushna</a>
        </div>
    </aside>