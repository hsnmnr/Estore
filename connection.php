<?php
ini_set('error_reporting', 'E_COMPILE_ERROR|E_RECOVERABLE_ERROR|E_ERROR|E_CORE_ERROR');

function OpenCon()
{
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$db = "testdb";
$conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Unable to connect to server. <br> Error:: %s\n". $conn -> error);

if (mysqli_connect_errno())
  {
	echo "Unable to connect to server " . mysqli_connect_error();
  }
return $conn;
}	 
    function CloseCon($conn)
     {
     $conn -> close();
     }
       
?> 