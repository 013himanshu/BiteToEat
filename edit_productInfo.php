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
	}
	
	if(isset($_GET["p_id"])){
		include('conx.php');
		$p_id=test_input($_GET["p_id"]);
		if($stmt = $conn->prepare("SELECT server FROM products WHERE p_id=?")) {
			if($stmt->bind_param("s",$p_id)){
				$stmt->execute();
				$stmt->bind_result($db_mbl);
				$stmt->fetch();
				if($_SESSION["sellcheck"]!=$db_mbl){
					header("Location:sell_products.php");
					exit(0);
				}
				else{
					include('conx.php');
					
					if($stmt = $conn->prepare("SELECT p_type, v_nv, p_name, p_desc, p_category, p_ori_cost, p_cost, cost_on, measure_unit, p_discount, p_discount_type FROM products WHERE server=? AND p_id=?")) {
						if($stmt->bind_param("si",$_SESSION["sellcheck"], $p_id)){
							$stmt->execute();
							$stmt->bind_result($p_type, $v_nv, $p_name, $p_desc, $p_category, $p_ori_cost, $p_cost, $cost_on, $measure_unit, $p_discount, $p_discount_type);
							$stmt->fetch();
							
							if($p_discount==NULL){
								$p_discount="";
							}
							if($p_discount_type==NULL){
								$p_discount_type="";
							}
							if($p_desc==NULL){
								$p_desc="";
							}
							
						}
					}
				}
			}
		}
	}	
	
	
	if($_SERVER["REQUEST_METHOD"]=="POST"){
		if(isset($_POST["edit"])){
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
			
			$p_id=test_input($_POST["p_id"]);
			if(empty($p_type)){
				//empty value
				unsetval();
				header("Location:edit_productInfo.php?p_id=".$p_id."&t_data=Empty&t_err=001");
			}
			else if(!preg_match("/^[a-zA-Z ]+$/",$p_type)){
				//invalid value
				header("Location:edit_productInfo.php?p_id=".$p_id."&t_data=Invalid&t_err=002");
			}
			if(empty($v_nv)){
				//empty value
				unsetval();
				header("Location:edit_productInfo.php?p_id=".$p_id."&vnv_data=Empty&vnv_err=001");
			}
			else if(!preg_match("/^[a-zA-Z ]+$/",$v_nv)){
				//invalid value
				unsetval();
				header("Location:edit_productInfo.php?p_id=".$p_id."&vnv_data=Invalid&vnv_err=002");
			}			
			else if(empty($p_name)){
				//empty value
				unsetval();
				header("Location:edit_productInfo.php?p_id=".$p_id."&pn_data=Empty&pn_err=001");
			}
			else if(!preg_match("/^[a-zA-Z0-9\.\+(),\-\| ]+$/",$p_name)){
				//invalid value
				unsetval();
				header("Location:edit_productInfo.php?p_id=".$p_id."&pn_data=Invalid&pn_err=002");
			}
			else if((strlen($p_desc>0)) && (!preg_match("/^[a-zA-Z0-9\.\+(),\-\| ]+$/",$p_desc))){
				//invalid value
				unsetval();
				header("Location:sell_products.php?pd_data=Invalid&pd_err=002");
			}
			else if(empty($p_category)){
				//empty value
				unsetval();
				header("Location:edit_productInfo.php?p_id=".$p_id."&pc_data=Empty&pc_err=001");
			}
			else if(!preg_match("/^[a-zA-Z0-9\.(),\- ]+$/",$p_category)){
				//invalid value
				unsetval();
				header("Location:edit_productInfo.php?p_id=".$p_id."&pc_data=Invalid&pc_err=002");
			}
			else if(empty($p_ori_cost)){
				//empty value
				unsetval();
				header("Location:edit_productInfo.php?p_id=".$p_id."&poc_data=Invalid&poc_err=001");
			}
			else if(!preg_match("/^[0-9]+$/",$p_ori_cost)){
				//invalid value
				unsetval();
				header("Location:edit_productInfo.php?p_id=".$p_id."&poc_data=Invalid&poc_err=002");
			}
			else if(empty($p_cost)){
				//empty value
				unsetval();
				header("Location:edit_productInfo.php?p_id=".$p_id."&pco_data=Invalid&pco_err=001");
			}
			else if(!preg_match("/^[0-9]+$/",$p_cost)){
				//invalid value
				unsetval();
				header("Location:edit_productInfo.php?p_id=".$p_id."&pco_data=Invalid&pco_err=002");
			}
			else if(empty($cost_on)){
				//empty value
				unsetval();
				header("Location:edit_productInfo.php?p_id=".$p_id."&co_data=Invalid&co_err=001");
			}
			else if(!preg_match("/^[0-9]+$/",$cost_on)){
				//invalid value
				unsetval();
				header("Location:edit_productInfo.php?p_id=".$p_id."&co_data=Invalid&co_err=002");
			}
			else if(empty($measure_unit)){
				//empty value
				unsetval();
				header("Location:edit_productInfo.php?p_id=".$p_id."&mu_data=Invalid&mu_err=001");
			}
			else if(!preg_match("/^[a-zA-Z ]+$/",$measure_unit)){
				//invalid value
				unsetval();
				header("Location:edit_productInfo.php?p_id=".$p_id."&mu_data=Invalid&mu_err=002");			
			}			
			else if(!preg_match("/^[1-9]*[0-9]*$/",$p_discount)){
				//invalid value
				unsetval();
				header("Location:edit_productInfo.php?p_id=".$p_id."&pdi_data=Invalid&pdi_err=002");	
			}			
			else if(!preg_match("/^[a-zA-Z ]*$/",$p_discount_type)){
				//invalid value
				unsetval();
				header("Location:edit_productInfo.php?p_id=".$p_id."&pdit_data=Invalid&pdit_err=002");	
			}
			else if((strlen($p_discount)>0) && ($p_discount_type=="")){
				//Error:discount type not selected
				unsetval();
				header("Location:edit_productInfo.php?p_id=".$p_id."&pdit_data=Invalid&pdit_err=003");	
			}
			else if((strlen($p_discount)>0) && ($p_discount===0)){
				//Error:discount cannot be 0
				unsetval();
				header("Location:edit_productInfo.php?p_id=".$p_id."&pdit_data=Invalid&pdit_err=004");
			}
			else if(($p_discount_type!="") && ($p_discount<1)){
				unsetval();
				header("Location:edit_productInfo.php?p_id=".$p_id."&pdit_data=Invalid&pdit_err=005");
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
				$p_id=test_input($_POST["p_id"]);				
				
				if($stmt = $conn->prepare("UPDATE products SET p_type=?, v_nv=?, p_name=?, p_desc=?, p_category=?, p_ori_cost=?, p_cost=?, cost_on=?, measure_unit=?, p_discount=?, p_discount_type=? WHERE p_id=? AND server=?")) {					
					if($stmt->bind_param("sssssiiisisis", $p_type, $v_nv, $p_name, $p_desc, $p_category, $p_ori_cost, $p_cost, $cost_on, $measure_unit, $p_discount, $p_discount_type, $p_id, $_SESSION["sellcheck"])){
						$stmt->execute();						
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

	<title>Products-Edit Info | BiteToEat-Sell</title>
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
		
		.edit {background-color:#ffffff;margin-top:10px;margin-bottom:10px;padding:30px;}
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
	
	<div class="container edit">
		<h2>Edit Product...</h2><br><br>
		<form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" autocomplete="off">						
			<div class="row">
				<div class="col-sm-12">					
								
					<div class="form-group">
						<label for="p_type">Edit Product Type :</label>
						<input type="radio" id="one-time" name="p_type" value="One Time" <?php if($p_type=="One Time"){echo "checked";} ?> required /><label for="one-time" class="radio-text" style="width:160px;">One Time</label>
						<input type="radio" id="service" name="p_type" value="Service" <?php if($p_type=="Service"){echo "checked";} ?> required /><label for="service" class="radio-text" style="width:160px;">Service</label>
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
						<label for="v_nv">Edit Veg / Non-Veg :</label>
						<input type="radio" id="veg" name="v_nv" value="Veg" <?php if($v_nv=="Veg"){echo "checked";} ?> required /><label for="veg" class="radio-text" style="width:160px;">Veg</label>
						<input type="radio" id="non-veg" name="v_nv" value="Non Veg" <?php if($v_nv=="Non Veg"){echo "checked";} ?> required /><label for="non-veg" class="radio-text" style="width:160px;">Non Veg</label>						
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
						<label for="p_name">Edit Product Name :</label>
						<input type="text" name="p_name" id="p_name" class="form-control" value=<?php echo $p_name; ?> placeholder="Give a nice name to your product." required />						
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
						<label for="p_desc">Edit Product Description :</label>
						<textarea name="p_desc" id="p_desc" class="form-control" placeholder="Some products needs a description (Optional)."><?php echo $p_desc; ?></textarea>				
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
						<label for="p_category">Edit Product Category :</label><br>
						<select name="p_category" id="p_category" required>
							<option value="">Select a caregory</option>
							<option value="Dairy" <?php if($p_category=="Dairy"){echo "selected";} ?> >Dairy</option>
							<option value="Desert" <?php if($p_category=="Desert"){echo "selected";} ?> >Desert</option>
							<option value="Fast Food" <?php if($p_category=="Fast Food"){echo "selected";} ?> >Fast Food</option>
							<option value="Tiffin" <?php if($p_category=="Tiffin"){echo "selected";} ?> >Tiffin</option>
							<option value="Thali" <?php if($p_category=="Thali"){echo "selected";} ?> >Thali</option>
							<option value="Bakery" <?php if($p_category=="Bakery"){echo "selected";} ?> >Bakery</option>
							<option value="Drinks and Beverages" <?php if($p_category=="Drinks and Beverages"){echo "selected";} ?> >Drinks and Beverages</option>
							<option value="Sweets" <?php if($p_category=="Sweets"){echo "selected";} ?> >Sweets</option>
							<option value="Snacks" <?php if($p_category=="Snacks"){echo "selected";} ?> >Snacks</option>
							<option value="Cakes" <?php if($p_category=="Cakes"){echo "selected";} ?> >Cakes</option>
							<option value="Gifts" <?php if($p_category=="Gifts"){echo "selected";} ?> >Gifts</option>
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
						<label for="p_ori_cost">Edit Your Price :</label><br>
						<input type="number" id="p_ori_cost" name="p_ori_cost" min="1" value=<?php echo $p_ori_cost; ?> placeholder="Price at which you sell." required />										
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
						<label for="p_cost">Edit Price for BiteToEat :</label><br>
						<input type="number" id="p_cost" name="p_cost" min="1" value="<?php echo $p_cost; ?>" placeholder="Price you will sell here." required /> per								
						<input type="number" id="cost_on" name="cost_on" min="1" value="<?php echo $cost_on; ?>" placeholder="Enter quantity." required />				
						<select name="measure_unit" id="measure_unit" required>
							<option value="">Select a measure unit</option>
							<option value="piece" <?php if($measure_unit=="piece"){echo "selected";} ?> >Piece</option>
							<option value="g" <?php if($measure_unit=="g"){echo "selected";} ?> >Gram</option>
							<option value="mg" <?php if($measure_unit=="mg"){echo "selected";} ?> >Miligram</option>
							<option value="kg" <?php if($measure_unit=="kg"){echo "selected";} ?> >Kilogram</option>
							<option value="pack" <?php if($measure_unit=="pack"){echo "selected";} ?> >Pack</option>
							<option value="unit" <?php if($measure_unit=="unit"){echo "selected";} ?> >Unit</option>
							<option value="l" <?php if($measure_unit=="l"){echo "selected";} ?> >Litre</option>
							<option value="ml" <?php if($measure_unit=="ml"){echo "selected";} ?> >Mililitre</option>
							<option value="Plate" <?php if($measure_unit=="Plate"){echo "selected";} ?> >Plate</option>
							<option value="Half Plate" <?php if($measure_unit=="Half Plate"){echo "selected";} ?> >Half Plate</option>
							<option value="Scoop" <?php if($measure_unit=="Scoop"){echo "selected";} ?> >Scoop</option>
							<option value="Double Scoop" <?php if($measure_unit=="Double Scoop"){echo "selected";} ?> >Double Scoop</option>
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
						<label for="p_discount">Edit Product Discount :</label><br>
						<input type="number" id="p_discount" name="p_discount" min="0" max="100" value="<?php echo $p_discount; ?>" placeholder="Discount if you want." /> 			
						<select name="p_discount_type" id="p_discount_type">
							<option value="">Select discount type</option>
							<option value="Percent off" <?php if($p_discount_type=="Percent off"){echo "selected";} ?> >Percent off</option>
							<option value="Money off" <?php if($p_discount_type=="Money off"){echo "selected";} ?> >Money off</option>					
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
					<input type="hidden" name="p_id" value=<?php echo $_GET["p_id"]; ?> />
					<br>					
					<input type="submit" name="edit" value="Edit Product" /><br><br>
					
					<p style="font-family:muli;font-size:15px;"><span style="font-weight:bold;">NOTE :</span> We accept only natural numbers (1,22,100,250) as price.</p>	
					
				</div>
			</div>
		</form>
	</div>
	
</body>
</html>		