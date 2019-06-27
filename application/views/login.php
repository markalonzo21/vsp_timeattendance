<div class="container">
	<div class="form-group login">
		<form method="post" accept-charset="utf-8" action="<?php echo site_url('login/authenticate'); ?>">
			<div class="login_logo">
				<img src="<?php echo site_url('res/img/VSPsmall.bmp'); ?>" class="img_logo" width="120">
				<h1 class="login_text">TIME ATTENDANCE</h1>
			</div>
			<?php if($this->session->flashdata('error')) : ?>
			<div class="alert alert-danger" role="alert">
				<?php echo $this->session->flashdata('error'); ?>
			</div>
			<?php elseif ($this->session->flashdata('info')): ?>
			<div class="alert alert-info" role="alert">
				<?php echo $this->session->flashdata('info'); ?>
			</div>
			<?php endif; ?>
			<input type="text" class="form-control" name="username" placeholder="Username">
			<input type="password" name="password" class="form-control mt_5" placeholder="Password">
			<button class="btn btn-success btn-block mt_5 btn-login" type="submit">LOGIN</button>
		</form>
	</div>
	<?php 
		// print_r($result[0]["username"]);
		// foreach ($result as $value) {
		// 	echo $value["username"];
		// }
	?>

</div>