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
		$productid = $_GET['productid'];
		$description = $_POST['descrip'];
		$query = 'SELECT * FROM products WHERE product_id='.$productid;
		$result = mysqli_query($conn,$query);
		if($result->num_rows == 1)
		{
			$query = 'UPDATE products SET description=\''.$description.'\' WHERE product_id='.$productid;
			$result = mysqli_query($conn,$query);
			if($result == 1)
			{
				echo '<script>alert("Product Description Updated");</script>';
				echo '<script>window.history.back();</script>';
				exit;
			}
			else
			{
				echo '<script>alert("Unable to update Product Description");</script>';
				echo '<script>window.history.back();</script>';
				exit;
			}
		}
		else
		{
			echo '<script>alert("No product exists with this Product-ID");</script>';
			echo '<script>window.history.back();</script>';
			exit;
		}
	?>
</html>