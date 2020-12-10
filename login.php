<!DecoType HTML>

<html lang="en">

	<?php
		ini_set('error_reporting', 'E_COMPILE_ERROR|E_RECOVERABLE_ERROR|E_ERROR|E_CORE_ERROR');

		include 'connection.php';
		$conn = OpenCon();

		if (mysqli_connect_errno())
		{
			echo "Unable to connect to server " . mysqli_connect_error();
		}
		
		session_start();
		
		if($_SESSION['logged_in'] == true)
		{
			if($_SESSION['admin'] == true)
			{
				echo '<meta http-equiv="refresh" content="0; URL=\'admin.php\'" /> ';
				exit;
			}
			else
			{
				echo '<meta http-equiv="refresh" content="0; URL=\'ehome.php\'" /> ';
				exit;
			}
		}
		
		if(isset($_POST['signup-submit'])) {
			ini_set('error_reporting', 'E_COMPILE_ERROR|E_RECOVERABLE_ERROR|E_ERROR|E_CORE_ERROR');

			$u_fn = $u_ln = $u_p = $u_cp = $u_addr =  "";

			$u_fn = $_POST["first_name"];
			$u_ln = $_POST["last_name"];
			$u_p = $_POST["password"];
			$u_cp = $_POST["c_password"];
			$u_addr = $_POST["address"];


			if(!(($u_fn == "") || ($u_ln == "") || ($u_p == "") || ($u_cp == "") || ($u_addr == "")))
			{
				if($u_cp !== $u_p)
				{
					echo "Password and Confirm Password fields mismatch <br> ";
					exit;
				}

				$full_name=$u_fn.' '.$u_ln;

				include 'connection.php';
				$conn = OpenCon();

				if (mysqli_connect_errno())
				{
					echo "Unable to connect to server " . mysqli_connect_error();
				}

				$check="SELECT * FROM userss ORDER BY user_id DESC";
				$result = mysqli_query($conn, $check);
				$row = $result->fetch_assoc();
				$u_id = $row['user_id'];
				$u_id = $u_id + 1;

				$query = 'SELECT user_id FROM userss WHERE (user_id = '.$u_id.')';
				$res = mysqli_query($conn, $query);

				$number_rows = $res->num_rows;
				$iquery='INSERT INTO userss (user_id,first_name,last_name,password,wallet,address) VALUES(';
				$iquery=$iquery.$u_id.",'".$u_fn."','".$u_ln."','".$u_p."',0,'".$u_addr."')";


				if($number_rows == 1)
				{
					echo "Account already exists with this username. <br>";
					exit;
				}
				else if($number_rows == 0)
				{
					$add = mysqli_query($conn, $iquery);
					if($add == 1)
					{
						echo '<script>alert("'.$u_fn.' '.$u_ln.' Your account has been created. Now you can buy products.\n Your USERNAME/USERID is \''.$u_id.'\'")</script>';
					}
					else
					{
						echo "Error creating account. Please try again later.<br>";
					}
				}
			}
			header("Location: ehome.php");
		}
	?>


    <head>
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<title>E-Store - Online Shopping in Pakistan</title>
        <link rel="stylesheet" type="text/css" href="estyle.css">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

      	<link style="width: 100%;height: 100%" rel="tab icon" href="store_images/logoicon.ico"/>
    

      	<style>
			.modal-header, h4, .close {
				background-color: #222222;
				color:white !important;
				text-align: center;
				font-size: 30px;
			}
			.modal-footer {
				background-color: #f9f9f9;
			}

			.myLogin {
				background-color: inherit;
				border: none;
				border-radius: 0;
				display: flex;
				height: 100%;
				text-align: center;
				text-decoration: none;
				font-size: 10px;
				margin-top: -2px;
				max-height: 55px;
				cursor: pointer;
			}
			.inmyLogin{
				background-color: #2196f3;
				border: 1px solid #1590FF;
			}
			.inmyLogin:hover{
				background-color: #0065FF;
				border: 1px solid #0050FF;
			}
			.linkButton {
			    background:none;
			    color:inherit;
			    background-color: inherit;
			    border:none;
			    padding:0;
			    color: #5075FF;
			    height:20px;
			    margin-right: 20px;
			    font: inherit; 
			    border-radius: 0;
			    cursor: pointer;
			}
			.linkButton:hover{
			    border-bottom:1px solid #444;
			    background-color: inherit;
			}
		</style>
    </head>


    <body>
    	<!-- Top navigation Bar ( LOGO + Other Buttons) -->
    	<header>        
            <div class="logo"><a href="ehome.php"><img class="logoClass" src="store_images/logo.png"></a></div>
            <nav role = "header">
            	<ul>
            		<li><a href="ehome.php" class="active">HOME</a></li>
            		<li><a href="trackmyorder.php"> TRACK MY ORDER</a></li>
            		<li><a href="info.php"> ABOUT DEVELOPERS</a></li>
            		<li><button type="button" class="btn btn-default btn-lg myLogin" id="signupBtn">SIGNUP</button></li>
            		<li><button type="button" class="btn btn-default btn-lg myLogin" id="loginBtn">LOGIN</button></li>
            	</ul>
            </nav>
            <div class="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i></div>
    	</header>
    	
    	<br>
    	<br>
    	<br>

    	<!-- Categories Button + Search Bar + Cart -->
    	<div class="catsearchDiv">

    		<!-- Categories Button -->
    		<nav role = "catmenu" id='categorymenu'>
		        <ul>
		            <li role = "plusminusANDtext"><a href='#' class="plusMinus" style="margin-top: 1px;height: 10px;box-sizing : border-box;border-radius: 5px;outline: none;border: 4px solid #2196f3;text-align: center;" >CATEGORIES</a>
		                <ul>
		                	<?php
		                		$query = 'SELECT category_name FROM category';
		                		$result = mysqli_query($conn,$query);
		                		
		                		while($row = $result->fetch_assoc())
		                		{
		                			echo "<li role = 'plusminus'><a href='search.php?query=".$row['category_name']."'>".$row['category_name']."</a> </li>";

		                		}				    
			            	?>
			         
		              	</ul>
		            </li>
		        </ul>
		    </nav>

		    <!-- Search bar -->
		    <form class="search" method="POST" action="search.php">
		        <input type="text" name="sp" class="searchTerm" pattern="\S+.*"/ placeholder="Search in E-Store ...">
		        <input type="submit" class="searchButton">
		    	
		    	<select class="filterclass" name="search_filters" id="search_filters" onchange="searchfilters(this.options[this.selectedIndex].value)">
					<option value="no_filters">No filters </option>
					<option value="price_lth">Price Low to High </option>
					<option value="price_htl">Price High to Low</option>
					<option value="date_added_r">Recent Products</option>
					<option value="date_added_o">Old Added Products</option>
				</select>
		    </form>
		    
		    <!-- Cart -->
		    <div class="cart"><a href="mycart.php"><img class="cartClass" src="store_images/cart.png"></a></div>
    	</div>
    	
    	<!-- Slides Show -->
    	<div class="slideBack container" style="width: 100%">
			<div id="myCarousel" class="carousel slide" data-ride="carousel" style="width: 50%;margin-left: 25%;">
			    <!-- Indicators -->
			    <ol class="carousel-indicators">
			    	<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
			    	<li data-target="#myCarousel" data-slide-to="1"></li>
			    	<li data-target="#myCarousel" data-slide-to="2"></li>
			    	<li data-target="#myCarousel" data-slide-to="3"></li>
			    	<li data-target="#myCarousel" data-slide-to="4"></li>
			    </ol>

			    <!-- Wrapper for slides -->
			    <div class="carousel-inner">
			    	<div class="item active">
			    		<img src="store_images/img4.jpg" alt="Los Angeles" style="width:100%;">
			        	<div class="carousel-caption">
			        		<h3>Los Angeles</h3>
			         		<p>LA is always so much fun!</p>
			        	</div>
			    	</div>
				    <div class="item">
				        <img src="store_images/img2.png" alt="Chicago" style="width:100%;">
				        <div class="carousel-caption">
				        	<h3>Chicago</h3>
				        	<p>Thank you, Chicago!</p>
				        </div>
				    </div>
				    <div class="item">
				        <img src="store_images/img5.png" alt="New York" style="width:100%;">
				        <div class="carousel-caption">
				        	<h3>New York</h3>
				        	<p>We love the Big Apple!</p>
				        </div>
				    </div>
				    <div class="item">
				        <img src="store_images/img4.jpg" alt="New York" style="width:100%;">
				        <div class="carousel-caption">
				        	<h3>New York</h3>
				        	<p>We love the Big Apple!</p>
				        </div>
				    </div>
				    <div class="item">
				        <img src="store_images/img5.png" alt="New York" style="width:100%;">
				        <div class="carousel-caption">
				        	<h3>New York</h3>
				        	<p>We love the Big Apple!</p>
				        </div>
				    </div>
			    </div>

			    <!-- Left and right controls -->
			    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
			    	<span class="glyphicon glyphicon-chevron-left"></span>
			    	<span class="sr-only">Previous</span>
				</a>
			    <a class="right carousel-control" href="#myCarousel" data-slide="next">
			    	<span class="glyphicon glyphicon-chevron-right"></span>
			    	<span class="sr-only">Next</span>
			    </a>
			</div>
		</div>



		</br>
		</br>
		</br>

		<div class="container" style="border: 1px solid #00bff3;border-radius: 10px ;margin-top: 5px;">
		    <div class="row">
				<?php
				    $disp_lp='SELECT product_id,product_name,products.category_id,category_name,date_added,price,icon_name,description FROM category,products WHERE (products.category_id=category.category_id) ORDER BY date_added DESC';
				    $result = mysqli_query($conn,$disp_lp);
				    while($row = $result->fetch_assoc())
				    {
				    	$productid=$row['product_id'];
				    	$productname=$row['product_name'];
				    	$productcategory=$row['category_name'];
				    	$productprice=$row['price'];
				    	$productdescription=$row['description'];
						$image=$row['icon_name'];

						$link =  '<a href="product.php?product_id='.$productid.'">';
				?>
				        <div class="col-md-3 col-sm-6" style="margin-top: 25px;margin-bottom: 25px">
				            <div class="product-grid7" style="border: 1px solid #262626">
				                <div class="product-image7">
				                    <?php
				                    	echo '<a href="product.php?product_id='.$productid.'">
				                    		<img class="pic-1" src="images/'.$image.'">;
				                    </a>'
				                    ?>
				                    <ul class="social">
				                        <li><?php echo '<a href="product.php?product_id='.$productid.'" class="fa fa-search"></a>' ?></li>
				                        <li><a href="" class="fa fa-shopping-cart"></a></li>
				                    </ul>
				                    <span class="product-new-label">New</span>
				                </div>
				                <div class="product-content">
				                    <h3 class="title"><a href="#"><?php echo $productname ?></a></h3>
				                    <ul class="rating">
				                        <li class="fa fa-star"></li>
				                        <li class="fa fa-star"></li>
				                        <li class="fa fa-star"></li>
				                        <li class="fa fa-star"></li>
				                        <li class="fa fa-star"></li>
				                    </ul>
				                    <div class="price"><?php echo $productprice ?>
				                        <span>$20.00</span>
				                    </div>
				                </div>
				            </div>
				        </div>
				<?php
					}				             
				                
				?>
		    </div>
		</div>
  

    	<!-- LOGIN BUTTON -->
    	<div class="container">
			<!-- Modal -->
			<div class="modal fade" id="loginModal" role="dialog">
			    <div class="modal-dialog">
			    	<!-- Modal content-->
			    	<div class="modal-content">
				        <div class="modal-header" style="padding:35px 50px;">
				          <button type="button" class="close" data-dismiss="modal">&times;</button>
				          <h4><span class="glyphicon glyphicon-lock"></span>LOG IN</h4>
				        </div>
				        <div class="modal-body" style="padding:40px 50px;">
				        	<form role="form" method="POST" action="ehome.php">
					            <div class="form-group">
					            	<label for="usrname"><span class="glyphicon glyphicon-user"></span> User ID</label>
					            	<input name="user_name" required type="number" class="form-control" id="usrname" placeholder="Enter ID">
					            </div>
					            <div class="form-group">
					            	<label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Password</label>
					            	<input name="password" required type="password" class="form-control" id="psw" placeholder="Enter password" minlength="8">
					            </div>
					            <div class="checkbox">
					            	<label><input type="checkbox" value="" checked>Remember me</label>
					            </div>
					            <button type="submit" name="login-submit" class="btn btn-success btn-block inmyLogin" onclick="showLogout()"><span class="glyphicon glyphicon-off"></span>Login</button>
				        	</form>
				        </div>
				        <div class="modal-footer">
				        	<button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
				        	<button type="button" class="btn btn-default btn-lg linkButton" data-dismiss="modal" id="loginasadminBtn">Login as Admin</button>
				        	<p>Forgot <a href="#">Password?</a></p>
				        </div>
			    	</div>
			      
			    </div>
			</div> 
		</div>


		<!-- LOGIN As admin Modal -->
    	<div class="container">
			<!-- Modal -->
			<div class="modal fade" id="loginasadminModal" role="dialog">
			    <div class="modal-dialog">
			    	<!-- Modal content-->
			    	<div class="modal-content">
				        <div class="modal-header" style="padding:35px 50px;">
				          <button type="button" class="close" data-dismiss="modal">&times;</button>
				          <h4><span class="glyphicon glyphicon-lock"></span>LOG IN AS ADMIN</h4>
				        </div>
				        <div class="modal-body" style="padding:40px 50px;">
				        	<form role="form" method="POST" action="admin.php">
					            <div class="form-group">
					            	<label for="usrname"><span class="glyphicon glyphicon-user"></span> Admin ID</label>
					            	<input name="user_name_a" required type="number" class="form-control" id="usrname" placeholder="Enter ID">
					            </div>
					            <div class="form-group">
					            	<label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Password</label>
					            	<input name="password_a" required type="password" class="form-control" id="psw" placeholder="Enter password" minlength="8">
					            </div>
					            <div class="checkbox">
					            	<label><input type="checkbox" value="" checked>Remember me</label>
					            </div>
					            <button type="submit" name="login-submit" class="btn btn-success btn-block inmyLogin" onclick="showLogout()"><span class="glyphicon glyphicon-off"></span>Login As Admin</button>
				        	</form>
				        </div>
				        <div class="modal-footer">
				        	<button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
				        	<button type="button" class="btn btn-default btn-lg linkButton" data-dismiss="modal" id="loginBtn">Log in</button>
				        	<p>Forgot <a href="#">Password?</a></p>
				        </div>
			    	</div>
			      
			    </div>
			</div> 
		</div>



		<!-- SIGNUP BUTTON -->
    	<div class="container">
			<!-- Modal -->
			<div class="modal fade" id="signupModal" role="dialog">
			    <div class="modal-dialog">
			    	<!-- Modal content-->
			    	<div class="modal-content">
				        <div class="modal-header" style="padding:35px 50px;">
				          <button type="button" class="close" data-dismiss="modal">&times;</button>
				          <h4><span class="glyphicon glyphicon-lock"></span>SIGN UP</h4>
				        </div>
				        <div class="modal-body" style="padding:40px 50px;">
				        	
				        	<form role="form" method="post" action="signup.php" name="signupForm">
					            <div class="form-group">
					            	<label for="usrname"><span class="glyphicon glyphicon-user"></span> First Name</label>
					            	<input name="first_name" type="text" pattern="\S+.*"/ required class="form-control" placeholder="Enter first name">
					            </div>
					            <div class="form-group">
					            	<label for="usrname"><span class="glyphicon glyphicon-user"></span> Last Name</label>
					            	<input name="last_name" type="text" pattern="\S+.*"/ required class="form-control" placeholder="Enter last name">
					            </div>
					            <div class="form-group">
					            	<label for="address"><span class="glyphicon glyphicon-user"></span> Address</label>
					            	<input name="address" type="text" pattern="\S+.*"/ required class="form-control" placeholder="Enter Address">
					            </div>
					            <div class="form-group">
					            	<label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Password</label>
					            	<input name="password" type="password" required class="form-control" id="password" onchange="validatePassword()" placeholder="Enter password" minlength="8">
					            </div>
					            <div class="form-group">
					            	<label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Password</label>
					            	<input name="c_password" type="password" required class="form-control" id="confirm_password" onkeyup="validatePassword()" placeholder="Confirm password">
					            </div>
					            <div class="checkbox">
					            	<label><input type="checkbox" value="" checked>Remember me</label>
					            	<label><input type="checkbox" value="" onclick="showpass()">Show password</label>
					            </div>
					            <button id="submit_button" name="signup-submit" type="submit" class="btn btn-success btn-block inmyLogin"><span class="glyphicon glyphicon-off"></span>Signup</button>
				        	</form>
				        
				        </div>
				        <div class="modal-footer">
				        	<button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove "></span> Cancel</button>
				        	<button type="button" class="btn btn-default btn-lg linkButton" data-dismiss="modal" id="loginBtn">Log in</button>
				        </div>
			    	</div>
			      
			    </div>
			</div> 
		</div>



		<br><br><br>
    	<br>
    	<br>
    	<br>
    	<br>


		<!-- Footer Starts From Here   -->

		<footer class="ct-footer">
			<div class="container">
				<ul class="ct-footer-list text-center-sm">
					<li>
		        		<h2 class="ct-footer-list-header">Learn More</h2>
				        <ul>
				        	<li>
				            	<a href="info.php">About us</a>
				        	</li>
				        	
				        </ul>
		      		</li>
		    		
		    		<li>
		        		<h2 class="ct-footer-list-header">Services</h2>
				        <ul>
				          	<li>
				            	<a href="">Design</a>
				          	</li>
				          	<li>
				            	<a href="">Marketing</a>
				          	</li>
				          	<li>
				            	<a href="">Sales</a>
				          	</li>
				          	<li>
				            	<a href="">Programming</a>
				          	</li>
				          	<li>
				            	<a href="">Support</a>
				          	</li>
				        </ul>
		      		</li>
		      		
		      		<li>
		       			<h2 class="ct-footer-list-header">Our Team</h2>
				        <ul>
				          	<li>
				            	<a href="info.php">Developers</a>
				          	</li>
				          	
				        </ul>
		      		</li>
		      		
		      		<li>
		        		<h2 class="ct-footer-list-header">Customer Care</h2>
		        		<ul>
		          			<li>
		            			<a href="">Help Centre</a>
		          			</li>
		          			<li>
					            <a href="" onclick="alert('You can add money in your wallet through coupons. Coupons are avaiable at general stores. Add money using coupon and add products you want to buy in cart. After that press check out button. Products will be deleivered at your door step')" >How to buy?</a>
					        </li>
					        <li>
					        	<a href="" onclick="alert('This feature is not working at the moment. Please try later')" >Track Your Order</a>
					        </li>
					        <li>
					        	<a href="" onclick="alert('You can buy coupons from General Stores around your house')" >How to get coupon?</a>
					        </li>
					        <li>
					            <a href="" onclick="alert('At your given address the products will be delievered');" >Delivery method</a>
					        </li>
		        		</ul>
		      		</li>
				     
				    <li>
				        <h2 class="ct-footer-list-header">Estore</h2>
				        <ul>
					        <li>
					            <a href="info.php">About Us</a>
					        </li>
					        <li>
					            <a href="" onclick="alert('We will not be responsible if you give incorrect address. Products will be deleivered once on user confirmation. If user fails to receive, company is not responsible for it.')" >Trems and Conditions</a>
					        </li>
					        <li>
					            <a href="" onclick="alert('You can email us \n bscs17070@itu.edu.pk \n bscs17063@itu.edu.pk \n bscs17077@itu.edu.pk \n bscs17026@itu.edu.pk \n bscs17064@itu.edu.pk \n bscs17056@itu.edu.pk')" >Contact Us</a>
					        </li>
				        </ul>
				      </li>
		    	</ul>
		    

			    <div class="ct-footer-meta text-center-sm">
				    <div class="row">
				        <div class="col-sm-6 col-md-2">
				        	<img class="footerlogo" alt="logo" src="store_images/logoicon.ico">
				        </div>
				        <div class="col-sm-6 col-md-3">
				          	<address>
				            	<span>EStore Co.<br></span>
				            	Arfa Software Technology Park<br>Lahore, Pakistan 53720<br>
				            	<span>Phone: <a href="tel:5555555555">(000) 000-000</a></span>
				          	</address>
				        </div>
				        <div class="col-sm-6 col-md-2 ct-u-paddingTop10">
				          	<a href="" target="_blank"><img alt="app store" src="https://www.solodev.com/assets/footer/appstore.png"></a>
				        </div>
				        <div class="col-sm-6 col-md-2 ct-u-paddingTop10">
				          	<a href="" target="_blank"><img alt="google play store" src="https://www.solodev.com/assets/footer/androidstore.png"></a>
				        </div>
				        <div class="col-sm-6 col-md-3">
					        <ul class="ct-socials list-unstyled list-inline">
					            <li>
					              	<a href="" target="_blank"><img alt="facebook" src="https://www.solodev.com/assets/footer/facebook-white.png"></a>
					            </li>
					            <li>
					              	<a href="" target="_blank"><img alt="twitter" src="https://www.solodev.com/assets/footer/twitter-white.png"></a>
					            </li>
					            <li>
					              	<a href="" target="_blank"><img alt="youtube" src="https://www.solodev.com/assets/footer/youtube-white.png"></a>
					            </li>
					            <li>
					              	<a href="" target="_blank"><img alt="instagram" src="https://www.solodev.com/assets/footer/instagram-white.png"></a>
					            </li>
					            <li>
					              	<a href="" target="_blank"><img alt="pinterest" src="https://www.solodev.com/assets/footer/pinterest-white.png"></a>
					            </li>
					        </ul>
				        </div>
				    </div>
			    </div>
		  	</div>
		  
		  	<div class="ct-footer-post">
		    	<div class="container">
		      		<div class="inner-left">
		        		<ul>
		          			<li>
		            			<a href="">FAQ</a>
		          			</li>
		          			<li>
		            			<a href="">News</a>
		          			</li>
		          			<li>
		            			<a href="">Contact Us</a>
		          			</li>
		        		</ul>
		      		</div>
		      		
		      		<div class="inner-right">
		        		<p>Copyright © 2019 EstoreCo.&nbsp;<a href="">Privacy Policy</a></p>
		        		<p><a class="ct-u-motive-color" href="" target="_blank">Web Design</a> by HMC Co. on <a href="" target="_blank">HMC.com</a></p>
		      		</div>
		    	</div>
		  	</div>
		</footer>



    	
    	<script type="text/javascript">
    		$(document).ready(function(){
    			$('.menu-toggle').click(function(){
    				$('nav').toggleClass('active')
    			})
    		})
    		$(document).ready(function(){
				$(document).on("click", "#loginBtn", function(event){
			    $("#loginModal").modal();
				});
			});
			$(document).ready(function(){
				$(document).on("click", "#loginasadminBtn", function(event){
			    $("#loginasadminModal").modal();
				});
			});
			$(document).ready(function(){
				$(document).on("click", "#signupBtn", function(event){
			    $("#signupModal").modal();
				});
			});
			
			function showpass(){
				var x = document.getElementById("password");
				if(x.type === "password"){
					x.type = "text";
				}
				else{
					x.type = "password";
				}
			}
			function validatePassword(){
				var password = document.getElementById("password");
				var confirm_password = document.getElementById("confirm_password");

				if(password.value != confirm_password.value) {
					confirm_password.setCustomValidity("Passwords Don't Match");
					document.getElementById("submit_button").disabled = true;
				} 
				else {
				    confirm_password.setCustomValidity('');
				    document.getElementById("submit_button").disabled = false;
				}
			}

			function searchfilters(name){
				 var filter;
				 filter = 'nf';
				 if(name == "price_lth")
				 {
					filter = 'plth'
				 }
				 else if(name == "price_htl")
				 {
					filter = 'phtl'; 
				 }
				 else if(name == "date_added_r")
				 {
					filter = 'rp'; 
				 }
				 else if(name == "date_added_o")
				 {
					filter = 'oap'; 
				 }
				 else if(name == "no_filters")
				 {
					filter = 'nf';
				 }
				 document.cookie="filter="+filter;
			}

    	</script>
    </body>
</html>