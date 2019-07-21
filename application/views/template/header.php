<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Time Attendance</title>
	<link rel="shortcut icon" href="<?php echo site_url('res/img/vsp_logo2.png');?>" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.css" integrity="sha256-IvM9nJf/b5l2RoebiFno92E5ONttVyaEEsdemDC6iQA=" crossorigin="anonymous" />
	<!-- <link rel="stylesheet" href="<?php //echo site_url('res/css/bootstrap.min.css'); ?>" type="text/css"> -->
	<link rel="stylesheet" href="<?php echo site_url('res/css/datepicker.min.css'); ?>" type="text/css">
	<link rel="stylesheet" href="<?php echo site_url('res/style.css'); ?>" type="text/css">


<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" integrity="sha256-Uv9BNBucvCPipKQ2NS9wYpJmi8DTOEfTA/nH2aoJALw=" crossorigin="anonymous"></script>

 <script src="<?php echo site_url('res/js/jquery.base64.min.js'); ?>"></script>
<script src="<?php // echo site_url('res/js/bootstrap.min.js'); ?>"></script>
<script src="<?php  echo site_url('res/js/datepicker.min.js'); ?>"></script>
<script src="<?php  echo site_url('res/js/i18n/datepicker.en.js'); ?>"></script>
<script type="text/javascript" src="<?php  echo site_url('res/script.js'); ?>"></script>
</head>
<body>
	<?php if($this->session->userdata('_id')): ?>
	<nav class="navbar navbar-dark fixed-top bg-custom flex-md-nowrap p-0 shadow">
		<a href="#" class="navbar-brand col-sm-3 col-md-2 mr-0">THE VALUESYSTEMSPHILS. INC.</a>
		<input type="text" id="searchEngine" class="form-control form-control-dark w-100" placeholder="Search" aria-label="Search">
		<ul class="navbar-nav px-3">
			<li class="nav-item text-nowrap"><a href="<?php echo site_url('login/signout'); ?>" class="nav-link">Sign out</a></li>
		</ul>
	</nav>
	<div class="container-fluid">
		<div class="row">
			<nav class="col-md-2 d-none d-md-block bg-light sidebar">
				<div class="sidebar-sticky">
					<ul class="nav flex-column" id="sidebar-menu">
						<li class="nav-item menu">
							<a href="<?php echo site_url('home'); ?>" class="nav-link">
								<img src="<?php echo site_url('res/img/home.png'); ?>">
								Dashboard
							</a>
						</li>
						<li class="nav-item menu">
							<a href="<?php echo site_url('employee'); ?>" class="nav-link">
								<img src="<?php echo site_url('res/img/people.png'); ?>">
								Employees
							</a>
						</li>
						<li class="nav-item menu">
				            <a class="nav-link" href="<?php echo site_url('report'); ?>">
				              <img src="<?php echo site_url('res/img/bar.png'); ?>">
				              Reports
				            </a>
				        </li>
				        <li class="nav-item menu">
				            <a class="nav-link" href="<?php echo site_url('settings'); ?>">
				              <img src="<?php echo site_url('res/img/gear.png'); ?>">
				              Settings
				            </a>
				        </li>
					</ul>
					<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
						<span>Archive</span>
					</h6>
					<ul class="nav flex-column">
						<?php $result = $this->mreport->distinct_dates(); ?>
						<?php for($i = 0; $i < count($result); $i++): ?>
							<li class="nav-item">
								<a href="#" class="nav-link">
									<img src="<?php echo site_url('res/img/file.png'); ?>">
									<?php echo date('F d, Y', strtotime($result[$i])); ?>
								</a>
							</li>
						<?php endfor; ?>
					</ul>
				</div>
			</nav>
	<?php endif; ?>
