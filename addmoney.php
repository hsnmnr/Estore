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

		if (mysqli_connect_errno())
		{
			echo "Unable to connect to server " . mysqli_connect_error();
		}

		$coupon=$_POST['coupon'];
		session_start();

		if($_SESSION['logged_in'] == true)
		{
			$un=$_SESSION["fullname"];
			$p=$_POST["password"];
			$wallet=$_SESSION['wallet'];
			$username = $_SESSION["username"];
			echo 'Logged in as '.$un.'<br>';
		}
		else
		{
			echo '<script>alert("You are not logged in. Login to continue") </script>';
			echo '<meta http-equiv="refresh" content="0; URL=\'login.php\'" />';
			exit;
		}
		$query='SELECT coupon_code,money from coupon where coupon_code="'.$coupon.'"';
		$result=mysqli_query($conn,$query);
		if($result->num_rows == 0)
		{
			echo '<script>alert("Invalid coupon");</script>';
			echo '<script>window.history.back();</script>';
		}
		else
		{
			$row=$result->fetch_assoc();
			$money=$row['money'];
			$query='SELECT wallet from userss where user_id='.$username;
			$result=mysqli_query($conn,$query);
			//echo 'Query = '.$query;
			//echo '<br>Username = '.$username.'<br>';
			if($result->num_rows == 0)
			{
				echo '<script>alert("Error finding your session. Login again to continue")</script>';
				echo '<meta http-equiv="refresh" content="0; URL=\'login.php\'" />';
				exit;
			}
			else
			{
				$row = $result->fetch_assoc();
				$wall=$row['wallet'];
				$wall=$wall+$money;
				$_SESSION['wallet']=$wall;
				$query='UPDATE userss SET wallet='.$wall.' WHERE user_id='.$username;
				$result=mysqli_query($conn,$query);
				$query='DELETE from coupon WHERE coupon_code=\''.$coupon.'\'';
				$result=mysqli_query($conn,$query);
				$print = 'Money added Rs.'.$money.' Total amount = '.$wall;
				echo '<script>alert("'.$print.'");</script>';
				echo '<meta http-equiv="refresh" content="0; URL=\'ehome.php\'" />';
			}
		}
	?>
</html>