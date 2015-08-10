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
			<h3 style="margin-left:50px; ">Persons List</h3>
		</div>
		<div class="row">
			<table class="table table-striped table-bordered" style="margin-left:50px; max-width: 800px;">
			  <thead>
				<tr>
				  <th>Name</th>
				  <th>Email</th>
				  <th>Phone</th>
				  <th>Institution</th>
				  <th>Action</th>
				</tr>
			  </thead>
			  <tbody>
			  <?php

				echo '<p>
					  <a href="per_create.php" class="btn btn-success" 
					  style="margin-left:50px;">Create New Person</a>
					  <a href="per_list.php" class="btn btn-info" 
					  style="margin-left:50px;">Persons List</a>
					  <a href="les_list.php" class="btn btn-info" 
					  style="margin-left:50px;">Lessons List</a>
					  <a href="rev_list.php" class="btn btn-info" 
					  style="margin-left:50px;">Reviews List</a>
					  </p>';


			   include 'database.php';
			   $pdo = Database::connect();
			   $sql = 'SELECT * FROM persons2 ORDER BY per_name ASC';
			   foreach ($pdo->query($sql) as $row) {
						echo '<tr>';
						echo '<td>'. $row['per_name'] . '</td>';
						echo '<td>'. $row['per_email'] . '</td>';
						echo '<td>'. $row['per_phone'] . '</td>';
						echo '<td>'. $row['per_institution'] . '</td>';
			
						echo '<td><a class="btn" href="per_read.php?per_id='.$row['per_id'].'">Read</a>';
						echo ' ';
						echo '<a class="btn btn-success" href="per_update.php?per_id='.$row['per_id'].'">Update</a>';
						echo ' ';
						echo '<a class="btn btn-danger" href="per_delete.php?per_id='.$row['per_id'].'">Delete</a>';
			
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