<?php
	session_start();
	if(!isset($_SESSION["sellcheck"]))
	{
		header("Location:sell.php");	
	}
?>

<?php	
		include('conx.php');
		
		if ($stmt = $conn->prepare("SELECT store_status FROM register WHERE mbl_no=?")) {
			if($stmt->bind_param("s", $_SESSION["sellcheck"])){
				$stmt->execute();
				$stmt->bind_result($proVal);
				$stmt->fetch();
				if($proVal=='0'){
					unset($proVal);
					$stmt->close();
					$conn->close();
					header("Location:sell_personalInfo-0.php");
					exit(0);
				}
				else if($proVal=='1'){
					unset($proVal);
					$stmt->close();
					$conn->close();
					header("Location:sell_storeInfo-1.php");
					exit(0);
				}
				else if($proVal=='2'){
					unset($proVal);
					$stmt->close();
					$conn->close();
					header("Location:sell_ownPsw-2.php");
					exit(0);
				}				
				else{
					unset($proVal);
					$stmt->close();
					$conn->close();
				}
			}
			else{
				session_unset();
				session_destroy();
				die('<h3>Sorry! Please Try Again Later.<br><br><a href="sell_logout.php">Go Back</a></h3>');
			}
		}
		else{
			session_unset();
			session_destroy();
			die('<h3>Sorry! Please Try Again Later.<br><br><a href="sell_logout.php">Go Back</a></h3>');
		}
	
	if(isset($_SESSION["sellcheck"])){
		include('conx.php');
			
		if($stmt = $conn->prepare("SELECT firm_name, office_add FROM register WHERE mbl_no=? LIMIT 1")) {
			if($stmt->bind_param("s", $_SESSION["sellcheck"])){
				$stmt->execute();
				$stmt->bind_result($fname, $office_add);
				$stmt->fetch();
				$stmt->close();
				$conn->close();
			}
		}
	}
	
?>

<!DOCTYPE html>
<html lang="en">
<head>

	<title>Dashboard | BiteToEat-Sell</title>
	
	<meta charset="utf-8">
	<meta name="sitelock-site-verification" content="307">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>	
	

	
	<style>					
		body{background-color:#edecec;}
		
		@font-face{
			font-family:abeezee;
			src:url(text/abeezee/ABeeZee-Regular.otf);			
		}
		@font-face{
			font-family:bellota;
			src:url(text/bellota/Bellota-Regular.otf);
		}
		@font-face{
			font-family:signika;
			src:url(text/signika/Signika-Bold.otf);
		}
		@font-face{
			font-family:barOne;
			src:url(text/signika/Signika-Regular.otf);
		}
		@font-face{
			font-family:muli;
			src:url(text/muli/Muli.ttf);
		}
		
		
		.navbar{			
			margin-bottom: 0;
			border-radius:0px;
			border:0;
			background-color:#1cb01c;
			position:relative;
			padding:15px;															
		}
		
		.navbar .navbar-nav li:last-child{padding-left:40px;padding-right:30px;border-left:2px dashed #ffffff;}
		
		#blogin{border:none;}
		
		.navbar .navbar-nav li a{
			color:#ffffff !important;
			background-color:#1cb01c !important;
			letter-spacing: 2px;
			font-family:barOne;
			font-size:18px;
			font-weight:bolder;
			cursor:pointer;
		}
		
		.navbar .navbar-nav li a:hover{
			color:#000000 !important;
		}
		
		.navbar-nav li.active a{
			color: #000000 !important;
			background-color: #1cb01c !important;
		}
		
		.navbar-default .navbar-toggle {
			border-color: transparent;
			background-color:#ffffff !important;
		}
		
		.navbar-default .navbar-toggle .icon-bar{background-color:#1cb01c !important;}
		
		ul.dropdown-menu{
			border:0;			
			background-color:#1cb01c;			
			box-shadow: 0px 5px 5px #1cb01c;
			padding-left:0px !important;
		}
		
		ul.dropdown-menu li{padding:10px;padding-left:0px !important;}

		.open .dropdown-menu li a{
			letter-spacing:3px;font-size:16px !important;									
		}	

		#myac{width:200px;}
		
		
		@media only screen and (max-width: 767px) {
			.navbar .navbar-nav li a:hover{
				color:#ffffff !important;
			}
			.navbar .navbar-nav li a:active{
				color:#000000 !important;
			}
			.navbar .navbar-nav li:last-child{padding-left:0px;border-left:none;}
		}	
		/*Navbar Css ends*/	
		


				
		.logo{
			height:70px;
			margin-top:-23px;
			margin-left:-15px;
		}
		@media only screen and (max-width: 767px){
			.logo{
				height:50px;	
				margin-top:-15px;	
			}
		}
		
		#dashboard{background-color:#ffffff;box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);padding:20px;margin-top:10px;margin-bottom:10px;}
		
		.style-txt{
			font-family:abeezee;			
		}
		
		.style-calcs{color:#ffffff;}
		
		#browse, #browse a{color:#8c8c8c;}
		
		.data-head{position:relative;z-index: 1;overflow: hidden;}
		
		.data-head:before, .data-head:after{
			position: absolute;
			top: 50%;
			overflow: hidden;
			width: 20%;
			height: 2px;
			content: '\a0';
			background-color: #1cb01c;
		}
		
		.data-head:before{
			margin-left: -21%;
			text-align: right;
		}
		
		.data-head:after{
			margin-left: 1%;
			text-align: right;
		}
		
	</style>

</head>

<body>

<!--Navbar Start-->	
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="sell.php"><img src="images/logoSellW.png" class="logo" alt="logo-text" /></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
		<li class="active"><a href="sell_login.php"><span class="glyphicon glyphicon-dashboard"></span> <span class="sidemenu-text">Dashboard</span></a></li> 
		<li><a href="orders.php"><span class="glyphicon glyphicon-bookmark"></span> <span class="sidemenu-text">Orders</span></a></li>
		<li><a href="sell_products.php"><span class="glyphicon glyphicon-glass"></span> <span class="sidemenu-text">Products</span></a></li>
		<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> <?php echo $fname; ?><span class="caret"></span></a>
			<ul class="dropdown-menu" id="myac">
			<li><a href="sell-settings.php"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>					
			<li id="blogin"><a href="sell_logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
          </ul>
        </li>	
      </ul>
    </div>
  </div>
</nav>
<!--Navbar End-->

<div style="padding-left:2%;padding-right:2%;">
<div class="container" id="dashboard" style="padding:20px;">	
	
	<div class="row" id="content">
		<div class="col-sm-12">
			<h2 class="style-txt" style="border-left:5px solid #1cb01c;padding:10px;"><?php echo $fname; ?><br><span style="font-size:18px;"><?php echo $office_add; ?></span></h2><br><br>
			<h4 class="style-txt" style="display:inline;padding:0px;">Welcome to BiteToEat </h4><h3 class="style-txt" style="display:inline;padding:0px;font-weight:bold;color:#1cb01c;">Seller Panel.</h3>
			<br><br>
			<h5 class="style-txt" id="browse">Browse through your, <a href="orders.php">Orders</a> | <a href="sell_products.php">Products</a> | <a href="sell_sett_myInfo.php">Settings</a></h5>
		</div>			
	</div>
	<br><br>
	<div class="row">
		<h3 class="style-txt text-center data-head">Orders Data</h3>
		
		<div class="col-sm-4" style="padding:5px;">
			<div class="calcs-content text-center" style="padding:5px;background-color:#1cb01c;">			
				<div style="padding:5px;border-radius:2px;border:2px dashed #ffffff;">
					<h3 class="style-txt style-calcs">Total Orders</h3>
					<?php
						$calcs_orders=0;	
						if(isset($_SESSION["sellcheck"])){
							include('conx.php');
								
							if($stmt = $conn->prepare("SELECT COUNT(seller) FROM orders_child WHERE seller=?")) {
								if($stmt->bind_param("s", $_SESSION["sellcheck"])){
									$stmt->execute();
									$stmt->bind_result($calcs_orders);
									$stmt->fetch();								
								}
							}
						}
						echo '<h2 class="style-txt style-calcs">'.$calcs_orders.'</h2>';
					?>
				</div>			
			</div>
		</div>
		
		<div class="col-sm-4" style="padding:5px;">
			<div class="calcs-content text-center" style="padding:5px;background-color:#1cb01c;">			
				<div style="padding:5px;border-radius:2px;border:2px dashed #ffffff;">
					<h3 class="style-txt style-calcs">Current Year Total Orders</h3>
					<?php
						$calcs_yorders=0;	
						if(isset($_SESSION["sellcheck"])){
							include('conx.php');
							
							date_default_timezone_set("Asia/Kolkata");						
							$date=date("Y");											
							
							if($stmt = $conn->prepare("SELECT count(seller) from orders_child, orders_parent where orders_child.order_parent_id=orders_parent.order_id AND orders_child.seller=? AND EXTRACT(YEAR FROM orders_parent.add_date)=?")) {
								if($stmt->bind_param("ss", $_SESSION["sellcheck"], $date)){
									$stmt->execute();
									$stmt->bind_result($calcs_yorders);
									$stmt->fetch();								
								}
							}
						}
						echo '<h2 class="style-txt style-calcs">'.$calcs_yorders.'</h2>';
					?>
				</div>			
			</div>
		</div>
		
		<div class="col-sm-4" style="padding:5px;">
			<div class="calcs-content text-center" style="padding:5px;background-color:#1cb01c;">			
				<div style="padding:5px;border-radius:2px;border:2px dashed #ffffff;">
					<h3 class="style-txt style-calcs">Current Month Total Orders</h3>
					<?php
						$calcs_morders=0;	
						if(isset($_SESSION["sellcheck"])){
							include('conx.php');
							
							date_default_timezone_set("Asia/Kolkata");						
							$year=date("Y");											
							$month=date("m");											
							
							if($stmt = $conn->prepare("SELECT count(seller) from orders_child, orders_parent where orders_child.order_parent_id=orders_parent.order_id AND orders_child.seller=? AND EXTRACT(YEAR FROM orders_parent.add_date)=? AND EXTRACT(MONTH FROM orders_parent.add_date)=?")) {
								if($stmt->bind_param("sss", $_SESSION["sellcheck"], $year, $month)){
									$stmt->execute();
									$stmt->bind_result($calcs_morders);
									$stmt->fetch();								
								}
							}
						}
						echo '<h2 class="style-txt style-calcs">'.$calcs_morders.'</h2>';
					?>
				</div>			
			</div>
		</div>
				
	</div>
	
	<br>
	
	<div class="row">	
		<h3 class="style-txt text-center data-head">Sales Data</h3>
		
		<div class="col-sm-4" style="padding:5px;">
			<div class="calcs-content text-center" style="padding:5px;background-color:#1cb01c;">			
				<div style="padding:5px;border-radius:2px;border:2px dashed #ffffff;">
					<h3 class="style-txt style-calcs">Total Sales</h3>
					<?php							
						if(isset($_SESSION["sellcheck"])){
							include('conx.php');
								
							if($stmt = $conn->prepare("SELECT SUM(subtotal) FROM orders_child WHERE seller=?")) {
								if($stmt->bind_param("s", $_SESSION["sellcheck"])){
									$stmt->execute();
									$stmt->bind_result($calcs_sales);
									$stmt->fetch();								
								}
							}
						}
						
						if(!$calcs_sales>0){
							$calcs_sales=0;
						}
						
						echo '<h2 class="style-txt style-calcs">&#x20B9;'.$calcs_sales.'</h2>';
					?>
				</div>			
			</div>
		</div>
		
		<div class="col-sm-4" style="padding:5px;">
			<div class="calcs-content text-center" style="padding:5px;background-color:#1cb01c;">			
				<div style="padding:5px;border-radius:2px;border:2px dashed #ffffff;">
					<h3 class="style-txt style-calcs">Highest Sale</h3>
					<?php
						if(isset($_SESSION["sellcheck"])){
							include('conx.php');																									
							
							if($stmt = $conn->prepare("SELECT MAX(subtotal) FROM orders_child WHERE seller=?")) {
								if($stmt->bind_param("s", $_SESSION["sellcheck"])){
									$stmt->execute();
									$stmt->bind_result($calcs_max);
									$stmt->fetch();								
								}
							}
						}
						
						if(!$calcs_max>0){
							$calcs_max=0;
						}
						
						echo '<h2 class="style-txt style-calcs">&#x20B9;'.$calcs_max.'</h2>';
					?>
				</div>			
			</div>
		</div>
		
		<div class="col-sm-4" style="padding:5px;">
			<div class="calcs-content text-center" style="padding:5px;background-color:#1cb01c;">			
				<div style="padding:5px;border-radius:2px;border:2px dashed #ffffff;">
					<h3 class="style-txt style-calcs">Lowest Sale</h3>
					<?php						
						if(isset($_SESSION["sellcheck"])){
							include('conx.php');
							
							date_default_timezone_set("Asia/Kolkata");						
							$date=date("m");											
							
							if($stmt = $conn->prepare("SELECT MIN(subtotal) FROM orders_child WHERE seller=?")) {
								if($stmt->bind_param("s", $_SESSION["sellcheck"])){
									$stmt->execute();
									$stmt->bind_result($calcs_min);
									$stmt->fetch();								
								}
							}
						}
						
						if(!$calcs_min>0){
							$calcs_min=0;
						}
						
						echo '<h2 class="style-txt style-calcs">&#x20B9;'.$calcs_min.'</h2>';
					?>
				</div>			
			</div>
		</div>
				
	</div>
	
</div>
</div>
</body>
</html>