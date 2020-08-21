<?php
session_start();
	
	include("php_includes/functions.php");
	
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
	
	
?>

<!DOCTYPE html>
<html lang="en">
<head>

	<title>Products | BiteToEat</title>
	
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


</head>

<body>

<?php 
	require 'php_includes/c_navbar.php';
?>

<div class="container-fluid">
<div class="row">
	
	
	<div class="col-sm-12">
		<div class="container" style="background-color:#ffffff;padding:0px;box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);">
		
		<?php
			function test_input($data){
				$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars($data);		
				return $data;
			}
			
			include('conx.php');
			
			if(isset($_GET['search'])){
               $stmt = $conn->prepare("SELECT products.p_img, products.p_id, products.p_name, products.p_ori_cost, products.p_cost, products.cost_on, products.measure_unit, products.p_discount, products.p_discount_type FROM products, register WHERE register.mbl_no=products.server AND register.proceed='Y' AND register.acc_status='active' AND products.p_name=? ORDER BY RAND()");             
               $stmt->bind_param("s",  test_input($_GET['search']));
			}
			else if(isset($_GET['brand'])){				
				$stmt = $conn->prepare("SELECT products.p_img, products.p_id, products.p_name, products.p_ori_cost, products.p_cost, products.cost_on, products.measure_unit, products.p_discount, products.p_discount_type FROM products, register WHERE register.mbl_no=products.server AND register.proceed='Y' AND register.acc_status='active' AND register.firm_name LIKE ? ORDER BY RAND()");             
				$brand='%'.test_input($_GET['brand']).'%';
				$stmt->bind_param("s",  $brand);
			}
			else if(isset($_GET['category'])){
				$stmt = $conn->prepare("SELECT products.p_img, products.p_id, products.p_name, products.p_ori_cost, products.p_cost, products.cost_on, products.measure_unit, products.p_discount, products.p_discount_type FROM products, register WHERE register.mbl_no=products.server AND register.proceed='Y' AND register.acc_status='active' AND products.p_category LIKE ? ORDER BY RAND()");             
				$brand='%'.test_input($_GET['category']).'%';
				$stmt->bind_param("s",  $brand);
			}
			else{
				$stmt = $conn->prepare("SELECT products.p_img, products.p_id, products.p_name, products.p_ori_cost, products.p_cost, products.cost_on, products.measure_unit, products.p_discount, products.p_discount_type FROM products, register WHERE register.mbl_no=products.server AND register.proceed='Y' AND register.acc_status='active' ORDER BY RAND()");
			}
			
			
				$stmt->execute();
				$stmt->bind_result($db_img, $db_p_id, $db_p_name, $db_p_ori_cost, $db_p_cost, $db_cost_on, $db_measure_unit, $db_p_discount, $db_p_discount_type);
					
					
							
								$flag_item=0;
								while($stmt->fetch()){
									if($db_p_discount!=NULL){
										if($db_p_discount_type=="Percent off"){
											$cut=round(($db_p_cost*$db_p_discount)/100);
											$showCost=$db_p_cost-$cut;
											$flag2=1;
											$showDiscount=$db_p_discount.'% Off';
											
										}
										if($db_p_discount_type=="Money off"){
											$showCost=$db_p_cost-$db_p_discount;
											$flag2=1;
											$showDiscount='Rs.'.$db_p_discount.' Off';
										}
									}
									else{
										$showCost=$db_p_cost;
										$flag2=0;
									}
									
									if($db_p_cost>$showCost){
										$flag1=1;
									}
									else{
										$flag1=0;
									}
									
									if($db_p_ori_cost>$db_p_cost){
										$flag3=1;
									}
									else{
										$flag3=0;
									}
																								
									echo '<div class="pro-itm" style="float:left;padding:30px;">
										<a href="view-product.php?p_id='.base64_encode($db_p_id).'&item='.base64_encode($db_p_name).'" style="text-decoration:none;">
											<div class="thumb_img" style="padding:0px;box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);">
												<table style="width:230px;height:380px;word-wrap:break-word;overflow:hidden;">
													<tr>
														<td>
															<img src="'.$db_img.'" alt="'.$db_p_id.'" height="200px" width="100%">
															<div class="text-center" style="padding-left:5px;padding-right:5px;">
																<h3 style="font-family:barOne;letter-spacing:1px;text-align:center;color:#1cb01c;">'.$db_p_name.'</h3>
																<h4 style="font-family:abeezee;text-align:center;color:#000000;">Rs.'.$showCost.' on '.$db_cost_on.' '.$db_measure_unit.'</h4>';
																if($flag1==1){
																	echo '<h4 style="display:inline;font-family:muli;color:#878787;text-decoration:line-through;">&#x20B9;'.$db_p_cost.'</h4>';
																}
																if($flag2==1){
																	echo '<h4 style="display:inline;font-family:muli;color:#1cb01c;">&nbsp;'.$showDiscount.'</h4>';
																}
																if($flag3==1){
																	echo '<h4 style="font-family:muli;color:#878787;">List Price: <span style="text-decoration:line-through;">&#x20B9;'.$db_p_ori_cost.'</span></h4>';
																}																																											
															echo '</div>	
														</td>
													</tr>	
												</table>
											</div>
											
											</a>																			
											
									</div>';
																
									$flag_item=1;
										
								}						
								if($flag_item!=1){
									echo '<h3 style="font-family:barOne;letter-spacing:1px;text-align:center;color:#1cb01c;">No product found.</h3>';
								}
			
		  
		  ?>
		
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
		$("#li-order-now").addClass("active");
	});	
</script>
</body>
</html>