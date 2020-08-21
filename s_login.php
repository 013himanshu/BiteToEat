<?php 
	session_start();
	unset($_SESSION["check"]);	
	if(isset($_SESSION["sellcheck"]))
	{
		header("Location:sell_login.php");
	}
	
?>

<?php 
	
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
	
	$mbl=$psw="";						
		
	if($_SERVER["REQUEST_METHOD"]=="POST"){
		if(isset($_POST["login"])){
			
			$mbl=test_input($_POST["mbl"]);	
			$psw=test_input($_POST["psw"]);
			
			$_SESSION["mbl"]=$mbl;
			$_SESSION["psw"]=$psw;
						
			if(empty($mbl)){
				//Empty field				
				header("Location:s_login.php?data=Empty&err=001");				
			}
			else if(!preg_match("/^[0-9]{10}+$/",$mbl)){
				//Invalid Entry				
				header("Location:s_login.php?data=Invalid&err=002");
			}
			else if(empty($psw)){
				//Empty field				
				header("Location:s_login.php?data=Empty&err=001");				
			}
			else if(!preg_match("/^[a-zA-Z0-9\W ]{4,8}+$/",$psw)){
				//Invalid Entry				
				header("Location:s_login.php?data=Invalid&err=002");
			}
			else{
				
				include('conx.php');								
				
				if($stmt = $conn->prepare("SELECT s_login.mbl_no, s_login.password, register.proceed, register.acc_status from s_login, register where s_login.mbl_no=register.mbl_no AND s_login.mbl_no=? LIMIT 1")) {
					if($stmt->bind_param("s", $mbl)){
						$stmt->execute();
						$stmt->bind_result($dmbl, $dpsw, $dproceed, $dbacc_status);
						$stmt->fetch();
						if($dmbl==$mbl && $dpsw==$psw && $dproceed=='Y' && $dbacc_status=='Active'){
							$_SESSION["sellcheck"]=$mbl;
							unsetval();	
							$stmt->close();
							$conn->close();	
							header("Location:sell_login.php");
						}
						else{
							unsetval();						
							$stmt->close();
							$conn->close();
							header("Location:s_login.php?data=Invalid&err=002");
						}
					}
					else{
						unsetval();						
						$stmt->close();
						$conn->close();
						header("Location:s_login.php?data=Invalid&err=002");
					}	
				}
				else{
					unsetval();					
					$conn->close();
					header("Location:s_login.php?data=Invalid&err=003");
				}
			}			
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>

	<title>BiteToEat-Sell</title>
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
		
	
		body{
			background-color:#f8f8f8;
		}
		
		.s_login-form{
			overflow:hidden;
			padding-top:150px;	
			box-sizing:border-box;
		}
		
		.s_login-form .form-start{
			display:table;
			padding:0px;
			width:100%;
			background-color:#ffffff;
			border:2px solid #1cb01c;
			border-radius:15px;
		}
		
		.s_login-form .header h2{
			color:#ffffff;
			background-color:#1cb01c;
			letter-spacing:2px;
			font-family:signika;
			padding:20px;
			margin:0;
			border-top-left-radius:10px;
			border-top-right-radius:10px;
		}
		
		.s_login-form .form-group label{
			color:#1cb01c;
			letter-spacing:2px;
			font-size:20px;
			font-family:abeezee;
		}
		
		input[type=tel], input[type=password]{			
			outline:none;
			font-family:abeezee;
			color:#1cb01c;
			letter-spacing:1px;
			font-size:18px;
		}
		
		input[type=tel]:focus, input[type=password]:focus{
			border:0.5px solid #1cb01c;
			box-shadow:0 0 5px 1px #1cb01c;
		}
		
		input[type=submit]{			
			background-color:#1cb01c;
			color:#ffffff;
			width:100%;
			border:none;
			padding:7px;
			font-size:20px;
			font-family:barOne;
			letter-spacing:2px;
			outline:none;
			border-radius:5px;
		}
		
		input[type=submit]:hover, input[type=submit]:focus{
			background-color:#189a18;
		}
		
		.s_login-form .logoText{padding:15px;}
		
		@media only screen and (max-width: 767px){
			.s_login-form{
				padding-top:30px;			
			}						
		}
		
		
	</style>
	
</head>

<body id="home">


<div class="container-fluid s_login-form">
<div class="row">
	<div class="col-sm-4 tohide"></div>
  
  <div class="col-sm-4">
	  <div class="container form-start">
		
		<div class="header text-center">
			<h2><span class="glyphicon glyphicon-log-in"></span> Seller Login</h2>
		</div>
		<?php
			if(isset($_GET["err"]) && isset($_GET["data"])){			
				if($_GET["err"]=="001" && $_GET["data"]=="Empty"){
					echo '<span style="font-size:17px;font-family:muli;padding:10px;">*Empty field.</span>';
				}
				if($_GET["err"]=="002" && $_GET["data"]=="Invalid"){
					echo '<span style="font-size:17px;font-family:muli;padding:10px;">*Invalid username or password.</span>';
				}
				if($_GET["err"]=="003" && $_GET["data"]=="Invalid"){
					echo '<span style="font-size:17px;font-family:muli;padding:10px;">*Some problem occured, please try again later.</span>';
				}
			}	
		?>
		<div class="body" style="padding:20px;">
			<form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">				
				<div class="form-group">
					<label for="mbl"><span class="glyphicon glyphicon-phone"></span> Mobile No.</label>
					<input type="tel" class="form-control" name="mbl" minlength="10" maxlength="10" placeholder="Enter your mobile no." value="<?php if(isset($_SESSION["mbl"])){ echo $_SESSION["mbl"]; } ?>" required />					
				</div>
				<div class="form-group">
					<label for="psw"><span class="glyphicon glyphicon-lock"></span> Password</label>
					<input type="password" class="form-control" name="psw" minlength="4" maxlength="8" placeholder="Enter your password" required />
				</div>
				<input type="submit" value="Login" id="login" name="login" />
			</form>
		</div>
		<div class="modal-footer">
          <p><a id="forgot" style="color:#1cb01c;cursor:pointer;font-family:abeezee;letter-spacing:2px;font-size:15px;">Forgot Password?</a></p>
		  <p style="font-family:abeezee;letter-spacing:2px;font-size:15px;">Need a store?<a href="sell.php" style="color:#1cb01c;cursor:pointer;">Register</a></p>
        </div>
	  </div>
  </div>
 
  <div class="col-sm-4 tohide"></div>
</div>  
</div>


</body>
</html>