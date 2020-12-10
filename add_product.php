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

if($_SESSION["admin"]==false)
{
	echo '<script>alert("You are not admin. Only admins can view this page.");</script>';
	echo '<script>window.history.back();</script>';
	exit;
}
$target_dir='images/';
$filename=basename($_FILES["pic"]["name"]);
//echo 'Filename = '.$filename.'<br>';
$target_file=$target_dir.$filename;
//echo 'Target file = '.$target_file.'<br>';
if (file_exists($target_file)) 
{
    echo '<script>alert("Sorry, file already exists with this name")</script>';
    echo '<script>window.location.href = "admin.php";</script>';
	exit;	
}


$check_query='SELECT product_id FROM products ORDER BY product_id DESC';
$result = mysqli_query($conn, $check_query);
$row=$result->fetch_assoc();
$p_id = $row['product_id'] + 1;
$add_query= 'INSERT INTO `products` (`product_id`, `product_name`, `category_id`, `date_added`, `description`, `price`,`icon_name`) VALUES ('.$p_id.', \''.$_POST['product_name'].'\', '.$_POST['category_id'].', NOW(), \''.$_POST['description'].'\','.$_POST['price'].',\''.$filename.'\')';


$check_query='SELECT product_id FROM products WHERE product_id='.$p_id;
$result = mysqli_query($conn, $query);
$number_of_rows = $result->num_rows;
if($number_of_rows == 1)
{
		$row=$result->fetch_assoc();
		echo '<script>alert("Product already exists with this ID") </script>';
		echo '<script>window.location.href = "admin.php";</script>';
		exit;
}
else if($number_of_rows == 0)
{
	if (move_uploaded_file($_FILES["pic"]["tmp_name"], $target_file)) 
	{
		//echo "The file ". basename( $_FILES["fileToUpload"][$filename]). " has been uploaded.";
	} 
	else 
	{
		echo '<script>alert("Sorry, there was an error uploading your file. Product not added");</script>';
		echo '<script>window.location.href = "admin.php";</script>';
		exit;
	}

	$add = mysqli_query($conn, $add_query);
	if($add == 1)
	{
		echo '<script>alert("Product has been added");</script>';
		echo '<script>window.location.href = "admin.php";</script>';
		exit;
	}
	else
	{
		echo '<script>alert("Error adding product")</script>';
		echo '<script>window.location.href = "admin.php";</script>';
		exit;
	}
}


?>

</html>