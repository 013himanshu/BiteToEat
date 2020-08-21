<?php 
	session_start();	
?>
<?php
	if(!isset($_SESSION["check"])){
		header("Location:index.php");
	}
	
	if(isset($_SESSION["check"])){
		include('conx.php');
			
		if($stmt = $conn->prepare("SELECT name, email FROM c_info WHERE mbl_no=? LIMIT 1")) {
			if($stmt->bind_param("s", $_SESSION["check"])){
				$stmt->execute();
				$stmt->bind_result($name, $email);
				$stmt->fetch();								
			}
		}
	}
	
?>

<!DOCTYPE html>
<html lang="en">
<head>

	<title>My Account | BiteToEat</title>
	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="Description" content="Order anything to eat or drink from the top brands in the market. BiteToEat provide its customers sweets deserts, dairy products, and services like juice, tiffin, etc. at reasonable prices within an hour at their doorstep." />
    <meta name="robots" content="index, follow">
	<meta name="googlebot" content="index, follow">	
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery.min.js"></script>
	<link href="css/jquery-ui.css" rel="stylesheet">
	<script src="js/bootstrap.min.js"></script>			
	<link rel="stylesheet" href="css/c_navbar.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/fonts.css">

	
	<style>		
		
		body{background-color:#edecec;}
							
		.my-ac-info{font-size:15px;color:#333;}
		a:hover{ text-decoration:none; }
		.block{ padding-bottom:15px; }		
		.block-data{ padding:10px; background-color:white; box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3); cursor:pointer; }
		.style-txt{ font-family:abeezee; letter-spacing:2px; color:#000; }
		.style-txt2{ font-family:barOne; letter-spacing:2px; color:#1cb01c; }
		.no-point{ cursor:default; }
	</style>

</head>

<body>

<?php 
	require 'php_includes/c_navbar.php';
?>

<div class="container" style="padding-top:5px;">
	<h3 class="style-txt" style="margin-left:2%;margin-right:2%;padding:10px;border-left:5px solid #1cb01c;background-color:#fff;box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);">
		My Account
		<?php echo '<br><span class="my-ac-info">'.$name.'</span>'; ?>
		<?php echo '<br><span class="my-ac-info">'.$email.'</span>'; ?>
		<?php echo '<br><span class="my-ac-info">'.$_SESSION["check"].'</span>'; ?>
	</h3>
	<div class="row" style="padding:2%;">
		<div class="col-sm-6 block">
			<a href="my-orders.php">
				<div class="block-data">
					<h3 class="style-txt">My Orders</h3><hr>
					<h5 class="style-txt2"><span class="glyphicon glyphicon-bookmark"></span>Go through your orders.</h5>
				</div>
			</a>
		</div>
		<div class="col-sm-6 block">
			<a href="my-settings.php">
				<div class="block-data">
					<h3 class="style-txt">Account Settings</h3><hr>
					<h5 class="style-txt2"><span class="glyphicon glyphicon-cog"></span>Manage your account settings.</h5>
				</div>
			</a>
		</div>
	</div>
	<div class="row" style="padding:2%;">
		<div class="col-sm-6 block">			
				<div class="block-data no-point">
					<h3 class="style-txt">My Reviews</h3><hr>
					<h5 class="style-txt2">Coming Soon...</h5>
				</div>			
		</div>
		<div class="col-sm-6 block">
			<a href="#">
				<div class="block-data no-point">
					<h3 class="style-txt">Contact BiteToEat</h3><hr>
					<h5 class="style-txt2"><span class="glyphicon glyphicon-envelope"></span>Call or drop a mail to us.</h5>
				</div>
			</a>
		</div>
	</div>
	<div class="row" style="padding:2%;">
		<div class="col-sm-6 block">			
				<div class="block-data no-point">
					<h3 class="style-txt">Help Center</h3><hr>
					<h5 class="style-txt2">Coming Soon...</h5>
				</div>			
		</div>
		<div class="col-sm-6 block">			
				<div class="block-data no-point">
					<h3 class="style-txt">Legal</h3><hr>
					<h5 class="style-txt2">Coming Soon...</h5>
				</div>			
		</div>
	</div>
</div>


<script src="js/jquery-ui.js"></script>
<script type="text/javascript">
$(function() {
    $( "#search" ).autocomplete({
      source: 'getdata.php',
      minLength: 1
    });
  });
</script>
<script>
	$(window).load(function(){		
		$("#li-my-ac").addClass("active");
	});	
</script>
</body>
</html>