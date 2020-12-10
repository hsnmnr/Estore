<!DOCTYPE>
<html>
	<script type="text/javascript">
		var store_name = 'E-Store Management System'
		document.title=store_name;
		document.write("<center><h1>",store_name,"<h1></center>");
	</script>
	<?php
		ini_set('error_reporting', 'E_COMPILE_ERROR|E_RECOVERABLE_ERROR|E_ERROR|E_CORE_ERROR');
		
		session_start();
		
		include 'connection.php';
		$conn = OpenCon();
		
		if($_SESSION['admin'] == false)
		{
			echo '<script>alert("You are not admin. Only admins can visit this page");</script>';
			echo '<script>window.history.back();</script>';
			exit;
		}
		if($_SESSION['logged_in'] == false)
		{
			echo '<script>alert("You are not logged. You must login as admin to visit this page");</script>';
			echo '<meta http-equiv="Refresh" content="0; url=login.php">';
			exit;
		}
		$couc=$_POST['cc'];
		$mon=$_POST['ca'];
		$query='SELECT * from coupon WHERE coupon_code=\''.$couc.'\'';
		$result=mysqli_query($conn,$query);
		if($result->num_rows > 0)
		{
			echo '<script>alert("Coupon Code already exists");</script>';
			echo '<script>window.history.back();</script>';
			exit;
		}
		$query='INSERT INTO coupon(coupon_code,money) VALUES(\''.$couc.'\','.$mon.')';
		$result=mysqli_query($conn,$query);
		if($result == 1)
		{
			echo '<script>alert("Coupon Code added");</script>';
			echo '<script>window.history.back();</script>';
			exit;
		}
		else
		{
			echo '<script>alert("Unable to add Coupon Code");</script>';
			echo '<script>window.history.back();</script>';
			exit;
		}
	?>
</html>