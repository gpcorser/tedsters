<?php

    require 'database.php';
 
    $id = null;
    if ( !empty($_GET['per_id'])) {
        $id = $_REQUEST['per_id'];
    }
     
    if ( null==$id ) {
        header("Location: per_list.php");
    }
     
    if ( !empty($_POST)) {
        // keep track validation errors
        $nameError = null;
        $emailError = null;
        $phoneError = null;
        $institutionError = null;
         
        // keep track post values
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $institution = $_POST['institution'];
         
        // validate input
        $valid = true;
        if (empty($name)) {
            $nameError = 'Please enter Name';
            $valid = false;
        }
         
        // update data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE persons2  set per_name = ?, 
			    per_email = ?, per_phone = ?, per_institution = ?
				WHERE per_id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($name,$email,$phone,$institution,$id));
            Database::disconnect();
            header("Location: per_list.php");
        }
    } else { // pre-fill fields for update
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM persons2 where per_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $name = $data['per_name'];
        $email = $data['per_email'];
        $phone = $data['per_phone'];
		$institution = $data['per_institution'];
        Database::disconnect();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="utf-8"> 
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/2.3.2/css/bootstrap.min.css" rel="stylesheet"> 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/2.3.2/js/bootstrap.min.js"></script> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css"> 
    <style> .glyphicon{ color: #f6d200; } </style> 
</head> 
 
<body>
    <div class="container">

		<div class="span10 offset1">
			<div class="row">
				<h3>Update Person</h3>
			</div>
	 
			<form class="form-horizontal" action="per_update.php?per_id=<?php echo $id?>" method="post">
			
			  <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
				<label class="control-label">Name</label>
				<div class="controls">
					<input name="name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
					<?php if (!empty($nameError)): ?>
						<span class="help-inline"><?php echo $nameError;?></span>
					<?php endif; ?>
				</div>
			  </div>
			  
			  <div class="control-group <?php echo !empty($emailError)?'error':'';?>">
				<label class="control-label">Email</label>
				<div class="controls">
					<input name="email" type="text" placeholder="Email" value="<?php echo !empty($email)?$email:'';?>">
					<?php if (!empty($emailError)): ?>
						<span class="help-inline"><?php echo $emailError;?></span>
					<?php endif;?>
				</div>
			  </div>
			  
			  <div class="control-group <?php echo !empty($phoneError)?'error':'';?>">
				<label class="control-label">Phone</label>
				<div class="controls">
					<input name="phone" type="text"  placeholder="phone" value="<?php echo !empty($phone)?$phone:'';?>">
					<?php if (!empty($phoneError)): ?>
						<span class="help-inline"><?php echo $phoneError;?></span>
					<?php endif;?>
				</div>
			  </div>
			  
			  <div class="control-group <?php echo !empty($institutionError)?'error':'';?>">
				<label class="control-label">Institution</label>
				<div class="controls">
					<input name="institution" type="text"  placeholder="institution" value="<?php echo !empty($institution)?$institution:'';?>">
					<?php if (!empty($institutionError)): ?>
						<span class="help-inline"><?php echo $institutionError;?></span>
					<?php endif;?>
				</div>
			  </div>

			  <div class="form-actions">
				  <button type="submit" class="btn btn-success">Update</button>
				  <a class="btn" href="per_list.php">Back</a>
				</div>
			</form>
		</div>
                 
    </div> <!-- /container -->
	
		<p align="center">
	<a href="phpReader.php?file='<?php echo __FILE__; ?>'" >source code</a>
	</p>
  </body>
</html>
