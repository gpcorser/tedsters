<?php 

session_start();
if (!$_SESSION['email']) header('Location: login.php');

    require 'database.php'; 
  
    $id = null; 
    if ( !empty($_GET['id'])) { 
        $id = $_REQUEST['id']; 
    } 
      
    if ( null==$id ) { 
        header("Location: les_list.php"); 
    } 
      
    if ( !empty($_POST)) { 
$radioError = null; 
        $commentError = null; 
         
        // keep track post values 
        $rating = $_POST['rating']; 
        $comment = $_POST['comment']; 
        $date = $_POST['date']; 
        $rev_per_id = $_POST['rev_per_id']; 
        $rev_les_id = $_POST['rev_les_id']; 
         
         
         
         
        // validate input 
        $valid = true; 

          
        if (empty($rating)) { 
            $radioError = 'Please rate the lesson'; 
            $valid = false; 
        } 
        if (empty($comment)) { 
            $commentError = 'Please enter your comments about the lesson'; 
            $valid = false; 
        }     
          
        // update data 
        if ($valid) { 
            $pdo = Database::connect(); 
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            $sql = "UPDATE reviews2 set rev_per_id = ? ,rev_les_id = ? ,rev_rating = ? ,rev_comments = ? ,rev_date = ? WHERE rev_id = ?"; 
              
            $q = $pdo->prepare($sql); 
            $q->execute(array($rev_per_id,$rev_les_id,$rating,$comment,$date,$id)); 
            Database::disconnect(); 
            header("Location: rev_list.php"); 
        } 
    } else { 
        $pdo = Database::connect(); 
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        $sql = "SELECT * FROM reviews2 where rev_id = ?"; 
        $q = $pdo->prepare($sql); 
        $q->execute(array($id)); 
        $data = $q->fetch(PDO::FETCH_ASSOC); 

        $rating = $data['rev_rating']; 
         
         
        if($rating == 5){$radio5='checked="checked"';} 
        if($rating == 4){$radio4='checked="checked"';} 
        if($rating == 3){$radio3='checked="checked"';} 
        if($rating == 2){$radio2='checked="checked"';} 
        if($rating == 1){$radio1='checked="checked"';} 
         
        $comment = $data['rev_comments']; 
        $date = $data['rev_date']; 
        $rev_per_id = $data['rev_per_id']; 
        $rev_les_id = $data['rev_les_id']; 
         
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
                        <h3>Update Review</h3> 
                    </div> 
              
                    <form class="form-horizontal" action="rev_update.php?id=<?php echo $id?>" method="post"> 
   
                      <div class="control-group"> 
                        <label class="control-label">Person (Reviewer)</label> 
                        <div class="controls"> 
                        <?php 
                         
                        $pdo = Database::connect(); 
                        $sql = 'SELECT * FROM persons2'; 
                         
                        echo "<select class='form-control' name='rev_per_id' id='rev_per_id' >"; 
                        foreach ($pdo->query($sql) as $row) { 
                            if($row['per_id']  == $rev_per_id){ 
                                echo "<option value='" . $row['per_id'] . " ' selected> " . $row['per_name'] . "</option>";     
                            } 
                            else{ 
                                echo "<option value='" . $row['per_id'] . " '> " . $row['per_name'] . "</option>"; 
                            } 
                             
                             
                        } 
                        echo "</select>"; 
                        Database::disconnect(); 
         
                        ?> 
                                 
                        </div> 
                      </div> 
                      <div class="control-group"> 
                        <label class="control-label">Lessons</label> 
                        <div class="controls"> 
                        <?php 
                         
                        $pdo = Database::connect(); 
                        $sql = 'SELECT * FROM lessons2'; 
                         
                        echo "<select class='form-control' name='rev_les_id' id='rev_les_id' >"; 
                        foreach ($pdo->query($sql) as $row) { 
                            if($row['les_id']  == $rev_les_id){ 
                                echo "<option value='" . $row['les_id'] . " ' selected> " . $row['les_name'] . "</option>";     
                            } 
                            else{ 
                                echo "<option value='" . $row['les_id'] . " '> " . $row['les_name'] . "</option>"; 
                            } 
                        } 
                        echo "</select>"; 
                        Database::disconnect(); 
         
                        ?> 
                                 
                        </div> 
                      </div> 
                       
                       
                      <div class="control-group"> 
                        <label class="control-label">Rating</label> 
                        <div class="controls"> 
                         
                        <fieldset class="rating"> 
                                <input type="radio" id="star5" name="rating" value="5" <?php echo $radio5;?>/><label class = "full" for="star5" title="Awesome - 5 stars"></label> 
                                <input type="radio" id="star4" name="rating" value="4" <?php echo $radio4;?>/><label class = "full" for="star4" title="Pretty good - 4 stars"></label> 
                                <input type="radio" id="star3" name="rating" value="3" <?php echo $radio3;?>/><label class = "full" for="star3" title="Meh - 3 stars"></label> 
                                <input type="radio" id="star2" name="rating" value="2" <?php echo $radio2;?>/><label class = "full" for="star2" title="Kinda bad - 2 stars"></label> 
                                <input type="radio" id="star1" name="rating" value="1" <?php echo $radio1;?>/><label class = "full" for="star1" title="Sucks big time - 1 star"></label> 
                        </fieldset> 
                            <?php if (!empty($radioError)): ?> 
                                <span class="help-inline"><?php echo $radioError;?></span> 
                            <?php endif;?> 
                             
                             

                             
                        </div> 
                      </div> 
                       
                      <div class="control-group "> 
                        <label class="control-label">Date</label> 
                        <div class="controls"> 
             
                        <input name="date" type="hidden" value="<?php echo $date;?>"> 
                            <label class="checkbox"> 
                                <?php echo $date;?> 
                            </label> 
                        </div> 
                      </div> 
                       
                       
                      <div class="control-group <?php echo !empty($commentError)?'error':'';?>"> 
                        <label class="control-label">Comment</label> 
                        <div class="controls"> 
                        <textarea name="comment" cols="50" rows="5"  ><?php echo $comment;?></textarea> 
                        
                            <?php if (!empty($commentError)): ?> 
                                <span class="help-inline"><?php echo $commentError;?></span> 
                            <?php endif;?> 
                             
                        </div> 
                      </div> 
                       
                       
                       
                       
                      <div class="form-actions"> 
                          <button type="submit" class="btn btn-success">Update</button> 
                          <a class="btn" href="rev_list.php">Back</a> 
                      

                        </div> 
                    </form> 
                </div> 
                  
    </div> <!-- /container --> 
		<p align="center">
	<a href="phpReader.php?file='<?php echo __FILE__; ?>'" >source code</a>
	</p>
  </body> 
</html> 