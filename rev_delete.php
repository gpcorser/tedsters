<?php 
    require 'database.php'; 
    $id = 0; 
      
    if ( !empty($_GET['id'])) { 
        $id = $_REQUEST['id']; 
    } 
      
    if ( !empty($_POST)) { 
        // keep track post values 
        $id = $_POST['id']; 
          
        // delete data 
        $pdo = Database::connect(); 
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        $sql = "DELETE FROM reviews2  WHERE rev_id = ?"; 
        $q = $pdo->prepare($sql); 
        $q->execute(array($id)); 
        Database::disconnect(); 
        header("Location: rev_list.php"); 
          
    } 
    else { 
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
</head> 
  
<body> 
    <div class="container"> 
      
                <div class="span10 offset1"> 
                    <div class="row"> 
                        <h3>Delete a Lesson</h3> 
                    </div> 
                      
                    <form class="form-horizontal" action="rev_delete.php" method="post"> 
                      <input type="hidden" name="id" value="<?php echo $id;?>"/> 
                        <ul class="alert alert-error">Are you sure you want to delete ? 
                       
                        <li> 
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
                        </li> 
                        <li> 
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
                        </li> 

                        <li><?php echo $data["rev_date"];?></li> 
                        <li><?php echo $data["rev_comments"];?></li> 

                      </ul> 

                       
                      <div class="form-actions"> 
                          <button type="submit" class="btn btn-danger">Yes</button> 
                          <a class="btn" href="rev_list.php">No</a> 
                         <a href="phpReader.php?file='<?php echo __FILE__; ?>'" > Source Code rev_delete.txt</a> 
  
                        </div> 
                    </form> 
                </div> 
                  
    </div> <!-- /container --> 
  </body> 
</html> 