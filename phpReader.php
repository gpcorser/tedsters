<?php
/**
 * filename	: phpReader.php
 * author	: David Roof
 * course	: CIS 355
 * purpose	: This program displays the source code of a php file
 *
 *
*/

 $file = null;
 if ( !empty($_GET['file'])) {
	 $file = $_REQUEST['file'];
	 $file=  str_replace("'","",$file);
	echo highlight_file($file, true);
 }
 else{
	 echo "No File listed";
	 echo "<br>";
	 echo "Source code for phpReader";
	 echo "<br>";
	 echo highlight_file("phpReader.php", true);
 }
?>
