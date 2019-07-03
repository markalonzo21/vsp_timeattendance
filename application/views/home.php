<main class="col-md-9 ml-sm-auto col-lg-10 px-4" role="main">
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Welcome <?php echo $this->session->userdata("username"); ?></h1>
	</div>
	<canvas id="myChart" class="m-4 w-100"></canvas>
<!-- 	<div class="table-responsive">
		<table class="table table-striped table-sm">
			<thead>
				<tr>
					<th>EMPLOYEE NAME</th>
					<th>DATE REGISTED</th>
					<th>TIME OUT</th>
					<th>TOTAL HOURS</th>
				</tr>
			</thead>
			<tbody id="emp_table">
				<tr>
					<td>employee name</td>
					<td>date registered</td>
					<td>time out</td>
					<td>total hours</td>
				</tr>
			</tbody>
		</table>
	</div> -->
</main>
