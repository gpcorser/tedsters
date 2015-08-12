<?php

session_start();
if (!$_SESSION['email']) header('Location: login.php');


    require 'database.php';
 
    $id = null;
    if ( !empty($_GET['les_id'])) {
        $id = $_REQUEST['les_id'];
    }
     
    if ( null==$id ) {
        header("Location: les_list.php");
    }
     
    if ( !empty($_POST)) {
	
        // keep track validation errors
		$les_per_idError = null;
        $nameError = null;
        $statusError = null;
        $videoError = null;
        $labnotesError = null;
        $quizError = null;
        $answersError = null;
		 
        // keep track post values
		$les_per_id = $_POST['les_per_id'];
        $name = $_POST['name'];
        $status = $_POST['status'];
        $video = $_POST['video'];
        $labnotes = $_POST['labnotes'];
        $quiz = $_POST['quiz'];
        $answers = $_POST['answers'];

        // validate input
		$valid = true;
		if (empty($name)) {
            $nameError = 'Please enter Lesson Name';
            $valid = false;
        }
		if (empty($les_per_id)) {
            $les_per_idError = 'Please enter Person ID';
            $valid = false;
        }
         
        // update data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE lessons2  set les_name = ?, les_status = ?,
			    les_per_id = ?, les_video_url = ?, les_labnotes_url = ?,
				les_quiz_url = ?, les_answers_url = ?
				WHERE les_id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($name,$status,$les_per_id,
			    $video,$labnotes,$quiz,$answers,$id));
            Database::disconnect();
            header("Location: les_list.php");
        }
    } else { // pre-fill fields for update
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM lessons2 where les_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $name = $data['les_name'];
        $status = $data['les_status'];
        $les_per_id = $data['les_per_id'];
		$video = $data['les_video_url'];
		$labnotes = $data['les_labnotes_url'];
		$quiz = $data['les_quiz_url'];
		$answers = $data['les_answers_url'];
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
				<h3>Update Lesson</h3>
			</div>
	 
			<form class="form-horizontal" action="les_update.php?les_id=<?php echo $id?>" method="post">
					
                      <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
                        <label class="control-label">Lesson Name</label>
                        <div class="controls">
                            <input name="name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
                            <?php if (!empty($nameError)): ?>
                                <span class="help-inline"><?php echo $nameError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
					  
					  <div class="control-group">
					    <label class="control-label">Person (Author)</label>
					    <div class="controls">
							<?php
							$pdo = Database::connect();
							$sql = 'SELECT * FROM persons2 ORDER BY per_name ASC';
							echo "<select class='form-control' name='les_per_id' id='person_id'>";
							foreach ($pdo->query($sql) as $row) {
							    if ($row['per_id'] == $les_per_id) {
								    echo "<option value='" . $row['per_id'] . " ' selected> " . $row['per_name'] . "</option>";
								}
								else {
								    echo "<option value='" . $row['per_id'] . " '> " . $row['per_name'] . "</option>";
								}
							}
							echo "</select>";
							Database::disconnect();
							?>
					    </div>	<!-- end controls -->
					  </div> <!-- end control group -->
					  
                      <div class="control-group <?php echo !empty($statusError)?'error':'';?>">
                        <label class="control-label">Status</label>
                        <div class="controls">
                            <input name="status" type="text" placeholder="status" value="<?php echo !empty($status)?$status:'';?>">
                            <?php if (!empty($statusError)): ?>
                                <span class="help-inline"><?php echo $statusError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
					  
                      <div class="control-group <?php echo !empty($videoError)?'error':'';?>">
                        <label class="control-label">Video URL</label>
                        <div class="controls">
                            <input name="video" type="text" placeholder="video" value="<?php echo !empty($video)?$video:'';?>">
                            <?php if (!empty($videoError)): ?>
                                <span class="help-inline"><?php echo $videoError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
					  
                      <div class="control-group <?php echo !empty($labnotesError)?'error':'';?>">
                        <label class="control-label">Lab Notes URL</label>
                        <div class="controls">
                            <input name="labnotes" type="text" placeholder="labnotes" value="<?php echo !empty($labnotes)?$labnotes:'';?>">
                            <?php if (!empty($labnotesError)): ?>
                                <span class="help-inline"><?php echo $labnotesError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
					  
                      <div class="control-group <?php echo !empty($quizError)?'error':'';?>">
                        <label class="control-label">Quiz URL</label>
                        <div class="controls">
                            <input name="quiz" type="text" placeholder="quiz" value="<?php echo !empty($quiz)?$quiz:'';?>">
                            <?php if (!empty($quizError)): ?>
                                <span class="help-inline"><?php echo $quizError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
					  
                      <div class="control-group <?php echo !empty($answersError)?'error':'';?>">
                        <label class="control-label">Answers URL</label>
                        <div class="controls">
                            <input name="answers" type="text" placeholder="answers" value="<?php echo !empty($answers)?$answers:'';?>">
                            <?php if (!empty($answersError)): ?>
                                <span class="help-inline"><?php echo $answersError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
					  
			  <div class="form-actions">
				  <button type="submit" class="btn btn-success">Update</button>
				  <a class="btn" href="les_list.php">Back</a>
				</div>
			</form>
		</div>
                 
    </div> <!-- /container -->
	<p align="center">
	<a href="phpReader.php?file='<?php echo __FILE__; ?>'" >source code</a>
	</p>
  </body>
</html>
