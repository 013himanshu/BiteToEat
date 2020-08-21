<?php 
	session_start();	
	
	function unsetSess(){
		unset($_SESSION["p_id"]);
		unset($_SESSION["qty"]);
		unset($_SESSION["c"]);
		unset($_SESSION["d"]);
		unset($_SESSION["d_t"]);
		unset($_SESSION["action"]);
		unset($_SESSION["return"]);
	}
	
	if(isset($_SESSION["action"])){
		if(isset($_SESSION["p_id"])){
			$p_id=base64_decode($_SESSION["p_id"]);
		}
		if(isset($_SESSION["qty"])){
			$qty=$_SESSION["qty"];
		}
		if(isset($_SESSION["c"])){
			$c=$_SESSION["c"];
		}
		if(isset($_SESSION["d"])){
			$d=$_SESSION["d"];
		}
		if(isset($_SESSION["d_t"])){
			$d_t=$_SESSION["d_t"];
		}
		if(isset($_SESSION["return"])){
			$return=$_SESSION["return"];
		}		
		$action=$_SESSION["action"];		
	}
	
	unsetSess();
	
	if((!isset($action)=="direct_buy") || (!isset($action)=="cart_buy")){
		header("Location:view-cart.php");
		exit(0);
	}

	
	if(isset($_SESSION["check"])){
		if(isset($action) && $action=='direct_buy'){ 
			if(isset($p_id) && isset($qty)){								
				include('conx.php');
				if($stmt = $conn->prepare("SELECT server FROM products WHERE p_id=? LIMIT 1")) {
					if($stmt->bind_param("i", $p_id)){
						$stmt->execute();
						$stmt->bind_result($dbseller);										
						$stmt->fetch();
									
						date_default_timezone_set("Asia/Kolkata");
						$date=$time="";
						$date=date("Y-m-d");				
						$time=date("h:i:sa");
						include('conx.php');
						if($stmt = $conn->prepare("INSERT INTO cart (seller, customer, product_id, qty, add_date, add_time) VALUES (?, ?, ?, ?, ?, ?)")) {
							if($stmt->bind_param("ssiiss", $dbseller, $_SESSION["check"], $p_id, $qty, $date, $time)){
								$stmt->execute();
								$stmt->close();
								$conn->close();
							}
						}								
					}
				}
			}
		}
		
		include('conx.php');
		
		if($stmt = $conn->prepare("SELECT mbl_no, delivery_mbl, address, landmark, pincode, city, state, country FROM c_info WHERE mbl_no=?")) {
			if($stmt->bind_param("s", $_SESSION["check"])){
				$stmt->execute();
				$stmt->bind_result($mbl, $delivery_mbl, $address, $landmark, $pincode, $city, $state, $country);
				$stmt->fetch();			
			}	
			$stmt->close();
			$conn->close();
		}
		
		
		if($delivery_mbl==NULL){
			$delivery_mbl=$mbl;
		}
		if($address==NULL){
			$address="";
		}
		if($landmark==NULL){
			$landmark="";
		}
		if($pincode==NULL){
			$pincode="";
		}	
		if($city==NULL){
			$city="";
		}
		if($state==NULL){
			$state="";
		}
		if($country==NULL){
			$country="";
		}
	}	
	
?>
<!DOCTYPE html>
<html lang="en">
<head>

	<title>Buy Online Food And Services India | BiteToEat-A Network Of Food &amp; Services</title>
	
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
	body{background-color:#edecec;}				
		
		label{
			color:#1cb01c;
			letter-spacing:2px;
			font-size:18px;
			font-family:abeezee;
		}
		
		input[type=text], input[type=tel], input[type=password], textarea{
			width:280px;
			outline:none;
			font-family:abeezee;
			color:#1cb01c;
			letter-spacing:1px;
			font-size:15px;
			border-radius:2px;
		}
		
		input[type=text]:focus, input[type=tel]:focus, input[type=password]:focus, textarea:focus{
			border:0.5px solid #1cb01c;
			box-shadow:0 0 5px 1px #1cb01c;
			-webkit-box-shadow:0 0 5px 1px #1cb01c;
			-moz-box-shadow:0 0 5px 1px #1cb01c;
		}
		
		
		input[type=submit], .go-btn{			
			background-color:#1cb01c;
			color:#ffffff;
			width:280px;
			border:none;
			padding:7px;
			font-size:20px;
			font-family:barOne;
			letter-spacing:2px;
			outline:none;
			border-radius:2px;
		}
		
		input[type=submit]:hover, input[type=submit]:focus, .go-btn:hover, .go-btn:focus{
			background-color:#189a18;
		}
		
		.style-txt{
			font-family:muli;
		}								
		
		.banner-head{
			font-family:abeezee;
		}
		.side-glyph{
			color:#1cb01c;
			font-size:25px;
		}
		.banner-text{
			border-left:5px solid #1cb01c;
			padding:5px;
		}
				
		#wait span {			
			animation-name: blink;			
			animation-duration: 1.4s;			
			animation-iteration-count: infinite;			
			animation-fill-mode: both;
		}

		#wait span:nth-child(2) {			
			animation-delay: .2s;
		}

		#wait span:nth-child(3) {			
			animation-delay: .4s;
		}
		
		#wait span:nth-child(4) {			
			animation-delay: .6s;
		}

		@keyframes blink {			
			0% {
			  opacity: .2;
			}			
			20% {
			  opacity: 1;
			}			
			100% {
			  opacity: .2;
			}
		}
		.dot{font-size:22px;font-weight:bold;}
		</style>
			
		
		
	
</head>

<body id="home">

<!--Navbar Start-->	
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">      
      <a class="navbar-brand" href="sell.php"><img src="images/logoW.png" class="logo" alt="logo-text" /></a>
    </div>    
  </div>
</nav>
<!--Navbar End-->



<div class="container" style="margin-top:20px;padding:3px;">
	<div style="padding-bottom:10px;">
		<div class="container-fluid" style="padding:5px;background-color:#ffffff;box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);">
		
			<h3 id="loginHead" class="banner-head"><?php if(isset($_SESSION["check"])){ echo '<span class="glyphicon glyphicon-ok side-glyph"></span>'; } else echo '<span class="side-glyph" style="padding-left:10px;font-family:abeezee;font-size:25px;">1</span>'; ?> <span class="banner-text">Login</span></h3>
			
			<?php 
			
				if(!isset($_SESSION["check"])){					
					echo '<div id="loginDiv" style="padding-bottom:10px;"><hr>
							<form role="form" id="loginForm" name="loginForm" style="padding-left:2%;" autocomplete="off">
								<p id="login-err" style="font-size:15px;font-family:muli;padding:10px;"></p>
								<div class="form-group">
									<label for="mbl"><span class="glyphicon glyphicon-phone"></span> Mobile No.</label>
									<input type="tel" class="form-control" id="login-mbl" name="login-mbl" minlength="10" maxlength="10" placeholder="Enter your mobile no." required />					
								</div>
								<div class="form-group">
									<label for="psw"><span class="glyphicon glyphicon-lock"></span> Password</label>
									<input type="password" class="form-control" id="login-psw" name="login-psw" minlength="4" maxlength="8" placeholder="Enter your password" required />
								</div>
								<input type="submit" value="Login" id="loginBtn" name="loginBtn" />									        
								<br><br><p style="font-family:abeezee;letter-spacing:2px;font-size:15px;">Need an account?<a href="c_signup.php" style="color:#1cb01c;cursor:pointer;">SignUp</a></p>
							</form>
						</div>';
				}
			
			?>		
			
		</div>
	</div>
	
	<div style="padding-bottom:10px;">
		<div class="container-fluid" id="deliveryOuter" style="padding:5px;background-color:#ffffff;box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);">
			
			<h3 id="deliveryHead" class="banner-head"><span class="side-glyph" style="padding-left:10px;font-family:abeezee;font-size:25px;">2</span> <span class="banner-text">Delivery Details</span></h3>
			
			<?php 
			
				if(isset($_SESSION["check"]) && isset($action)=="direct_buy"){
					echo '<div id="deliveryDiv" style="padding-bottom:10px;"><hr>
						<form role="form" id="deliveryForm" name="deliveryForm" style="padding-left:2%;" autocomplete="off">
							<p id="delivery-err" style="font-size:15px;font-family:muli;padding:10px;"></p>
							<div class="form-group">
								<label for="mbl">Mobile No.</label>
								<input type="tel" class="form-control" id="delivery-mbl" name="delivery-mbl" minlength="10" maxlength="10" placeholder="Enter your mobile no." value="'.$delivery_mbl.'" required />					
							</div>
							<div class="form-group">
								<label for="pin">Pincode</label>
								<input type="tel" class="form-control" id="delivery-pincode" name="delivery-pincode" minlength="6" maxlength="6" placeholder="Enter your pincode." value="'.$pincode.'" required />					
							</div>
							<div class="form-group">
								<label for="address">Address</label><br>
								<textarea name="delivery-address" id="delivery-address" rows="3" cols="10" maxlength="200" placeholder="Enter your address." required style="resize:none;">'.$address.'</textarea>
							</div>
							<div class="form-group">
								<label for="landmark">Landmark</label>
								<input type="text" class="form-control" id="delivery-landmark" name="delivery-landmark" placeholder="(Optional)" value="'.$landmark.'" />					
							</div>
							<div class="form-group">
								<label for="city">City <span style="color:#000000;font-size:12px;">(Service currently available only in Jaipur)</span></label>													
							</div>
							<div class="form-group">
								<label for="state">State <span style="color:#000000;font-size:12px;">(Service currently available only in Rajasthan)</span></label>													
							</div>
							<div class="form-group">
								<label for="country">Country <span style="color:#000000;font-size:12px;">(Service currently available only in India)</span></label>													
							</div>
							<input type="submit" value="Continue" id="deliveryBtn" name="deliveryBtn" />
						</form>
					</div>';
				}
				
			
			?>
			
		</div>
	</div>
	
	<div style="padding-bottom:10px;">
		<div class="container-fluid" id="confirmOuter" style="padding:5px;background-color:#ffffff;box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);">
			<h3 id="confirmHead" class="banner-head"><span class="side-glyph" style="padding-left:10px;font-family:abeezee;font-size:25px;">3</span> <span class="banner-text">Confirm Order</span></h3>
		</div>
	</div>

	<div style="padding-bottom:10px;">
		<div class="container-fluid" id="payOuter" style="padding:5px;background-color:#ffffff;box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);">
			<h3 id="payHead" class="banner-head"><span class="side-glyph" style="padding-left:10px;font-family:abeezee;font-size:25px;">4</span> <span class="banner-text">Payment</span></h3>
		</div>
	</div>
	
</div>




<script>
	$(document).on("submit", "#loginForm", function(event){				
		event.preventDefault();									
		var mbl=document.forms["loginForm"]["login-mbl"].value;
		var psw=document.forms["loginForm"]["login-psw"].value;					
		var formData={ loginBtn:"loginBtn", mbl: mbl, psw: psw,};					
		$.ajax({
			method: "POST",
			url: "php_includes/getuser.php",
			data: formData
		}).done(function(msg){
			if(msg!="success"){
				$("#home").scrollTop(0);
				$("#login-err").html(msg);								
			}
			else{								
				$("#loginDiv").html("");								
				$("#loginHead").html("<span class='glyphicon glyphicon-ok side-glyph'></span> <span class='banner-text'>Login</span>");								
				$("#deliveryOuter").load("php_includes/get-delivery-form.php", { <?php if(isset($p_id) && isset($qty)){ echo 'key1:'.$p_id.', key2:'.$qty.','; } ?> action: '<?php echo $action; ?>' });						
			}							
		});																
	});												
</script>		
<script>
	$(document).on("submit", "#deliveryForm", function(event){				
		event.preventDefault();									
		var mbl=document.forms["deliveryForm"]["delivery-mbl"].value;
		var pin=document.forms["deliveryForm"]["delivery-pincode"].value;
		var address=document.forms["deliveryForm"]["delivery-address"].value;
		var landmark=document.forms["deliveryForm"]["delivery-landmark"].value;						
		var formData={ deliveryBtn:"deliveryBtn", mbl: mbl, pin: pin, address: address, landmark: landmark };						
		$.ajax({
			method: "POST",
			url: "php_includes/newdetails.php",
			data: formData
		}).done(function(msg){							
			if(msg!="success"){
				$("#home").scrollTop(0);
				$("#delivery-err").html(msg);								
			}
			else{
				$("#deliveryDiv").html("");	
				$("#deliveryHead").html("<span class='glyphicon glyphicon-ok side-glyph'></span> <span class='banner-text'>Delivery Details</span>");					
				$("#confirmOuter").load("php_includes/confirm.php", {'key1': '<?php echo str_shuffle("1234567890ABCDabcd"); ?>', 'key2': '<?php echo $action; ?>', <?php if(isset($p_id)){ echo 'key3:'.$p_id; } ?> });									
			}							
		});																
	});						
</script>
<script>
	$(document).on("click", "#confirmBtn", function(){
		$("#confirmDiv").html("");
		$("#confirmHead").html("<span class='glyphicon glyphicon-ok side-glyph'></span> <span class='banner-text'>Confirm Order</span>");
		$("#payOuter").load("php_includes/payment.php", {'key1': '<?php echo str_shuffle("!@$%^*123456ABCDabcd"); ?>', 'key2': '<?php echo $action; ?>',  <?php if(isset($p_id)){ echo 'key3:'.$p_id; } ?> });
	});
</script>
<script>
	$(document).on("click", "#payBtn", function(){		
		$("#payBtnDiv").html("<p id='wait' class='go-btn' style='text-align:center;'>Please wait<span class='dot'>.</span><span class='dot'>.</span><span class='dot'>.</span><span class='dot'>.</span></p>");			
		$("#payOuter").load("php_includes/orderOk.php", {'key1': '<?php echo str_shuffle("!@$%^*123456ABCDabcd"); ?>', 'key2': '<?php echo $action; ?>', <?php if(isset($p_id)){ echo 'key3:'.$p_id; } ?> });
		$("#payHead").html("<span class='glyphicon glyphicon-ok side-glyph'></span> <span class='banner-text'>Payment</span>");
	});
</script>
<script>
	$(document).on("click", "#continueShopBtn", function(){
		window.open("index.php", "_self");
	});
</script>

</body>
</html>