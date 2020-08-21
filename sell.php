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
		unset($reg_firm, $reg_mbl, $reg_email);
		unset($_POST["reg_firm"], $_POST["reg_mbl"], $_POST["reg_email"]);	
		unset($_SESSION["reg_firm"]);	
		unset($_SESSION["reg_mbl"]);
		unset($_SESSION["reg_email"]);
	}
	
	$reg_firm=$reg_mbl=$reg_email="";						
		
	if($_SERVER["REQUEST_METHOD"]=="POST"){
		if(isset($_POST["register"])){
			
			
			
			$reg_firm=test_input($_POST["reg_firm"]);
			$reg_mbl=test_input($_POST["reg_mbl"]);	
			$reg_email=test_input($_POST["reg_email"]);
			
			$_SESSION["reg_firm"]=$reg_firm;
			$_SESSION["reg_mbl"]=$reg_mbl;
			$_SESSION["reg_email"]=$reg_email;
			
			if (empty($reg_firm)) {
				//Empty field					
				header("Location:sell.php?f_data=Empty&f_err=001 ");
			}
			else if(!preg_match("/^[a-zA-Z0-9\.()_,\- ]+$/",$reg_firm)){
				//Invalid Entry					
				header("Location:sell.php?f_data=Invalid&f_err=002");
			}
			else if(empty($reg_mbl)){
				//Empty field				
				header("Location:sell.php?m_data=Empty&m_err=001");				
			}
			else if(!preg_match("/^[0-9]{10}+$/",$reg_mbl)){
				//Invalid Entry				
				header("Location:sell.php?m_data=Invalid&m_err=002");
			}
			else if(empty($reg_email)){
				//Empty field				
				header("Location:sell.php?e_data=Empty&e_err=001");				
			}
			else if(!filter_var($reg_email, FILTER_VALIDATE_EMAIL)){
				//Invalid Entry				
				header("Location:sell.php?e_data=Invalid&e_err=002");
			}
			else{
				
				function sendOTP($reg_firm, $reg_mbl, $reg_email, $reg_time){					
					include('conx.php');
					$string = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
					$string_shuffled = str_shuffle($string);
					$otp = substr($string_shuffled, 1, 8);
					if ($stmt = $conn->prepare("INSERT INTO s_login (mbl_no, password) VALUES (?, ?)")) {
						if($stmt->bind_param("ss", $reg_mbl, $otp)){
							$stmt->execute();
							
							//mail starts
							$to=$reg_email;
							$subject="Welcome to BiteToEat.";
							
							
							require 'PHPMailer/PHPMailerAutoload.php';

							$mail = new PHPMailer;

							$mail->isSMTP(); 
							
							$mail->SMTPOptions = array(
								'ssl' => array(
									'verify_peer' => false,
									'verify_peer_name' => false,
									'allow_self_signed' => true
								)
							);
							                                 
							$mail->Host = 'mail.bitetoeat.in';  
							$mail->SMTPAuth = true;                               
							$mail->Username = 'mail@bitetoeat.in';                 
							$mail->Password = 'i0=i3i2(q7Rr';                           
							$mail->SMTPSecure = 'tls';                          
							$mail->Port = 587;                                    

							$mail->setFrom('mail@bitetoeat.in', 'BiteToEat');
							$mail->addAddress($reg_email);     

							$mail->addReplyTo('mail@bitetoeat.in');

							$mail->isHTML(true);                                  

							$mail->Subject = $subject;
							$mail->Body    = '<div class="container" style="color:#1cb01c;font-family:arial;text-align:center;width:500px;border:2px solid;">
												<div class="logoText" style="background-color:#1cb01c;">
													<a href="sell.php"><img class="img-responsive" src="https://bitetoeat.in/images/logoW.png" alt="BiteToEat" style="width:70%;" /></a>
												</div>
												<div class="body">
													<h1 style="border-bottom:2px dashed;padding:5px;">Hello! '.$reg_firm.'.</h1>
													<h2><u>Your Login Details</u></h2>
												</div>		
												<div class="details" style="text-align:left;padding:20px;">
													<h3>Mobile No. : '.$reg_mbl.'</h3>
													<h3>Password : '.$otp.'</h3>
												</div>
												<div class="footer" style="text-align:left;border-top:2px dashed;">			
													<h4 style="padding:5px;">info@bitetoeat.in <span style="float:right;">Mail Sent On, ['.$reg_time.']</span></h4>			
												</div>
											</div>';
							$mail->AltBody = 'OTP : '.$otp;

							if(!$mail->send()) {
								echo 'Message could not be sent.';
								echo 'Mailer Error: ' . $mail->ErrorInfo;
							}
							else{
								header("Location:sell.php");
								exit(0);
							}
							unset($string);
							unset($string_shuffled);
							unset($otp);
							unset($to);
							unset($subject);
							unset($msg);					
						}
					}
				}
				
				include('conx.php');								
				
				date_default_timezone_set("Asia/Kolkata");
				$reg_date=$reg_time="";
				$reg_date=date("Y-m-d");				
				$reg_time=date("h:i:sa");
				
				$check="SELECT * FROM register WHERE mbl_no='$reg_mbl'";
				$result = $conn->query($check);
				$rows=$result->num_rows;
				
				if($rows>0){
					$_SESSION["registered"]="fail";						
					$conn->close();
					unsetval();
					header("Location:sell.php");
					exit(0);
				}
				else{
					include ('conx.php');
					if($stmt=$conn->prepare("INSERT INTO register (firm_name, mbl_no, email, reg_date, reg_time) VALUES (?, ?, ?, ?, ?)")){
						if($stmt->bind_param('sssss',$reg_firm, $reg_mbl, $reg_email, $reg_date, $reg_time)){
							$stmt->execute();
							sendOTP($reg_firm, $reg_mbl, $reg_email, $reg_time);
							$stmt->close();
							$conn->close();
							$_SESSION["registered"]="successful";					
							unsetval();
												
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

	<title>Sell Online Food And Services India | BiteToEat-Sell</title>
	<meta charset="utf-8">
	<meta name="sitelock-site-verification" content="307">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>				
	
	<?php
		if(isset($_SESSION["registered"])){			
			echo '<script>$(window).load(function(){$("#registermodal").modal("show");});</script>';		
		}
	?>
	
	<!--styling starts-->
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
		
		.navbar-nav li.active a{
			color: #000000 !important;
			background-color: #1cb01c !important;
		}
		
		.navbar-default .navbar-toggle {
			border-color: transparent;
			background-color:#ffffff !important;
		}
		
		.navbar-default .navbar-toggle .icon-bar{background-color:#1cb01c !important;}
		/*Navbar Css ends*/
		
		/*image-banner css starts*/
		.img-banner{
			background-image:url(images/sell-banner.jpg);
			background-size:cover;
			background-position:center center;
			background-repeat:no-repeat;
			height:450px;
			padding-top:0px;
			padding-left:50px;
			padding-right:50px;
			overflow:hidden;						
		}
		
		.img-banner .col-sm-5{
			padding:30px;
		}
		
		.img-banner div#register-form{
			width:260px;
			background-color:#ffffff;	
			padding:0;
			border-radius:10px;	
		}
		
		
		
		.img-banner .header h2{
			color:#ffffff;
			background-color:#1cb01c;
			letter-spacing:2px;
			font-family:signika;
			padding:20px;
			margin:0;
			border-top-left-radius:10px;
			border-top-right-radius:10px;
		}
		
		.img-banner .form-group label{
			color:#1cb01c;
			letter-spacing:2px;
			font-size:16px;
			font-family:abeezee;
		}
		
		.img-banner input[type=tel], input[type=email], input[type=text]{			
			outline:none;
			font-family:abeezee;
			color:#1cb01c;
			letter-spacing:1px;
			font-size:14px;
		}
		
		.img-banner input[type=tel]:focus, input[type=email]:focus, input[type=text]:focus{
			border:0.5px solid #1cb01c;
			box-shadow:0 0 5px 1px #1cb01c;
		}
		
		.img-banner input[type=submit]{			
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
		
		.img-banner input[type=submit]:hover, input[type=submit]:focus{
			background-color:#189a18;
		}
		
		@media only screen and (max-width: 767px){
			.img-banner .col-sm-6{display:none;}
			
			.img-banner{
				padding-top:30px;			
			}
			
			.img-banner .col-sm-5{
				padding:0px;
			}
		
			
		}
		/*image-banner css ends*/
		
		/*why-us css starts*/
		.why-us .img-circle{
			border:2px dashed #1cb01c;
		}
		
		.why-us{
			color:#1cb01c;
		}
		
		.why-us h1{
			font-family:signika;
			font-size:50px;
			padding-top:40px;
			padding-bottom:30px; 
			padding-left:10px;
			padding-right:10px;
			letter-spacing:1px;
		}
		
		.why-us .col-sm-3{padding:15px;}			
		
		.why-us p{font-family:abeezee;font-size:25px;letter-spacing:1px;padding:20px;}		
		/*why-us how-to css ends*/
		
		/*needs section css starts*/
		.needs{background-color:#1cb01c;color:#ffffff;padding-bottom:50px;}
		
		.needs h1{
			font-family:signika;
			font-size:50px;
			padding-top:40px;
			padding-bottom:30px; 
			padding-left:20px;
			padding-right:20px;	
			letter-spacing:1px;
		}
		
		.needs .col-sm-3{padding:40px;}
		
		.needs p{
			font-family:abeezee;
			font-size:30px;
			padding:15px;
			border-bottom:6px solid #ffffff;
			border-radius:30px;	
			letter-spacing:1px;
		}
		
		.needs .col-sm-12{padding-bottom:10px;}
		
		.needs .col-sm-12 a{
			font-family:abeezee;
			font-size:30px;
			padding:25px;
			border:6px solid #ffffff;
			border-radius:30px;	
			letter-spacing:1px;
			color:#ffffff;
			text-decoration:none;
		}
		/*needs section css ends*/
		
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
		
		/*Modal css starts*/
		.modal-header, .modal-header h1{
			background-color: #1cb01c;
			color:#ffffff !important;
			text-align: center;
			letter-spacing:2px;
			font-family:signika;
		}
		
		.form-group label{
			color:#1cb01c;
			letter-spacing:2px;
			font-size:18px;
			font-family:abeezee;
			}
		
		.modal-footer {
			background-color: #f2f2f2;
		}
		
		input[type=tel], input[type=password]{
			border-radius:0px;
			outline:none;
			font-family:abeezee;
			color:#1cb01c;
			letter-spacing:1px;
			font-size:14px;
		}
		
		input[type=tel]:focus, input[type=password]:focus{
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
			font-size:25px;
			font-family:barOne;
			letter-spacing:2px;
			outline:none;
		}
		input[type=submit]:hover, input[type=submit]:focus{
			background-color:#189a18;
		}			
		/*Modal css ends*/
		
		
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
	<!--styling ends-->
	
</head>

<body id="home">



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
		<li class="active"><a href="sell.php"><span class="glyphicon glyphicon-home"></span> Home</a></li> 		                		
        <li><a href="how_it_works.html" target="_blank"><span class="glyphicon glyphicon-edit"></span> How it Works</a></li>
		<li><a href="sell_faqs.html" target="_blank"><span class="glyphicon glyphicon-user"></span> FAQs</a></li>
        <li><a href="s_login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>					
      </ul>
    </div>
  </div>
</nav>
<!--Navbar End-->


<!--image banner starts-->
<div class="container-fluid img-banner">
<div class="row">
	<div class="col-sm-6" style="padding-top:150px;padding-left:70px;color:#ffffff;font-family:muli;font-size:40px;"><p class="margin">Sell With Us &amp Grow With Us</p></div>
  <!--regitration starts-->
  <div class="col-sm-5">
	  <div class="container" id="register-form">
		
		<div class="header text-center">
			<h2><span class="glyphicon glyphicon-edit"></span> Register</h2>
		</div>
		
		<div class="body" style="padding:20px;">
			<form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<div class="form-group">
					<label for="firm_name">Firm Name</label>
					<input type="text" class="form-control" name="reg_firm" id="firm_name" placeholder="Enter your firm name" value="<?php if(isset($_SESSION["reg_firm"])){ echo $_SESSION["reg_firm"]; } ?>" required />
					<?php
						if(isset($_GET["f_err"])){
							
							if($_GET["f_err"]=="001" && $_GET["f_data"]=="Empty"){
								echo '<span style="font-family:muli;">*Empty field.</span>';
							}
							if($_GET["f_err"]=="002" && $_GET["f_data"]=="Invalid"){
								echo '<span style="font-family:muli;">*Invalid entry.</span>';
							}
						}	
					?>
				</div>
				<div class="form-group">
					<label for="mbl">Mobile No.</label>
					<input type="tel" class="form-control" name="reg_mbl" minlength="10" maxlength="10" placeholder="Enter your mobile no." value="<?php if(isset($_SESSION["reg_mbl"])){ echo $_SESSION["reg_mbl"]; } ?>" required />					
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
					<label for="email">Email ID</label>
					<input type="email" class="form-control" name="reg_email" placeholder="Enter your email id" value="<?php if(isset($_SESSION["reg_email"])){ echo $_SESSION["reg_email"]; } ?>" required />
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
				<input type="submit" value="Register" id="reg_btn" name="register" />
			</form>
		</div>
		
	  </div>
  </div>
  <!--regitration starts-->
</div>  
</div>
<!--image banner ends-->

	
<!--why us section starts-->
<div class="container-fluid why-us text-center" id="why-us">	
	<div class="row">		
		<h1>Why do business with us?</h1>
		<br>
		
		<div class="col-sm-3">
			<img src="images/manycust.png" class="img-circle" alt="image 1" />
			<p>Many Customers Waiting For You In Your City</p>
		</div>
		
		<div class="col-sm-3">
			<img src="images/growbg.png" class="img-circle" alt="image 2" />	
			<p>Earn Big and Grow With Us</p>	
		</div>
		
		<div class="col-sm-3">
			<img src="images/securepay.png" class="img-circle" alt="image 3" />
			<p>Secure and Quick Payments</p>
		</div>
		
		<div class="col-sm-3">
			<img src="images/available.png" class="img-circle" alt="image 4" />
			<p>Always With You Through Every Step</p>
		</div>
	</div>
	
</div>
<!--why us section ends-->

<!--needs section starts-->
<div class="container-fluid needs text-center" id="requirements">	
	<div class="row">
		<h1>Requirements before starting up.</h1>
	
			<div class="col-sm-3">
				<p>Address<br>Proof</p>
			</div>
			
			<div class="col-sm-3">
				<p>Food<br>License</p>
			</div>
			
			<div class="col-sm-3">
				<p>Bank<br>Account</p>
			</div>
			
			<div class="col-sm-3">
				<p><br>Pancard</p>
			</div>
				
	</div>
	<br>
	<div class="row">
		<div class="col-sm-12">
			<a href="#home" onfocus='document.getElementById("firm_name").focus();'>Register Now</a>
		</div>
	</div>
</div>
<!--needs section ends-->


<!-- Modal register success starts -->
<div class="modal fade" id="registermodal" role="dialog">
   <div class="modal-dialog modal-sm">
     <div class="modal-content">
       <div class="modal-header text-center">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <p><img class="img-responsive" src="images/logoW.png" height="100"/></p>
       </div>
       <div class="modal-body">
		<?php
			if(isset($_SESSION["registered"])){
				if($_SESSION["registered"]=="successful"){
					echo '<p>You have been successfully registered.</p>
					<p>Your login password has been sent to you on your email.</p>';
					unset($_SESSION["registered"]);	
				}
				else if($_SESSION["registered"]=="fail"){
					echo '<p>You are already registered.</p>
					<p>Login with your registered mobile no. and password to re-open your store.</p>';
					unset($_SESSION["registered"]);	
				}
				else{
					echo '<p>Welcome! To BiteToEat - A Network Of Food &amp; Services.</p>';
					unset($_SESSION["registered"]);	
				}
				unset($_SESSION["registered"]);	
			}
		?> 
       </div>
       <div class="modal-footer">
			<p><span class="glyphicon glyphicon-envelope"></span> info&copy;bitetoeat.in</p>
			<p><span class="glyphicon glyphicon-phone"></span> 9694020006</p>
       </div>
     </div>
   </div>
</div>
<!-- Modal register success ends -->

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
				<h5><a href="contact-us.php#contact-us">Contact Us</a></h5>
				<h5><a href="sell_faqs.html">FAQs</a></h5>
			</div>			
			<div class="col-sm-3">
				<h4 style="border-bottom:1px dotted;padding-bottom:6px;">BiteToEat</h4>
				<h5><a href="contact-us.php">About Us</a></h5>				
				
			</div>
		</div><br><br>
		<hr width="60%">
		<center><p><a href="index.php" style="color:#1cb01c;text-decoration:none;">BiteToEat</a> &copy 2016</p></center>
	</div>	
	
</footer>
<!-- footer ends -->

</body>
</html>