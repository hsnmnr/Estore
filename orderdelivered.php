<!DOCTYPE>
<html>
	<?php
		ini_set('error_reporting', 'E_COMPILE_ERROR|E_RECOVERABLE_ERROR|E_ERROR|E_CORE_ERROR');

		include 'connection.php';
		$conn = OpenCon();

		if (mysqli_connect_errno())	
		{
			echo "Unable to connect to server " . mysqli_connect_error();
		}
		
		session_start();
		if($_SESSION['logged_in'] == false)
		{
			echo '<script>alert("You are not logged in. You must log in as admin to view this page.")</script>';
			echo '<meta http-equiv="refresh" content="0; URL=\'login.php\'" /> ';
			exit;
		}
		
		if($_SESSION['admin'] == false)
		{
			echo '<script>alert("You are not admin. You must be admin to view this page.")</script>';
			echo '<script>window.history.back()</script>';
			exit;
		}
		
		$order = $_GET['order'];
		$query = 'SELECT * from orders where order_id='.$order;
		$result = mysqli_query($conn, $query);
		if($result->num_rows == 0)
		{
			echo '<script>alert("No order found with this ID.")</script>';
			echo '<script>window.history.back()</script>';
			exit;
		}
		else
		{
			$query = 'UPDATE orders SET status=\'delivered\' WHERE order_id='.$order;
			$result = mysqli_query($conn, $query);
			if($result == 1)
			{
				echo '<script>alert("Order status set to delivered.")</script>';
				echo '<script>window.location.href = "admin.php"</script>';
				exit;
			}
		}
		
		
	?>
</html>