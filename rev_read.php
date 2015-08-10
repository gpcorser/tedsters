<?php 
    require 'database.php'; 
    $id = null; 
    if ( !empty($_GET['id'])) { 
        $id = $_REQUEST['id']; 
    } 
      
    if ( null==$id ) { 
        header("Location: rev_list.php"); 
    } else { 
        $pdo = Database::connect(); 
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        $sql = "SELECT * FROM reviews2 where rev_id = ?"; 
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
  <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/2.3.2/css/bootstrap.min.css" rel="stylesheet"> 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/2.3.2/js/bootstrap.min.js"></script> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css"> 
    <style> 
        .glyphicon{ 
 color: #f6d200;  
    } 
    </style> 
</head> 
  
<body> 
    <div class="container"> 
                <div class="span10 offset1"> 
                    <div class="row"> 
                        <h3>Read a Lesson</h3> 
                    </div> 
                      
                    <div class="form-horizontal" > 
                     
          
                       
                      <div class="control-group"> 
                        <label class="control-label">Person</label> 
                        <div class="controls"> 
                            <label class="checkbox"> 

                                <?php 
                                $pid = $data['rev_per_id']; 
                                $pdo = Database::connect(); 
                                $sql = 'SELECT * FROM persons2'; 
                                foreach ($pdo->query($sql) as $row) { 
                                    if($row['per_id']  == $pid){ 
                                        echo  $row['per_name']; 
                                    }     
                                } 
                                Database::disconnect(); 
                                ?> 
                            </label> 
                        </div> 
                      </div> 
                       
                      <div class="control-group"> 
                        <label class="control-label">Lesson</label> 
                        <div class="controls"> 
                            <label class="checkbox"> 

                                <?php 
                                $pid = $data['rev_les_id']; 
                                $pdo = Database::connect(); 
                                $sql = 'SELECT * FROM lessons2'; 
                                foreach ($pdo->query($sql) as $row) { 
                                    if($row['les_id']  == $pid){ 
                                        echo  $row['les_name']; 
                                    }     
                                } 
                                Database::disconnect(); 
                                ?> 
                            </label> 
                        </div> 
                      </div> 
                       
                       
                      <div class="control-group"> 
                        <label class="control-label">Rating</label> 
                        <div class="controls"> 
                            <label class="checkbox"> 
                            <?php  
                                $rating = $data['rev_rating'] ; 
                            for( $x = 0;$x < 5;$x++){ 
                                if($rating >= 1){ 
                                    echo '<span class ="glyphicon glyphicon-star"></span>'; 
                                    $rating = $rating - 1; 
                                }else{ 
                                    echo '<span class ="glyphicon glyphicon-star-empty"></span>'; 
                                } 
                            } 
                            ?> 
                            </label> 
                        </div> 
                      </div> 
                       
                      <div class="control-group"> 
                        <label class="control-label">Date</label> 
                        <div class="controls"> 
                            <label class="checkbox"> 
                                <?php echo $data['rev_date'];?> 
                            </label> 
                        </div> 
                      </div> 
                      <div class="control-group"> 
                        <label class="control-label">Comment</label> 
                        <div class="controls"> 
                            <label class="checkbox"> 
                                <?php echo $data['rev_comments'];?> 
                            </label> 
                        </div> 
                      </div> 
                     
                       
                        <div class="form-actions"> 
                          <a class="btn" href="rev_list.php">Back</a> 
                          <a href="phpReader.php?file='<?php echo __FILE__; ?>'" > Source Code rev_read.txt</a> 
                       </div> 
                      
                       
                    </div> 
                </div> 
                  
    </div> <!-- /container --> 
  </body> 
</html> 