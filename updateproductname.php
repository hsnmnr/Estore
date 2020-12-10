<!DOCTYPE>
<html>
	<script type="text/javascript">
		var store_name = 'E-Store Management System'
		document.title=store_name;
		document.write("<center><h1>",store_name,"<h1></center>");
	</script>
	<?php
		ini_set('error_reporting', 'E_COMPILE_ERROR|E_RECOVERABLE_ERROR|E_ERROR|E_CORE_ERROR');
		include 'connection.php';
		$conn = OpenCon();
		session_start();
		if($_SESSION["admin"] === false)
		{
			echo '<script>alert("You are not admin. Only admins can view this page.");</script>';
			echo '<script>window.history.back();</script>';
			exit;
		}
		$productid=$_GET['productid'];
		$name = $_POST['update_pn'];
		$query = 'SELECT * from products where product_id='.$productid;
		$result= mysqli_query($conn,$query);
		$num = $result->num_rows;
		if($num == 1)
		{
			$query = 'UPDATE products SET product_name = \''.$name.'\' WHERE product_id='.$productid;
			$result= mysqli_query($conn,$query);
			if($result == 1)
			{
				echo '<script>alert("Product Name Updated");</script>';
				echo '<script>window.history.back();</script>';
				exit;
			}
			else
			{
				echo '<script>alert("Unable to update product name");</script>';
				echo '<script>window.history.back();</script>';
				exit;
			}
		}
		else
		{
			echo '<script>alert("No product found with this ID");</script>';
			echo '<script>window.history.back();</script>';
			exit;
		}
	?>
</html>