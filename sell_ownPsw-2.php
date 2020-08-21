<?php
	session_start();
	if(!isset($_SESSION["sellcheck"]))
	{
		header("Location:sell.php");	
	}
	else{
		
		include('conx.php');
		
		if ($stmt = $conn->prepare("SELECT store_status FROM register WHERE mbl_no=? LIMIT 1")) {
			if($stmt->bind_param("s", $_SESSION["sellcheck"])){
				$stmt->execute();
				$stmt->bind_result($proVal);
				$stmt->fetch();
				if($proVal=='Set'){
					unset($proVal);
					$stmt->close();
					$conn->close();
					header("Location:sell_login.php");
					exit(0);
				}
				else if($proVal=='0'){
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
	}
	
	
	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);		
		return $data;
	}
	
	if($_SERVER["REQUEST_METHOD"]=="POST"){
		if(isset($_POST["continue2"])){
			
			$cpsw=test_input($_POST["cpsw"]);				
			$psw=test_input($_POST["psw"]);
			
			if(empty($cpsw)){
				//Empty field	
				unset($cpsw);
				unset($psw);
				header("Location:sell_ownPsw-2.php?data=Empty&err=001");
			}
			else if(!preg_match("/^[a-zA-Z0-9\W ]{4,8}+$/",$cpsw)){
				//Invalid Entry
				unset($cpsw);
				unset($psw);
				header("Location:sell_ownPsw-2.php?data=Invalid&err=002");
			}					
			else if(empty($psw)){
				//Empty field				
				unset($cpsw);
				unset($psw);
				header("Location:sell_ownPsw-2.php?data=Empty&err=001");			
			}
			else if(!preg_match("/^[a-zA-Z0-9\W ]{4,8}+$/",$psw)){
				//Invalid Entry
				unset($cpsw);
				unset($psw);
				header("Location:sell_ownPsw-2.php?data=Invalid&err=002");
			}
			else{ 
				include('conx.php');								
				if($stmt=$conn->prepare("SELECT password FROM s_login WHERE mbl_no=? LIMIT 1")){
					if($stmt->bind_param("s", $_SESSION["sellcheck"])){
						$stmt->execute();
						$stmt->bind_result($fpsw);						
						$stmt->fetch();
						if($fpsw!=$cpsw){
							unset($fpsw);
							unset($cpsw);
							unset($psw);
							header("Location:sell_ownPsw-2.php?data=Invalid&err=002");
							exit(0);
						}
						else{
							include('conx.php');	
							if($stmt = $conn->prepare("UPDATE s_login SET password=? WHERE mbl_no=?")){							
								if($stmt->bind_param("ss", $psw, $_SESSION["sellcheck"])){
									$stmt->execute();
									unset($fpsw);
									unset($cpsw);
									unset($psw);
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
							
							
							if($stmt = $conn->prepare("UPDATE register SET store_status=? WHERE mbl_no=?")) {
								$newProVal="Set";
								if($stmt->bind_param("ss", $newProVal, $_SESSION["sellcheck"])){
									$stmt->execute();
									unset($newProVal);					
									$stmt->close();
									$conn->close();
									header("Location:sell_login.php");
									exit(0);
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
						}
					}
				}
			}			
		}
		
		if(isset($_POST["skip"])){
			include('conx.php');
			
			if($stmt = $conn->prepare("UPDATE register SET store_status=? WHERE mbl_no=?")) {
				$newProVal="Set";
				if($stmt->bind_param("ss", $newProVal, $_SESSION["sellcheck"])){
					$stmt->execute();
					unset($newProVal);						
					$stmt->close();
					$conn->close();
					header("Location:sell_login.php");
					exit(0);
				}
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login | BiteToEat-Sell</title>
	<meta charset="utf-8">
	<meta name="sitelock-site-verification" content="307">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>		
	
	<style>
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
		
		/*Navbar Css Starts*/
		.navbar{			
			margin-bottom: 0;
			border-radius:0px;
			border:0;
			background-color:#1cb01c;
			position:relative;
			padding:15px;															
		}
		
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
		
		.navbar-default .navbar-toggle {
			border-color: transparent;
			background-color:#ffffff !important;
		}
		
		.navbar-default .navbar-toggle .icon-bar{background-color:#1cb01c !important;}
		/*Navbar Css ends*/
		
		/*store-form1 css starts*/
		.store1{
			background-image:url(images/background01.jpg);
			background-size:cover;
			background-position:center center;
			background-repeat:no-repeat;
			height:700px;
			padding-top:30px;
			padding-left:30px;
			padding-right:30px;
			overflow:hidden;	
		}
		
		@media only screen and (max-width: 767px){
			.store1 .col-sm-7{display:none;}
			
			.store1{
				padding-top:30px;
				padding-left:5px;
				padding-right:5px;
				height:700px	
			}
			
			.store1 .col-sm-5{
				padding-top:20px;
			}
		
			
		}
		
		.store1 div#store-form1{
			background-color:#f2f2f2;
			opacity:0.9;
			border-radius:15px;
			padding-bottom:20px;
			width:100%;
		}
		
		.store1 h3{color:#1cb01c;letter-spacing:1px;font-family:abeezee;font-size:25px;padding-bottom:15px;}
		
		.store1 .form-group label{
			color:#1cb01c;
			letter-spacing:1px;
			font-size:18px;
			font-family:abeezee;
		}
		
		.store1 input[type=password]{			
			outline:none;
			font-family:abeezee;
			color:#1cb01c;
			letter-spacing:1px;
			font-size:16px;
		}
		
		.store1 input[type=password]:focus{
			border:0.5px solid #1cb01c;
			box-shadow:0 0 5px 1px #1cb01c;
		}
		
		.store1 input[type=submit]{
			border-radius:0px;
			background-color:#1cb01c;
			color:#ffffff;			
			width:40%;
			border:none;
			padding:10px;
			font-size:15px;
			font-family:barOne;
			letter-spacing:2px;
			outline:none;
		}
		
		input.right{float:right;}
		
		.store1 input[type=submit]:hover, input[type=submit]:focus{
			background-color:#189a18;
		}
		
		.store1 input.left_b{float:left;}
		
		.store1 input.right_b{float:right;}
		/*store-form1 css ends*/	
		
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
			<li><a href="sell_logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
		</ul>
	</div>
  </div>
</nav>
<!--Navbar End-->
	
<!--store-form1 section starts-->
<div class="container-fluid store1">
<div class="row">
	<div class="col-sm-7"></div>
  
  <div class="col-sm-5">
	  <div class="container" id="store-form1">
		
		<div class="header text-left">
			<h2 style="font-family:signika;font-size:35px;letter-spacing:2px;padding:5px;color:#1cb01c;"><img src="images/store-icon.png" alt="store-icon" width="60" /> Setup Your Store Now</h2>
			<h3>Choose Your Own Password</h3>
		</div>
		
		<?php
			if(isset($_GET["err"]) && isset($_GET["data"])){			
				if($_GET["err"]=="001" && $_GET["data"]=="Empty"){
					echo '<span style="font-size:17px;font-family:muli;padding:10px;">*Empty field not allowed.</span>';
				}
				if($_GET["err"]=="002" && $_GET["data"]=="Invalid"){
					echo '<span style="font-size:17px;font-family:muli;padding:10px;">*Invalid entry made or wrong current user name.</span>';
				}				
			}	
		?>
		
		<div class="body" style="padding:20px;">
			<form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				
				<div class="form-group">
					<label for="cpsw">Current Password</label>
					<input type="password" class="form-control" name="cpsw" minlength="4" maxlength="8" placeholder="Enter current password"  />
				</div>
				
				<div class="form-group">
					<label for="psw">New Password</label>
					<input type="password" class="form-control" name="psw" minlength="4" maxlength="8" placeholder="Enter new password"  />
				</div>												
				<input class="right" type="submit" value="Continue" name="continue2" />
				<input type="submit" value="Skip" name="skip" />				
			</form>
		</div>
		
	  </div>
  </div>
</div>  
</div>	
<!--store-form1 section ends-->	

<!-- footer starts -->
<footer>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-3">
				<h4 style="border-bottom:1px dotted;padding-bottom:6px;">Navigate</h4>
				<h5><a href="sell.php">Home</a></h5>
				<h5><a href="sell.php#why-us">Why Us</a></h5>										
				<h5><a href="sell.php#requirements">Requirements</a></h5>					
			</div>									
			<div class="col-sm-3">
				<h4 style="border-bottom:1px dotted;padding-bottom:6px;">Follow Us</h4>
				<a href="https://www.facebook.com/PageBiteToEat/" target="_blank"><img src="images/follow-fb.png"  alt="follow-fb" height="40" /></a>								
			</div>
			<div class="col-sm-3">
				<h4 style="border-bottom:1px dotted;padding-bottom:6px;">Help &amp Support</h4>
				<h5><a href="s_contact.php#contact-us">Contact Us</a></h5>
				<h5><a href="sell_faqs.html">FAQs</a></h5>
			</div>			
			<div class="col-sm-3">
				<h4 style="border-bottom:1px dotted;padding-bottom:6px;">BiteToEat</h4>
				<h5><a href="s_contact.php">About Us</a></h5>				
				
			</div>
		</div><br><br>
		<hr width="60%">
		<center><p><a href="index.php" style="color:#1cb01c;text-decoration:none;">BiteToEat</a> &copy 2016</p></center>
	</div>	
	
</footer>
<!-- footer ends -->

<a href="#" onclick="window.open('https://www.sitelock.com/verify.php?site=bitetoeat.in','SiteLock','width=600,height=600,left=160,top=170');" ><img class="img-responsive" alt="SiteLock" title="SiteLock" src="//shield.sitelock.com/shield/bitetoeat.in" /></a>
</body>
</html>