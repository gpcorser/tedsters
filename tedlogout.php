<?php	
	session_start();
	
	if(isset($_POST['logoutSubmit'])) // If the user pressed the Submit button
	{
        $_SESSION["id"] = "";
		session_destroy();
	}
	header('Location: tedsters.php');

?>