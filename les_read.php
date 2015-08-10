<?php

    require 'database.php';
    $id = null;
    if ( !empty($_GET['les_id'])) {
        $id = $_REQUEST['les_id'];
    }
     
    if ( null==$id ) {
        header("Location: les_list.php");
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM lessons2 where les_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
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
				<h3>Read Lesson</h3>
			</div>
			 
			<div class="form-horizontal" >
			
			  <div class="control-group">
				<label class="control-label">Lesson Name</label>
				<div class="controls">
					<label class="checkbox">
						<?php echo $data['les_name'];?>
					</label>
				</div>
			  </div>
			  
			  <!-- optional: add person -->
			  
			  <div class="control-group">
				<label class="control-label">Person</label>
				<div class="controls">
					<label class="checkbox">
						<?php 
							# echo $data['les_per_id'];
							$les_per_id = $data['les_per_id'];
							$pdo = Database::connect();
							$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							$sql = "SELECT * FROM persons2 where per_id = ?";
							$q = $pdo->prepare($sql);
							$q->execute(array($les_per_id));
							$data2 = $q->fetch(PDO::FETCH_ASSOC);
							$per_name = $data2['per_name'];
							Database::disconnect();
							echo $per_name;	
						?>		

					</label>
				</div>
			  </div>
			  
			  <div class="control-group">
				<label class="control-label">Video URL</label>
				<div class="controls">
					<label class="checkbox">
						<?php echo $data['les_video_url'];?>
					</label>
				</div>
			  </div>
			  
			  <div class="control-group">
				<label class="control-label">Lab Notes URL</label>
				<div class="controls">
					<label class="checkbox">
						<?php echo $data['les_labnotes_url'];?>
					</label>
				</div>
			  </div>
			  
			  <div class="control-group">
				<label class="control-label">Quiz URL</label>
				<div class="controls">
					<label class="checkbox">
						<?php echo $data['les_quiz_url'];?>
					</label>
				</div>
			  </div>
			  
			  <div class="control-group">
				<label class="control-label">Answers URL</label>
				<div class="controls">
					<label class="checkbox">
						<?php echo $data['les_answers_url'];?>
					</label>
				</div>
			  </div>

				<div class="form-actions">
				  <a class="btn" href="les_list.php">Back</a>
			   </div>

			</div>
		</div>
		<?php 
		
			$url = $data['les_video_url'] ;
			$parts = parse_url($url);
			$q = $parts['query'];
			if (strpos( $q, '=')) 
			    $q=substr($q, strpos( $q, '=') + 1, 1024);

echo "Displaying https://www.youtube.com/embed/" . $q ;
echo '<br />';
echo '<iframe width="420" height="315" src="https://www.youtube.com/embed/'. $q .'" frameborder="0" allowfullscreen></iframe>';

?>
    </div> <!-- /container -->
		<p align="center">
	<a href="phpReader.php?file='<?php echo __FILE__; ?>'" >source code</a>
	</p>
	</body>
</html>
