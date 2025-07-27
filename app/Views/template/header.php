<?php 
	$user = auth()->user();
	$user_group = ($user->getGroups()[0]);
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $page_title; ?> &ndash; SVCA</title>
  <link rel="shortcut icon" type="image/png" href="<?php echo base_url('public/assets/images/logos/favicon.svg'); ?>" />
  <link rel="stylesheet" href="<?php echo base_url('public/assets/css/styles.min.css');?>" />
  <!-- <link rel="stylesheet" href="<?php echo base_url('public/assets/css/dataTables.dataTables.css');?>" /> -->
  <link rel="stylesheet" href="https://cdn.datatables.net/v/dt/jq-3.7.0/moment-2.29.4/dt-2.3.2/sl-3.0.1/datatables.min.css">
  <link rel="stylesheet" href="<?php echo base_url('public/assets/css/custom.min.css');?>" />
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
</head>
<body>
	<?php include_once(APPPATH . 'Views/template/sidebar.php'); ?>
	<div class="body-wrapper">
		<!--  Header Start -->
		<header class="app-header">
			<nav class="navbar navbar-expand-lg navbar-light">
				<ul class="navbar-nav">
				<li class="nav-item d-block d-xl-none">
					<a class="nav-link sidebartoggler " id="headerCollapse" href="javascript:void(0)">
					<i class="ti ti-menu-2"></i>
					</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link " href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown" aria-expanded="false">
					<iconify-icon icon="solar:bell-linear" class="fs-6"></iconify-icon>
					<div class="notification bg-primary rounded-circle"></div>
					</a>
					<div class="dropdown-menu dropdown-menu-animate-up" aria-labelledby="drop1">
					<div class="message-body">
						<a href="javascript:void(0)" class="dropdown-item">
						Item 1
						</a>
						<a href="javascript:void(0)" class="dropdown-item">
						Item 2
						</a>
					</div>
					</div>
				</li>
				</ul>
				<div class="navbar-collapse justify-content-end px-0" id="navbarNav">
				<ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
					<li class="nav-item dropdown">
					<a class="nav-link " href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
						aria-expanded="false">
						<img src="<?php echo base_url('public/assets/images/profile/user-1.jpg');?>" alt="" width="35" height="35" class="rounded-circle">
					</a>
					<div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
						<div class="message-body">
						<a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
							<i class="ti ti-user fs-6"></i>
							<p class="mb-0 fs-3">My Profile</p>
						</a>
						<a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
							<i class="ti ti-mail fs-6"></i>
							<p class="mb-0 fs-3">My Account</p>
						</a>
						<a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
							<i class="ti ti-list-check fs-6"></i>
							<p class="mb-0 fs-3">My Task</p>
						</a>
						<a href="./authentication-login.html" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
						</div>
					</div>
					</li>
				</ul>
				</div>
			</nav>
		</header>
		<!--  Header End -->
		<div class="container-fluid">