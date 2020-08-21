<?php 
	session_start();
	
	if(!isset($_SESSION["check"])){
		header("Location:index.php");
	}
	
	function product_details($id){
		include('conx.php');
		if($stmt2 = $conn->prepare("select register.firm_name, products.p_name, products.p_img, orders_child.selling_price, orders_child.discount, orders_child.discount_type, orders_child.net_price, orders_child.qty, orders_child.subtotal from register, products, orders_child where orders_child.order_parent_id=? AND register.mbl_no=orders_child.seller AND products.p_id=orders_child.product_id order by orders_child.id DESC")) {						
			if($stmt2->bind_param("i", $id)){
				$stmt2->execute();
				$stmt2->bind_result($seller, $p_name, $p_img, $sp, $discount, $discount_type, $net_price, $qty, $child_subtotal);
				echo '<div class="col-sm-12 neck">
				<table>
					<tbody>';
				while($stmt2->fetch()){
							echo '<tr>
									<td><img src="'.$p_img.'" alt="Img" class="order-img" /></td>
									<td>
										<h5><strong>'.$p_name.'</strong></h5>
										<h5><i>'.$seller.'</i></h5>
										<h5>Quantity : '.$qty.'</h5>
										<h5>Price : Rs.'.$child_subtotal.'</h5>
									</td>
								</tr>';
				}	
				echo '</tbody>
					</table>
				</div>';
			}
		}
	}
	
?>
<!DOCTYPE html>
<html lang="en">
<head>

	<title>My Orders | BiteToEat</title>
	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="Description" content="Order anything to eat or drink from the top brands in the market. BiteToEat provide its customers sweets deserts, dairy products, and services like juice, tiffin, etc. at reasonable prices within an hour at their doorstep." />	
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery.min.js"></script>
	<link href="css/jquery-ui.css" rel="stylesheet">
	<script src="js/bootstrap.min.js"></script>			
	<link rel="stylesheet" href="css/c_navbar.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/fonts.css">	
	
	<style>		
		body{background-color:#edecec;}
		
		.order-block{padding:10px;border:1px solid #f2f2f2;box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);}
		
		.head{
			color:#1cb01c;
			font-family:barOne;
			letter-spacing:1px;
		}
		
		.neck{
			font-family:abeezee;
		}
		
		td, th{vertical-align:top;padding:5px;}
		
		th{text-align:right;}
		
		.order-img{
			width:80px;
			height:80px;
		}
		
		.fill{
			background-color:#1cb01c;
			outline:none;
			border:2px solid #1cb01c;
			color:#ffffff;
			padding:5px;
			font-size:18px;
			font-family:barOne;
			letter-spacing:2px;						
			width:205px;
		}
	</style>
	
</head>
<body id="home">
<?php 
	require 'php_includes/c_navbar.php';
?>

<div class="container" style="background-color:#ffffff;box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);margin-bottom:10px;padding:20px;">
	<?php 
		include('conx.php');
		if($stmt = $conn->prepare("SELECT orders_parent.order_id, orders_parent.customer_address, orders_parent.subtotal, orders_parent.delivery_fee, orders_parent.amt_pay, orders_parent.payment_mode, orders_parent.add_date FROM orders_parent WHERE orders_parent.customer_mbl=? ORDER BY orders_parent.add_date, orders_parent.order_id DESC")) {
			if($stmt->bind_param("s", $_SESSION["check"])){
				$stmt->execute();
				$stmt->bind_result($order_id, $address, $subtotal, $delivery_fee, $amt_pay, $pay_mode, $date);
				$flag=0;	
				while($stmt->fetch()){
					$flag=1;
					if($delivery_fee<1){
						$delivery_fee="Free";
					} 
					else{
						$delivery_fee='Rs.'.$delivery_fee;
					}
					echo '<div style="padding:10px;">
					<div class="row order-block">
						<h4 class="head">Order Id : '.$order_id.'</h4><hr>
						
						<div class="col-sm-6">													
							<h4 class="head">Delivery Details</h4>
							<div class="col-sm-12 neck">
								<table>
									<tbody>
										<tr>
											<th>Address</th>
											<td>'.$address.'</td>
										</tr>	
										<tr>
											<th>Date</th>
											<td>'.$date.'</td>
										</tr>	
									</tbody>
								</table>							
							</div>
						</div>
						
						<div class="col-sm-6">									
							<h4 class="head">Payment Details</h4>
							<div class="col-sm-12 neck">
								<table>
									<tbody>
										<tr>
											<th>Subtotal</th>
											<td>Rs.'.$subtotal.'</td>
										</tr>	
										<tr>
											<th>Delivery Fee</th>
											<td>'.$delivery_fee.'</td>
										</tr>
										<tr>
											<th>Payment Mode</th>
											<td>'.$pay_mode.'</td>
										</tr>
									</tbody>
								</table>							
							</div>
						</div>
						
						<div class="col-sm-12">
							<h4 class="head">Product Details</h4>';
							
							product_details($order_id);
							
							echo '<h4 style="font-family:abeezee;float:right;letter-spacing:1px;"><strong>Order Total :</strong> Rs.'.$amt_pay.'</h4>';
							
					echo '</div>
						</div>
					</div>';
					
				}
				$stmt->close();
				$conn->close();					
			}
		}
		if($flag==0){
			echo '<div class="container text-center">
				<h3 class="neck text-center">No orders yet.</h3>
				<button type="button" class="fill go-order">Order Now</button>
			</div>';
		}
	?>	
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
		$("#li-my-orders").addClass("active");
	});	
</script>
<script>
	$(document).on("click", ".go-order", function(event){
		event.preventDefault();
		window.open("product-list.php", "_self");
	});
</script>
</body>
</html>