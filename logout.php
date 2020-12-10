<!DOCTYPE>
<html>


<script>
var store_name = 'E-Store Management System'
document.title=store_name;
document.write("<center><h1>",store_name,"<h1></center>");
</script>



<?php
ini_set('error_reporting', 'E_COMPILE_ERROR|E_RECOVERABLE_ERROR|E_ERROR|E_CORE_ERROR');

include 'connection.php';
$conn = OpenCon();

if (mysqli_connect_errno())
{
	echo "Unable to connect to server " . mysqli_connect_error();
}


session_start();
echo "<br> <br>";

if($_SESSION['logged_in'] == true)
{
	$_SESSION["logged_in"] = false;
	session_destroy();
	echo '<script>alert("Logged out")</script>';
	echo '<meta http-equiv="refresh" content="0; URL=\'login.php\'" /> ';
	exit;
}
else
{
	echo '<script>alert("You are not Logged IN")</script>';
	echo '<meta http-equiv="refresh" content="0; URL=\'login.php\'" /> ';
	exit;
}
?>
 
</br>
</br>
 
 

</html>