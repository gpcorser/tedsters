<?php
	session_start();
	$sess_id = "iloveted";
	if ($_SESSION["id"]!=$sess_id) 
	    header("Location: tedsters.php");
    require 'teddatabase.php';
 
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( null==$id ) {
        header("Location: tedsters.php");
    }
     
    if ( !empty($_POST)) {
        // keep track validation errors
        $nameError = null;
        $emailError = null;
        $mobileError = null;
		$committeeError = null;
		$locationError = null;
         
        // keep track post values
        $name = $_POST['name'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $committee = $_POST['committee'];
		$location = $_POST['location'];
         
        // validate input
        $valid = true;
        if (empty($name)) {
            $nameError = 'Please enter Name';
            $valid = false;
        }
         
        if (empty($email)) {
            $emailError = 'Please enter Email Address';
            $valid = false;
        } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
            $emailError = 'Please enter a valid Email Address';
            $valid = false;
        }
         
        if (empty($mobile)) {
            $mobileError = 'Please enter Mobile Number';
            $valid = false;
        }
         
        // update data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE tedsters  set name = ?, email = ?, mobile = ?, committee = ?, location = ? WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($name,$email,$mobile,$committee,$location,$id));
            Database::disconnect();
            header("Location: tedsters.php");
        }
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM tedsters where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $name = $data['name'];
        $email = $data['email'];
        $mobile = $data['mobile'];
		$committee = $data['committee'];
		$location = $data['location'];
        Database::disconnect();
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
                        <h3>Update a Tedster</h3>
                    </div>
             
                    <form class="form-horizontal" action="tedupdate.php?id=<?php echo $id?>" method="post">
					
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
                        <label class="control-label">Email </label>
                        <div class="controls">
                            <input name="email" type="text" placeholder="Email " value="<?php echo !empty($email)?$email:'';?>">
                            <?php if (!empty($emailError)): ?>
                                <span class="help-inline"><?php echo $emailError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
					  
                      <div class="control-group <?php echo !empty($mobileError)?'error':'';?>">
                        <label class="control-label">Mobile </label>
                        <div class="controls">
                            <input name="mobile" type="text"  placeholder="Mobile " value="<?php echo !empty($mobile)?$mobile:'';?>">
                            <?php if (!empty($mobileError)): ?>
                                <span class="help-inline"><?php echo $mobileError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
					  
                      <div class="control-group <?php echo !empty($committeeError)?'error':'';?>">
                        <label class="control-label">Committee</label>
                        <div class="controls">
                            <input name="committee" type="text"  placeholder="Committee" value="<?php echo !empty($committee)?$committee:'';?>">
                            <?php if (!empty($committeeError)): ?>
                                <span class="help-inline"><?php echo $committeeError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
					  
                      <div class="control-group <?php echo !empty($locationError)?'error':'';?>">
                        <label class="control-label">Location</label>
                        <div class="controls">
						    <!-- drop down list box: below -->
							<select name="location">
							<?php
							$pdo = Database::connect();
                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $sql = "SELECT * FROM tedlocations";
							foreach($pdo->query($sql) as $row)
							{
							    if ($row[0] == $location)
								    echo "<option selected value=$row[0]>$row[1]</option>";
							    else
								    echo "<option value=$row[0]>$row[1]</option>";
							}
							Database::disconnect();
						    ?>
						    </select>
							<!-- drop down list box: above -->
						    <?php if (!empty($locationError)): ?>
                                <span class="help-inline"><?php echo $locationError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
					  
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Update</button>
                          <a class="btn" href="tedsters.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>
