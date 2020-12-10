<!DOCTYPE html>
<html>

<script type="text/javascript">
var store_name = 'E-Store Management System'
document.title=store_name;
document.write("<center><h1>",store_name,"<h1></center>");

function showlogin()
{
	$t = document.getElementById('disp_login').style.display="block";
	$tw = document.getElementById('disp_welcome').style.display="none";
}

function hidelogin()
{
	$tt = document.getElementById('disp_login').style.display="none";
	$ttw = document.getElementById('disp_welcome').style.display="block";
}

</script>

<?php 

ini_set('error_reporting', 'E_COMPILE_ERROR|E_RECOVERABLE_ERROR|E_ERROR|E_CORE_ERROR');


$u_fn = $_POST["first_name"];
$u_ln = $_POST["last_name"];
$u_p = $_POST["password"];
$u_cp = $_POST["c_password"];
$u_addr = $_POST["address"];

if(($u_fn == "") || ($u_ln == "") || ($u_p == "") || ($u_cp == "") || ($u_addr == ""))
{
	echo '<script>alert("Error in data. Please re-sign-up");</script>';
	echo '<script>window.history.back();</script>';
	exit;
}

//error_reporting(0);

$full_name=$u_fn.' '.$u_ln;

session_start();

include 'connection.php';
$conn = OpenCon();

if (mysqli_connect_errno())
{
	echo "Unable to connect to server " . mysqli_connect_error();
}

if($_SESSION['logged_in'] == true)
{
	//echo '<div align="right"> <a href="logout.php">Logout </a> </div>';
	//echo 'You must be logged out to sign up <br>';
}

if($u_cp !== $u_p)
{
	echo "Password and Confirm Password fields mismatch <br> ";
	exit;
}

$check="SELECT * FROM userss ORDER BY user_id DESC";
$result = mysqli_query($conn, $check);
$row = $result->fetch_assoc();
$u_id = $row['user_id'];
$u_id = $u_id + 1;

$query = 'SELECT user_id FROM userss WHERE (user_id = '.$u_id.')';
$res = mysqli_query($conn, $query);

$number_rows = $res->num_rows;
$iquery='INSERT INTO userss (user_id,first_name,last_name,password,wallet,address) VALUES(';
$iquery=$iquery.$u_id.",'".$u_fn."','".$u_ln."','".$u_p."',0,'".$u_addr."')";

if($number_rows == 1)
{
		$row=$result->fetch_assoc();
		$pass=$row["password"];
		$fn=$row["first_name"];
		$ln=$row["last_name"];
		$full_name=$fn." ".$ln;
		echo "Account already exists with this username. <br>";
		echo '<script> showlogin() </script>';
		exit;
}
else if($number_rows == 0)
{
		$add = mysqli_query($conn, $iquery);
		if($add == 1)
		{
			echo '<script>alert("'.$u_fn.' '.$u_ln.' Your account has been created. Now you can buy products.\n Your USERNAME/USERID is \''.$u_id.'\'")</script>';
			$_SESSION["admin"]=false;
			$_SESSION["logged_in"]=false;
			$_SESSION["username"]=$u_id;
			$_SESSION["fullname"]=$full_name;
			$_SESSION["wallet"]=0;
			echo '<script>hidelogin() </script>';
			echo '<meta http-equiv="refresh" content="0;url=login.php">';
		}
		else
		{
			echo "Error creating account. Please try again later.<br>";
			echo '<script> showlogin() </script>';
		}
}

?>


</html>
