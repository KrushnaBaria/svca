<?php ?>
<!--  Body Wrapper -->
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="" class="text-nowrap logo-img">
            <img src="<?php echo base_url('public/assets/images/logos/logo.svg');?>" alt="" />
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
                        <i class="ti ti-atom"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="<?php echo base_url('/expense');?>" aria-expanded="false">
                        <i class="ti ti-currency-dollar"></i>
                        <span class="hide-menu">Expense</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="<?php echo base_url('/student/list');?>" aria-expanded="false">
                        <i class="ti ti-user"></i>
                        <span class="hide-menu">Student</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="<?php echo base_url('/inquery');?>" aria-expanded="false">
                        <i class="ti ti-phone-call"></i>
                        <span class="hide-menu">Inquery</span>
                    </a>
                </li>
                <?php if ($user_group == 'admin' || $user_group == 'superadmin'){?>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="<?php echo base_url('/settings');?>" aria-expanded="false">
                        <i class="ti ti-settings"></i>
                        <span class="hide-menu">Setting</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="<?php echo base_url('/add');?>" aria-expanded="false">
                        <i class="ti ti-user"></i>
                        <span class="hide-menu">Add User</span>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </aside>