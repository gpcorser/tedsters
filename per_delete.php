<?php
    require 'database.php';
	
    $id = 0;
     
    if ( !empty($_GET['per_id'])) {
        $id = $_REQUEST['per_id'];
    }
     
    if ( !empty($_POST)) {
        // keep track post values
        $id = $_POST['per_id'];
         
        // delete data
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM persons2 WHERE per_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        Database::disconnect();
        header("Location: per_list.php");
         
    }
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/bootstrap.min.js"></script>
</head>
 
<body>
    <div class="container">
     
		<div class="span10 offset1">
			<div class="row">
				<h3>Delete Person</h3>
			</div>
			 
			<form class="form-horizontal" action="per_delete.php" method="post">
			  <input type="hidden" name="per_id" value="<?php echo $id;?>"/>
			  <p class="alert alert-error">Are you sure you want to delete (<?php echo $id;?>)?
			  </p>
			  <?php 
					$pdo = Database::connect();
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$sql = "SELECT * FROM persons2 where per_id = ?";
					$q = $pdo->prepare($sql);
					$q->execute(array($id));
					$data = $q->fetch(PDO::FETCH_ASSOC);
					Database::disconnect();
			  ?>
			  <div class="control-group">
				<label class="control-label">Name</label>
				<div class="controls">
					<label class="checkbox">
						<?php echo $data['per_name'];?>
					</label>
				</div>
			  </div>
			  
			  <div class="control-group">
				<label class="control-label">Email</label>
				<div class="controls">
					<label class="checkbox">
						<?php echo $data['per_email'];?>
					</label>
				</div>
			  </div>
			  
			  <div class="control-group">
				<label class="control-label">Phone</label>
				<div class="controls">
					<label class="checkbox">
						<?php echo $data['per_phone'];?>
					</label>
				</div>
			  </div>
			  
			  <div class="control-group">
				<label class="control-label">Institution</label>
				<div class="controls">
					<label class="checkbox">
						<?php echo $data['per_institution'];?>
					</label>
				</div>
			  </div>
			  <div class="form-actions">
				  <button type="submit" class="btn btn-danger">Yes</button>
				  <a class="btn" href="per_list.php">No</a>
				</div>
			</form>
		</div>
                 
    </div> <!-- /container -->
  </body>
</html>