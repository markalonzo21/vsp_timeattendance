<main class="col-md-9 ml-sm-auto col-lg-10 px-4" role="main">
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Settings</h1>
        <?php if ($this->session->flashdata('info')): ?>
			<div class="alert alert-info" role="alert">
				<?php echo $this->session->flashdata('info'); ?>
			</div>
			<?php endif; ?>
	</div>
	<div class="settings">
		<h1>SAFR Settings</h1>
		<form method="POST" accept-charset="utf-8" action="<?php echo site_url('settings/update'); ?>">
			<div class="form-row settings-form">
				<div class="col">
					<label for="directory">Directory</label>
					<input class="form-control" type="text" name="directory" value="<?php if($data){ echo $data[0]['directory']; } ?>" placeholder="Enter Directory" />
				</div>
				<div class="col">
					<label></label>
				</div>
			</div>
			<div class="form-row settings-form">
				<div class="col">
					<label for="username">Username</label>
					<input class="form-control" name="username" type="text" value="<?php if($data){ echo $data[0]['username']; } ?>" placeholder="Enter Username" />
				</div>
				<div class="col">
					<label for="password">Password</label>
					<input class="form-control" name="password" type="password" placeholder="Enter Password" />
				</div>
			</div>
			<h1 class="mt-3">Time Settings</h1>
			<div>Work in progress..</div>
			<div class="row">
				<div class="col">
					<button class="btn btn-success btn-block mt_20 btn-login" type="submit">Save</button>
				</div>
				<div class="col"></div>
			</div>
		</form>
	</div>
</main>
