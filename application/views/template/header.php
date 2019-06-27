<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Time Attendance</title>
</head>
<body><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Time Attendance</title>
	<link rel="shortcut icon" href="<?php echo site_url('res/img/vsp_logo2.png');?>" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<!-- <link rel="stylesheet" href="<?php echo site_url('res/css/bootstrap.min.css'); ?>" type="text/css"> -->
	<link rel="stylesheet" href="<?php echo site_url('res/style.css'); ?>" type="text/css">


<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<!--  <script src="<?php // echo site_url('res/js/jquery-3.4.1.min.js'); ?>"></script>
<script src="<?php // echo site_url('res/js/bootstrap.min.js'); ?>"></script> -->
<script src="<?php  echo site_url('res/script.js'); ?>"></script>
</head>
<body>
	<?php if($this->session->userdata('_id')): ?>
	<nav class="navbar navbar-dark fixed-top bg-custom flex-md-nowrap p-0 shadow">
		<a href="#" class="navbar-brand col-sm-3 col-md-2 mr-0">The Value System Phils. Inc</a>
		<input type="text" name="" id="" class="form-control form-control-dark w-100" placeholder="Search" aria-label="Search">
		<ul class="navbar-nav px-3">
			<li class="nav-item text-nowrap"><a href="<?php echo site_url('login/signout'); ?>" class="nav-link">Sign out</a></li>
		</ul>
	</nav>
	<div class="container-fluid">
		<div class="row">
			<nav class="col-md-2 d-none d-md-block bg-light sidebar">
				<div class="sidebar-sticky">
					<ul class="nav flex-column">
						<li class="nav-item">
							<a href="<?php echo site_url('home'); ?>" class="nav-link">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
								<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
								<polyline points="9 22 9 12 15 12 15 22"></polyline>
								Dashboard
								<span class="sr-only">(current)</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo site_url('employee'); ?>" class="nav-link">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
								Employees
							</a>
						</li>
						<li class="nav-item">
				            <a class="nav-link" href="<?php echo site_url('report'); ?>">
				              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
				              Reports
				            </a>
				        </li>
					</ul>
				</div>
			</nav>
	<?php endif; ?>
