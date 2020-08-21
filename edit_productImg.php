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
		//image data
		unset($img_name);
		unset($img_tmpName);
		unset($img_size);
		unset($img_targetpath);
		unset($img_check);
		unset($img_ext);
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
					
					if($stmt = $conn->prepare("SELECT p_img FROM products WHERE server=? AND p_id=?")) {
						if($stmt->bind_param("si",$_SESSION["sellcheck"], $p_id)){
							$stmt->execute();
							$stmt->bind_result($p_img);
							$stmt->fetch();														
						}
					}
				}
			}
		}
	}	
	
	
	if($_SERVER["REQUEST_METHOD"]=="POST"){
		if(isset($_POST["edit"])){			
			$p_id=test_input($_POST["p_id"]);				
			//img data
			$img_name     = $_FILES['p_img']['name'];
			$img_tmpName  = $_FILES['p_img']['tmp_name'];
			$img_size     = $_FILES['p_img']['size'];
			$img_targetPath = 'upload' . DIRECTORY_SEPARATOR. $img_name;
			$img_check = getimagesize($img_tmpName);		
			$img_ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
										
			if($img_check==false){
				//error:this is not image
				unsetval();
				header("Location:edit_productImg.php?p_id=".$p_id."&ic_data=Invalid&ic_err=002");
			}	
			else if (file_exists($img_targetPath)) {
				//error:Sorry, file already exists.Rename 
				unsetval();
				header("Location:edit_productImg.php?p_id=".$p_id."&it_data=Invalid&it_err=002");
			}
			else if ( !in_array($img_ext, array('jpg','jpeg','png')) ) {
				//error:Invalid file extension
				unsetval();
				header("Location:edit_productImg.php?p_id=".$p_id."&ie_data=Invalid&ie_err=002");
			}
			else if ( $img_size/1024/1024 > 3 ) {
				//error:File size is exceeding maximum allowed size
				unsetval();
				header("Location:edit_productImg.php?p_id=".$p_id."&is_data=Invalid&is_err=002");
			}			
			else{				
				
				include('conx.php');
				$p_id=test_input($_POST["p_id"]);								
				$back_img=$_POST["back_img"];
				if($stmt = $conn->prepare("UPDATE products SET p_img=? WHERE p_id=? AND server=?")) {					
					if($stmt->bind_param("sis", $img_targetPath, $p_id, $_SESSION["sellcheck"])){
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

	<title>Products-Edit Image | BiteToEat-Sell</title>
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
		
		input[type=tel], input[type=email], input[type=text]{
			border-radius:0px;
			outline:none;
			font-family:abeezee;
			color:#1cb01c;
			letter-spacing:1px;
			font-size:15px;
			width:95%;
		}
		
		input[type=tel]:focus, input[type=email]:focus, input[type=text]:focus{
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
		
		textarea{
			border-radius:0px;
			outline:none;
			font-family:abeezee;
			color:#1cb01c;
			letter-spacing:1px;
			font-size:15px;
			width:95%;
		}
		
		textarea:focus{
			border:0.5px solid #1cb01c;
			box-shadow:0 0 5px 1px #1cb01c;
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
					<div style="height:300px;display:table;">
						<table style="height:350px;">
							<tr>
								<td>
									<?php echo '<img src="'.$p_img.'" alt="'.$p_id.'" width="250px">'; ?>
								</td>
							</tr>
							<tr>
								<td>
									<h4>Edit Image :</h4>
									<input type="file" name="p_img" id="p_img" required />
								</td>
							</tr>	
						</table>
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
					<input type="hidden" name="p_id" value=<?php echo $_GET["p_id"]; ?> />
					<input type="hidden" name="back_img" value=<?php echo $p_img; ?> />
					<br>					
					<input type="submit" name="edit" value="Change Image" /><br><br>	
				</div>
			</div>
		</form>
	</div>
	
</body>
</html>		