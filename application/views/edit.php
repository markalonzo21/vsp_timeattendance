<main class="col-md-9 ml-sm-auto col-lg-10 px-4" role="main">
   <?php foreach ($result as $key => $value): ?>
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit <?php echo $value["emp_name"]; ?>'s Details</h1>
  </div>
  <form method="post" accept-charset="utf-8" action="<?php echo site_url('employee/update/'.$value["_id"]); ?>">
      <div class="form-group">
        <label for="formGroupExampleInput">Employee Name</label>
        <input type="text" class="form-control" name="emp_name" value="<?php echo $value["emp_name"]; ?>" required>
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput2">Position</label>
        <input type="text" class="form-control" name="emp_pos" value="<?php echo $value["position"]; ?>" required>
      </div>
     <button type="submit" class="btn btn-success">Save</button>
  </form>
<?php endforeach; ?>
</main>