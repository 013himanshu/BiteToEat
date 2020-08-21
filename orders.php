<?php	
	session_start();
	
	if(!isset($_SESSION["sellcheck"]))
	{
		header("Location:sell.php");	
	}

		include('conx.php');
		
		if ($stmt = $conn->prepare("SELECT store_status FROM register WHERE mbl_no=?")) {
			if($stmt->bind_param("s", $_SESSION["sellcheck"])){
				$stmt->execute();
				$stmt->bind_result($proVal);
				$stmt->fetch();
				if($proVal=='0'){
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

	<title>Orders | BiteToEat-Sell</title>
	
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
		
		label{			
			letter-spacing:2px;
			font-size:20px;
			font-family:abeezee;
		}			

		input[type=radio]{
			border: 0;
			height: 1px; 
			margin: -1px;
			padding: 0;
			position: absolute;
			width: 1px;
			display:none;
		}
		
		input[type=radio]+label{
			display:inline;
			padding:10px;
		}
		
		label.radio-text{cursor:pointer;font-size:18px;}
		
		input[type=radio]+label:before{
			content: '';
			display: inline-block;
			width: 18px;
			height: 18px;
			vertical-align: -3px;
			border-radius: 50%;          
			border: 3px solid #ffffff;
			margin-right: 10px;
			transition: 0.5s ease all;    
			cursor:pointer;
		}
		
		input[type=radio]:checked + label:before {
			background: #ffffff;
			box-shadow: 0 0 0 3px #ffffff;
			border: 3px solid #4c4a4a;
		}
		
		.orders-body{background-color:#ffffff;box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);margin-bottom:10px;}			
		
		.style-txt{font-family:abeezee;letter-spacing:2px;}
		
						
		
		/*sort-orders-bar starts*/
		.navbar-sort{			
			border-radius:0px;
			border:0;
			background-color:#4c4a4a;
			position:relative;
			box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);
			margin-top:10px;
			margin-bottom:5px;
		}
		
		.navbar-sort .navbar-nav li{
			line-height:50px;
		}
		
		.navbar-sort .navbar-nav li label{
			color:#ffffff !important;			
			letter-spacing: 3px;
			font-family:abeezee;
			font-size:18px;			
			cursor:pointer;
		}
		
		.navbar-sort .navbar-toggle {
			border-color: none;
			background-color:#4c4a4a !important;
		}
		
		.navbar-sort .navbar-default .navbar-toggle .icon-bar{background-color:#1cb01c !important;}
		/*sort-orders-bar ends*/
		
		.order-action{background-color:transparent;border:none;border:2px solid #1cb01c;outline:none;padding:5px;color:#1cb01c;font-family:barOne;letter-spacing:2px;font-size:15px;}
		.order-action:hover{background-color:#1cb01c;color:#ffffff;}
		
		.order-action-ok{background-color:#1cb01c;border:none;border:2px solid #1cb01c;outline:none;padding:5px;color:#ffffff;font-family:barOne;letter-spacing:2px;font-size:15px;}
	</style>

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
		<li><a href="sell_login.php"><span class="glyphicon glyphicon-dashboard"></span> <span class="sidemenu-text">Dashboard</span></a></li> 
		<li class="active"><a href="orders.php"><span class="glyphicon glyphicon-bookmark"></span> <span class="sidemenu-text">Orders</span></a></li>
		<li><a href="sell_products.php"><span class="glyphicon glyphicon-glass"></span> <span class="sidemenu-text">Products</span></a></li>
		<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> <?php echo $fname; ?><span class="caret"></span></a>
		  <ul class="dropdown-menu" id="myac">
			<li><a href="sell-settings.php"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>					
			<li id="blogin"><a href="sell_logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
          </ul>
        </li>	
      </ul>
    </div>
  </div>
</nav>
<!--Navbar End-->


<div style="padding-left:2%;padding-right:2%;">
		
		<nav class="navbar-sort navbar-default">
			<div class="container-fluid">
				<div class="navbar-header" style="padding-left:5px;">
				  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#searchOpt">
					<span class="glyphicon glyphicon-sort" id="glyphicon-sort" style="color:#ffffff;font-size:25px;"></span>			                       
				  </button>				  
					<h3 class="style-txt" style="color:#ffffff;">Sort Orders</h3>				  
				</div>
				<div class="collapse navbar-collapse" id="searchOpt">
				  <ul class="nav navbar-nav navbar-right"> 
					<li><input type="radio" id="all" name="searchBy" value="all" required checked /><label for="all" class="radio-text" style="width:160px;">All</label></li>
					<li><input type="radio" id="month" name="searchBy" value="month" required /><label for="month" class="radio-text" style="width:160px;">This Month</label></li>
					<li><input type="radio" id="today" name="searchBy" value="today" required /><label for="today" class="radio-text" style="width:160px;">Today</label></li>		
				  </ul>
				</div>
			</div>
		</nav>		
	
	<div class="container-fluid orders-body">		
				
		<div class="row orders-tables-div">			
			<div class="col-sm-12">
				<div id="displaying" style="font-family:barOne;border-left:5px solid #1cb01c;padding:5px;letter-spacing:1px;margin-bottom:5px;">
					<h4 id="display-wat"></h4>
				</div>
				
				<div class="table-responsive" id="table-responsive" style="height:800px;overflow:auto;">
					
				</div>
			</div>
		</div>
		
	</div>
</div>


<script>
	$(document).on("click", "input:radio[name=searchBy]", function(){				
		var opt=$('input:radio[name=searchBy]:checked').val();
		if(opt=="month"){
			opt="current month";
		}		
		$("#display-wat").html("Displaying "+opt+" orders.");
		var opt=$('input:radio[name=searchBy]:checked').val();
			var formData={ key1: '<?php echo str_shuffle("1234567890ABCDabcd"); ?>', opt: opt };
		
			$.ajax({
				method: "POST",
				url: "php_includes/getOrders.php",
				data: formData
			}).done(function(msg){					
					$("#table-responsive").html(msg);														
			});
		setInterval(function(){ 
			var opt=$('input:radio[name=searchBy]:checked').val();
			var formData={ key1: '<?php echo str_shuffle("1234567890ABCDabcd"); ?>', opt: opt };
		
			$.ajax({
				method: "POST",
				url: "php_includes/getOrders.php",
				data: formData
			}).done(function(msg){					
					$("#table-responsive").html(msg);														
			});
		}, 2000);
		$("#table-responsive").scrollTop(0);
	});
</script>
<script>	
	$(window).load(function(){
		$("#all").click();
		
		var width=$(window).width();		
		if(width<768){
			$("#displaying").append("<h5 style='font-family:barOne;'>Scroll <span class='glyphicon glyphicon-circle-arrow-left'></span> <span class='glyphicon glyphicon-circle-arrow-up'></span> <span class='glyphicon glyphicon-circle-arrow-down'></span> <span class='glyphicon glyphicon-circle-arrow-right'></span> on mobile and small devices to see full table.</h5><br>");
		}
		
	});
</script>
<script>
	$(document).on("blur", ".navbar-sort", function(){
		$(".navbar-collapse").collapse('hide');
	})
</script>
<script>
	$(document).on("click", ".order-action", function(){
		var pid=$(this).attr("pid");
		var id=$(this).attr("id");
		var opt=$('input:radio[name=searchBy]:checked').val();
		
		var formData={ key1: '<?php echo str_shuffle("1234567890ABCDabcd"); ?>', pid: pid, id: id, opt: opt };
		$.ajax({
			method: "POST",
			url: "php_includes/orderStatus.php",
			data: formData
		}).done(function(msg){															
			$("#"+opt).click();
		});
		
	});
</script>
</body>
</html>