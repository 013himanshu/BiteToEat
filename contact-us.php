<?php
	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);		
		return $data;
	}
	
	if($_SERVER["REQUEST_METHOD"]=="POST"){
		if(isset($_POST["submit"])){
			
			$name=test_input($_POST["name"]);
			$mbl=test_input($_POST["mbl"]);
			$email=test_input($_POST["email"]);
			$sub=test_input($_POST["sub"]);
			$query=test_input($_POST["query"]);
			
			if(empty($name)){
				//Empty field					
				header("Location:s_contacts.php?n_data=Empty&n_err=001 ");
			}
			else if(!preg_match("/^[a-zA-Z\.\- ]+$/",$name)){
				//Invalid Entry					
				header("Location:s_contacts.php?n_data=Invalid&n_err=002");
			}
			else if(empty($mbl)){
				//Empty field					
				header("Location:s_contacts.php?m_data=Empty&m_err=001 ");
			}
			else if(!preg_match("/^[0-9]{10}+$/",$mbl)){
				//Invalid Entry				
				header("Location:s_contacts.php?m_data=Invalid&m_err=002");
			}
			else if(empty($email)){
				//Empty field					
				header("Location:s_contacts.php?e_data=Empty&e_err=001 ");
			}
			else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				//Invalid Entry				
				header("Location:s_contacts.php?e_data=Invalid&e_err=002");
			}
			else if(empty($sub)){
				//Empty field					
				header("Location:s_contacts.php?s_data=Empty&s_err=001 ");
			}
			else if(!preg_match("/^[a-zA-Z0-9\.\+()_,\-\/ ]+$/",$sub)){
				//Invalid Entry					
				header("Location:s_contacts.php?s_data=Invalid&s_err=002");
			}
			else if(empty($query)){
				//Empty field					
				header("Location:s_contacts.php?q_data=Empty&q_err=001 ");
			}
			else if(!preg_match("/^[a-zA-Z0-9\.\+()_,\-\/ ]+$/",$name)){
				//Invalid Entry					
				header("Location:s_contacts.php?q_ata=Invalid&q_err=002");
			}
			else{
				
			}
		}
	}	
?>
<!Doctype html>
<html lang="en">
<head>

	<title>Contact Us | BiteToEat</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="Description" content="Order anything to eat or drink from the top brands in the market. BiteToEat provide its customers sweets deserts, dairy products, and services like juice, tiffin, etc. at reasonable prices within an hour at their doorstep." />
    <meta name="robots" content="index, follow">
	<meta name="googlebot" content="index, follow">	
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery.min.js"></script>
	<link href="css/jquery-ui.css" rel="stylesheet">
	<script src="js/bootstrap.min.js"></script>			
	<link rel="stylesheet" href="css/c_navbar.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/fonts.css">		
	
	<style>			
		body{background-color:#f2f2f2;}				
		
		/*footer css starts*/
		footer {
			background-color: #ffffff;
			color: #1cb01c;
			padding: 32px;			
		}
				
		
		footer h4, footer h5 a {
			color: #1cb01c;
			font-family:muli;
		}

		footer a:hover, a:visited, a:link{color: #1cb01c;text-decoration:none;}			
		/*footer css ends*/
		
		/*body css starts*/
		.form-group label{			
			letter-spacing:1px;
			color:#1cb01c;
			font-size:17px;
			font-family:abeezee;
		}
		
		input[type=tel], input[type=email], input[type=text]{
			border-radius:0px;
			outline:none;
			font-family:abeezee;
			color:#1cb01c;
			letter-spacing:1px;
			font-size:15px;
			width:100%;
		}
		
		input[type=tel]:focus, input[type=email]:focus, input[type=text]:focus{
			border:0.5px solid #1cb01c;
			box-shadow:0 0 5px 1px #1cb01c;
		}
		
		input[type=submit]{
			border-radius:0px;
			background-color:#1cb01c;
			color:#ffffff;
			width:100%;
			border:none;
			padding:7px;
			font-size:20px;
			font-family:barOne;
			letter-spacing:2px;
			outline:none;
		}
		
		input[type=submit]:hover, input[type=submit]:focus{
			background-color:#189a18;
		}
		
		textarea{
			border-radius:0px;
			outline:none;
			font-family:abeezee;
			color:#1cb01c;
			letter-spacing:1px;
			font-size:15px;
			width:100%;
		}
		
		textarea:focus{
			border:0.5px solid #1cb01c;
			box-shadow:0 0 5px 1px #1cb01c;
		}
		.body{
			background-color:#ffffff;
			margin-top:15px;
			margin-bottom:15px;
			padding:20px;
			box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);
		}
		.body h1{
			color:#1cb01c;
			letter-spacing:2px;
			font-family:abeezee;
		}
		.body p.desc{
			font-size:25px;
			letter-spacing:1px;
			font-family:abeezee;	
		}
		.body .left{
			padding:130px;
			font-size:25px;			
		}
		.body .right{
			border-left:2px solid #1cb01c;
			padding:25px;
		}
		@media only screen and (max-width:767px){
			.body p.desc{
				font-size:20px;				
			}
			.body .left{
				padding:5px;
				font-size:25px;
				text-align:center;	
			}
			.body .right{
				border-left:none;
				padding:25px;
			}
		}
		/*body css ends*/			
	</style>
	
</head>
<body>

<!--Navbar Start-->	
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">      
      <a class="navbar-brand" href="sell.php"><img src="images/logoW.png" class="logo" alt="logo-text" /></a>
    </div>    
  </div>
</nav>
<!--Navbar End-->


<div class="container body">
	<h1 id="about-us">About Us...</h1>
	<p class="desc">BiteToEat is a food service company established in 2016 in Jaipur, Rajasthan. The company visualizes merging of food with technology to give its users a healthy
	and quality experience. Our company will provide its customers fast food, deserts, dairy products, and services like juice, tiffin, etc. at reasonable prices. It will prove a tasty and healthy
	source of food service for every Jaipurite.</p>
	<br>
	<h1>Mission...</h1>
	<p class="desc">We aim at expanding the food e-commerce market all over the country. We also see a vision of providing our customers of any eatable they can think of.</p>
	<br><br>
	
	<div class="contact">
		<h1 class="con-head text-center" id="contact-us" style="padding:30px;text-decoration:underline;">Contact Us</h1>
		<div class="row">
			
			<div class="left col-sm-6">
				<p><span class="glyphicon glyphicon-phone"></span> 9694020006</p><br>
				<p><span class="glyphicon glyphicon-phone"></span> 9983751677</p><br>
				<p><span class="glyphicon glyphicon-envelope"></span> info@bitetoeat.in</p>
			</div>
			
			<div class="right col-sm-6">
				<h2>Email us your query.</h2><br>
				<form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<div class="form-group">
						<label for="name">Full Name</label>
						<input type="text" class="form-control" name="name" placeholder="Enter your full name." required />
						<?php
							if(isset($_GET["n_err"])){
								
								if($_GET["n_err"]=="001" && $_GET["n_data"]=="Empty"){
									echo '<span style="font-family:muli;">*Empty field.</span>';
								}
								if($_GET["n_err"]=="002" && $_GET["n_data"]=="Invalid"){
									echo '<span style="font-family:muli;">*Invalid entry.</span>';
								}
							}	
						?>
					</div>
					<div class="form-group">
						<label for="mbl">Mobile No.</label>
						<input type="tel" class="form-control" name="mbl" minlength="10" maxlength="10" placeholder="Enter your mobile no." required />
						<?php
							if(isset($_GET["m_err"])){
								
								if($_GET["m_err"]=="001" && $_GET["m_data"]=="Empty"){
									echo '<span style="font-family:muli;">*Empty field.</span>';
								}
								if($_GET["m_err"]=="002" && $_GET["m_data"]=="Invalid"){
									echo '<span style="font-family:muli;">*Invalid entry.</span>';
								}
							}	
						?>
					</div>
					<div class="form-group">
						<label for="email">Email Id</label>
						<input type="email" class="form-control" name="email" placeholder="Enter your email id." required />
						<?php
							if(isset($_GET["e_err"])){
								
								if($_GET["e_err"]=="001" && $_GET["e_data"]=="Empty"){
									echo '<span style="font-family:muli;">*Empty field.</span>';
								}
								if($_GET["e_err"]=="002" && $_GET["e_data"]=="Invalid"){
									echo '<span style="font-family:muli;">*Invalid entry.</span>';
								}
							}	
						?>
					</div>
					<div class="form-group">
						<label for="sub">Subject</label>
						<input type="text" class="form-control" name="sub" placeholder="Enter your subject." required />
						<?php
							if(isset($_GET["s_err"])){
								
								if($_GET["s_err"]=="001" && $_GET["s_data"]=="Empty"){
									echo '<span style="font-family:muli;">*Empty field.</span>';
								}
								if($_GET["s_err"]=="002" && $_GET["s_data"]=="Invalid"){
									echo '<span style="font-family:muli;">*Invalid entry.</span>';
								}
							}	
						?>
					</div>
					<div class="form-group">
						<label for="query">Query</label>
						<textarea name="query" placeholder="Enter your query." maxlength="550" required style="resize:none;"></textarea>
						<?php
							if(isset($_GET["q_err"])){
								
								if($_GET["q_err"]=="001" && $_GET["q_data"]=="Empty"){
									echo '<span style="font-family:muli;">*Empty field.</span>';
								}
								if($_GET["q_err"]=="002" && $_GET["q_data"]=="Invalid"){
									echo '<span style="font-family:muli;">*Invalid entry.</span>';
								}
							}	
						?>
					</div>
					
					<input type="submit" name="submit" value="Send" />
					<?php 
						if(isset($_SESSION["mailSent"])){
							if($_SESSION["mailSent"]=="sent"){
								echo '<br><span style="font-family:muli;font-size:17px;color:#1cb01c;"><span class="glyphicon glyphicon-ok"></span> Mail Sent.</span>';
								unset($_SESSION["mailSent"]);
							}
							else{
								echo '<br><span style="font-family:muli;font-size:17px;color:#1cb01c;"><span class="glyphicon glyphicon-remove"></span> Mail not Sent.</span>';
								unset($_SESSION["mailSent"]);
							}
						}
					?>
				</form>
			</div>
			
		</div>
	</div>	
</div>




<!-- footer starts -->
<footer>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-3">
				<h4 style="border-bottom:1px dotted;padding-bottom:6px;">Navigate</h4>
				<h5><a href="index.php">Home</a></h5>
				<h5><a href="index.php#categories">Categories</a></h5>
				<h5><a href="product-list.php">Products</a></h5>									
			</div>									
			<div class="col-sm-3">
				<h4 style="border-bottom:1px dotted;padding-bottom:6px;">Follow Us</h4>
				<a href="https://www.facebook.com/PageBiteToEat/" target="_blank"><img src="images/follow-fb.png"  alt="follow-fb" height="40" /></a>								
			</div>
			<div class="col-sm-3">
				<h4 style="border-bottom:1px dotted;padding-bottom:6px;">Help &amp Support</h4>
				<h5><a href="contact-us.php">About Us</a></h5>
				<h5><a href="contact-us.php#contact-us">Contact Us</a></h5>				
			</div>			
			<div class="col-sm-3">
				<h4 style="border-bottom:1px dotted;padding-bottom:6px;">BiteToEat-Sell</h4>
				<h5><a href="sell.php">Sell Now</a></h5>
				<h5><a href="how_it_works.html">How It Works</a></h5>
				<h5><a href="sell_faqs.html">FAQs</a></h5>								
				
			</div>
		</div><br><br>
		<hr width="60%">
		<center><p><a href="index.php" style="color:#1cb01c;text-decoration:none;">BiteToEat</a> &copy 2016</p></center>
	</div>	
	
</footer>

</body>
</html>	