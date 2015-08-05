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
    <link   href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/bootstrap.min.js"></script>
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
                 
    </div> <!-- /container -->
  </body>
</html>
