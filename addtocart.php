<!DOCTYPE>
<html>
	<script type="text/javascript">
		function goback()
		{
			window.history.back();
		}
	</script>
	<?php
		ini_set('error_reporting', 'E_COMPILE_ERROR|E_RECOVERABLE_ERROR|E_ERROR|E_CORE_ERROR');

		include 'connection.php';
		$conn = OpenCon();

		session_start();

		if($_SESSION['logged_in'] == false)
		{
			echo '<sctipt>alert("You are not logged in. You must login to continue. ")</script>.';
			echo '<meta http-equiv="refresh" content="0; URL=\'login.php\'" />';
			exit;
		}
		$user_name=$_SESSION['username'];
		$query='SELECT wallet from userss where user_id='.$user_name;
		$result=mysqli_query($conn,$query);
		$row=$result->fetch_assoc();
		$wallet=$row['wallet'];
		$_SESSION['wallet']=$wallet;
		
		$product_id = $_GET['product_id'];
		$quantity = $_POST['quantity'];
		$print_pro = 'Product ID = '.$product_id.' \n Quantity   = '.$quantity.' \n ';
		$query = 'SELECT price from products where product_id='.$product_id;
		$result=mysqli_query($conn,$query);
		$row=$result->fetch_assoc();
		$price=$row['price'];
		$print_pro = $print_pro.'Price = '.$price.' \n ';
		$total = $price*$quantity;
		$ttotal=$total;
		$print_pro = $print_pro.'Total Price = '.$total.' \n ';
		if($ttotal > $wallet)
		{
			echo '<script> alert("You don\'t have enough money. Please recharge your account to buy products.");</script>';
			echo '<script>window.history.back();</script>';
			exit;
		}
		$query='SELECT quantity,total from cart WHERE user_id='.$user_name.' AND product_id='.$product_id;
		$result=mysqli_query($conn,$query);
		if($result->num_rows == 1)
		{
			$row=$result->fetch_assoc();
			$q=$row['quantity'];
			$t=$row['total'];
			$quantity=$quantity+$q;
			$total=$total+$t;
			$query='DELETE from cart WHERE user_id='.$user_name.' AND product_id='.product_id;
			$deleteresult=mysqli_query($conn,$query);
		}
		$query='INSERT INTO cart (user_id,product_id,quantity,total) VALUES('.$user_name.','.$product_id.','.$quantity.','.$total.')';
		$result=mysqli_query($conn,$query);
		$wallet=$wallet-$ttotal;
		$_SESSION['wallet']=$wallet;
		$query='UPDATE userss SET wallet='.$wallet.' WHERE user_id = '.$user_name;
		$result=mysqli_query($conn,$query);
		echo '<script>alert("'.$print_pro.' \n Product Added");</script>';

		echo '<meta http-equiv="refresh" content="0; URL=\'ehome.php\'" /> ';		
	?>
	
	
</html>