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
    <style> 
	.glyphicon{ color: #f6d200; }
	table {table-layout: fixed; }	
	</style> 

</head> 
  
<body> 
    <div class="container"> 
		<div class="row"> 
			<h3 style="margin-left:50px; ">Reviews List</h3> 
		</div> 
		
		<div class="row"> 
			<table class="table table-striped table-bordered" style="margin-left:50px; max-width: 800px;"> 
			  <col style="width: 15%;">
			  <col style="width: 20%;">
			  <col style="width: 15%;">
			  <col style="width: 15%;">
			  <col style="width: 35%;">
			  <thead> 
				<tr> 
				  <th>Reviewer</th> 
				  <th>Lesson</th> 
				  <th>Rating</th> 
				  <th>Date</th> 
				  <th>Action</th> 
				</tr> 
			  </thead> 
			  <tbody> 
				<?php 
				echo '<p> 
					<a href="rev_create.php" class="btn btn-success"  
					style="margin-left:50px;">Create New Review</a> 
					<a href="per_list.php" class="btn btn-info" 
					style="margin-left:50px;">Persons List</a>
					<a href="les_list.php" class="btn btn-info" 
					style="margin-left:50px;">Lessons List</a>
					<a href="rev_list.php" class="btn btn-info" 
					style="margin-left:50px;">Reviews List</a>
				  <a href="logout.php" class="btn btn-danger" 
				  style="margin-left:50px;">Logout</a>
					</p>';
				?>
			  <?php 
			   include 'database.php'; 
			   $pdo = Database::connect(); 
			   $sql = 'SELECT * FROM reviews2 '; 
			   foreach ($pdo->query($sql) as $row) { 
					echo '<tr>'; 
					 
					echo '<td>'; 
				 
						$pid = $row['rev_per_id']; 
						$ppdo = Database::connect(); 
						$psql = 'SELECT * FROM persons2'; 
						foreach ($ppdo->query($psql) as $prow) { 
							if($prow['per_id']  == $pid){ 
								echo  $prow['per_name']; 
							}     
						} 
						Database::disconnect(); 
					echo '</td>'; 
					echo '<td>'; 
				 
						$lid = $row['rev_les_id']; 
						$lpdo = Database::connect(); 
						$lsql = 'SELECT * FROM lessons2'; 
						foreach ($lpdo->query($lsql) as $lrow) { 
							if($lrow['les_id']  == $lid){ 
								echo  $lrow['les_name']; 
							}     
						} 
						Database::disconnect(); 
					echo '</td>'; 
					 
					//echo '<td>'. $row['rev_rating'] . '</td>'; 
					$rating = $row['rev_rating'] ; 
					echo '<td>'; 
					for( $x = 0;$x < 5;$x++){ 
						if($rating >= 1){ 
							echo '<span class ="glyphicon glyphicon-star"></span>'; 
							$rating = $rating - 1; 
						}else{ 
							echo '<span class ="glyphicon glyphicon-star-empty"></span>'; 
						} 
					} 
					echo '</td>'; 

					echo '<td>'. $row['rev_date'] . '</td>'; 
					 
					echo '<td><a class="btn" href="rev_read.php?id='.$row['rev_id'].'">Read</a>'; 
					if($_SESSION['per_id']==$row['rev_per_id'] or $_SESSION['per_id']==1) { # per_id 1 is administrator
						echo ' '; 
						echo '<a class="btn btn-success" href="rev_update.php?id='.$row['rev_id'].'">Update</a>'; 
						echo ' '; 
						echo '<a class="btn btn-danger" href="rev_delete.php?id='.$row['rev_id'].'">Delete</a>'; 
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
<script> 

</script>