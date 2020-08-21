<?php 
	session_start();	
	if(isset($_SESSION["sellcheck"]))
	{
		unset($_SESSION["sellcheck"]);
	}	
	
	if(isset($_SESSION["check"])){
		header("Location:index.php");
		exit(0);
	}
	
?>

<?php 
	
	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);		
		return $data;
	}
	
	if($_SERVER["REQUEST_METHOD"]=="POST"){
		if(isset($_POST["signup"])){
		
			$name=test_input($_POST["name"]);
			$mbl=test_input($_POST["mbl"]);
			$email=test_input($_POST["email"]);			
			$psw=test_input($_POST["psw"]);			
		
			if(empty($name)){
				//Empty field	
				header("Location:c_signup.php?n_data=Empty&n_err=001");
			}
			else if(!preg_match("/^[a-zA-Z\.()_,\- ]+$/",$name)){
				//Invalid Entry	
				header("Location:c_signup.php?n_data=Invalid&n_err=002");
			}
			if(empty($mbl)){
				//Empty field	
				header("Location:c_signup.php?m_data=Empty&m_err=001");
			}
			else if(!preg_match("/^[0-9]{10}+$/",$mbl)){
				//Invalid Entry				
				header("Location:c_signup.php?m_data=Invalid&m_err=002");
			}
			else if(empty($email)){
				//Empty field				
				header("Location:c_signup.php?e_data=Empty&e_err=001");				
			}
			else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				//Invalid Entry				
				header("Location:c_signup.php?e_data=Invalid&e_err=002");
			}			
			else if(empty($psw)){
				//Empty field				
				header("Location:c_signup.php?p_data=Empty&p_err=001");	
			}
			else if(!preg_match("/^[a-zA-Z0-9\W ]{4,8}+$/",$psw)){
				//Invalid Entry					
				header("Location:c_signup.php?p_data=Invalid&p_err=002");
			}
			else{
				
				function login_det($mbl, $psw){
					include('conx.php');					
					if ($stmt = $conn->prepare("INSERT INTO c_login (mbl_no, password) VALUES (?, ?)")) {
						if($stmt->bind_param("ss", $mbl, $psw)){
							$stmt->execute();
						}
					}		
				}
				
					include('conx.php');
					if($stmt = $conn->prepare("SELECT mbl_no FROM c_info WHERE mbl_no=?")){
						if($stmt->bind_param("s", $mbl)){
							$stmt->execute();
							$stmt->bind_result($db_mbl);
							if($stmt->fetch()){
								//account already exists.
								header("Location:c_signup.php?m_data=Duplicate&m_err=003");
								exit(0);
							}
							else{
								include('conx.php');
				
								date_default_timezone_set("Asia/Kolkata");
								$date=$time="";
								$date=date("Y-m-d");				
								$time=date("h:i:sa");
								
								if($stmt = $conn->prepare("INSERT INTO c_info (name, mbl_no, email, add_date, add_time) VALUES (?, ?, ?, ?, ?)")) {
									if($stmt->bind_param("sssss", $name, $mbl, $email, $date, $time)){
										$stmt->execute();
										login_det($mbl, $psw);
										$_SESSION["check"]=$mbl;
										$stmt->close();
										$conn->close();										
										header("Location:index.php");
										exit(0);
									}
								}
							}
						}
					}	
			}			
		}
	}
?>


<!DOCTYPE html>
<html lang="en">
<head>

	<title>SignUp | BiteToEat</title>
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
		
		input[type=text], input[type=tel], input[type=email], input[type=password]{			
			outline:none;
			font-family:abeezee;
			color:#1cb01c;
			letter-spacing:1px;
			font-size:18px;
		}
		
		input[type=text]:focus, input[type=tel]:focus, input[type=email]:focus, input[type=password]:focus{
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
			<h2><span class="glyphicon glyphicon-user"></span> Customer SignUp</h2>
		</div>		
		<div class="body" style="padding:20px;">
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
					<input type="tel" class="form-control" name="mbl" minlength="10" maxlength="10" placeholder="Enter your mobile no."  required />
					<?php 
						if(isset($_GET["m_err"])){
							
							if($_GET["m_err"]=="001" && $_GET["m_data"]=="Empty"){
								echo '<span style="font-family:muli;">*Empty field.</span>';
							}
							if($_GET["m_err"]=="002" && $_GET["m_data"]=="Invalid"){
								echo '<span style="font-family:muli;">*Invalid entry.</span>';
							}
							if($_GET["m_err"]=="003" && $_GET["m_data"]=="Duplicate"){
								echo '<span style="font-family:muli;">*An account already exists with this no.</span>';
							}							
						}
					?>				
				</div>
				<div class="form-group">
					<label for="email">Email ID</label>
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
					<label for="psw">Password</label>
					<input type="password" class="form-control" name="psw" minlength="4" maxlength="8" placeholder="Enter your password (max characters : 8)" required />
					<?php 
						if(isset($_GET["p_err"])){
							
							if($_GET["p_err"]=="001" && $_GET["p_data"]=="Empty"){
								echo '<span style="font-family:muli;">*Empty field.</span>';
							}
							if($_GET["p_err"]=="002" && $_GET["p_data"]=="Invalid"){
								echo '<span style="font-family:muli;">*Invalid entry.</span>';
							}
						}
					?>
				</div>
				<input type="submit" value="SignUp" id="signup" name="signup" />
			</form>
		</div>
		<div class="modal-footer">          
		  <p style="font-family:abeezee;letter-spacing:2px;font-size:15px;">Account already exists?<a href="c_login.php" style="color:#1cb01c;cursor:pointer;">Login</a></p>
        </div>
	  </div>
  </div>
 
  <div class="col-sm-4 tohide"></div>
</div>  
</div>


</body>
</html>