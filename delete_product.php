<!DOCTYPE>
<html>

<?php
ini_set('error_reporting', 'E_COMPILE_ERROR|E_RECOVERABLE_ERROR|E_ERROR|E_CORE_ERROR');


include 'connection.php';
$conn = OpenCon();
$sconn = OpenCon();

if (mysqli_connect_errno())	
{
	echo "Unable to connect to server " . mysqli_connect_error();
}


if($_GET['product_id'] == "")
{
	$product_id = $_POST['product_id'];
}
else if($_POST['product_id'] == "")
{
	$product_id = $_GET['product_id'];
}

session_start();
if($_SESSION['admin'] == false)
{
	echo '<script>alert("You are not admin. You must be admin to view this page.")</script>';
	echo '<script>window.history.back()</script>';
	exit;
}

$check_query='SELECT * FROM products WHERE product_id = '.$product_id;
$delete_query='DELETE FROM products WHERE product_id = '.$product_id;


$result = mysqli_query($conn, $check_query);
$number_of_rows = 1;
$number_of_rows = $result->num_rows;
if($number_of_rows == 1)
{
		$row=$result->fetch_assoc();
		$fileimage='images/'.$row['icon_name'];
		
		$delete = mysqli_query($conn, $delete_query);
		if($delete == 1)
		{
			unlink($fileimage);
			$query = 'SELECT user_id,total FROM cart WHERE product_id='.$product_id;
			$result = mysqli_query($conn, $query);
			while($row = $result->fetch_assoc())
			{
				$us_id = $row['user_id'];
				$squery = 'SELECT wallet FROM userss WHERE user_id='.$us_id;
				$sresult = mysqli_query($sconn,$squery);
				$srow = $sresult->fetch_assoc();
				$am=$row['total'];
				$wallet=$srow['wallet'];
				$wallet = $wallet + $am;
				$squery = 'UPDATE userss SET wallet='.$wallet.' WHERE user_id='.$us_id;
				$s_result = mysqli_query($sconn, $squery);
			}
			echo '<script>alert("Product has been removed"); </script>';
			echo '<meta http-equiv="refresh" content="0; URL=\'admin.php\'" /> ';
			exit;
		}
		else
		{
			echo '<script>alert("Error removing product"); </script>';
			echo '<script>window.history.back();</script>';
			exit;
		}
		
}
else if($number_of_rows == 0)
{
		echo '<script>alert("No Product exists with this ID"); </script>';
		echo '<script>window.history.back();</script>';
		exit;
}


?>

</html>