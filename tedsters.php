<!DOCTYPE html>
<!-- from : http://www.startutorial.com/articles/view/php-crud-tutorial-part-1 -->
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/bootstrap.min.js"></script>
</head>
 
<body>
    <div class="container">
            <div class="row">
                <h3 style="margin-left:50px; ">Tedster Committee Assignments</h3>
            </div>
			<?php
			    session_start();
			   	$sess_id = "iloveted";
				if ($_SESSION["id"]!=$sess_id)
				{
				   	echo '<form method="POST" action="tedlogin.php">
		                  <input type="text" size="9" name="username" 
						  class="form-control" placeholder="Username">
		                  <input type="password" size="9" name="password" 
						  class="form-control" placeholder="Password">
		                  <button type="submit" name="loginSubmit" 
						  class="btn btn-success">Login</button>
	                      </form>';
				}
				if ($_SESSION["id"]==$sess_id)
				{
				    echo  '<form method="POST" action="tedlogout.php">
				          <button type="submit" name="logoutSubmit" 
						  class="btn btn-success">Logout</button>
						  </form>';
				}
			?>
            <div class="row">
                <table class="table table-striped table-bordered" style="margin-left:50px; max-width: 800px;">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Mobile</th>
					  <th>Committee</th>
					  <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                   include 'teddatabase.php';
                   $pdo = Database::connect();
                   $sql = 'SELECT * FROM tedsters ORDER BY id DESC';
                   foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. $row['name'] . '</td>';
                            echo '<td>'. $row['email'] . '</td>';
                            echo '<td>'. $row['mobile'] . '</td>';
							echo '<td>'. $row['committee'] . '</td>';
							if ($_SESSION["id"]==$sess_id)
							{
							echo '<td><a class="btn" href="tedread.php?id='.$row['id'].'">Read</a>';
							echo ' ';
                            echo '<a class="btn btn-success" href="tedupdate.php?id='.$row['id'].'">Update</a>';
                            echo ' ';
                            echo '<a class="btn btn-danger" href="teddelete.php?id='.$row['id'].'">Delete</a>';
							}
							else
							{
							echo '<td>Login required.</td>';
							}
                            echo '</td>';
                            echo '</tr>';
                   }
                   Database::disconnect();
                  ?>
                  </tbody>
            </table>
			<?php
				if ($_SESSION["id"]==$sess_id)
				{
					echo '<p>
                          <a href="tedcreate.php" class="btn btn-success" 
						  style="margin-left:50px;">Create</a>
                          </p>';
				}
			?>
        </div>
    </div> <!-- /container -->
  </body>
</html>