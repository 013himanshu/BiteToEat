<?php
	session_start();
	
	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);		
		return $data;
	}
	
	if(isset($_SESSION["sellcheck"])){
		include('conx.php');
		if($stmt = $conn->prepare("SELECT owner_name FROM register WHERE mbl_no=?")) {
			if($stmt->bind_param("s", test_input($_SESSION["sellcheck"]))){
				$stmt->execute();
				$stmt->bind_result($owner_name);
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
	<title>Store Setup | BiteToEat-Sell</title>
	<meta charset="utf-8">
	<meta name="sitelock-site-verification" content="307">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="Description" content="Setup your store to start selling on BiteToEat | BiteToEat-Sell | Sell Online Food And Services India" />
	<meta name="robots" content="noindex, nofollow" />
	<meta name="googlebot" content="noindex, nofollow" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>		
	<link rel="stylesheet" href="css/fonts.css">
	
	<style>
		body{background-color:#edecec;}
		
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
		
		.banner-head{
			font-family:barOne;
			letter-spacing:1px;
			color:#1cb01c;
		}
		
		label{
			color:#1cb01c;
			letter-spacing:2px;			
			font-family:abeezee;
		}
		
		input[type=text], input[type=tel], input[type=password], #address{
			width:280px;
			outline:none;
			font-family:muli;
			color:#1cb01c;
			letter-spacing:1px;
			font-size:14px;
			border-radius:2px;
			resize:none;
		}
		
		input[type=text]:focus, input[type=tel]:focus, input[type=password]:focus, #address:focus{
			border:0.5px solid #1cb01c;
			box-shadow:0 0 2px 1px #1cb01c;
			-webkit-box-shadow:0 0 2px 1px #1cb01c;
			-moz-box-shadow:0 0 2px 1px #1cb01c;
		}
		
		input[type=submit], .go-btn{			
			background-color:#1cb01c;
			color:#ffffff;
			width:280px;
			border:none;
			padding:7px;
			font-size:18px;
			font-family:barOne;
			letter-spacing:2px;
			outline:none;
			border-radius:2px;
		}
		
		input[type=submit]:hover, input[type=submit]:focus, .go-btn:hover, .go-btn:focus{
			background-color:#189a18;
		}
		
		@media only screen and (max-width: 400px){
			input[type=text], input[type=tel], input[type=password], #address{
				width:100%;
			}
			
			input[type=submit], .go-btn{			
				width:100%;
			}			
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
		
		.err{
			font-size:15px;
			font-family:barOne;			
			padding:10px;
			color:#D8000C;
			background-color:#FFBABA;
			letter-spacing:1px;
		}				
		
		.setup-forms{
			padding-left:1%;
			padding-right:1%;
		}				
		
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
	


<div class="container" style="margin-top:20px;padding:3px;">
	
	<!--Personal Info-->
	<div style="padding-bottom:10px;">	
		<div class="container-fluid" id="personalOuter" style="padding:5px;background-color:#ffffff;box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);">
			<h3 id="personalHead" class="banner-head"><span class="glyphicon glyphicon-user"></span> Personal Info.</h3>						
			<div id="personalDiv"><hr>
				<form role="form" id="personalForm" name="personalForm" class="setup-forms" autocomplete="off">
					<span id="personal-err"></span>
					<div class="form-group">
						<label for="owner_name">Owner Name</label>
						<input type="text" class="form-control" name="owner_name" id="owner_name" placeholder="Enter your full name" <?php if(isset($owner_name)){echo 'value="'.$owner_name.'"';} ?> required />					
					</div>
					<div class="form-group">
						<label for="owner_name">Mobile No. <span style="color:rgba(0,0,0,0.5)">(Login Id)</span></label>
						<input type="tel" class="form-control" name="mbl" id="mbl" minlength="10" maxlength="10" placeholder="Enter your mobile no." <?php if(isset($_SESSION["sellcheck"])){echo 'value="'.$_SESSION["sellcheck"].'"';} ?> required />					
					</div>
					<div class="form-group" id="personalBtnDiv">
						<input type="submit" value="Proceed" id="personalBtn" name="personalBtn" />	
					</div>
				</form>
			</div>								
		</div>						
	</div>
	<!--Personal Info end-->
	
	<!--Store Info-->
	<div style="padding-bottom:10px;">	
		<div class="container-fluid" id="storeOuter" style="padding:5px;background-color:#ffffff;box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);">
			<h3 id="storeHead" class="banner-head"><span class="glyphicon glyphicon-home"></span> Store Info.</h3>
		</div>
	</div>
	<!--Store Info ends-->
	
</div>
	


<script>
	$(document).on("submit", "#personalForm", function(event){				
		event.preventDefault();
		$("#personalBtnDiv").html("<p id='wait' class='go-btn' style='text-align:center;'>Please wait<span class='dot'>.</span><span class='dot'>.</span><span class='dot'>.</span><span class='dot'>.</span></p>");
		var name=document.forms["personalForm"]["owner_name"].value;					
		var mbl=document.forms["personalForm"]["mbl"].value;				
		var formData={ personalBtn:"personalBtn", name: name, mbl: mbl };					
		$.ajax({
			method: "POST",
			url: "php_includes/store-personal.php",
			data: formData
		}).done(function(msg){
			if(msg!="success"){
				$("#home").scrollTop(0);
				$("#personal-err").html("<p style='font-size:14px;font-family:barOne;display:inline-block;padding:6px;color:#D8000C;background-color:#FFBABA;letter-spacing:1px;'><span class='glyphicon glyphicon-remove-sign'></span> "+msg+"</p>");
				$("#personalBtnDiv").html("<input type='submit' value='Proceed' id='personalBtn' name='personalBtn' />");
			}
			else{											
				$("#personalDiv").slideUp(450, function(){
					$("#personalDiv").remove();
					$("#personalHead").html("<span class='glyphicon glyphicon-ok'></span> Personal Info.");					
					$("#storeOuter").load("php_includes/get-store-info.php", { 'key1': '<?php echo str_shuffle("!@$%^*123456ABCDabcd"); ?>' });					
				});				
			}							
		});																
	});	
</script>
<script>
	$(document).on("submit", "#storeForm", function(event){				
		event.preventDefault();
		$("#storeBtnDiv").html("<p id='wait' class='go-btn' style='text-align:center;'>Please wait<span class='dot'>.</span><span class='dot'>.</span><span class='dot'>.</span><span class='dot'>.</span></p>");
		var address=document.forms["storeForm"]["address"].value;					
		var pan=document.forms["storeForm"]["pan"].value;				
		var tin=document.forms["storeForm"]["tin"].value;				
		var formData={ storeBtn:"storeBtn", address: address, pan: pan, tin: tin };					
		$.ajax({
			method: "POST",
			url: "php_includes/store-info.php",
			data: formData
		}).done(function(msg){
			if(msg!="success"){
				
				$("#store-err").html("<p style='font-size:14px;font-family:barOne;display:inline-block;padding:6px;color:#D8000C;background-color:#FFBABA;letter-spacing:1px;'><span class='glyphicon glyphicon-remove-sign'></span> "+msg+"</p>");
				$("#storeBtnDiv").html("<input type='submit' value='Proceed' id='storeBtn' name='storeBtn' />");
			}
			else{											
				$("#personalDiv").slideUp(450, function(){
					$("#personalDiv").remove();
					$("#personalHead").html("<span class='glyphicon glyphicon-ok'></span> Personal Info.");					
					$("#storeOuter").load("php_includes/get-store-info.php", { 'key1': '<?php echo str_shuffle("!@$%^*123456ABCDabcd"); ?>' });					
				});				
			}							
		});																
	});	
</script>

</body>
</html>