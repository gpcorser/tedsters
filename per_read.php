<?php

    require 'database.php';
    $id = null;
    if ( !empty($_GET['per_id'])) {
        $id = $_REQUEST['per_id'];
    }
     
    if ( null==$id ) {
        header("Location: per_list.php");
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM persons2 where per_id = ?";
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
                        <h3>Read Person</h3>
                    </div>
                     
                    <div class="form-horizontal" >
					
                      <div class="control-group">
                        <label class="control-label">Name</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['per_name'];?>
                            </label>
                        </div>
                      </div>
					  
                      <div class="control-group">
                        <label class="control-label">Email</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['per_email'];?>
                            </label>
                        </div>
                      </div>
					  
                      <div class="control-group">
                        <label class="control-label">Phone</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['per_phone'];?>
                            </label>
                        </div>
                      </div>
					  
                      <div class="control-group">
                        <label class="control-label">Institution</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['per_institution'];?>
                            </label>
                        </div>
                      </div>

                        <div class="form-actions">
                          <a class="btn" href="per_list.php">Back</a>
                       </div>

                    </div>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>
