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
                <h3 style="margin-left:50px; ">Lessons List</h3>
            </div>

            <div class="row">
                <table class="table table-striped table-bordered" style="margin-left:50px; max-width: 800px;">
                  <thead>
                    <tr>
                      <th>Lesson Name</th>
                      <th>Status</th>
					  <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php

					echo '<p>
                          <a href="les_create.php" class="btn btn-success" 
						  style="margin-left:50px;">Create</a>
                          </p>';

                   include 'database.php';
                   $pdo = Database::connect();
                   $sql = 'SELECT * FROM lessons2 ORDER BY les_name ASC';
                   foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. $row['les_name'] . '</td>';
                            echo '<td>'. $row['les_status'] . '</td>';
				
							echo '<td><a class="btn" href="les_read.php?les_id='.$row['les_id'].'">Read</a>';
							echo ' ';
                            echo '<a class="btn btn-success" href="les_update.php?les_id='.$row['les_id'].'">Update</a>';
                            echo ' ';
                            echo '<a class="btn btn-danger" href="les_delete.php?les_id='.$row['les_id'].'">Delete</a>';
				
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