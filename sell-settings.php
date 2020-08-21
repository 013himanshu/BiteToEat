<?php
	session_start();
	if(!isset($_SESSION["sellcheck"]))
	{
		header("Location:sell.php");	
	}
?>
<?php 

	include('conx.php');
	if ($stmt = $conn->prepare("SELECT owner_name, mbl_no, email, res_add, firm_name, firm_reg_no, office_no, office_add FROM register WHERE mbl_no=? LIMIT 1")) {
		if($stmt->bind_param("s", $_SESSION["sellcheck"])){		
			$stmt->execute();
			$stmt->bind_result($owner_name, $mbl, $email, $res_add, $firm_name, $firm_reg_no, $office_no, $office_add);
			$stmt->fetch();
			if($owner_name==NULL){
				$owner_name="";
			}
			if($mbl==NULL){
				$mbl="";
			}
			if($email==NULL){
				$email="";
			}	
			if($res_add==NULL){
				$res_add="";
			}
			if($firm_name==NULL){
				$firm_name="";
			}
			if($firm_reg_no==NULL){
				$firm_reg_no="";
			}
			if($office_no==NULL){
				$office_no="";
			}
			if($office_add==NULL){
				$office_add="";
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
	
	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);		
		return $data;
	}
	
	function unsetval(){
		unset($_SESSION["mbl"]);
		unset($_SESSION["psw"]);
		unset($_POST["mbl"]);
		unset($_POST["psw"]);
		unset($mbl);
		unset($psw);
	}
	
	if($_SERVER["REQUEST_METHOD"]=="POST"){
		if(isset($_POST["change_info"])){
			
			$owner_name=test_input($_POST["owner_name"]);
			$mbl=test_input($_POST["mbl"]);
			$email=test_input($_POST["email"]);
			$res_add=test_input($_POST["res_add"]);
			$firm_name=test_input($_POST["firm_name"]);
			$firm_reg_no=test_input($_POST["firm_reg_no"]);
			$office_no=test_input($_POST["office_no"]);
			$office_add=test_input($_POST["office_add"]);
			
			
			if(empty($owner_name)){
				//Empty field	
				header("Location:sell-settings.php?on_data=Empty&on_err=001");
			}
			else if(!preg_match("/^[a-zA-Z\.()_,\- ]+$/",$owner_name)){
				//Invalid Entry	
				header("Location:sell-settings.php?on_data=Invalid&on_err=002");
			}
			else if(empty($mbl)){
				//Empty field				
				header("Location:sell-settings.php?m_data=Empty&m_err=001");				
			}
			else if(!preg_match("/^[0-9]{10}+$/",$mbl)){
				//Invalid Entry				
				header("Location:sell-settings.php?m_data=Invalid&m_err=002");
			}
			else if(empty($email)){
				//Empty field				
				header("Location:sell-settings.php?e_data=Empty&e_err=001");				
			}
			else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				//Invalid Entry				
				header("Location:sell-settings.php?e_data=Invalid&e_err=002");
			}
			else if(empty($res_add)){
				//Empty field				
				header("Location:sell-settings.php?r_data=Empty&r_err=001");			
			}
			else if(!preg_match("/^[a-zA-Z0-9\.\+()_,\-\/ ]+$/",$res_add)){
				//Invalid Entry				
				header("Location:sell-settings.php?r_data=Invalid&r_err=002");
			}
			else if(empty($firm_name)) {
				//Empty field					
				header("Location:sell-settings.php?fn_data=Empty&fn_err=001 ");
			}
			else if(!preg_match("/^[a-zA-Z0-9 ]+$/",$firm_name)){
				//Invalid Entry					
				header("Location:sell-settings.php?fn_data=Invalid&fn_err=002");
			}
			else if(!preg_match("/^[a-zA-Z0-9]*$/",$firm_reg_no)){
				//Invalid Entry	
				header("Location:sell-settings.php?fr_data=Invalid&fr_err=002");
			}
			else if((strlen($office_no)>0) && (!preg_match("/^[0-9 ]{7,12}+$/",$office_no))){				
					//Invalid Entry				
					header("Location:sell-settings.php?ofn_data=Invalid&ofn_err=002");				
			}
			else if(!preg_match("/^[a-zA-Z0-9\.\+()_,\-\/ ]*$/",$office_add)){
				//Invalid Entry				
				header("Location:sell-settings.php?oa_data=Invalid&oa_err=002");
			}
			else{
				include('conx.php');
				if($firm_reg_no==""){
					$firm_reg_no=NULL;
				}
				if($office_no==""){
					$office_no=NULL;
				}
				if($office_add==""){
					$office_add=NULL;
				}
				
				
				
				if($stmt = $conn->prepare("UPDATE register SET owner_name=?, mbl_no=?, email=?, res_add=?, firm_name=?, firm_reg_no=?, office_no=?, office_add=? where mbl_no=?")) {
					if($stmt->bind_param("sssssssss", $owner_name, $mbl, $email, $res_add, $firm_name, $firm_reg_no, $office_no, $office_add, $_SESSION["sellcheck"])){
						$stmt->execute();
						$stmt->close();
						$conn->close();
						$_SESSION["update"]="success";
						header("Location:sell-settings.php");
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
		
		if(isset($_POST["change_psw"])){
				
				$cpsw=test_input($_POST["cpsw"]);				
				$psw=test_input($_POST["psw"]);
				$rpsw=test_input($_POST["rpsw"]);
				
				if(empty($cpsw)){
					//Empty field	
					unset($cpsw);
					unset($psw);
					unset($rpsw);
					header("Location:sell-settings.php?data=Empty&err=001");
				}
				else if(!preg_match("/^[a-zA-Z0-9\W ]{4,8}+$/",$cpsw)){
					//Invalid Entry
					unset($cpsw);
					unset($psw);
					unset($rpsw);
					header("Location:sell-settings.php?data=Invalid&err=002");
				}					
				else if(empty($psw)){
					//Empty field				
					unset($cpsw);
					unset($psw);
					unset($rpsw);
					header("Location:sell-settings.php?data=Empty&err=001");			
				}
				else if(!preg_match("/^[a-zA-Z0-9\W ]{4,8}+$/",$psw)){
					//Invalid Entry
					unset($cpsw);
					unset($psw);
					unset($rpsw);
					header("Location:sell-settings.php?data=Invalid&err=002");
				}
				else if(empty($rpsw)){
					//Empty field				
					unset($cpsw);
					unset($psw);
					unset($rpsw);
					header("Location:sell-settings.php?data=Empty&err=001");			
				}
				else if(!preg_match("/^[a-zA-Z0-9\W ]{4,8}+$/",$rpsw)){
					//Invalid Entry
					unset($cpsw);
					unset($psw);
					unset($rpsw);
					header("Location:sell-settings.php?data=Invalid&err=002");
				}
				else if($psw!=$rpsw){
					//No match
					unset($cpsw);
					unset($psw);
					unset($rpsw);
					header("Location:sell-settings.php?data=Invalid&err=003");
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
								header("Location:sell-settings.php?data=Invalid&err=004"); //Invalid cpsw
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
										$_SESSION["update"]="success";
										header("Location:sell-settings.php");
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
		
		if(isset($_POST["delete"])){
			
			$mbl=test_input($_POST["mbl"]);	
			$psw=test_input($_POST["psw"]);			
						
			if(empty($mbl)){
				//Empty field				
				header("Location:sell-settings.php?data=Empty&err=001");				
			}
			else if(!preg_match("/^[0-9]{10}+$/",$mbl)){
				//Invalid Entry				
				header("Location:sell-settings.php?data=Invalid&err=002");
			}
			else if(empty($psw)){
				//Empty field				
				header("Location:sell-settings.php?data=Empty&err=001");				
			}
			else if(!preg_match("/^[a-zA-Z0-9\W ]{4,8}+$/",$psw)){
				//Invalid Entry				
				header("Location:sell-settings.php?data=Invalid&err=002");
			}
			else if($_SESSION["sellcheck"]!=$mbl){
				//No match				
				header("Location:sell-settings.php?data=Invalid&err=003");
			}
			else{
				
				include('conx.php');								
				
				if($stmt = $conn->prepare("SELECT mbl_no, password from s_login WHERE mbl_no=? LIMIT 1")) {
					if($stmt->bind_param("s", $mbl)){
						$stmt->execute();
						$stmt->bind_result($dmbl, $dpsw);
						$stmt->fetch();
						if($dmbl!=$mbl || $dpsw!=$psw){
							unsetval();
							$stmt->close();
							$conn->close();	
							header("Location:sell-settings.php?data=Invalid&err=003"); //No match
						}
						else{
							include('conx.php');	
							if($stmt = $conn->prepare("UPDATE register SET acc_status=? WHERE mbl_no=?")) {	
								$acc_status="Closed";
								if($stmt->bind_param("ss", $acc_status, $_SESSION["sellcheck"])){
									$stmt->execute();
									unsetval();	
									unset($acc_status);
									$stmt->close();
									$conn->close();	
									header("Location:sell_logout.php");
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


if(isset($_SESSION["sellcheck"])){
	include('conx.php');
		
	if($stmt = $conn->prepare("SELECT firm_name FROM register WHERE mbl_no=? LIMIT 1")) {
		if($stmt->bind_param("s", $_SESSION["sellcheck"])){
			$stmt->execute();
			$stmt->bind_result($fname);
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

	<title>Store Settings | BiteToEat-Sell</title>
	
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
			background-color:transparent !important;
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
		
		/*tabs css starts*/
		.tabs h1{color:#1cb01c;padding:15px;}
		
		.nav-tabs { border-bottom: 3px solid #ddd; }
		
		.nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover { border-width: 0; }
		
		.nav-tabs > li > a { border:none; color:#666; font-family:muli; font-size:22px;  }
		
		.nav-tabs > li.active > a, .nav-tabs > li > a:hover { border: none; color: #1cb01c !important; background: transparent; }
		
		.nav-tabs > li > a::after { content: ""; background: #1cb01c; height: 2px; position: absolute; width: 100%; left: 0px; bottom: -1px; transition: all 250ms ease 0s; transform: scale(0); }
		
		.nav-tabs > li.active > a::after, .nav-tabs > li:hover > a::after { transform: scale(1); }
		
		.tab-pane { padding:5px; }
		
		.tab-content{padding:5px}		
		
		.tabs{background:#fff; box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3); margin-top:10px;margin-bottom:10px;}
		/*tabs css ends*/
		
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
			.tab-text{display:none;}
			.nav-tabs li a{padding-left:30px;padding-right:30px;}			
		}
		
		/*inputs*/
		input[type=tel], input[type=email], input[type=text], input[type=password]{
			border-radius:0px;
			outline:none;
			font-family:abeezee;
			color:#1cb01c;
			letter-spacing:1px;
			font-size:15px;
			width:300px;
		}
		
		input[type=tel]:focus, input[type=email]:focus, input[type=text]:focus, input[type=password]:focus{
			border:0.5px solid #1cb01c;
			box-shadow:0 0 5px 1px #1cb01c;
		}
		
		input[type=submit]{
			border-radius:0px;
			background-color:#1cb01c;
			color:#ffffff;
			width:300px;
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
		
		.form-group label{
			color:#1cb01c;
			letter-spacing:2px;
			font-size:16px;
			font-family:abeezee;
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
		<li><a href="sell_login.php"><span class="glyphicon glyphicon-dashboard"></span> <span class="sidemenu-text">Dashboard</span></a></li> 
		<li><a href="orders.php"><span class="glyphicon glyphicon-bookmark"></span> <span class="sidemenu-text">Orders</span></a></li>
		<li><a href="sell_products.php"><span class="glyphicon glyphicon-glass"></span> <span class="sidemenu-text">Products</span></a></li>
		<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"><span style="color:#000000;"><span class="glyphicon glyphicon-user"></span> <?php echo $fname; ?><span class="caret"></span></span></a>
		  <ul class="dropdown-menu" id="myac">
			<li class="active"><a href="sell-settings.php"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>					
			<li id="blogin"><a href="sell_logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
          </ul>
        </li>	
      </ul>
    </div>
  </div>
</nav>
<!--Navbar End-->


<div class="container tabs">
  <h2 style="font-family:abeezee;letter-spacing:2px;">Settings</h2><br>
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#chng-info"><span class="glyphicon glyphicon-info-sign"></span> <span class="tab-text">My Information</span></a></li>
    <li><a data-toggle="tab" href="#chng-psw"><span class="glyphicon glyphicon-lock"></span> <span class="tab-text">Change Password</span></a></li>
	<li><a data-toggle="tab" href="#dlt_act"><span class="glyphicon glyphicon-trash"></span> <span class="tab-text">Delete Store</span></a></li>
  </ul>

  <div class="tab-content">        
    <div id="chng-info" class="tab-pane fade in active">
		<h3 style="font-family:barOne;color:#1cb01c;">Edit My Information</h3>
		<h4 style="font-family:muli;">Fields marked with * are compulsory.</h4>
		<br>
		<form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off">
			<?php
				if(isset($_SESSION["update"])){
					if($_SESSION["update"]=="success"){
						echo '<span style="font-family:muli;font-size:17px;color:#1cb01c;"><span class="glyphicon glyphicon-ok"></span> Information Updated.</span><br><br>';
						unset($_SESSION["update"]);
					}
				}
			?>
			<div class="form-group">
				<label for="owner_name">*Owner Name</label>
				<input type="text" class="form-control" name="owner_name" placeholder="Enter your name." value="<?php if(isset($owner_name)){echo $owner_name;} ?>" required />
				<?php
					if(isset($_GET["on_err"])){							
						if($_GET["on_err"]=="001" && $_GET["on_data"]=="Empty"){
							echo '<span style="font-family:muli;font-size:16px;">*Empty field.</span>';
						}
						if($_GET["on_err"]=="002" && $_GET["on_data"]=="Invalid"){
							echo '<span style="font-family:muli;font-size:16px;">*Invalid entry.</span>';
						}
					}	
				?>
			</div>
			<div class="form-group">
				<label for="mbl">*Mobile No.</label>
				<input type="tel" class="form-control" name="mbl" minlength="10" maxlength="10" placeholder="Enter your mobile no." value="<?php if(isset($mbl)){echo $mbl;} ?>" required/>
				<?php
					if(isset($_GET["m_err"])){							
						if($_GET["m_err"]=="001" && $_GET["m_data"]=="Empty"){
							echo '<span style="font-family:muli;font-size:16px;">*Empty field.</span>';
						}
						if($_GET["m_err"]=="002" && $_GET["m_data"]=="Invalid"){
							echo '<span style="font-family:muli;font-size:16px;">*Invalid entry.</span>';
						}
					}	
				?>
			</div>
			<div class="form-group">
				<label for="email">*Email ID</label>
				<input type="email" class="form-control" name="email" placeholder="Enter your email id." value="<?php if(isset($email)){echo $email;} ?>" required/>
				<?php
					if(isset($_GET["e_err"])){							
						if($_GET["e_err"]=="001" && $_GET["e_data"]=="Empty"){
							echo '<span style="font-family:muli;font-size:16px;">*Empty field.</span>';
						}
						if($_GET["e_err"]=="002" && $_GET["e_data"]=="Invalid"){
							echo '<span style="font-family:muli;font-size:16px;">*Invalid entry.</span>';
						}
					}	
				?>
			</div>
			<div class="form-group">
				<label for="res_add">*Residential Address</label>
				<input type="text" class="form-control" name="res_add" placeholder="Enter your residential address." value="<?php if(isset($res_add)){echo $res_add;} ?>" required/>
				<?php
					if(isset($_GET["r_err"])){							
						if($_GET["r_err"]=="001" && $_GET["r_data"]=="Empty"){
							echo '<span style="font-family:muli;font-size:16px;">*Empty field.</span>';
						}
						if($_GET["r_err"]=="002" && $_GET["r_data"]=="Invalid"){
							echo '<span style="font-family:muli;font-size:16px;">*Invalid entry.</span>';
						}
					}	
				?>
			</div>
			<div class="form-group">
				<label for="firm_name">*Firm Name</label>
				<input type="text" class="form-control" name="firm_name" placeholder="Enter your firm name." value="<?php if(isset($firm_name)){echo $firm_name;} ?>" required />
				<?php
					if(isset($_GET["fn_err"])){							
						if($_GET["fn_err"]=="001" && $_GET["fn_data"]=="Empty"){
							echo '<span style="font-family:muli;font-size:16px;">*Empty field.</span>';
						}
						if($_GET["fn_err"]=="002" && $_GET["fn_data"]=="Invalid"){
							echo '<span style="font-family:muli;font-size:16px;">*Invalid entry.</span>';
						}
					}	
				?>
			</div>
			<div class="form-group">
				<label for="firm_reg_no">Firm Registration No.</label>
				<input type="text" class="form-control" name="firm_reg_no" placeholder="Enter your firm registraion no." value="<?php if(isset($firm_reg_no)){echo $firm_reg_no;} ?>" />
				<?php
					if(isset($_GET["fr_err"])){							
						if($_GET["fr_err"]=="001" && $_GET["fr_data"]=="Empty"){
							echo '<span style="font-family:muli;font-size:16px;">*Empty field.</span>';
						}
						if($_GET["fr_err"]=="002" && $_GET["fr_data"]=="Invalid"){
							echo '<span style="font-family:muli;font-size:16px;">*Invalid entry.</span>';
						}
					}	
				?>
			</div>
			<div class="form-group">
				<label for="office_no">Office No.</label>
				<input type="tel" class="form-control" name="office_no" maxlength="12" placeholder="Enter your office no." value="<?php if(isset($office_no)){echo $office_no;} ?>" />
				<?php
					if(isset($_GET["ofn_err"])){							
						if($_GET["ofn_err"]=="001" && $_GET["ofn_data"]=="Empty"){
							echo '<span style="font-family:muli;font-size:16px;">*Empty field.</span>';
						}
						if($_GET["ofn_err"]=="002" && $_GET["ofn_data"]=="Invalid"){
							echo '<span style="font-family:muli;font-size:16px;">*Invalid entry.</span>';
						}
					}	
				?>
			</div>
			<div class="form-group">
				<label for="office_add">Office Address</label>
				<input type="text" class="form-control" name="office_add" placeholder="Enter your office address." value="<?php if(isset($office_add)){echo $office_add;} ?>" />
				<?php
					if(isset($_GET["oa_err"])){							
						if($_GET["oa_err"]=="001" && $_GET["oa_data"]=="Empty"){
							echo '<span style="font-family:muli;font-size:16px;">*Empty field.</span>';
						}
						if($_GET["oa_err"]=="002" && $_GET["oa_data"]=="Invalid"){
							echo '<span style="font-family:muli;font-size:16px;">*Invalid entry.</span>';
						}
					}	
				?>
			</div>			
			<input type="submit" value="Save" name="change_info" />
		</form>		
    </div>
	
    <div id="chng-psw" class="tab-pane fade">
		<h3 style="font-family:barOne;color:#1cb01c;">Change Password</h3>
		<br>
		<form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off">
			<?php
				if(isset($_SESSION["update"])){
					if($_SESSION["update"]=="success"){
						echo '<span style="font-family:muli;font-size:17px;color:#1cb01c;"><span class="glyphicon glyphicon-ok"></span> Password changed.</span><br><br>';
							unset($_SESSION["update"]);
					}
				}
			?>
			<?php
				if(isset($_GET["err"])){							
					if($_GET["err"]=="001" && $_GET["data"]=="Empty"){
						echo '<span style="font-family:muli;font-size:16px;">*No empty fields allowed.</span><br><br>';
					}
					if($_GET["err"]=="002" && $_GET["data"]=="Invalid"){
						echo '<span style="font-family:muli;font-size:16px;">*No invalid entries allowed.</span><br><br>';
					}
					if($_GET["err"]=="003" && $_GET["data"]=="Invalid"){
						echo '<span style="font-family:muli;font-size:16px;">*New password &amp; retype new password does not match.</span><br><br>';
					}
					if($_GET["err"]=="004" && $_GET["data"]=="Invalid"){
						echo '<span style="font-family:muli;font-size:16px;">*Invalid current password.</span><br><br>';
					}
				}	
			?>
			<div class="form-group">
				<label for="current-pass">Current Password</label>
				<input type="password" class="form-control" name="cpsw" minlength="4" maxlength="8" required />
			</div>
			<div class="form-group">
				<label for="new-pass">New Password</label>
				<input type="password" class="form-control" name="psw" minlength="4" maxlength="8" required/>
			</div>
			<div class="form-group">
				<label for="re-new-pass">Retype New Password</label>
				<input type="password" class="form-control" name="rpsw" minlength="4" maxlength="8" required/>
			</div>								
			<input type="submit" value="Change" name="change_psw" />
		</form>		
    </div>
	
	<div id="dlt_act" class="tab-pane fade">
		<h3 style="font-family:barOne;color:#1cb01c;">Delete Account</h3>
		<br>
		<form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off">
			<?php
				if(isset($_GET["err"])){							
					if($_GET["err"]=="001" && $_GET["data"]=="Empty"){
						echo '<span style="font-family:muli;font-size:16px;">*No empty fields allowed.</span><br><br>';
					}
					if($_GET["err"]=="002" && $_GET["data"]=="Invalid"){
						echo '<span style="font-family:muli;font-size:16px;">*No invalid entries allowed.</span><br><br>';
					}
					if($_GET["err"]=="003" && $_GET["data"]=="Invalid"){
						echo '<span style="font-family:muli;font-size:16px;">*Invalid mobile no. or password</span><br><br>';
					}								
				}	
			?>
			<div class="form-group">
				<label for="mbl">Mobile No.</label>
				<input type="tel" class="form-control" name="mbl" minlength="10" maxlength="10" required />
			</div>
			<div class="form-group">
				<label for="psw">Password</label>
				<input type="password" class="form-control" name="psw" minlength="4" maxlength="8" required/>
			</div>											
			<input type="submit" value="Delete" name="delete" />
		</form>
	</div>
	
  </div>
</div>





</body>
</html>