<!DOCTYYPE>
<html>
	<?php
		ini_set('error_reporting', 'E_COMPILE_ERROR|E_RECOVERABLE_ERROR|E_ERROR|E_CORE_ERROR');
		include 'connection.php';
		$conn = OpenCon();

		$username=$_GET['username'];
		$query='SELECT * FROM userss where user_id='.$username;
		$result=mysqli_query($conn,$query);
		if($result->num_rows == 1)
		{
			$query='DELETE FROM userss WHERE user_id='.$username;
			$result=mysqli_query($conn,$query);
			if($result == 1)
			{
				$query='DELETE from cart where user_id='.$username;
				$result=mysqli_query($conn,$query);
				echo '<script>alert("Customer account has been removed.");</script>';
				$_SESSION['refresh']=true;
				echo '<script> window.location.href = "admin.php";</script>';
				exit;
			}
			else
			{
				echo '<script>alert("Unable to remove account")</script>';
			}
		}
		else
		{
			echo '<script>alert("No user found with this USERID");</script>';
		}
		echo '<script>window.history.back()</script>';
	?>
</html>