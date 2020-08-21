<?php 
	session_start();
	unset($_SESSION["sellcheck"]);	
	if(isset($_SESSION["check"]))
	{
		header("Location:index.php");
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
				header("Location:c_login.php?data=Empty&err=001");				
			}
			else if(!preg_match("/^[0-9]{10}+$/",$mbl)){
				//Invalid Entry				
				header("Location:c_login.php?data=Invalid&err=002");
			}
			else if(empty($psw)){
				//Empty field				
				header("Location:c_login.php?data=Empty&err=001");				
			}
			else if(!preg_match("/^[a-zA-Z0-9\W ]{4,8}+$/",$psw)){
				//Invalid Entry				
				header("Location:c_login.php?data=Invalid&err=002");
			}
			else{
				require 'php_includes/functions.php';
				
				include('conx.php');																
				if($stmt = $conn->prepare("SELECT mbl_no, password from c_login WHERE mbl_no=? LIMIT 1")) {
					if($stmt->bind_param("s", $mbl)){
						$stmt->execute();
						$stmt->bind_result($dmbl, $dpsw);
						$stmt->fetch();
						if($dmbl==$mbl && $dpsw==$psw){
							$_SESSION["check"]=$mbl;
							unsetval();	
							$stmt->close();
							$conn->close();
							logoutCart();																					
							header("Location:index.php");
							exit(0);
						}
						else{
							unsetval();						
							$stmt->close();
							$conn->close();
							header("Location:c_login.php?data=Invalid&err=002");
						}
					}
					else{
						unsetval();						
						$stmt->close();
						$conn->close();
						header("Location:c_login.php?data=Invalid&err=002");
					}	
				}
				else{
					unsetval();					
					$conn->close();
					header("Location:c_login.php?data=Invalid&err=003");
				}
			}			
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>

	<title>Login | BiteToEat</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="Description" content="Order anything to eat or drink from the top brands in the market. BiteToEat provide its customers sweets deserts, dairy products, and services like juice, tiffin, etc. at reasonable prices within an hour at their doorstep." />
    <meta name="robots" content="index, follow">
	<meta name="googlebot" content="index, follow">	
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery.min.js"></script>
	<link href="css/jquery-ui.css" rel="stylesheet">
	<script src="js/bootstrap.min.js"></script>		
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/c_navbar.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/fonts.css">			
	
	<style>

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
			<h2><span class="glyphicon glyphicon-log-in"></span> Customer Login</h2>
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
		  <p style="font-family:abeezee;letter-spacing:2px;font-size:15px;">Need an account?<a href="c_signup.php" style="color:#1cb01c;cursor:pointer;">SignUp</a></p>
        </div>
	  </div>
  </div>
  
  <div class="col-sm-4 tohide"></div>
</div>  
</div>


</body>
</html>