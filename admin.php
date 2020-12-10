<!DOCTYPE>
<html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<title>Admin Portal</title>
<?php
ini_set('error_reporting', 'E_COMPILE_ERROR|E_RECOVERABLE_ERROR|E_ERROR|E_CORE_ERROR');

$un=$_POST["user_name_a"];
$p=$_POST["password_a"];

include 'connection.php';
$conn = OpenCon();

if (mysqli_connect_errno())
{
	echo "Unable to connect to server " . mysqli_connect_error();
}

session_start();
			
if($_SESSION['logged_in'] == true)
{
	if($_SESSION["admin"]==false)
	{
		echo '<script>alert("You are not admin. Only admins can view this page.");</script>';
		echo "<meta http-equiv='refresh' content='0; URL=welcome.php'>";
		exit;
	}
	$full_name = $_SESSION['fullname'];
			
}
else
{
 
	$query = "SELECT * FROM admins WHERE user_id = ";
	$query=$query.$un;
	$result = mysqli_query($conn, $query);
	//echo $result;
	$number_of_rows = $result->num_rows;
	if($number_of_rows == 1)
	{
			$row=$result->fetch_assoc();
			$pass=$row["password"];
			$fn=$row["first_name"];
			$ln=$row["last_name"];
			$full_name=$fn." ".$ln;
			if($p == $pass)
			{
				$_SESSION["admin"]=true;
				$_SESSION["logged_in"]=true;
				$_SESSION["username"]=$un;
				$_SESSION["fullname"]=$full_name;
			}
			else
			{
				echo '<script>alert("Invalid Password") </script>';
				echo '<meta http-equiv="refresh" content="0; URL=\'login.php\'" /> ';
				exit;
			}
	}
	else
	{
		echo '<script>alert("Invalid User_ID") </script>';
		echo '<meta http-equiv="refresh" content="0; URL=\'login.php\'" /> ';
		exit;
	}
	
	// output data of each row
	$result = mysqli_query($conn, $query);
} 

if($_SESSION['refresh'] == true)
{
	echo '<meta http-equiv="refresh" content="0" /> ';
	$_SESSION['refresh'] = false;
}
?>

<head><link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous"></head>

<style type="text/css">
  @charset "UTF-8";
@import url(https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,400italic);

html {
  box-sizing: border-box;
}


body {
  background: #f1f2f7;
  font-family: "Open Sans", arial, sans-serif;
  color: darkslategray;
}

body.login {
  background-color: white;
  max-width: 500px;
  margin: 10vh auto;
  padding: 1em;
  height: auto;
}

#custblock
{
  float:center;
  width: 25%;
  height: 8%;
  font-size: 40px;
  text-align: center;
}
#productblock
{
  height: 8%;
  float:center;
  width: 20%;
  text-align: center;
}
#addblock
{
  float:left;
  margin-bottom: 1em;
  width: 20%;
}
#cupontxt, #cuponnum
{
  justify-content: center;
  text-align: center;
  width :50%;
  height: 8%;
  font-size: 40px;
}


/* header */
header[role ="banner"] {
  background: white;
  box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.15);
}
header[role ="banner"] h1 {
  margin: 0;
  font-weight: 300;
  padding: 1rem;
}
header[role="banner"]
{
  padding-right: 0.6em;
  color: red;
}
header[role="banner"] .utilities {
  width: 100%;
  background: slategray;
  color: #ddd;
}
header[role="banner"] .utilities li {
  border-bottom: solid 1px rgba(255, 255, 255, 0.2);
}
header[role="banner"] .utilities li a {
  padding: 0.7em;
  display: block;
}

/* header */


.dropdown-customer-btn, .dropdown-order-btn, .dropdown-products-btn, .dropdown-coupon-btn
{
  border:none;
  text-align: left;
  margin: 0;
  width:100%;
  background: #2a3542;
  color: #ddd;
  border-bottom: 1px solid rgba(255, 255, 255, 0.08);
  padding: 0.7em;
}
.customercontainter, .ordercontainter, .productscontainer, .couponcontainer
{
  display: none;
  background-color: #262626;
  padding-left: 8px;
}
.fa-caret-down
{
  float: right;
  padding-right: 8px;
  margin-top: 4px;
}

nav[role="navigation"]{
  background: #2a3542;
  color: #ddd;
  /* icons */
}
nav[role="navigation"] li {
  border-bottom: 1px solid rgba(255, 255, 255, 0.08);

}
nav[role="navigation"] li a {
  color: #ddd;
  text-decoration: none;
  display: block;
  padding: 0.7em;
}
nav[role="navigation"] li a, .dropdown-customer-btn, .dropdown-order-btn, .dropdown-products-btn, .dropdown-coupon-btn {
  cursor:pointer;
  color: #ddd;
  background-color: rgba(255, 255, 255, 0.05);
}

.active {
  background-color: green;
  color: white;
}
.active2 
{
  background-color: red;
  color: white;
}

nav[role="navigation"] li a:hover, .dropdown-customer-btn:hover, .dropdown-order-btn:hover, .dropdown-products-btn:hover, .dropdown-coupon-btn:hover {
  background-color: green;
}


.dashboard
{
  background-color: rgba(255, 255, 255);
}

a {
  text-decoration: none;
  color: inherit;
}

ul,
li {
  list-style-type: none;
  margin: 0;
  padding: 0;
}

main li {
  display: flex;
  position: relative;
  padding-left: 1.2em;
  margin: 0.5em 0;
}

form input,
form textarea,
form select {
  width: 100%;
  display: block;
  border: solid 1px #dde;
  padding: 0.5em;
}

form label,
form legend {
  display: block;
  margin: 1em 0 0.5em;
}

form input[type = "submit"] 
{
  background: #ff1a1a;
  border: none;
  border-bottom: solid 4px #e60000;
  padding: 0.7em 3em;
  margin: 1em 0;
  color: white;
  text-shadow: 0 -1px 0 #e60000;
  font-size: 1.1em;
  font-weight: bold;
  display: inline-block;
  width: auto;
  -webkit-border-radius: 0.5em;
  -moz-border-radius: 0.5em;
  -ms-border-radius: 0.5em;
  border-radius: 0.5em;
}

form input[type="submit"]:hover 
{
  background: turquoise;
  border: none;
  border-bottom: solid 4px #21ccbb;
  padding: 0.7em 3em;
  margin: 1em 0;
  color: white;
  text-shadow: 0 -1px 0 #21ccbb;
  font-size: 1.1em;
  font-weight: bold;
  display: inline-block;
  width: auto;
  -webkit-border-radius: 0.5em;
  -moz-border-radius: 0.5em;
  -ms-border-radius: 0.5em;
  border-radius: 0.5em;
}

table {
  border-collapse: collapse;
  width: 96%;
  margin: 2%;
}

th {
  text-align: left;
  font-weight: 400;
  font-size: 13px;
  text-transform: uppercase;
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
  padding: 0 10px;
  padding-bottom: 14px;
}

tr:not(:first-child):hover {
  background: rgba(0, 0, 0, 0.1);
}

td 
{
  line-height: 40px;
  font-weight: 300;
  padding: 0 10px;
}

@media screen and (min-width: 600px) {
  html,
  body {
    height: 100%;
  }

  header[role="banner"] {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 99;
    height: 75px;
  }
  header[role="banner"] .utilities {
    position: absolute;
    top: 0;
    right: 0;
    background: transparent;
    color: darkslategray;
    width: auto;
  }
  header[role="banner"] .utilities li {
    display: inline-block;
  }
  header[role="banner"] .utilities li a {
    padding: 0.5em 1em;
  }

  nav[role="navigation"] {
    position: fixed;
    width: 200px;
    top: 75px;
    bottom: 0px;
    left: 0px;
  }

  main[role="main"] 
  {
    margin: 75px 0 40px 200px;
  }
  main[role="main"]:after {
    content: "";
    display: table;
    clear: both;
  }

  .panel {
    margin: 2% 0 0 2%;
    float: left;
    width: 96%;
  }

@media screen and (min-width: 900px) {
  footer[role="contentinfo"] {
    position: fixed;
    width: 100%;
    bottom: 0;
    left: 0px;
    margin: 0;
  }

  .panel 
  {
    width: 47%;
    clear: none;
  }
  .panel.important {
    width: 96%;
  }
  .panel.secondary 
  {
    width: 23%;
  }
  .logout
  {
    color:red;
  }




</style>



<script type="text/javascript">

  function showfield(name)
  {
    if(name == 'view_customers')
    {
      document.getElementById('vao').style.display='none';
      document.getElementById('vpo').style.display='none';
      document.getElementById('vp').style.display='none';
      document.getElementById('addcoup').style.display='none';
      document.getElementById('cp').style.display='none';
      document.getElementById('viewcou').style.display='none';
      document.getElementById('dc').style.display='none';
      document.getElementById('ap').style.display='none';
      document.getElementById('rp').style.display='none';
      document.getElementById('vc').style.display='block';
    }
    else if(name == 'delete_customer')
    {
      document.getElementById('vao').style.display='none';
      document.getElementById('vpo').style.display='none';
      document.getElementById('addcoup').style.display='none';
      document.getElementById('vp').style.display='none';
      document.getElementById('viewcou').style.display='none';
      document.getElementById('cp').style.display='none';
      document.getElementById('dc').style.display='block';
      document.getElementById('ap').style.display='none';
      document.getElementById('rp').style.display='none';
      document.getElementById('vc').style.display='none';
    }
    else if(name == 'add_product')
    {
      document.getElementById('viewcou').style.display='none';
      document.getElementById('vao').style.display='none';
      document.getElementById('vpo').style.display='none';
      document.getElementById('vp').style.display='none';
      document.getElementById('addcoup').style.display='none';
      document.getElementById('cp').style.display='none';
      document.getElementById('dc').style.display='none';
      document.getElementById('ap').style.display='block';
      document.getElementById('rp').style.display='none';
      document.getElementById('vc').style.display='none';
    }
    else if(name == 'remove_product')
    {
      document.getElementById('vao').style.display='none';
      document.getElementById('vpo').style.display='none';
      document.getElementById('viewcou').style.display='none';
      document.getElementById('addcoup').style.display='none';
      document.getElementById('vp').style.display='none';
      document.getElementById('dc').style.display='none';
      document.getElementById('ap').style.display='none';
      document.getElementById('rp').style.display='block';
      document.getElementById('vc').style.display='none';
      document.getElementById('cp').style.display='none';
    }
    else if(name == 'change_password')
    {
      document.getElementById('vao').style.display='none';
      document.getElementById('vpo').style.display='none';
      document.getElementById('addcoup').style.display='none';
      document.getElementById('vp').style.display='none';
      document.getElementById('viewcou').style.display='none';
      document.getElementById('dc').style.display='none';
      document.getElementById('ap').style.display='none';
      document.getElementById('cp').style.display='block';
      document.getElementById('vc').style.display='none';
      document.getElementById('rp').style.display='none';
    }
    else if(name == 'view_products')
    {
      document.getElementById('vao').style.display='none';
      document.getElementById('vpo').style.display='none';
      document.getElementById('addcoup').style.display='none';
      document.getElementById('rp').style.display='none';
      document.getElementById('viewcou').style.display='none';
      document.getElementById('dc').style.display='none';
      document.getElementById('ap').style.display='none';
      document.getElementById('cp').style.display='none';
      document.getElementById('vc').style.display='none';
      document.getElementById('vp').style.display='block';
    }
    else if(name == 'add_coupon')
    {
      document.getElementById('vao').style.display='none';
      document.getElementById('vpo').style.display='none';
      document.getElementById('rp').style.display='none';
      document.getElementById('dc').style.display='none';
      document.getElementById('viewcou').style.display='none';
      document.getElementById('ap').style.display='none';
      document.getElementById('cp').style.display='none';
      document.getElementById('vc').style.display='none';
      document.getElementById('vp').style.display='none';
      document.getElementById('addcoup').style.display='block';
    }
    else if(name == 'view_all_orders')
    {
      document.getElementById('viewcou').style.display='none';
      document.getElementById('addcoup').style.display='none';
      document.getElementById('vpo').style.display='none';
      document.getElementById('rp').style.display='none';
      document.getElementById('dc').style.display='none';
      document.getElementById('ap').style.display='none';
      document.getElementById('cp').style.display='none';
      document.getElementById('vc').style.display='none';
      document.getElementById('vp').style.display='none';
      document.getElementById('vao').style.display='block';
    }
    else if(name == 'view_pending_orders')
    {
      document.getElementById('viewcou').style.display='none';
      document.getElementById('addcoup').style.display='none';
      document.getElementById('vao').style.display='none';
      document.getElementById('rp').style.display='none';
      document.getElementById('dc').style.display='none';
      document.getElementById('ap').style.display='none';
      document.getElementById('cp').style.display='none';
      document.getElementById('vc').style.display='none';
      document.getElementById('vp').style.display='none';
      document.getElementById('vpo').style.display='block';
    }
    else if(name == 'view_coupon')
    {
      document.getElementById('addcoup').style.display='none';
      document.getElementById('vao').style.display='none';
      document.getElementById('rp').style.display='none';
      document.getElementById('dc').style.display='none';
      document.getElementById('ap').style.display='none';
      document.getElementById('cp').style.display='none';
      document.getElementById('vc').style.display='none';
      document.getElementById('vp').style.display='none';
      document.getElementById('vpo').style.display='none';
      document.getElementById('viewcou').style.display='block';
    }
  }
  
  function hidefield()
  {
    document.getElementById('vao').style.display='none';
    document.getElementById('vpo').style.display='none';
    document.getElementById('dc').style.display='none';
    document.getElementById('vp').style.display='none';
    document.getElementById('ap').style.display='none';
    document.getElementById('viewcou').style.display='none';
    document.getElementById('rp').style.display='none';
    document.getElementById('addcoup').style.display='none';
    document.getElementById('vc').style.display='block';
    document.getElementById('cp').style.display='none';
  }
  
  function checkpass()
  {
    var passx=document.getElementById('passaa').value;
    var passy=document.getElementById('passbb').value;
    var passo=document.getElementById('oldppa').value;
    if(passx == "" || passy == "" || passo == "")
    {
      document.getElementById('chpp').disabled = true;
    }
    else
    {
      if(passx == passy && passx != "")
      {
        document.getElementById('chpp').disabled = false;
        document.getElementById('notmat').style.display = "none";
        document.getElementById('mat').style.display = "block";
      }
      else if(passx == "" && passy == "")
      {
        document.getElementById('chpp').disabled = true;
        document.getElementById('notmat').style.display = "none";
        document.getElementById('mat').style.display = "none";
      }
      else
      {
        document.getElementById('chpp').disabled = true;
        document.getElementById('notmat').style.display = "block";
        document.getElementById('mat').style.display = "none";
      }
    }
  }
  
    function showhidepass()
  {
    var x=document.getElementById("passaa");
    if(x.type == "password")
    {
      x.type="text";
    }
    else if(x.type == "text")
    {
      x.type="password";
    }
  }

function confirmdeletionproduct()
  {
  var che=confirm("This will remove the selected product. Are you sure?");
  if(che == true)
  {
    return true;
  }
  return false;
  }
  
  
  function confirmdeletioncustomer()
  {
  var che=confirm("This will remove the selected customer. Are you sure?");
  if(che == true)
  {
    return true;
  }
  return false;
  }
  
  function updateorder()
  {
  var che=confirm("This will change order to delivered status. Are you sure?");
  if(che == true)
  {
    return true;
  }
  return false;
  }
  
 
  
  function confirmfield(f1,f2,subbutton)
  {
    var a=document.getElementById(f1).value;
    var b=document.getElementById(f2).value;
    if(a=="" || b == "")
    {
      document.getElementById(subbutton).disabled = true;
    }
    else
    {
      document.getElementById(subbutton).disabled = false;
    }
  }


</script>




<header role="banner">
  <h1> <i style="color:#332F2F;" class="fas fa-user-lock"></i> Admin Portal</h1>
  <ul class="utilities">
    <br>
    <li class="users">
      <?php
      echo $full_name;

      ?>
    </a></li>
    <li class="logout"><a href="logout.php"><i class="fas fa-sign-out-alt" style =" margin-right: 4px"></i>Log Out</a></li>
  </ul>
</header>

<nav role='navigation'>
  <ul class="main">


    <li style="padding: 0.5em 1em;"><i class="fas fa-clipboard" style=" margin-right: 8px"></i> Dashboard</li>

    <button class="dropdown-customer-btn" onclick="changecustomercarret();"><i class="fas fa-users" style =" margin-right: 8px"></i><font size="3">Customer</font><i class="fa fa-caret-down" id="customercarret"></i>
    </button>

    <div class = "customercontainter">

    <li class = "viewcustomer"><a href="#">View Customers</a></li>
    <li class = "deletecustomer"><a href="#">Delete Customer</a></li>




<script>



$('.viewcustomer').click(function()
{
  showfield('view_customers');
});

$('.deletecustomer').click(function()
{
  showfield('delete_customer');
});




function changecustomercarret() {
   var element = document.getElementById("customercarret");

   element.classList.toggle("fa-caret-up");
}




        /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
        var dropdown = document.getElementsByClassName("dropdown-customer-btn");
        var i;
        for (i = 0; i < dropdown.length; i++) 
        {
          dropdown[i].addEventListener("click", function() 
          {
          this.classList.toggle("active");

          var dropdownContent = this.nextElementSibling;

          if (dropdownContent.style.display === "block") 
          {
          dropdownContent.style.display = "none";
          } 
          else 
          {
          dropdownContent.style.display = "block";
          }
          });
        }
    </script>

  </div>

    <button class="dropdown-order-btn" onclick="changeordercarret()"><font size="3"> <i class="fas fa-shipping-fast" style="margin-right: 8px;"></i>Orders</font><i class="fa fa-caret-down" id="ordercarret"></i>
    </button>

    <div class = "ordercontainter">

    <li class="view_all_orders"><a href="#">View All Orders</a></li>
    <li class="view_pending"><a href="#">All Pending Orders</a></li>

    <script>
$('.view_pending').click(function()
{
  showfield('view_pending_orders');
});

$('.view_all_orders').click(function()
{
  showfield('view_all_orders');
});



    function changeordercarret() {
   var element = document.getElementById("ordercarret");

   element.classList.toggle("fa-caret-up");
}

        /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
        var dropdown = document.getElementsByClassName("dropdown-order-btn");
        var i;
        for (i = 0; i < dropdown.length; i++) 
        {
          dropdown[i].addEventListener("click", function() 
          {
          this.classList.toggle("active");

          var dropdownContent = this.nextElementSibling;

          if (dropdownContent.style.display === "block") 
          {
          dropdownContent.style.display = "none";
          } 
          else 
          {
          dropdownContent.style.display = "block";
          }
          });
        }
    </script>

  </div>

    <button class="dropdown-products-btn" onclick="changeproductcarret()"><font size="3"> <i class="fas fa-tshirt" style="margin-right: 8px;"></i> Products</font><i class="fa fa-caret-down" id="productscarret"></i>
    </button>

    <div class = "productscontainer">

    <li class = "view_products"><a href="#">View Products</a></li>
    <li class = "add_products"><a href="#">Add Products</a></li>
    <li class = "remove_product"><a href="#">Remove Products</a></li>

    <script>
$('.view_products').click(function()
{
  showfield('view_products');
});
$('.add_products').click(function()
{
  showfield('add_product');
});
$('.remove_product').click(function()
{
  showfield('remove_product');
});



function changeproductcarret(){
   var element = document.getElementById("productscarret");

   element.classList.toggle("fa-caret-up");
 }



        /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
        var dropdown = document.getElementsByClassName("dropdown-products-btn");
        var i;
        for (i = 0; i < dropdown.length; i++) 
        {
          dropdown[i].addEventListener("click", function() 
          {
          this.classList.toggle("active");

          var dropdownContent = this.nextElementSibling;

          if (dropdownContent.style.display === "block") 
          {
          dropdownContent.style.display = "none";
          } 
          else 
          {
          dropdownContent.style.display = "block";
          }
          });
        }
    </script>

  </div>


    <button class="dropdown-coupon-btn" onclick="changecouponcarret()"><font size="3"><i class="fas fa-money-check-alt"style="margin-right: 8px;"></i>Coupon</font><i class="fa fa-caret-down" id="couponcarret"></i>
    </button>

    <div class = "couponcontainer">

    <li class = "add_coupon"><a href="#">Add New Coupon</a></li>
    <li class = "view_coupon"><a href="#">View Coupons</a></li>

    <script>

$('.add_coupon').click(function()
{
  showfield('add_coupon');
});
$('.view_coupon').click(function()
{
  showfield('view_coupon');
});


            function changecouponcarret(){
               var element = document.getElementById("couponcarret");

               element.classList.toggle("fa-caret-up");
             }



        /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
        var dropdown = document.getElementsByClassName("dropdown-coupon-btn");
        var i;
        for (i = 0; i < dropdown.length; i++) 
        {
          dropdown[i].addEventListener("click", function() 
          {
          this.classList.toggle("active");

          var dropdownContent = this.nextElementSibling;

          if (dropdownContent.style.display === "block") 
          {
          dropdownContent.style.display = "none";
          } 
          else 
          {
          dropdownContent.style.display = "block";
          }
          });
        }



    </script>

  </div>   

  <li class = "change_password"><a href="#"><i class="fas fa-key" style=" margin-right: 8px"></i>Change Password</a></li>
  <script>
    $('.change_password').click(function()
    {
      showfield('change_password');
    });
  </script>
  </ul>
</nav>

<main role="main">
  
  <section class="panel important">
   

<body onload="hidefield()">

  <div id="dc" style="display: none">
	  <form method="POST" action="delete_customer.php" >
		  <center>
				<input type="text" min="0" name="user_id" placeholder="Enter User ID"/> </br>
				<input type="submit"  value="Delete Customer Account" />
		  </center>
	   </form>
  </div>
  
 <div id="ap" style="display: none">
	  <form method="POST" action="add_product.php" enctype="multipart/form-data">
		  <center>
				<input type="text" name="product_name" placeholder="Product Name"/>  </br>
				<input type="text" min="0" name="category_id" placeholder="Category ID"/>  </br>
				<textarea rows = "10" cols = "16" name = "description" placeholder="Description"></textarea> </br>
				<input type="text" min="0" name="price" placeholder="Price"/>  </br>
				<input type="FILE" name ="pic" accept="image/*" value="Go"> </br>
				<input type="submit"  value="Add Product" />
		   </center>
	   </form>
  </div>
   
  <div id="rp" style="display: none">
  <form method="POST" action="delete_product.php" >
  <center>
  <input type="text" id="productblock" min="0" name="product_id" placeholder="Enter Product ID"/> </br>
  <input type="submit"  value="Delete Product" />
   </center>
   </form>
  </div>
  
  <div id="cp" style="display:none">
  <center>
  <form method="POST" action="updateadminpassword.php" >
  <input type="password" id="oldppa" required name="oldpassword" placeholder="Enter Old Password" onchange="checkpass();" onkeyup="checkpass();" /> </br>
  <input type="password" id="passaa" required name="newpassword" placeholder="Enter New Password" onchange="checkpass();" onkeyup="checkpass();"  /> </br>
  <input type="password" id="passbb" required name="confirmpassword" placeholder="Confirm New Password" onchange="checkpass();" onkeyup="checkpass();" /> <div id="notmat" style="color:rgb(255,0,0);display:none"> Password Not Matching </div><div id="mat" style="color:rgb(0,255,0);display:none"> Password Matching </div> </br>
  <input type="checkbox" id="showpass" onchange="showhidepass()"> Show Password </br>
  <input type="submit" id="chpp" disabled value="Change Password" />
  </form>
  </center>
  </div>

  <div id="vp" style="display:none">
  <center>
  <table>
    <tr>
    <th>Product ID</th>
    <th>Product Name</th>
    <th>Category ID</th>
    <th>Category Name</th>
    <th>Price</th>
    <th>Description</th>
    </tr>
    <?php
      $users='SELECT products.product_id,products.product_name,products.category_id,category.category_name,products.price,products.description FROM products,category WHERE category.category_id=products.category_id';
      $result = mysqli_query($conn,$users);
      if($result->num_rows == 0)
      {
        echo "No products found. <br>.";
      }
      else
      {
        while($row = $result->fetch_assoc())
        {
          $prid=$row['product_id'];
          $prn=$row['product_name'];
          $prcid=$row['category_id'];
          $prcn=$row['category_name'];
          $prpr=$row['price'];
          $prdes=$row['description'];
          $prdesc=substr($prdes,0,20);
          $prdesc=$prdesc.'...';
          $pr_id='<a href="product_edit.php?productid='.$prid.'&"><font color=rgb(255,255,255)>'.$prid.'</font></a>';
          $pr_n='<a href="product_edit.php?productid='.$prid.'&"><font color=rgb(255,255,255)>'.$prn.'</a></font>';
          $pr_cid='<a href="product_edit.php?productid='.$prid.'&"><font color=rgb(255,255,255)>'.$prcid.'</a></font>';
          $pr_cn='<a href="product_edit.php?productid='.$prid.'&"><font color=rgb(255,255,255)>'.$prcn.'</a></font>';
          $pr_pr='<a href="product_edit.php?productid='.$prid.'&"><font color=rgb(255,255,255)>'.$prpr.'</a></font>';
          $pr_des='<a href="product_edit.php?productid='.$prid.'&"><font color=rgb(255,255,255)>'.$prdesc.'</a></font>';
          echo '<tr><td>'.$pr_id.'</td><td>'.$pr_n.'</td><td>'.$pr_cid.'</td><td>'.$pr_cn.'</td><td>'.$pr_pr.'</td><td>'.$pr_des.'</td> </tr>';
          
        }
      }
    ?>
  </table>
  </center>
  </div>

  <div id="vc" style="display: none"> 
  <center>
  <table>
    <tr>
    <th>User ID</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Password</th>
    <th>Address</th>
    </tr>
    <?php
      $users='SELECT * FROM userss';
      $result = mysqli_query($conn,$users);
      if($result->num_rows == 0)
      {
        echo "No customer found. <br>.";
      }
      else
      {
        while($row = $result->fetch_assoc())
        {
          $r_id=$row['user_id'];
          $r_fn=$row['first_name'];
          $r_ln=$row['last_name'];
          $r_password=$row['password'];
          $r_address=$row['address'];
          $user_id_a='<a href="javascript:var z=confirmdeletioncustomer(); if(z == true){window.location.href = \'removecustomerfromid.php?username='.$r_id.'&\';} "><font color=rgb(255,255,255)>'.$r_id.'</font></a>';
          $fn_a='<a href="javascript:var s=confirmdeletioncustomer(); if(s == true){window.location.href = \'removecustomerfromid.php?username='.$r_id.'&\';}"><font color=rgb(255,255,255)>'.$r_fn.'</a></font>';
          $ln_a='<a href="javascript:var t=confirmdeletioncustomer(); if(t == true){window.location.href = \'removecustomerfromid.php?username='.$r_id.'&\';}"><font color=rgb(255,255,255)>'.$r_ln.'</a></font>';
          $pass_a='<a href="javascript:var q=confirmdeletioncustomer(); if(q == true){window.location.href = \'removecustomerfromid.php?username='.$r_id.'&\';}"><font color=rgb(255,255,255)>'.$r_password.'</a></font>';
          $address_a='<a href="javascript:var q=confirmdeletioncustomer(); if(q == true){window.location.href = \'removecustomerfromid.php?username='.$r_id.'&\';}"><font color=rgb(255,255,255)>'.$r_address.'</a></font>';
          echo '<tr><td>'.$user_id_a.'</td><td>'.$fn_a.'</td><td>'.$ln_a.'</td><td>'.$pass_a.'</td><td>'.$address_a.'</td> </tr> ';
          
        }
      }
    ?>
  </table>
  </center>
</div>

  <div id="addcoup" style="display:none">
  <center>
  <form action="newcoupon.php" method="POST">
    <input type="text" id="cupontxt" required name="cc" placeholder="Enter coupon code"  onchange="confirmfield('cupontxt','cuponnum','add_c')" onkeyup="confirmfield('cupontxt','cuponnum','add_c')"/> </br>
    <input type="number" id="cuponnum" min="1" name="ca" required placeholder="Enter amount" onchange="confirmfield('cupontxt','cuponnum','add_c')" onkeyup="confirmfield('cupontxt','cuponnum','add_c')"/> </br>
    <input type="submit" id="add_c" disabled value="Add Coupon" />
  </form>
  </center>
  </div>
  
  <div id="vao" style="display:none">
  <center>
  <?php
    $query = 'SELECT DISTINCT orders.status,userss.address,userss.first_name,userss.last_name,orders.order_id,buy.user_id from orders,buy,userss where (userss.user_id=buy.user_id) AND (orders.order_id=buy.order_id)';
    $result = mysqli_query($conn, $query);
    echo '<table><th>Order ID</th><th>User ID</th><th>User FULLNAME</th><th>Address</th><th>Status</th>';
    while($row = $result->fetch_assoc())
    {
      $orderid = $row['order_id'];
      $useer = $row['user_id'];
      $ufn = $row['first_name'];
      $uln = $row['last_name'];
      $uad = $row['address'];
      $ustatus = $row['status'];
      $userfn = $ufn.' '.$uln;
      if($ustatus == "pending")
      {
        echo '<tr><td><a href="javascript: var vaaaa = updateorder(); if(vaaaa == true) {window.location.href = \'orderdelivered.php?order='.$orderid.'&\';}"><font color=rgb(255,255,255)>'.$orderid.'</a></font></td>';
          echo '<td><a href="javascript: var vaaab = updateorder(); if(vaaab == true) {window.location.href = \'orderdelivered.php?order='.$orderid.'&\';}"><font color=rgb(255,255,255)>'.$useer.'</a></font></td>';
          echo '<td><a href="javascript: var vaaac = updateorder(); if(vaaac == true) {window.location.href = \'orderdelivered.php?order='.$orderid.'&\';}"><font color=rgb(255,255,255)>'.$userfn.'</a></font></td>';
          echo '<td><a href="javascript: var vaaad = updateorder(); if(vaaad == true) {window.location.href = \'orderdelivered.php?order='.$orderid.'&\';}"><font color=rgb(255,255,255)>'.$uad.'</a></font></td>';
          echo '<td><a href="javascript: var vaaae = updateorder(); if(vaaae == true) {window.location.href = \'orderdelivered.php?order='.$orderid.'&\';}"><font color=rgb(255,255,255)>'.$ustatus.'</a></font></td></tr>';
      }
      else if($ustatus == "delivered")
      {
        echo '<tr><td>'.$orderid.'</td><td>'.$useer.'</td><td>'.$userfn.'</td><td>'.$uad.'</td><td>'.$ustatus.'</td></tr>';
      }
    }
    echo '</table>';
  ?>
  </center>
  </div>
  
  <div id="vpo" style="display:none">
  <center>
  <?php
    $query = 'SELECT DISTINCT userss.address,userss.first_name,userss.last_name,orders.order_id,buy.user_id from orders,buy,userss where (userss.user_id=buy.user_id) AND (orders.order_id=buy.order_id) AND status=\'pending\'';
    $result = mysqli_query($conn, $query);
    echo '<center><table><th>Order ID</th><th>User ID</th><th>User FULLNAME</th><th>Address</th>';
    while($row = $result->fetch_assoc())
    {
      $orderid = $row['order_id'];
      $useer = $row['user_id'];
      $ufn = $row['first_name'];
      $uln = $row['last_name'];
      $uad = $row['address'];
      $userfn = $ufn.' '.$uln;
      echo '<tr><td><a href="javascript: var aaaa = updateorder(); if(aaaa == true) {window.location.href = \'orderdelivered.php?order='.$orderid.'&\';}"><font color=rgb(255,255,255)>'.$orderid.'</a></font></td>';
          echo '<td><a href="javascript: var aaab = updateorder(); if(aaab == true) {window.location.href = \'orderdelivered.php?order='.$orderid.'&\';}"><font color=rgb(255,255,255)>'.$useer.'</a></font></td>';
          echo '<td><a href="javascript: var aaac = updateorder(); if(aaac == true) {window.location.href = \'orderdelivered.php?order='.$orderid.'&\';}"><font color=rgb(255,255,255)>'.$userfn.'</a></font></td>';
          echo '<td><a href="javascript: var aaad = updateorder(); if(aaad == true) {window.location.href = \'orderdelivered.php?order='.$orderid.'&\';}"><font color=rgb(255,255,255)>'.$uad.'</a></font></td></tr>';
    }
    echo '</table></center>';
  ?>
  </center>
  </div>
  
  <div id="viewcou" style="display:none">
  <?php
    $query = 'SELECT coupon_code,money FROM coupon';
    $result = mysqli_query($conn,$query);
    if($result->num_rows == 0)
    {
      echo '<center>No coupons added.</center>';
    }
    else
    {
      echo '<table><th> Code </th><th> Amount </th>';
      while($row = $result->fetch_assoc())
      {
        echo '<tr><td>'.$row['coupon_code'].'</td><td>'.$row['money'].'</td></tr>';
      }
    }     
  ?>
  </div>
</body>

  </section>







</main>
</html>