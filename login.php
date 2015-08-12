<?php
	
	// Start the session
	session_start();
	
	// Set an error message
	$error = "";
	
	// If the user pressed the Submit button
	if(isset($_POST['loginSubmit']))
	{
		// This will not be used if successful login
		$error = '<div class="alert alert-danger" role="alert"><b>Login Error:</b> Please enter a valid username and password.</div>';
		
		// Required Database Information
		$dbHost = 'localhost' ;
		$dbUsername = 'gpcorser';
		$dbUserPassword = 'remember';
		$dbName = 'gpcorser' ;
		
		// Entered user information
		$uname = $_POST['username'];
		$pass = $_POST['password'];
		
		// Session Information
		$dataEmail = "";
		$dataPerId = "";
		
		// Create a mysqli object
		$mysqli = new mysqli($dbHost, $dbUsername, $dbUserPassword, $dbName);
		
		// Init statement
		$stmt = $mysqli->stmt_init();
		
		// Create query
		$sql = "SELECT per_email, per_id FROM persons2 
		    WHERE per_email = ? AND per_password = ?";
		
		if($stmt = $mysqli->prepare($sql))
		{
            // Bind params
            $stmt->bind_param('ss', $uname, $pass);

			// Execute statement
            if($stmt->execute())
            {
				// Bind query result to variables
				$stmt->bind_result($dataEmail,$dataPerId);
				
				// Fetch the statement
				if ($stmt->fetch())
				{
					// Set SESSION variable
					$_SESSION['email'] = $dataEmail;
					$_SESSION['per_id'] = $dataPerId;
					
					// Close statement and mysqli object
					$stmt->close();
					$mysqli->close();
					
					// always redirect to per_list.php if login successful
					header('Location: per_list.php');
					exit;
					
					/*
					// If the user came from the login page, direct them to the landing page
					if ($_SERVER['HTTP_REFERER'] == "http://cis355.com/student14/login.php" 
					    || $_SERVER['HTTP_REFERER'] == "http://www.cis355.com/student14/login.php" )
					{
						// Relocate to landing page
						header('Location: landing.php');
						exit;
					}
					
					else
					{
						// Relocate to landing page
						header('Location: '. $_SERVER['HTTP_REFERER']);
						exit;
					}
					*/
				}
			}
                      
            // Close statement
			$stmt->close();
		}
		$mysqli->close();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Teacherati</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.23.1" />
	
	<!-- Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

	<div class="col-md-4"></div>	
	<div class="col-md-4" style="margin-top: 40px;">

		<br/>
		<div class="panel panel-default" style="box-shadow: 2px 2px 7px #888888;">
			<div class="panel-heading"><b>Login</b></div>
				<div class="panel-body">
				<?php
					echo '<form method="POST" action="login.php">
					<input type="text" size="10" name="username" class="form-control" value="'. $uname .'" placeholder="email">
					<input type="password" size="10" name="password" style="margin-top: 5px;" class="form-control" placeholder="password"><br>
					'.$error.'
					<button type="submit" name="loginSubmit" style="width: 100%;" class="btn btn-success">Submit</button>
				</form>';
				?>
				</div>
		</div>		
	</div>
	<div class="col-md-4"></div>
	</div>
	</center>
		<p align="center">
	<a href="phpReader.php?file='<?php echo __FILE__; ?>'" >source code</a>
	</p>
	</body>
	</html>	
		
		