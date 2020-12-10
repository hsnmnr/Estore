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
		session_start();
		$username=$_SESSION['username'];
		$oldpass=$_POST['oldpassword'];
		$pass=$_POST['newpassword'];
		$confirmpass=$_POST['confirmpassword'];
		$query='SELECT user_id,password from userss where user_id='.$username;
		$result=mysqli_query($conn,$query);
		if($result->num_rows == 0)
		{
			echo 'Invalid Username or Login Session<br>';
			exit;
		}
		$row=$result->fetch_assoc();
		$mypass=$row['password'];
		if($mypass == $oldpass)
		{
			if($pass == $confirmpass)
			{
				$query = 'UPDATE userss SET password = \''.$pass.'\' WHERE user_id='.$username;
				$result=mysqli_query($conn,$query);
				echo '<script>alert("Password updated")</script><br>';
			}
			else
			{
				echo 'New Password and Confirm Password Field Mismatch<br>';
			}
		}
		else
		{
			echo 'Invalid Old Password<br>';
			
		}
	?>
	<meta http-equiv="refresh" content="1;url=myprofile.php">
</html>