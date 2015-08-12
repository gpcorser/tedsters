<?php 
session_start();
if (!$_SESSION['email']) header('Location: login.php');
?>
<!DOCTYPE html>
<!-- from : http://www.startutorial.com/articles/view/php-crud-tutorial-part-1 -->
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
		<div class="row">
			<h3 style="margin-left:50px; ">Lessons List</h3>
		</div>

		<div class="row">
			<table class="table table-striped table-bordered" style="margin-left:50px; max-width: 800px;">
				  <col style="width: 40%;">
				  <col style="width: 25%;">
				  <col style="width: 35%;">
			  <thead>
				<tr>
				  <th>Lesson Name</th>
				  <th>Status</th>
				  <th>Action</th>
				</tr>
			  </thead>
			  <tbody>
			  <?php

				echo '<p>
					  <a href="les_create.php" class="btn btn-success" 
					  style="margin-left:50px;">Create New Lesson</a>
					  <a href="per_list.php" class="btn btn-info" 
					  style="margin-left:50px;">Persons List</a>
					  <a href="les_list.php" class="btn btn-info" 
					  style="margin-left:50px;">Lessons List</a>
					  <a href="rev_list.php" class="btn btn-info" 
					  style="margin-left:50px;">Reviews List</a>
					  <a href="logout.php" class="btn btn-danger" 
					  style="margin-left:50px;">Logout</a>
					  </p>';

			   include 'database.php';
			   $pdo = Database::connect();
			   $sql = 'SELECT * FROM lessons2 ORDER BY les_name ASC';
			   foreach ($pdo->query($sql) as $row) {
						echo '<tr>';
						echo '<td>'. $row['les_name'] . '</td>';
						echo '<td>'. $row['les_status'] . '</td>';
			
						echo '<td><a class="btn" href="les_read.php?les_id='.$row['les_id'].'">Read</a>';

						if($_SESSION['per_id']==$row['les_per_id'] or $_SESSION['per_id']==1) { # per_id 1 is administrator
							echo ' ';
							echo '<a class="btn btn-success" href="les_update.php?les_id='.$row['les_id'].'">Update</a>';
							echo ' ';
							echo '<a class="btn btn-danger" href="les_delete.php?les_id='.$row['les_id'].'">Delete</a>';
						}
						echo '</td>';
						echo '</tr>';
			   }
			   Database::disconnect();
			  ?>
			  </tbody>
		</table>

		</div>
    </div> <!-- /container -->
	<p align="center">
	<a href="phpReader.php?file='<?php echo __FILE__; ?>'" >source code</a>
	</p>
  </body>
</html>