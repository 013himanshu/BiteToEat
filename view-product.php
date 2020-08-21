<?php
	session_start();
  
	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);		
		return $data;
	}
	
	if(isset($_GET["p_id"])){
		include('conx.php');
		$p_id=test_input(base64_decode($_GET["p_id"]));
		if($stmt = $conn->prepare("SELECT p_name FROM products WHERE p_id=?")) {
			if($stmt->bind_param("s",$p_id)){
				$stmt->execute();
				$stmt->bind_result($db_p_name);
				$stmt->fetch();
				$p_name=test_input(base64_decode($_GET["item"]));
				if($p_name!=$db_p_name){					
					header("Location:product-list.php");
					exit(0);
				}
				else{
					include('conx.php');
					
					if($stmt = $conn->prepare("SELECT server, p_img, p_type, v_nv, p_name, p_desc, p_category, p_ori_cost, p_cost, cost_on, measure_unit, p_discount, p_discount_type FROM products WHERE p_id=?")) {
						if($stmt->bind_param("i", $p_id)){
							$stmt->execute();
							$stmt->bind_result($server, $p_img, $p_type, $v_nv, $p_name, $p_desc, $p_category, $p_ori_cost, $p_cost, $cost_on, $measure_unit, $p_discount, $p_discount_type);
							$stmt->fetch();
							
							if($p_discount==NULL){
								$p_discount="";
							}
							if($p_discount_type==NULL){
								$p_discount_type="";
							}
							if($p_desc==NULL){
								$p_desc="Not Available";
							}
						}
					}
					
					include('conx.php');
					
					if($stmt = $conn->prepare("SELECT firm_name FROM register WHERE mbl_no=?")) {					
						if($stmt->bind_param("s", $server)){
							$stmt->execute();
							$stmt->bind_result($server_name);
							$stmt->fetch();
						}
					}
					
				}
			}
		}
	}
	else{
		header("Location:product-list.php");
		exit(0);
	}
	
	function createSess(){
		$_SESSION["p_id"]=$_POST["id"];
		$_SESSION["qty"]=$_POST["qty"];
		$_SESSION["c"]=$_POST["c"];
		$_SESSION["d"]=$_POST["d"];
		$_SESSION["d_t"]=$_POST["d_t"];
		$_SESSION["return"]=$_POST["return"];
	}
	
	if($_SERVER["REQUEST_METHOD"]=="POST"){
	
		if(isset($_POST["direct_buy"])){
			$_SESSION["action"]="direct_buy";	
			createSess();
			header("Location:checkout.php");
			exit(0);	
		}
	}
	
?>
<!DOCTYPE html>
<html lang="en">
<head>

	<title><?php echo $p_name.' from '.$server_name.' | '; ?> BiteToEat.in</title>
	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="Description" content="Order anything to eat or drink from the top brands in the market. BiteToEat provide its customers sweets deserts, dairy products, and services like juice, tiffin, etc. at reasonable prices within an hour at their doorstep." />
    <meta name="keywords" content="<?php echo $p_name.','.$server_name.','.'BiteToEat'; ?>">
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

		#availabilityForm input[type=tel]{
			width:200px;
			outline:none;
			font-family:barOne;
			color:#1cb01c;
			letter-spacing:1px;
			font-size:18px;
			padding:2px;
			text-align:center;			
			border:2px solid #1cb01c;
		}
		
		#availabilityForm input[type=submit]{
			background-color:#1cb01c;
			color:#ffffff;			
			border:none;
			padding:4px;
			font-size:18px;
			font-family:barOne;
			letter-spacing:1px;
			outline:none;
			border-radius:0px;
			width:70px;
		}
		
		.orderForm input[type=submit], .go-cart{
			border-radius:2px;
			background-color:#1cb01c;
			color:#ffffff;
			width:250px;
			border:none;
			padding:15px;
			font-size:25px;
			font-family:barOne;
			letter-spacing:2px;
			outline:none;						
		}
		.orderForm input[type=submit]:hover, .go-cart:hover{
			background-color:#189a18;
		}
						
		/*footer css starts*/
		footer {
			background-color: #ffffff;
			color: #1cb01c;
			padding: 32px;	
			box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);			
		}
				
		
		footer h4, footer h5 a {
			color: #1cb01c;
			font-family:muli;
		}

		footer a:hover, a:visited, a:link{color: #1cb01c;text-decoration:none;}			
		/*footer css ends*/
	</style>	
	
</head>

<body>

<?php 
	require 'php_includes/c_navbar.php';	
?>

<div style="padding-left:2%;padding-right:2%;">
<div class="container-fluid" style="overflow:hidden;background-color:#ffffff;margin-top:10px;margin-bottom:10px;box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);">
<div class="row">
				
				<div class="col-sm-4 text-center" style="padding:15px;">					
					<?php echo '<img src="'.$p_img.'" alt="product-image"  class="img-responsive" style="margin:auto;" />'; ?>					
					<form role="form" id="availabilityForm" name="availabilityForm" autocomplete="off" style="padding-top:5px;">
						<h4 style="font-family:barOne;">Availability</h4> <input type="tel" id="pin" name="pin" minlength="6" maxlength="6" placeholder="Enter Your Pincode" /><input type="submit" id="availabilityBtn" name="availabilityBtn" value="Check" />
						<p id="availability-err" style="font-size:15px;font-family:muli;padding:10px;color:#1cb01c;"></p>
					</form>
				</div>
				<div class="col-sm-8" style="font-family:abeezee;">
					<?php echo '<h1>'.$p_name.'</h1><hr>'; ?>
					<div class="row">																				
						<div class="col-sm-7">
							
							<?php 
								if($p_discount!=NULL){
									if($p_discount_type=="Percent off"){
										$cut=($p_cost*$p_discount)/100;
										$showCost=$p_cost-$cut;
									}
									if($p_discount_type=="Money off"){
										$showCost=$p_cost-$p_discount;
									}
								}
								else{
									$showCost=$p_cost;
								}
								
								if($p_ori_cost==$p_cost || $p_ori_cost<$p_cost){
									
									if($p_discount!=""){								
										if($p_discount_type=="Percent off"){
											echo '<h4 style="color:#1cb01c;display:inline;">Selling Price: &#x20B9;'.$p_cost.' / </h4>';
											echo '<h4 style="display:inline;color:#1cb01c;">'.$p_discount.'%Off</h4>';
										}
										
										if($p_discount_type=="Money off"){
											echo '<h4 style="color:#1cb01c;display:inline;">Selling Price: &#x20B9;'.$p_cost.' / </h4>';
											echo '<h4 style="display:inline;color:#1cb01c;">&#x20B9;'.$p_discount.' Off</h4>';
										}
									}
									else{
										echo '<h4 style="color:#1cb01c;display:inline;">Selling Price: &#x20B9;'.$p_cost.'</h4>';
									}
								}
								else{
									echo '<h4 style="color:#1cb01c;">List Price: <del> &#x20B9; '.$p_ori_cost.'</del></h4>';
									echo '<h4 style="color:#1cb01c;display:inline;">Selling Price: &#x20B9;'.$p_cost.'</h4>';
									if(isset($p_discount)){
										if($p_discount_type=="Percent off"){
											echo '<h4 style="display:inline;color:#1cb01c;"> / '.$p_discount.' %Off</h4>';
										}
										if($p_discount_type=="Money off"){
											echo '<h4 style="display:inline;color:#1cb01c;"> / &#x20B9;'.$p_discount.' Off</h4>';
										}
									}							
								}
								echo '<h3 style="border-left:5px solid #1cb01c;padding:10px;">Net Price: &#x20B9;'.$showCost.' <span style="font-size:17px;">per '.$cost_on.' '.$measure_unit.'</span></h3>';								
							?>
							<form role="form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" autocomplete="off" class="orderForm" name="orderForm" id="orderForm">
								<h3 style="border-left:5px solid #1cb01c;padding:10px;">Select Quantitiy: 
									<select name="qty" style="background-color:transparent;padding:1px;font-size:20px;outline:none;width:70px;" required>
										<?php								
											$count=1;									
											while($count<=5){										
												
												echo '<option value="'.$count.'">'.$count.'</option>';
												$count++;
											}
										?>
									</select>
								</h3>
								
								<input type="hidden" name="id" value=<?php echo $_GET["p_id"]; ?> />								
								<input type="hidden" name="c" value=<?php echo base64_encode($p_cost); ?> />
								<input type="hidden" name="d" value=<?php echo base64_encode($p_discount); ?> />
								<input type="hidden" name="d_t" value=<?php echo base64_encode($p_discount_type); ?> />								
								<input type="hidden" name="return" value=<?php echo urlencode($_SERVER['REQUEST_URI']); ?> />								
								<?php $_SESSION["url"]="localhost".$_SERVER['REQUEST_URI']; ?>
								<div style="padding-top:15px;" id="add-or-not">
									<button type="button" name="add_orderList" class="go-cart" id="add_orderList">Add To Cart</button>
								</div>
								<div style="padding-top:15px;padding-bottom:15px;">
									<input type="submit" name="direct_buy" id="direct_buy" value="Buy Now" />
								</div>																								
							</form>
						</div>
						
						<div class="col-sm-5" style="border-left:1px solid #e9e9e9;">
							<h2 style="">Sold By</h2>
							<h3 style="border-left:5px solid #1cb01c;padding:5px;font-family:abeezee;"><?php echo $server_name; ?></h3><br>
							<ul>
								<h4><li>Usually delivered in 60 minutes.</li></h4>
								<h4><li>Cash On Delivery</li></h4>
								<h4><li>No return after the order has been placed.</li></h4>
							</ul><br>
						</div>
						
					</div>
				</div>
			
		
	
</div>
</div>	
</div>

<div style="padding-left:2%;padding-right:2%;">
	<div class="container-fluid" style="overflow:hidden;background-color:#ffffff;margin-top:10px;margin-bottom:10px;box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);">					
		
		<div class="row">			
			<div class="col-sm-7" style="padding-bottom:5px;">
				<h3 style="font-family:muli;">Description <span class="caret"></span></h3>
				<p style="border-left:5px solid #1cb01c;padding:6px;font-family:abeezee;font-size:18px;letter-spacing:1px;"><?php echo $p_desc; ?></p>
			</div>
			
			<div class="col-sm-5" style="padding-bottom:5px;">
				<h3 style="font-family:muli;">Specifications <span class="caret"></span></h3>
				<div class="table-responsive">
				  <table class="table table-bordered" style="font-size:15px;">					
					<tbody>					  
					  <tr>
						<td>Name</td>
						<td><?php echo $p_name; ?></td>						
					  </tr>					  
					  <tr>
						<td>Veg / Non Veg</td>
						<td><?php echo $v_nv; ?></td>						
					  </tr>
					  <tr>
						<td>Category</td>
						<td><?php echo $p_category; ?></td>						
					  </tr>
					  <tr>
						<td>Sold By</td>
						<td><?php echo $server_name; ?></td>						
					  </tr>
					  <tr>
						<td>List Price</td>
						<td><?php if($p_ori_cost==$p_cost || $p_ori_cost<$p_cost){ echo "Not Available"; } else { echo $p_ori_cost; } ?></td>						
					  </tr>
					  <tr>
						<td>Selling Price</td>
						<td><?php echo $p_cost; ?></td>						
					  </tr>
					  <tr>
						<td>Discount</td>
							<td>
								<?php  
									if($p_discount!=""){
										if($p_discount_type=="Percent off"){											
											echo $p_discount.' %Off';
										}
										
										if($p_discount_type=="Money off"){
											
											echo 'Rs. '.$p_discount.' Off</h4>';
										}
									}
									else{
										echo "Not Available";
									}
								?>
							</td>						
					  </tr>
					  <tr>
						<td>Net Price</td>
						<td><?php echo $showCost.' '.'per'.' '.$cost_on.' '.$measure_unit; ?></td>						
					  </tr>
					</tbody>	
				  </table>
				</div>
			</div>
						
		</div>
	</div>
</div>




<!-- footer starts -->
<footer>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-3">
				<h4 style="border-bottom:1px dotted;padding-bottom:6px;">Navigate</h4>
				<h5><a href="index.php">Home</a></h5>
				<h5><a href="index.php#categories">Categories</a></h5>
				<h5><a href="product-list.php">Products</a></h5>									
			</div>									
			<div class="col-sm-3">
				<h4 style="border-bottom:1px dotted;padding-bottom:6px;">Follow Us</h4>
				<a href="https://www.facebook.com/PageBiteToEat/" target="_blank"><img src="images/follow-fb.png"  alt="follow-fb" height="40" /></a>								
			</div>
			<div class="col-sm-3">
				<h4 style="border-bottom:1px dotted;padding-bottom:6px;">Help &amp Support</h4>
				<h5><a href="contact-us.php">About Us</a></h5>
				<h5><a href="contact-us.php#contact-us">Contact Us</a></h5>				
			</div>			
			<div class="col-sm-3">
				<h4 style="border-bottom:1px dotted;padding-bottom:6px;">BiteToEat-Sell</h4>
				<h5><a href="sell.php">Sell Now</a></h5>
				<h5><a href="how_it_works.html">How It Works</a></h5>
				<h5><a href="sell_faqs.html">FAQs</a></h5>								
				
			</div>
		</div><br><br>
		<hr width="60%">
		<center><p><a href="index.php" style="color:#1cb01c;text-decoration:none;">BiteToEat</a> &copy 2016</p></center>
	</div>	
	
</footer>


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
	$(document).on("submit", "#availabilityForm", function(event){				
		event.preventDefault();									
		var pin=document.forms["availabilityForm"]["pin"].value;						
		var formData={ availabilityBtn:"availabilityBtn", pin: pin };					
		$.ajax({
			method: "POST",
			url: "php_includes/availability-pin.php",
			data: formData
		}).done(function(msg){
			if(msg!="success"){				
				$("#availability-err").html(msg);								
			}										
		});																
	});
</script>
<script>	
	$(document).on("click", "#add_orderList", function(event){				
		event.preventDefault();									
		var pid=document.forms["orderForm"]["id"].value;
		var qty=document.forms["orderForm"]["qty"].value;
		var formData={ pid:pid, qty:qty };					
		$.ajax({
			method: "POST",
			url: "php_includes/add2cart.php",
			data: formData
		}).done(function(msg){			
			$('#cart-no').html(msg);
			$("#add-or-not").html("<button type='button' class='go-cart' id='go-to-cart'>Go To Cart</button>");
			setTimeout(function(){ $("#add-or-not").html("<input type='submit' name='add_orderList' id='add_orderList' value='Add To Cart' />") }, 3000);
		});																
	});
</script>
<script>	
	$(document).on("click", "#go-to-cart", function(event){
		event.preventDefault();
		window.open("view-cart.php", "_self");
	});
</script>

</body>
</html>