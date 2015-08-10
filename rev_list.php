<!DOCTYPE html> 
<!-- from : http://www.startutorial.com/articles/view/php-crud-tutorial-part-1 --> 
<html lang="en"> 
<head> 
    <meta charset="utf-8">  
  <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/2.3.2/css/bootstrap.min.css" rel="stylesheet"> 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/2.3.2/js/bootstrap.min.js"></script> 
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script> 
    <style> 
    .glyphicon{ 
 color: #f6d200;  
    } 
    </style> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css"> 
</head> 
  
<body> 
    <div class="container"> 
            <div class="row"> 
                <h3 style="margin-left:50px; ">Reviews List</h3> 
            </div> 

            <div class="row"> 
                <table class="table table-striped table-bordered" style="margin-left:50px; max-width: 800px;"> 
                  <thead> 
                    <tr> 
                      <th>Person</th> 
                      <th>Lesson</th> 
                      <th>Rating</th> 
                      <th>Date</th> 
                      <th>Action</th> 
                    </tr> 
                  </thead> 
                  <tbody> 
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
                            echo ' '; 
                            echo '<a class="btn btn-success" href="rev_update.php?id='.$row['rev_id'].'">Update</a>'; 
                            echo ' '; 
                            echo '<a class="btn btn-danger" href="rev_delete.php?id='.$row['rev_id'].'">Delete</a>'; 
                         
                            echo '</td>'; 
                            echo '</tr>'; 
                   } 
                   Database::disconnect(); 
                  ?> 
                  </tbody> 
                   
            </table> 
            <?php 
            echo '<p> 
                    <a href="rev_create.php" class="btn btn-success"  
                    style="margin-left:50px;">Create</a> 
                    </p>'; 
            ?> 
            <a href="phpReader.php?file='<?php echo __FILE__; ?>'" > Source Code rev_list.txt</a>     
        </div> 
    </div> <!-- /container --> 
  </body> 
</html> 
<script> 

</script>