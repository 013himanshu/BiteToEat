<?php 
	session_start();
	
	if(isset($_SESSION["check"])){
		include('conx.php');
			
		if($stmt = $conn->prepare("SELECT name FROM c_info WHERE mbl_no=? LIMIT 1")) {
			if($stmt->bind_param("s", $_SESSION["check"])){
				$stmt->execute();
				$stmt->bind_result($cname);
				$stmt->fetch();				
				$cname= substr($cname, 0, strpos($cname, ' '));
			}
		}
	}		
	
	if($_SERVER["REQUEST_METHOD"]=="POST"){	
		if(isset($_POST["add_orderList"])){
			$_SESSION["action"]="cart_buy";				
			header("Location:checkout.php");
			exit(0);	
		}
	}
		
	require 'php_includes/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>

	<title>Shopping Cart | BiteToEat</title>
	
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
				
		
		.glyphicon-trash{cursor:pointer;font-size:15px;color:red;}
		
		.no-fill{
			background-color:transparent;
			outline:none;
			border:2px solid #1cb01c;
			color:#1cb01c;
			padding:8px;
			font-size:15px;
			font-family:barOne;
			letter-spacing:2px;						
			width:205px;
		}
		.no-fill:hover{
			color:#ffffff;
			background-color:#1cb01c;
		}
		
		.fill{
			background-color:#1cb01c;
			outline:none;
			border:2px solid #1cb01c;
			color:#ffffff;
			padding:8px;
			font-size:15px;
			font-family:barOne;
			letter-spacing:2px;						
			width:205px;
		}
		
		
		
	</style>

</head>

<body>

<?php 
	require 'php_includes/c_navbar.php';
?>

<div class="display-cart">				
	
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
		$(".display-cart").load("php_includes/get-cart.php", { key1:'<?php echo str_shuffle("1234567890ABCDabcd"); ?>' });
	});
</script>
<script>
	$(document).on("click", ".trash", function(event){
		event.preventDefault();
		var id=$(this).attr("id");
		var formData={ id:id, key1:'<?php echo str_shuffle("1234567890ABCDabcd"); ?>' };						
		$.ajax({
			method: "POST",
			url: "php_includes/cart-trash.php",
			data: formData
		}).done(function(msg){							
			if(msg<1){
				$(".display-cart").html("<div class='container text-center' style='background-color:#ffffff;height:250px;padding:15px;padding-top:60px;box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);margin-bottom:10px;'><h3 style='color:#000;font-family:abeezee;letter-spacing:2px;'>Your cart is empty.</h3><button type='button' class='fill go-home'>&lt;&lt; Continue Shopping</button></div>");											
				$("#cart-no").html(msg);
			}
			else{
				$(".display-cart").load("php_includes/get-cart.php", { key1:'<?php echo str_shuffle("1234567890ABCDabcd"); ?>' });
				$("#cart-no").html(msg);				
			}							
		});
	});
</script>
<script>
	$(document).on("click", ".go-home", function(event){
		event.preventDefault();
		window.open("index.php", "_self");
	});
</script>
<script>
	$(document).on("change", ".qty", function(event){
		var id=$(this).attr("id");
		var qty=$(this).val();
		var formData={ id: id, qty: qty, key1:'<?php echo str_shuffle("1234567890ABCDabcd"); ?>' };
		$.ajax({
			method: "POST",
			url: "php_includes/cart-qty.php",
			data: formData
		}).done(function(msg){
			if(msg=="success"){
				$(".display-cart").load("php_includes/get-cart.php", { key1:'<?php echo str_shuffle("1234567890ABCDabcd"); ?>' });
			}
			else{
				alert("Oops! A problem occured. Please try again later.");
			}
		});
	});
</script>
<script>
	$(window).load(function(){		
		$("#li-cart").addClass("active");
	});	
</script>
</body>
</html>