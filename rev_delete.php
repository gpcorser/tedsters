<?php 

session_start();
if (!$_SESSION['email']) header('Location: login.php');


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
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"> 
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script> 
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script> 
<style> 
@import url(//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css); 

fieldset, label { margin: 0; padding: 0; } 
body{ margin: 20px; } 
h1 { font-size: 1.5em; margin: 10px; } 

/****** Style Star Rating Widget *****/ 

.rating {  
  border: none; 
  float: left; 
} 

.rating > input { display: none; }  
.rating > label:before {  
  margin: 5px; 
  font-size: 1.25em; 
  font-family: FontAwesome; 
  display: inline-block; 
  content: "\f005"; 
} 

.rating > .half:before {  
  content: "\f089"; 
  position: absolute; 
} 

.rating > label {  
  color: #ddd;  
 float: right;  
} 

/***** CSS Magic to Highlight Stars on Hover *****/ 

.rating > input:checked ~ label, /* show gold star when clicked */ 
.rating:not(:checked) > label:hover, /* hover current star */ 
.rating:not(:checked) > label:hover ~ label { color: #FFD700;  } /* hover previous stars in list */ 

.rating > input:checked + label:hover, /* hover current star when changing rating */ 
.rating > input:checked ~ label:hover, 
.rating > label:hover ~ input:checked ~ label, /* lighten current selection */ 
.rating > input:checked ~ label:hover ~ label { color: #f6d200;  }  

</style> 
</head> 
  
<body> 
    <div class="container"> 
      
                <div class="span10 offset1"> 
                    <div class="row"> 
                        <h3>Delete Review</h3> 
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
                      
  
                        </div> 
                    </form> 
                </div> 
                  
    </div> <!-- /container --> 
		<p align="center">
	<a href="phpReader.php?file='<?php echo __FILE__; ?>'" >source code</a>
	</p>
  </body> 
</html> 