<?php
	session_start();
	if(!isset($_SESSION["sellcheck"]))
	{
		header("Location:sell.php");	
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
		unset($p_type);
		unset($v_nv);
		unset($p_name);
		unset($p_desc);	
		unset($p_category);
		unset($p_ori_cost);
		unset($p_cost);
		unset($cost_on);
		unset($measure_unit);
		unset($p_discount);
		unset($p_discount_type);
		
		//image data
		unset($img_name);
		unset($img_tmpName);
		unset($img_size);
		unset($img_targetpath);
		unset($img_check);
		unset($img_ext);
	}
	
	
	
	if($_SERVER["REQUEST_METHOD"]=="POST"){
		if(isset($_POST["add_p"])){
			$p_type=test_input($_POST["p_type"]);		
			$v_nv=test_input($_POST["v_nv"]);			
			$p_name=test_input($_POST["p_name"]);
			$p_desc=test_input($_POST["p_desc"]);	
			$p_category=test_input($_POST["p_category"]);
			$p_ori_cost=test_input($_POST["p_ori_cost"]);
			$p_ori_cost=ltrim($p_ori_cost,0);
			$p_cost=test_input($_POST["p_cost"]);
			$p_cost=ltrim($p_cost,0);
			$cost_on=test_input($_POST["cost_on"]);
			$cost_on=ltrim($cost_on,0);
			$measure_unit=test_input($_POST["measure_unit"]);
			$p_discount=test_input($_POST["p_discount"]);
			$p_discount=ltrim($p_discount,0);
			$p_discount_type=test_input($_POST["p_discount_type"]);
			
			//img data
			$img_name     = $_FILES['p_img']['name'];
			$img_tmpName  = $_FILES['p_img']['tmp_name'];
			$img_size     = $_FILES['p_img']['size'];
			$img_targetPath = 'upload' . DIRECTORY_SEPARATOR. $img_name;
			$img_check = getimagesize($img_tmpName);		
			$img_ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
			
			
			
			if(empty($p_type)){
				//empty value
				unsetval();
				header("Location:sell_products.php?t_data=Empty&t_err=001");
			}
			else if(!preg_match("/^[a-zA-Z ]+$/",$p_type)){
				//invalid value
				header("Location:sell_products.php?t_data=Invalid&t_err=002");
			}
			if(empty($v_nv)){
				//empty value
				unsetval();
				header("Location:sell_products.php?vnv_data=Empty&vnv_err=001");
			}
			else if(!preg_match("/^[a-zA-Z ]+$/",$v_nv)){
				//invalid value
				unsetval();
				header("Location:sell_products.php?vnv_data=Invalid&vnv_err=002");
			}
			else if($img_check==false){
				//error:this is not image
				unsetval();
				header("Location:sell_products.php?ic_data=Invalid&ic_err=002");
			}	
			else if (file_exists($img_targetPath)) {
				//error:Sorry, file already exists.Rename 
				unsetval();
				header("Location:sell_products.php?it_data=Invalid&it_err=002");
			}
			else if ( !in_array($img_ext, array('jpg','jpeg','png')) ) {
				//error:Invalid file extension
				unsetval();
				header("Location:sell_products.php?ie_data=Invalid&ie_err=002");
			}
			else if ( $img_size/1024/1024 > 3 ) {
				//error:File size is exceeding maximum allowed size
				unsetval();
				header("Location:sell_products.php?is_data=Invalid&is_err=002");
			}
			else if(empty($p_name)){
				//empty value
				unsetval();
				header("Location:sell_products.php?pn_data=Empty&pn_err=001");
			}
			else if(!preg_match("/^[a-zA-Z0-9\.\+(),\-\| ]+$/",$p_name)){
				//invalid value
				unsetval();
				header("Location:sell_products.php?pn_data=Invalid&pn_err=002");
			}			
			else if((strlen($p_desc>0)) && (!preg_match("/^[a-zA-Z0-9\.\+(),\-\| ]+$/",$p_desc))){
				//invalid value
				unsetval();
				header("Location:sell_products.php?pd_data=Invalid&pd_err=002");
			}
			else if(empty($p_category)){
				//empty value
				unsetval();
				header("Location:sell_products.php?pc_data=Empty&pc_err=001");
			}
			else if(!preg_match("/^[a-zA-Z0-9\.(),\- ]+$/",$p_category)){
				//invalid value
				unsetval();
				header("Location:sell_products.php?pc_data=Invalid&pc_err=002");
			}
			else if(empty($p_ori_cost)){
				//empty value
				unsetval();
				header("Location:sell_products.php?poc_data=Invalid&poc_err=001");
			}
			else if(!preg_match("/^[0-9]+$/",$p_ori_cost)){
				//invalid value
				unsetval();
				header("Location:sell_products.php?poc_data=Invalid&poc_err=002");
			}
			else if(empty($p_cost)){
				//empty value
				unsetval();
				header("Location:sell_products.php?pco_data=Invalid&pco_err=001");
			}
			else if(!preg_match("/^[0-9]+$/",$p_cost)){
				//invalid value
				unsetval();
				header("Location:sell_products.php?pco_data=Invalid&pco_err=002");
			}
			else if(empty($cost_on)){
				//empty value
				unsetval();
				header("Location:sell_products.php?co_data=Invalid&co_err=001");
			}
			else if(!preg_match("/^[0-9]+$/",$cost_on)){
				//invalid value
				unsetval();
				header("Location:sell_products.php?co_data=Invalid&co_err=002");
			}
			else if(empty($measure_unit)){
				//empty value
				unsetval();
				header("Location:sell_products.php?mu_data=Invalid&mu_err=001");
			}
			else if(!preg_match("/^[a-zA-Z ]+$/",$measure_unit)){
				//invalid value
				unsetval();
				header("Location:sell_products.php?mu_data=Invalid&mu_err=002");			
			}			
			else if(!preg_match("/^[1-9]*[0-9]*$/",$p_discount)){
				//invalid value
				unsetval();
				header("Location:sell_products.php?pdi_data=Invalid&pdi_err=002");	
			}			
			else if(!preg_match("/^[a-zA-Z ]*$/",$p_discount_type)){
				//invalid value
				unsetval();
				header("Location:sell_products.php?pdit_data=Invalid&pdit_err=002");	
			}
			else if((strlen($p_discount)>0) && ($p_discount_type=="")){
				//Error:discount type not selected
				unsetval();
				header("Location:sell_products.php?pdit_data=Invalid&pdit_err=003");	
			}
			else if((strlen($p_discount)>0) && ($p_discount===0)){
				//Error:discount cannot be 0
				unsetval();
				header("Location:sell_products.php?pdit_data=Invalid&pdit_err=004");
			}
			else if(($p_discount_type!="") && ($p_discount<1)){
				unsetval();
				header("Location:sell_products.php?pdit_data=Invalid&pdit_err=005");
			}
			else{
				
				if($p_discount=="" || $p_discount<1){
					$p_discount=NULL;
					$p_discount_type=NULL;
				}
				
				if($p_desc==""){
					$p_desc=NULL;
				}
				
				include('conx.php');
				
				date_default_timezone_set("Asia/Kolkata");
				$date=$reg_time="";
				$date=date("Y-m-d");				
				$time=date("h:i:sa");
				
				if($stmt = $conn->prepare("INSERT INTO products (server, p_type, v_nv, p_img, p_name, p_desc, p_category, p_ori_cost, p_cost, cost_on, measure_unit, p_discount, p_discount_type, add_date, add_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
					if($stmt->bind_param("sssssssiiisisss", $_SESSION["sellcheck"], $p_type, $v_nv, $img_targetPath, $p_name, $p_desc, $p_category, $p_ori_cost, $p_cost, $cost_on, $measure_unit, $p_discount, $p_discount_type, $date, $time)){
						$stmt->execute();
						move_uploaded_file($img_tmpName,$img_targetPath);
						unsetval();						
						header("Location:sell_products.php");
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

	<title>Products | BiteToEat-Sell</title>
	
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
		
		input[type=tel], input[type=email], input[type=text], #p_desc{
			border-radius:0px;
			outline:none;
			font-family:abeezee;
			color:#1cb01c;
			letter-spacing:1px;
			font-size:15px;
			width:95%;
			resize:none;
		}
		
		input[type=tel]:focus, input[type=email]:focus, input[type=text]:focus, #p_desc:focus{
			border:0.5px solid #1cb01c;
			box-shadow:0 0 5px 1px #1cb01c;
		}
		
		input[type=submit]{
			border-radius:0px;
			background-color:#1cb01c;
			color:#ffffff;
			width:50%;
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
			display:block;
			padding:10px;
		}
		
		label.radio-text{cursor:pointer;font-size:18px;}
		
		input[type=radio]+label:before{
			content: '';
			display: inline-block;
			width: 22px;
			height: 22px;
			vertical-align: -6px;
			border-radius: 50%;          
			border: 3px solid #1cb01c;
			margin-right: 10px;
			transition: 0.5s ease all;    
			cursor:pointer;
		}
		
		input[type=radio]:checked + label:before {
			background: #1cb01c;
			box-shadow: 0 0 0 3px #1cb01c;
			border: 3px solid #fff;
		}
		
		input[type=file]{
			font-family:muli;
			font-size:16px;
			
		}
				

		
		
		/*body css ends*/
		
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
		
		.tabs{background:#fff none repeat scroll 0% 0%; box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3); margin-top:10px;margin-bottom:10px;}
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
		}
		
		/*thumbnail css starts*/
			.thumbnail:hover, .thumbnail:focus{
				border:2px solid #1cb01c;
				cursor:pointer;
			}
		
			.thumb_data input[type=button]{
				border-radius:0px;
				background-color:#1cb01c;
				color:#ffffff;
				width:70%;
				border:none;
				padding:7px;
				font-size:20px;
				font-family:barOne;
				letter-spacing:2px;
				outline:none;
			}
			
			.thumb_data input[type=button]:hover, .thumb_data input[type=button]:focus{
				background-color:#189a18;
			}
						
		/*thumbnail css ends*/
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
		<li class="active"><a href="sell_products.php"><span class="glyphicon glyphicon-glass"></span> <span class="sidemenu-text">Products</span></a></li>
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


<div class="container tabs">
  <h1>My Products</h1><br><br>
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#add_p">Add Product</a></li>
    <li><a data-toggle="tab" href="#my_p">My Products</a></li>
  </ul>

  <div class="tab-content">        
    <div id="add_p" class="tab-pane fade in active">
      <h3>Add a new product...</h3><br>
	  
		<form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" autocomplete="off">						
			<div class="form-group">
				<label for="p_type">Product Type :</label>
				<input type="radio" id="one-time" name="p_type" value="One Time" required /><label for="one-time" class="radio-text" style="width:160px;">One Time</label>
				<input type="radio" id="service" name="p_type" value="Service" required /><label for="service" class="radio-text" style="width:160px;">Service</label>
				<?php					
					if(isset($_GET["t_err"])){							
						if($_GET["t_err"]=="001" && $_GET["t_data"]=="Empty"){
							echo '<span style="font-family:muli;font-size:15px;">*No empty fields allowed.</span><br><br>';
						}
						if($_GET["t_err"]=="002" && $_GET["t_data"]=="Invalid"){
							echo '<span style="font-family:muli;font-size:15px;">*No invalid entries allowed.</span><br><br>';
						}						
					}	
				?>
			</div>
			<div class="form-group">
				<label for="v_nv">Veg / Non-Veg :</label>
				<input type="radio" id="veg" name="v_nv" value="Veg" required /><label for="veg" class="radio-text" style="width:160px;">Veg</label>
				<input type="radio" id="non-veg" name="v_nv" value="Non Veg" required /><label for="non-veg" class="radio-text" style="width:160px;">Non Veg</label>
				<?php					
					if(isset($_GET["vnv_err"])){							
						if($_GET["vnv_err"]=="001" && $_GET["vnv_data"]=="Empty"){
							echo '<span style="font-family:muli;font-size:15px;">*No empty fields allowed.</span><br><br>';
						}
						if($_GET["vnv_err"]=="002" && $_GET["vnv_data"]=="Invalid"){
							echo '<span style="font-family:muli;font-size:15px;">*No invalid entries allowed.</span><br><br>';
						}						
					}	
				?>
			</div>
			<div class="form-group">
				<label for="p_img">Product Image :</label>
				<input type="file" id="p_img" name="p_img" required />
				<?php					
					if(isset($_GET["ic_err"])){							
						if($_GET["ic_err"]=="002" && $_GET["ic_data"]=="Invalid"){
							echo '<span style="font-family:muli;font-size:15px;">*Only images allowed.</span><br><br>';
						}												
					}					
					if(isset($_GET["it_err"])){							
						if($_GET["it_err"]=="002" && $_GET["it_data"]=="Invalid"){
							echo '<span style="font-family:muli;font-size:15px;">*Please rename your image.</span><br><br>';
						}												
					}					
					if(isset($_GET["ie_err"])){							
						if($_GET["ie_err"]=="002" && $_GET["ie_data"]=="Invalid"){
							echo '<span style="font-family:muli;font-size:15px;">*Only .jpeg, .png, .jpg images allowed.</span><br><br>';
						}												
					}					
					if(isset($_GET["is_err"])){							
						if($_GET["is_err"]=="002" && $_GET["is_data"]=="Invalid"){
							echo '<span style="font-family:muli;font-size:15px;">*Image should be less than 3mb.</span><br><br>';
						}												
					}	
				?>
			</div>
			<div class="form-group">
				<label for="p_name">Product Name :</label>
				<input type="text" name="p_name" id="p_name" class="form-control" placeholder="Give a nice name to your product." required />				
				<?php					
					if(isset($_GET["pn_err"])){							
						if($_GET["pn_err"]=="001" && $_GET["pn_data"]=="Empty"){
							echo '<span style="font-family:muli;font-size:15px;">*No empty fields allowed.</span><br><br>';
						}												
					}					
					if(isset($_GET["pn_err"])){							
						if($_GET["pn_err"]=="002" && $_GET["pn_data"]=="Invalid"){
							echo '<span style="font-family:muli;font-size:15px;">*No invalid entries allowed.</span><br><br>';
						}												
					}											
				?>
			</div>
			<div class="form-group">
				<label for="p_desc">Product Description :</label>
				<textarea name="p_desc" id="p_desc" class="form-control" placeholder="Some products needs a description (Optional)."></textarea>				
				<?php					
					if(isset($_GET["pd_err"])){							
						if($_GET["pd_err"]=="001" && $_GET["pd_data"]=="Empty"){
							echo '<span style="font-family:muli;font-size:15px;">*No empty fields allowed.</span><br><br>';
						}												
					}					
					if(isset($_GET["pd_err"])){							
						if($_GET["pd_err"]=="002" && $_GET["pd_data"]=="Invalid"){
							echo '<span style="font-family:muli;font-size:15px;">*No invalid entries allowed.</span><br><br>';
						}												
					}											
				?>
			</div>
			<div class="form-group">
				<label for="p_category">Product Category :</label><br>
				<select name="p_category" id="p_category" required>
					<option value="">Select a caregory</option>
					<option value="Dairy">Dairy</option>
					<option value="Desert">Desert</option>
					<option value="Fast Food">Fast Food</option>
					<option value="Tiffin">Tiffin</option>
					<option value="Thali">Thali</option>
					<option value="Bakery">Bakery</option>
					<option value="Drink">Drinks and Beverages</option>
					<option value="Sweets">Sweets</option>
					<option value="Snacks">Snacks</option>	
					<option value="Snacks">Cakes</option>
					<option value="Gifts">Gifts</option>					
				</select>				
				<?php					
					if(isset($_GET["pc_err"])){							
						if($_GET["pc_err"]=="001" && $_GET["pc_data"]=="Empty"){
							echo '<span style="font-family:muli;font-size:15px;">*No empty fields allowed.</span><br><br>';
						}												
					}					
					if(isset($_GET["pc_err"])){							
						if($_GET["pc_err"]=="002" && $_GET["pc_data"]=="Invalid"){
							echo '<span style="font-family:muli;font-size:15px;">*No invalid entries allowed.</span><br><br>';
						}												
					}											
				?>
			</div>			
			<div class="form-group">
				<label for="p_ori_cost">List Price :</label><br>
				<input type="number" id="p_ori_cost" name="p_ori_cost" min="1" placeholder="Enter your list price." required />				
				<?php					
					if(isset($_GET["poc_err"])){							
						if($_GET["poc_err"]=="001" && $_GET["poc_data"]=="Empty"){
							echo '<span style="font-family:muli;font-size:15px;">*No empty fields allowed.</span><br><br>';
						}												
					}					
					if(isset($_GET["poc_err"])){							
						if($_GET["poc_err"]=="002" && $_GET["poc_data"]=="Invalid"){
							echo '<span style="font-family:muli;font-size:15px;">*No invalid entries allowed.</span><br><br>';
						}												
					}											
				?>
			</div>
			<div class="form-group">
				<label for="p_cost">Selling Price :</label><br>
				<input type="number" id="p_cost" name="p_cost" min="1" placeholder="Enter the selling price." required /> per								
				<input type="number" id="cost_on" name="cost_on" min="1" placeholder="Enter quantity." required />				
				<select name="measure_unit" id="measure_unit" required>
					<option value="">Select a measure unit</option>
					<option value="piece">Piece</option>
					<option value="g">Gram</option>
					<option value="mg">Miligram</option>
					<option value="kg">Kilogram</option>
					<option value="pack">Pack</option>
					<option value="unit">Unit</option>
					<option value="l">Litre</option>
					<option value="ml">Mililitre</option>
					<option value="Plate">Plate</option>
					<option value="Half Plate">Half Plate</option>
					<option value="Scoop">Scoop</option>
					<option value="Double Scoop">Double Scoop</option>
				</select>
				<?php					
					if(isset($_GET["pco_err"])){							
						if($_GET["pco_err"]=="001" && $_GET["pco_data"]=="Empty"){
							echo '<span style="font-family:muli;font-size:15px;">*No empty fields allowed.</span><br><br>';
						}												
					}					
					if(isset($_GET["pco_err"])){							
						if($_GET["pco_err"]=="002" && $_GET["pco_data"]=="Invalid"){
							echo '<span style="font-family:muli;font-size:15px;">*No invalid entries allowed.</span><br><br>';
						}												
					}											
				?>
				<?php					
					if(isset($_GET["co_err"])){							
						if($_GET["co_err"]=="001" && $_GET["co_data"]=="Empty"){
							echo '<span style="font-family:muli;font-size:15px;">*No empty fields allowed.</span><br><br>';
						}												
					}					
					if(isset($_GET["co_err"])){							
						if($_GET["co_err"]=="002" && $_GET["co_data"]=="Invalid"){
							echo '<span style="font-family:muli;font-size:15px;">*No invalid entries allowed.</span><br><br>';
						}												
					}											
				?>
				<?php					
					if(isset($_GET["mu_err"])){							
						if($_GET["mu_err"]=="001" && $_GET["mu_data"]=="Empty"){
							echo '<span style="font-family:muli;font-size:15px;">*No empty fields allowed.</span><br><br>';
						}												
					}					
					if(isset($_GET["mu_err"])){							
						if($_GET["mu_err"]=="002" && $_GET["mu_data"]=="Invalid"){
							echo '<span style="font-family:muli;font-size:15px;">*No invalid entries allowed.</span><br><br>';
						}												
					}											
				?>
			</div>
			<div class="form-group">
				<label for="p_discount">Product Discount :</label><br>
				<input type="number" id="p_discount" name="p_discount" min="0" max="100" placeholder="Discount if you want." /> 			
				<select name="p_discount_type" id="p_discount_type">
					<option value="" selected>Select discount type</option>
					<option value="Percent off">Percent off</option>
					<option value="Money off">Money off</option>					
				</select>
				<?php	
					if(isset($_GET["pdi_err"])){							
						if($_GET["pdi_err"]=="002" && $_GET["pdi_data"]=="Invalid"){
							echo '<span style="font-family:muli;font-size:15px;">*No invalid entries allowed.</span><br><br>';
						}												
					}											
				?>				
				<?php	
					if(isset($_GET["pdit_err"])){							
						if($_GET["pdit_err"]=="002" && $_GET["pdit_data"]=="Invalid"){
							echo '<span style="font-family:muli;font-size:15px;">*No invalid entries allowed.</span><br><br>';
						}												
					}											
				?>				
				<?php	
					if(isset($_GET["pdit_err"])){							
						if($_GET["pdit_err"]=="003" && $_GET["pdit_data"]=="Invalid"){
							echo '<span style="font-family:muli;font-size:15px;">*Discount type not selected.</span><br><br>';
						}												
					}											
				?>
				<?php	
					if(isset($_GET["pdit_err"])){							
						if($_GET["pdit_err"]=="004" && $_GET["pdit_data"]=="Invalid"){
							echo '<span style="font-family:muli;font-size:15px;">*0 discount not allowed.</span><br><br>';
						}												
					}											
				?>
				<?php	
					if(isset($_GET["pdit_err"])){							
						if($_GET["pdit_err"]=="005" && $_GET["pdit_data"]=="Invalid"){
							echo '<span style="font-family:muli;font-size:15px;">*Discount not entered.</span><br><br>';
						}												
					}											
				?>
			</div>
			<br>
			<input type="submit" name="add_p" value="Add Product" /><br><br>
			
			<p style="font-family:muli;font-size:15px;"><span style="font-weight:bold;">NOTE :</span> We accept only natural numbers (1,22,100,250) as price.</p>
		</form>
    </div>
    <div id="my_p" class="tab-pane fade">
      <h3>My Products...</h3><br>
      <div class="container-fluid">
	  
		  <?php 
			include('conx.php');
			
			if($stmt = $conn->prepare("SELECT p_img, p_id, p_name, p_cost, cost_on, measure_unit, p_discount, p_discount_type FROM products WHERE server=? ORDER BY p_id DESC")) {
				if($stmt->bind_param("s", $_SESSION["sellcheck"])){
					$stmt->execute();
					$stmt->bind_result($db_img, $db_p_id, $db_p_name, $db_p_cost, $db_cost_on, $db_measure_unit, $db_p_discount, $db_p_discount_type);
					
					
					echo '<div class="row text-center">';					
					
						while($stmt->fetch()){
							if($db_p_discount!=NULL){
								if($db_p_discount_type=="Percent off"){
									$cut=round(($db_p_cost*$db_p_discount)/100);
									$showCost=$db_p_cost-$cut;
								}
								if($db_p_discount_type=="Money off"){
									$showCost=$db_p_cost-$db_p_discount;
								}
							}
							else{
								$showCost=$db_p_cost;
							}
								echo '<div class="col-sm-4">
								<div class="thumbnail" style="height:550px;display:inline-block;">
									<div class="thumb_img" style="height:300px;display:table;">
										<table style="height:350px;border-bottom:2px solid #e6e6e6;">
											<tr>
												<td>
													<img src="'.$db_img.'" alt="'.$db_p_id.'" width="255px">
												</td>
											</tr>
											
										</table>
									</div>
									<div class="thumb_data" style="padding:10px;">
										<h3>'.$db_p_name.'</h3>
										<h4>Rs. '.$showCost.' on '.$db_cost_on,$db_measure_unit.'</h4>
										<input type="hidden" name="p_id" value='.$db_p_id.' />
										<a href="edit_productImg.php?p_id='.$db_p_id.'"><input type="button" name="editImage" value="Edit Image" /></a>
										<a href="edit_productInfo.php?p_id='.$db_p_id.'"><input type="button" name="editInfo" value="Edit Info" /></a>
										
									</div>										
								</div>
							</div>';
						}						
						echo '</div>';
					
				}
			}
			
			
		  ?>
		  
	  </div>
    </div>
  </div>
</div>


</body>
</html>