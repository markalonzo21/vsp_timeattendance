<main class="col-md-9 ml-sm-auto col-lg-10 px-4" role="main">
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Welcome <?php echo $this->session->userdata("username"); ?></h1>
        <?php if ($this->session->flashdata('info')): ?>
			<div class="alert alert-info" role="alert">
				<?php echo $this->session->flashdata('info'); ?>
			</div>
			<?php endif; ?>
        <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <button type="button" class="btn btn-sm btn-outline-secondary outline-custom" id="update_records"><img src="https://img.icons8.com/windows/20/000000/approve-and-update.png"><a href="<?php echo site_url('employee/updateRecords') ;?>">Update Records <span class="badge badge-danger" id="notif"></span></a>
        	</button>
        </div>
        <div class="btn-group mr-2">
            <button type="button" class="btn btn-sm btn-outline-secondary outline-custom" id="update_records" data-toggle="modal" data-target="#register_modal">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg> Add Employee
        	</button>
        </div>
		</div>
	</div>
	<div class="emp-no">
		<div class="alert alert-secondary" role="alert">
			<h4>Employee No.: <?php echo count($result);?></h4>
		</div>
	</div>
	<div class="table-responsive">
		<table class="table table-striped table-sm">
			<thead>
				<tr>
					<th>EMPLOYEE NAME</th>
					<th>POSITION</th>
					<th>DATE REGISTERED</th>
					<th>ACTIONS</th>
				</tr>
			</thead>
			<tbody id="emp_table">
				<?php foreach ($result as $key => $value): ?>
				<tr>
					<td><?php echo $value["emp_name"];?></td>
					<td><?php echo $value["position"];?></td>
					<td><?php echo $value["date_registed"];?></td>
					<td><a href="<?php echo site_url('employee/edit/'.$value["_id"]); ?>" class="emp_link edit">Edit</a> <a href="<?php echo site_url('employee/delete/'.$value["_id"]); ?>" class="emp_link delete" onClick="javascript: return confirm('Are you sure?');">Delete</a> </td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</main>

<!--Register Modal -->
<div class="modal fade" id="register_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-green">
        <h5 class="modal-title" id="exampleModalCenterTitle"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg> Add Employee</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<form method="post" accept-charset="utf-8" action="<?php echo site_url('employee/register'); ?>">
		  <div class="form-group">
		    <label for="formGroupExampleInput">Employee Name</label>
		    <input type="text" class="form-control" name="emp_name" required>
		  </div>
		  <div class="form-group">
		    <label for="formGroupExampleInput2">Position</label>
		    <input type="text" class="form-control" name="emp_pos" required>
		  </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>
