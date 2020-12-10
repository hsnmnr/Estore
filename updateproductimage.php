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
		$target_dir='images/';
		$filename=basename($_FILES["pic"]["name"]);
		$target_file=$target_dir.$filename;
		if (file_exists($target_file)) 
		{
			echo '<script>alert("Sorry, file already exists with this name")</script>';
			echo '<script>window.history.back();</script>';
			exit;	
		}
		
		$query='SELECT icon_name FROM products WHERE product_id='.$productid;
		$result = mysqli_query($conn,$query);
		$num = $result->num_rows;
		if($num == 0)
		{
			echo '<script>alert("Invalid Product ID")</script>';
			echo '<script>window.history.back();</script>';
			exit;
		}
		$row = $result->fetch_assoc();
		$old_filename = $row['icon_name'];
		if (move_uploaded_file($_FILES["pic"]["tmp_name"], $target_file)) 
		{
			//echo "The file ". basename( $_FILES["fileToUpload"][$filename]). " has been uploaded.";
			unlink('images/'.$old_filename);
			$query = 'UPDATE products SET icon_name=\''.$filename.'\' WHERE product_id='.$productid;
			$result = mysqli_query($conn,$query);
			echo '<script>alert("Product Image Updated");</script>';
			echo '<script>window.history.back();</script>';
			exit;
		
		} 
		else 
		{
			echo '<script>alert("Sorry, there was an error uploading your file. Product not added");</script>';
			echo '<script>window.history.back();</script>';
			exit;
		}
		

	?>
</html>