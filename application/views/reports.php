<main class="col-md-9 ml-sm-auto col-lg-10 px-4" role="main">
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Welcome <?php echo $this->session->userdata("username"); ?></h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        	<div class="report"> 
		        <button type="button" class="btn btn-sm btn-outline-secondary outline-custom" id="genReport">
		            <img src="<?php echo site_url('res/img/report.png');?>" width="24" height="24">Generate Report
		            <!-- <a href="<?php echo site_url('report/generateReport'); ?>">Generate Report</a> -->
		        </button><input type='text' id="dateRange" name="dateRange" class="form-control outline-custom" placeholder="Select Range Date" />
        	</div>
		</div>
	</div>
	<!-- <?php //echo date("m/d/Y");?> -->
	<div class="table-responsive">
		<table class="table table-striped table-sm">
			<thead>
				<tr>
					<th>EMPLOYEE NAME</th>
					<th>DATE RECOGNIZED</th>
					<th>TYPE</th>
					<th>SOURCE</th>
					<th>USER AGENT</th>
				</tr>
			</thead>
			<tbody id="emp_table">
				<?php foreach ($result as $key => $value): ?>
				<tr>
					<td><?php echo $value["emp_name"]; ?></td>
					<td><?php echo $value["date_recognized"]["date"]." ".$value["date_recognized"]["time"]; ?></td>
					<td><?php echo $value["idClass"]; ?></td>
					<td><?php echo (array_key_exists("source", $value)) ? $value["source"] : 'N/A'; ?></td>
					<td><?php echo (array_key_exists("device", $value)) ? $value["device"] : 'Web'; ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</main>
