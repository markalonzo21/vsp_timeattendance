<main class="col-md-9 ml-sm-auto col-lg-10 px-4" role="main">
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Welcome <?php echo $this->session->userdata("username"); ?></h1>
        <!-- <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <button type="button" class="btn btn-sm btn-outline-secondary" id="update_records">Update Records</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
        </div>
        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>This week
        </button>
		</div> -->
	</div>
	<div class="table-responsive">
		<table class="table table-striped table-sm">
			<thead>
				<tr>
					<th>EMPLOYEE NAME</th>
					<th>DATE RECOGNIZED</th>
					<th>TYPE</th>
				</tr>
			</thead>
			<tbody id="emp_table">
				<?php foreach ($result as $key => $value): ?>
				<tr>
					<td><?php echo $value["emp_name"]; ?></td>
					<td><?php echo $value["date_recognized"]; ?></td>
					<td><?php echo $value["idClass"]; ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</main>
