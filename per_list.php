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
                <h3 style="margin-left:50px; ">Persons List</h3>
            </div>

            <div class="row">
                <table class="table table-striped table-bordered" style="margin-left:50px; max-width: 800px;">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
					  <th>Institution</th>
					  <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php

					echo '<p>
                          <a href="per_create.php" class="btn btn-success" 
						  style="margin-left:50px;">Create</a>
                          </p>';

                   include 'database.php';
                   $pdo = Database::connect();
                   $sql = 'SELECT * FROM persons2 ORDER BY per_name DESC';
                   foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. $row['per_name'] . '</td>';
                            echo '<td>'. $row['per_email'] . '</td>';
                            echo '<td>'. $row['per_phone'] . '</td>';
							echo '<td>'. $row['per_institution'] . '</td>';
				
							echo '<td><a class="btn" href="per_read.php?id='.$row['per_id'].'">Read</a>';
							echo ' ';
                            echo '<a class="btn btn-success" href="per_update.php?id='.$row['per_id'].'">Update</a>';
                            echo ' ';
                            echo '<a class="btn btn-danger" href="per_delete.php?id='.$row['per_id'].'">Delete</a>';
				
                            echo '</td>';
                            echo '</tr>';
                   }
                   Database::disconnect();
                  ?>
                  </tbody>
            </table>

        </div>
    </div> <!-- /container -->
  </body>
</html>