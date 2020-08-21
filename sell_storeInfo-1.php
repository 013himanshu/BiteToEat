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
		unset($firm_reg_no);
		unset($office_no);
		unset($office_add);
		unset($newProVal);
		unset($_SESSION["firm_reg_no"]);
		unset($_SESSION["office_no"]);
		unset($_SESSION["office_add"]);
	}
			
	
	if($_SERVER["REQUEST_METHOD"]=="POST"){
		if(isset($_POST["continue1"])){
			
			$firm_reg_no=test_input($_POST["firm_reg_no"]);				
			$office_no=test_input($_POST["office_no"]);
			$office_add=test_input($_POST["office_add"]);						
			
			//docs details			
			$food_license_no=test_input($_POST["food_license_no"]);
			$pan_card_no=test_input($_POST["pan_card_no"]);
			$bank_ac_no=test_input($_POST["bank_ac_no"]);
			$tin_no=test_input($_POST["tin_no"]);
			
			//sessions
			$_SESSION["firm_reg_no"]=$firm_reg_no;					
			$_SESSION["office_no"]=$office_no;
			$_SESSION["office_add"]=$office_add;			
			
			//docs upload data			
			//food_license_upload
			$food_license_name     = $_FILES['food_license_upload']['name'];
			$food_license_tmpName  = $_FILES['food_license_upload']['tmp_name'];
			$food_license_size     = $_FILES['food_license_upload']['size'];
			$food_license_targetPath = 'docs' . DIRECTORY_SEPARATOR. $food_license_name;					
			$food_license_ext = strtolower(pathinfo($food_license_name, PATHINFO_EXTENSION));
			//pan_card_upload
			$pan_card_name     = $_FILES['pan_card_upload']['name'];
			$pan_card_tmpName  = $_FILES['pan_card_upload']['tmp_name'];
			$pan_card_size     = $_FILES['pan_card_upload']['size'];
			$pan_card_targetPath = 'docs' . DIRECTORY_SEPARATOR. $pan_card_name;					
			$pan_card_ext = strtolower(pathinfo($pan_card_name, PATHINFO_EXTENSION));
			//cancel_check_upload
			$cancel_name     = $_FILES['cancel_check_upload']['name'];
			$cancel_tmpName  = $_FILES['cancel_check_upload']['tmp_name'];
			$cancel_size     = $_FILES['cancel_check_upload']['size'];
			$cancel_targetPath = 'docs' . DIRECTORY_SEPARATOR. $cancel_name;					
			$cancel_ext = strtolower(pathinfo($cancel_name, PATHINFO_EXTENSION));
			//tin_no_upload
			$tin_name     = $_FILES['tin_no_upload']['name'];
			$tin_tmpName  = $_FILES['tin_no_upload']['tmp_name'];
			$tin_size     = $_FILES['tin_no_upload']['size'];
			$tin_targetPath = 'docs' . DIRECTORY_SEPARATOR. $tin_name;					
			$tin_ext = strtolower(pathinfo($tin_name, PATHINFO_EXTENSION));
			
			
			
			
			
			if(empty($firm_reg_no)){
				//Empty field	
				header("Location:sell_storeInfo-1.php?fr_data=Empty&fr_err=001");
			}
			else if(!preg_match("/^[a-zA-Z0-9]+$/",$firm_reg_no)){
				//Invalid Entry	
				header("Location:sell_storeInfo-1.php?fr_data=Invalid&fr_err=002");
			}					
			else if(empty($office_no)){
				//Empty field	
				header("Location:sell_storeInfo-1.php?n_data=Empty&n_err=001");	
			}
			else if(!preg_match("/^[0-9 ]{7,12}+$/",$office_no)){
				//Invalid Entry				
				header("Location:sell_storeInfo-1.php?n_data=Invalid&n_err=002");
			}
			else if(empty($office_add)){
				//Empty field		
				header("Location:sell_storeInfo-1.php?a_data=Empty&a_err=001");	
			}
			else if(!preg_match("/^[a-zA-Z0-9\.\+()_,\-\/ ]+$/",$office_add)){
				//Invalid Entry				
				header("Location:sell_storeInfo-1.php?a_data=Invalid&a_err=002");
			}			
			else if(empty($food_license_no)){
				//Empty field		
				header("Location:sell_storeInfo-1.php?fln_data=Empty&fln_err=001");	
			}
			else if(!preg_match("/^[a-zA-Z0-9 ]+$/",$food_license_no)){
				//Invalid Entry				
				header("Location:sell_storeInfo-1.php?fln_data=Invalid&fln_err=002");
			}
			else if(file_exists($food_license_targetPath)){
				//error:Sorry, file already exists.Rename 				
				header("Location:sell_storeInfo-1.php?flu_data=Invalid&flu_err=001");
			}
			else if(!in_array($food_license_ext, array('pdf'))){
				//error:Invalid file extension
				header("Location:sell_storeInfo-1.php?flu_data=Invalid&flu_err=002");
			}
			else if ( $food_license_size/1024/1024 > 1 ) {
				//error:File size is exceeding maximum allowed size
				header("Location:sell_storeInfo-1.php?flu_data=Invalid&flu_rr=003");
			}			
			else if(empty($pan_card_no)){
				//Empty field		
				header("Location:sell_storeInfo-1.php?pcn_data=Empty&pcn_err=001");	
			}
			else if(!preg_match("/^[a-zA-Z0-9 ]+$/",$pan_card_no)){
				//Invalid Entry				
				header("Location:sell_storeInfo-1.php?pcn_data=Invalid&pcn_err=002");
			}
			else if(file_exists($pan_card_targetPath)){
				//error:Sorry, file already exists.Rename 				
				header("Location:sell_storeInfo-1.php?pcu_data=Invalid&pcu_err=001");
			}
			else if(!in_array($pan_card_ext, array('pdf'))){
				//error:Invalid file extension
				header("Location:sell_storeInfo-1.php?pcu_data=Invalid&pcu_err=002");
			}
			else if ( $pan_card_size/1024/1024 > 1 ) {
				//error:File size is exceeding maximum allowed size
				header("Location:sell_storeInfo-1.php?pcu_data=Invalid&pcu_rr=003");
			}			
			else if(empty($bank_ac_no)){
				//Empty field		
				header("Location:sell_storeInfo-1.php?ban_data=Empty&ban_err=001");	
			}
			else if(!preg_match("/^[a-zA-Z0-9 ]+$/",$bank_ac_no)){
				//Invalid Entry				
				header("Location:sell_storeInfo-1.php?ban_data=Invalid&ban_err=002");
			}
			else if(file_exists($cancel_targetPath)){
				//error:Sorry, file already exists.Rename 				
				header("Location:sell_storeInfo-1.php?can_data=Invalid&can_err=001");
			}
			else if(!in_array($cancel_ext, array('pdf'))){
				//error:Invalid file extension
				header("Location:sell_storeInfo-1.php?can_data=Invalid&can_err=002");
			}
			else if ( $cancel_size/1024/1024 > 1 ) {
				//error:File size is exceeding maximum allowed size
				header("Location:sell_storeInfo-1.php?can_data=Invalid&can_rr=003");
			}			
			else if(empty($tin_no)){
				//Empty field		
				header("Location:sell_storeInfo-1.php?tn_data=Empty&tn_err=001");	
			}
			else if(!preg_match("/^[a-zA-Z0-9 ]+$/",$tin_no)){
				//Invalid Entry				
				header("Location:sell_storeInfo-1.php?tn_data=Invalid&tn_err=002");
			}
			else if(file_exists($tin_targetPath)){
				//error:Sorry, file already exists.Rename 				
				header("Location:sell_storeInfo-1.php?tu_data=Invalid&tu_err=001");
			}
			else if(!in_array($tin_ext, array('pdf'))){
				//error:Invalid file extension
				header("Location:sell_storeInfo-1.php?tu_data=Invalid&tu_err=002");
			}
			else if ( $tin_size/1024/1024 > 1 ) {
				//error:File size is exceeding maximum allowed size
				header("Location:sell_storeInfo-1.php?tu_data=Invalid&tu_rr=003");
			}			
			else{
				include('conx.php');								
				
				if($stmt = $conn->prepare("UPDATE s_docs SET fssai_upload=?, food_license_no=?, food_license_upload=?, pan_card_no=?, pan_card_upload=?, bank_ac_no=?, cancel_check_upload=?, tin_no=?, tin_no_upload=? WHERE mbl_no=?")) {
					if($stmt->bind_param("ssssssssss", $fssai_targetPath, $food_license_no, $food_license_targetPath, $pan_card_no, $pan_card_targetPath, $bank_ac_no, $cancel_targetPath, $tin_no, $tin_targetPath, $_SESSION["sellcheck"])){
						$stmt->execute();						
						move_uploaded_file($food_license_tmpName,$food_license_targetPath);
						move_uploaded_file($pan_card_tmpName,$pan_card_targetPath);
						move_uploaded_file($cancel_tmpName,$cancel_targetPath);
						move_uploaded_file($tin_tmpName,$tin_targetPath);
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
				
				if($stmt = $conn->prepare("UPDATE register SET firm_reg_no=?, office_no=?, office_add=?, store_status=? where mbl_no=?")) {
					$newProVal="2";
					if($stmt->bind_param("sssss", $firm_reg_no, $office_no, $office_add, $newProVal, $_SESSION["sellcheck"])){
						$stmt->execute();
						unsetval();						
						$stmt->close();
						$conn->close();
						header("Location:sell_ownPsw-2.php");	
					}
					else{
						unsetval();						
						$stmt->close();
						$conn->close();
						die('<h3>Sorry! Please Try Again Later.<br><br><a href="sell_logout.php">Go Back</a></h3>');
					}	
				}
				else{
					unsetval();					
					$conn->close();
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
			padding-top:30px;
			padding-left:30px;
			padding-right:30px;
			overflow:hidden;
			padding-bottom:5%;	
		}
		
		@media only screen and (max-width: 767px){
			.store1 .col-sm-7{display:none;}
			
			.store1{
				padding-top:30px;
				padding-left:5px;
				padding-right:5px;					
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
			<h3>Store Information</h3>
		</div>
		
		<div class="body" style="padding:20px;">
			<form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">				
				
				<div class="form-group">
					<label for="firm_reg_no">Firm Registration No.</label>
					<input type="text" class="form-control" name="firm_reg_no" placeholder="Enter your firm registration no." value="<?php if(isset($_SESSION["firm_reg_no"])){ echo $_SESSION["firm_reg_no"]; } ?>" />
					<?php
						if(isset($_GET["fr_err"])){
							
							if($_GET["fr_err"]=="001" && $_GET["fr_data"]=="Empty"){
								echo '<span style="font-family:muli;font-size:17px;">*Empty field.</span>';
							}
							if($_GET["fr_err"]=="002" && $_GET["fr_data"]=="Invalid"){
								echo '<span style="font-family:muli;font-size:17px;">*Invalid entry.</span>';
							}
						}	
					?>
				</div>
				
				<div class="form-group">
					<label for="office_no">Office No.</label>
					<input type="tel" class="form-control" name="office_no" maxlength="12" placeholder="Enter your office no." value="<?php if(isset($_SESSION["office_no"])){ echo $_SESSION["office_no"]; } ?>" />
					<?php
						if(isset($_GET["n_err"])){
							
							if($_GET["n_err"]=="001" && $_GET["n_data"]=="Empty"){
								echo '<span style="font-family:muli;font-size:17px;">*Empty field.</span>';
							}
							if($_GET["n_err"]=="002" && $_GET["n_data"]=="Invalid"){
								echo '<span style="font-family:muli;font-size:17px;">*Invalid entry.</span>';
							}
						}	
					?>
				</div>
				
				<div class="form-group">
					<label for="office_add">Office Address</label>
					<input type="text" class="form-control" name="office_add" placeholder="Enter your office address" value="<?php if(isset($_SESSION["office_add"])){ echo $_SESSION["office_add"]; } ?>" />
					<?php
						if(isset($_GET["a_err"])){							
							if($_GET["a_err"]=="001" && $_GET["a_data"]=="Empty"){
								echo '<span style="font-family:muli;font-size:17px;">*Empty field.</span>';
							}
							if($_GET["a_err"]=="002" && $_GET["a_data"]=="Invalid"){
								echo '<span style="font-family:muli;font-size:17px;">*Invalid entry.</span>';
							}
						}	
					?>
				</div>								
				<div class="form-group">
					<label for="food_license_no">Food License No.</label>
					<input type="text" class="form-control" name="food_license_no" placeholder="Enter your food license no." required />
					<?php
						if(isset($_GET["fln_err"])){							
							if($_GET["fln_err"]=="001" && $_GET["fln_data"]=="Empty"){
								echo '<span style="font-family:muli;font-size:17px;">*Empty field.</span>';
							}
							if($_GET["fln_err"]=="002" && $_GET["fln_data"]=="Invalid"){
								echo '<span style="font-family:muli;font-size:17px;">*Invalid entry.</span>';
							}
						}	
					?>
				</div>
				<div class="form-group">
					<label for="food_license_upload">Food License No. (scanned copy) :</label>
					<input type="file" id="food_license_upload" name="food_license_upload" required />
					<?php							
						if(isset($_GET["flu_err"])){							
							if($_GET["flu_err"]=="001" && $_GET["flu_data"]=="Invalid"){
								echo '<span style="font-family:muli;font-size:15px;">*Please rename your file &amp; upload again.</span><br><br>';
							}												
						}					
						if(isset($_GET["flu_err"])){							
							if($_GET["flu_err"]=="002" && $_GET["flu_data"]=="Invalid"){
								echo '<span style="font-family:muli;font-size:15px;">*Only .pdf files allowed.</span><br><br>';
							}												
						}					
						if(isset($_GET["flu_err"])){							
							if($_GET["flu_err"]=="003" && $_GET["flu_data"]=="Invalid"){
								echo '<span style="font-family:muli;font-size:15px;">*Image should be less than 1mb.</span><br><br>';
							}												
						}												
					?>
				</div>
				<div class="form-group">
					<label for="pan_card_no">Pan Card No.</label>
					<input type="text" class="form-control" name="pan_card_no" placeholder="Enter your pan card no." required />
					<?php
						if(isset($_GET["pcn_err"])){							
							if($_GET["pcn_err"]=="001" && $_GET["pcn_data"]=="Empty"){
								echo '<span style="font-family:muli;font-size:17px;">*Empty field.</span>';
							}
							if($_GET["pcn_err"]=="002" && $_GET["pcn_data"]=="Invalid"){
								echo '<span style="font-family:muli;font-size:17px;">*Invalid entry.</span>';
							}
						}	
					?>
				</div>
				<div class="form-group">
					<label for="pan_card_upload">Pan Card No. (scanned copy) :</label>
					<input type="file" id="pan_card_upload" name="pan_card_upload" required />
					<?php							
						if(isset($_GET["pcu_err"])){							
							if($_GET["pcu_err"]=="001" && $_GET["pcu_data"]=="Invalid"){
								echo '<span style="font-family:muli;font-size:15px;">*Please rename your file &amp; upload again.</span><br><br>';
							}												
						}					
						if(isset($_GET["pcu_err"])){							
							if($_GET["pcu_err"]=="002" && $_GET["pcu_data"]=="Invalid"){
								echo '<span style="font-family:muli;font-size:15px;">*Only .pdf files allowed.</span><br><br>';
							}												
						}					
						if(isset($_GET["pcu_err"])){							
							if($_GET["pcu_err"]=="003" && $_GET["pcu_data"]=="Invalid"){
								echo '<span style="font-family:muli;font-size:15px;">*Image should be less than 1mb.</span><br><br>';
							}												
						}												
					?>
				</div>
				<div class="form-group">
					<label for="bank_ac_no">Bank Account No.</label>
					<input type="text" class="form-control" name="bank_ac_no" placeholder="Enter your bank account no." required />
					<?php
						if(isset($_GET["ban_err"])){							
							if($_GET["ban_err"]=="001" && $_GET["ban_data"]=="Empty"){
								echo '<span style="font-family:muli;font-size:17px;">*Empty field.</span>';
							}
							if($_GET["ban_err"]=="002" && $_GET["ban_data"]=="Invalid"){
								echo '<span style="font-family:muli;font-size:17px;">*Invalid entry.</span>';
							}
						}	
					?>
				</div>
				<div class="form-group">
					<label for="cancel_check_upload">Cancel Cheque (scanned copy) :</label>
					<input type="file" id="cancel_check_upload" name="cancel_check_upload" required />
					<?php							
						if(isset($_GET["can_err"])){							
							if($_GET["can_err"]=="001" && $_GET["can_data"]=="Invalid"){
								echo '<span style="font-family:muli;font-size:15px;">*Please rename your file &amp; upload again.</span><br><br>';
							}												
						}					
						if(isset($_GET["can_err"])){							
							if($_GET["can_err"]=="002" && $_GET["can_data"]=="Invalid"){
								echo '<span style="font-family:muli;font-size:15px;">*Only .pdf files allowed.</span><br><br>';
							}												
						}					
						if(isset($_GET["can_err"])){							
							if($_GET["can_err"]=="003" && $_GET["can_data"]=="Invalid"){
								echo '<span style="font-family:muli;font-size:15px;">*Image should be less than 1mb.</span><br><br>';
							}												
						}												
					?>
				</div>
				<div class="form-group">
					<label for="tin_no">Tin No.</label>
					<input type="text" class="form-control" name="tin_no" placeholder="Enter your Tin no." required />
					<?php
						if(isset($_GET["tn_err"])){							
							if($_GET["tn_err"]=="001" && $_GET["tn_data"]=="Empty"){
								echo '<span style="font-family:muli;font-size:17px;">*Empty field.</span>';
							}
							if($_GET["tn_err"]=="002" && $_GET["tn_data"]=="Invalid"){
								echo '<span style="font-family:muli;font-size:17px;">*Invalid entry.</span>';
							}
						}	
					?>
				</div>
				<div class="form-group">
					<label for="tin_no_upload">Tin No. (scanned copy) :</label>
					<input type="file" id="tin_no_upload" name="tin_no_upload" required />
					<?php							
						if(isset($_GET["tu_err"])){							
							if($_GET["tu_err"]=="001" && $_GET["tu_data"]=="Invalid"){
								echo '<span style="font-family:muli;font-size:15px;">*Please rename your file &amp; upload again.</span><br><br>';
							}												
						}					
						if(isset($_GET["tu_err"])){							
							if($_GET["tu_err"]=="002" && $_GET["tu_data"]=="Invalid"){
								echo '<span style="font-family:muli;font-size:15px;">*Only .pdf files allowed.</span><br><br>';
							}												
						}					
						if(isset($_GET["tu_err"])){							
							if($_GET["tu_err"]=="003" && $_GET["tu_data"]=="Invalid"){
								echo '<span style="font-family:muli;font-size:15px;">*Image should be less than 1mb.</span><br><br>';
							}												
						}												
					?>
				</div>
								
				<input type="submit" value="Continue" name="continue1" />
			</form>
		</div>
		
	  </div>
  </div>
</div>  
</div>	
<!--store-form1 section ends-->	




<a href="#" onclick="window.open('https://www.sitelock.com/verify.php?site=bitetoeat.in','SiteLock','width=600,height=600,left=160,top=170');" ><img class="img-responsive" alt="SiteLock" title="SiteLock" src="//shield.sitelock.com/shield/bitetoeat.in" /></a>
</body>
</html>