<main class="col-md-9 ml-sm-auto col-lg-10 px-4" role="main">
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Settings</h1>
        <?php if ($this->session->flashdata('info')): ?>
			<div class="alert alert-info" role="alert">
				<?php echo $this->session->flashdata('info'); ?>
			</div>
			<?php endif; ?>
        <!-- <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <button type="button" class="btn btn-sm btn-outline-secondary outline-custom" id="update_records"><img src="https://img.icons8.com/windows/20/000000/approve-and-update.png"><a href="<?php echo site_url('employee/updateRecords') ;?>">Update Records <span class="badge badge-danger" id="notif"></span></a>
        	</button>
        </div>
        <div class="btn-group mr-2">
            <button type="button" class="btn btn-sm btn-outline-secondary outline-custom" id="update_records" data-toggle="modal" data-target="#register_modal">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg> Add Employee
        	</button>
        </div>
		</div> -->
	</div>
	<div class="settings">
		<form>
			<div class="form-row">
				<div class="col">
					<label for="directory">Directory</label>
					<input class="form-control" name="directory" placeholder="Enter Directory" />
				</div>
				<div class="col">
					<label></label>
				</div>
			</div>
			<div class="row">
				<button class="btn btn-success mt_5 btn-login" type="submit">Save</button>
			</div>
		</form>
	</div>
</main>
