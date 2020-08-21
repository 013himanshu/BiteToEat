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
	}
	
	
	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);		
		return $data;
	}
	function unsetval(){
		unset($owner_name);
		unset($res_add);
		unset($newProVal);
		unset($_SESSION["owner_name"]);
		unset($_SESSION["res_add"]);
	}
	
	if($_SERVER["REQUEST_METHOD"]=="POST"){
		if(isset($_POST["continue0"])){
			
			$owner_name=test_input($_POST["owner_name"]);				
			$res_add=test_input($_POST["res_add"]);
			
			//address proof data
			$ap_name     = $_FILES['add_proof']['name'];
			$ap_tmpName  = $_FILES['add_proof']['tmp_name'];
			$ap_size     = $_FILES['add_proof']['size'];
			$ap_targetPath = 'docs' . DIRECTORY_SEPARATOR. $ap_name;					
			$ap_ext = strtolower(pathinfo($ap_name, PATHINFO_EXTENSION));
			
			$_SESSION["owner_name"]=$owner_name;					
			$_SESSION["res_add"]=$res_add;
			
			if(empty($owner_name)){
				//Empty field	
				header("Location:sell_personalInfo-0.php?o_data=Empty&o_err=001");
			}
			else if(!preg_match("/^[a-zA-Z ]+$/",$owner_name)){
				//Invalid Entry	
				header("Location:sell_personalInfo-0.php?o_data=Invalid&o_err=002");
			}					
			else if(empty($res_add)){
				//Empty field				
				header("Location:sell_personalInfo-0.php?r_data=Empty&r_err=001");			
			}
			else if(!preg_match("/^[a-zA-Z0-9\.\+()_,\-\/ ]+$/",$res_add)){
				//Invalid Entry				
				header("Location:sell_personalInfo-0.php?r_data=Invalid&r_err=002");
			}
			else if(file_exists($ap_targetPath)){
				//error:Sorry, file already exists.Rename 				
				header("Location:sell_personalInfo-0.php?rn_data=Invalid&rn_err=002");
			}
			else if(!in_array($ap_ext, array('pdf'))){
				//error:Invalid file extension
				header("Location:sell_personalInfo-0.php?ex_data=Invalid&ex_err=002");
			}
			else if ( $ap_size/1024/1024 > 1 ) {
				//error:File size is exceeding maximum allowed size
				header("Location:sell_personalInfo-0.php?s_data=Invalid&s_rr=002");
			}
			else{
			
				
					include('conx.php');
					if($stmt = $conn->prepare("INSERT INTO s_docs (mbl_no, add_proof) VALUES (?,?)")) {
						if($stmt->bind_param("ss", $_SESSION["sellcheck"], $ap_targetPath)){
							$stmt->execute();
							move_uploaded_file($ap_tmpName,$ap_targetPath);
						}
						else{
							unsetval();						
							$stmt->close();
							$conn->close();
							session_unset();
							session_destroy();
							die('<h3>Sorry! Please Try Again Later.<br><br><a href="sell_logout.php">Go Back</a></h3>');
						}	
					}
					else{
						unsetval();						
						$stmt->close();
						$conn->close();
						session_unset();
						session_destroy();
						die('<h3>Sorry! Please Try Again Later.<br><br><a href="sell_logout.php">Go Back</a></h3>');
					}
				
			
											
				
				if($stmt = $conn->prepare("UPDATE register SET owner_name=?, res_add=?, store_status=? where mbl_no=?")) {
					$newProVal="1";
					if($stmt->bind_param("ssss", $owner_name, $res_add, $newProVal, $_SESSION["sellcheck"])){
						$stmt->execute();						
						unsetval();						
						$stmt->close();
						$conn->close();
						header("Location:sell_storeInfo-1.php");	
					}
					else{
						unsetval();						
						$stmt->close();
						$conn->close();
						session_unset();
						session_destroy();
						die('<h3>Sorry! Please Try Again Later.<br><br><a href="sell_logout.php">Go Back</a></h3>');
					}	
				}
				else{
					unsetval();					
					$conn->close();
					session_unset();
					session_destroy();
					die('<h3>Sorry! Please Try Again Later.<br><br><a href="sell_logout.php">Go Back</a></h3>');
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
			height:950px;
			padding-top:100px;
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
			width:100%;
		}
		
		.store1 h3{color:#1cb01c;letter-spacing:1px;font-family:abeezee;font-size:25px;padding-bottom:15px;}
		
		.store1 .form-group label{
			color:#1cb01c;
			letter-spacing:1px;
			font-size:18px;
			font-family:abeezee;
		}
		
		.store1 input[type=text], input[type=tel], input[type=email]{			
			outline:none;
			font-family:abeezee;
			color:#1cb01c;
			letter-spacing:1px;
			font-size:16px;
		}
		
		.store1 input[type=text]:focus, input[type=tel]:focus, input[type=email]:focus{
			border:0.5px solid #1cb01c;
			box-shadow:0 0 5px 1px #1cb01c;
		}
		
		.store1 input[type=submit]{
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
		
		.store1 input[type=submit]:hover, input[type=submit]:focus{
			background-color:#189a18;
		}
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
			<h3>Personal Information</h3>
		</div>
		
		<div class="body" style="padding:20px;">
			<form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" method="post">
				
				<div class="form-group">
					<label for="owner_name">Owner Name</label>
					<input type="text" class="form-control" name="owner_name" id="owner_name" placeholder="Enter your full name" value="<?php if(isset($_SESSION["owner_name"])){ echo $_SESSION["owner_name"]; } ?>" required />
					<?php
						if(isset($_GET["o_err"])){
							
							if($_GET["o_err"]=="001" && $_GET["o_data"]=="Empty"){
								echo '<span style="font-family:muli;font-size:17px;">*Empty field.</span>';
							}
							if($_GET["o_err"]=="002" && $_GET["o_data"]=="Invalid"){
								echo '<span style="font-family:muli;font-size:17px;">*Invalid entry.</span>';
							}
						}	
					?>
				</div>												
				
				<div class="form-group">
					<label for="res_add">Residential Address</label>
					<input type="text" class="form-control" name="res_add" placeholder="Enter your Residential Address" value="<?php if(isset($_SESSION["res_add"])){ echo $_SESSION["res_add"]; } ?>" required />
					<?php
						if(isset($_GET["r_err"])){
							
							if($_GET["r_err"]=="001" && $_GET["r_data"]=="Empty"){
								echo '<span style="font-family:muli;font-size:17px;">*Empty field.</span>';
							}
							if($_GET["r_err"]=="002" && $_GET["r_data"]=="Invalid"){
								echo '<span style="font-family:muli;font-size:17px;">*Invalid entry.</span>';
							}
						}	
					?>
				</div>
				
				<div class="form-group">
					<label for="add_proof">Address Proof (scanned copy) :</label>
					<input type="file" id="add_proof" name="add_proof" required />
					<?php					
						if(isset($_GET["rn_err"])){							
							if($_GET["rn_err"]=="002" && $_GET["rn_data"]=="Invalid"){
								echo '<span style="font-family:muli;font-size:15px;">*Please rename your file &amp; upload again.</span><br><br>';
							}												
						}					
						if(isset($_GET["ex_err"])){							
							if($_GET["ex_err"]=="002" && $_GET["ex_data"]=="Invalid"){
								echo '<span style="font-family:muli;font-size:15px;">*Only .pdf files allowed.</span><br><br>';
							}												
						}					
						if(isset($_GET["s_err"])){							
							if($_GET["s_err"]=="002" && $_GET["s_data"]=="Invalid"){
								echo '<span style="font-family:muli;font-size:15px;">*Image should be less than 1mb.</span><br><br>';
							}												
						}												
					?>
				</div>
				
				<input type="submit" value="Continue" name="continue0" />
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