<?php 
	session_start();	
?>	

<!DOCTYPE html>
<html lang="en">
<head>

	<title>Buy Online Food And Services India | BiteToEat-A Network Of Food &amp; Services</title>
	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="Description" content="Order anything to eat or drink from the top brands in the market. BiteToEat provide its customers sweets deserts, dairy products, and services like juice, tiffin, etc. at reasonable prices within an hour at their doorstep." />
    <meta name="robots" content="index, follow">
	<meta name="googlebot" content="index, follow">	
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery.min.js"></script>
	<link href="css/jquery-ui.css" rel="stylesheet">
	<script src="js/bootstrap.min.js"></script>		
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/c_navbar.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/fonts.css">
	
	<!--styling starts-->
	<style>
		body{background-color:#f2f2f2;}
	</style>
	<!--styling ends-->
	
</head>

<body id="home">

<!--navbar-->
<?php 
	require 'php_includes/c_navbar.php';
?>
<!--navbar-->

<!--carousel-->
<div class="container-fluid">
	<div class="row">
			
		<div class="col-sm-12" style="padding:2%;">
			<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="3000" data-pause="null">

				<div class="carousel-inner" role="listbox" style="box-shadow: 0px 1px 25px rgba(0, 0, 0, 0.4);">
							
					<div class="item" id="itm1">
						<a href="product-list.php?brand=Bombay Misthan Bhandar"><img src="banner/BMBBanner-lg.jpg" width="100%" alt="BMBBanner.jpg"></a>
					</div>
					<div class="item active" id="itm2">
						<a href="product-list.php?brand=Dunkin Donuts"><img src="banner/dunkinBanner-lg.jpg" width="100%" alt="dunkinBanner-lg.jpg"></a>
					</div>
					<div class="item" id="itm3">
						<a href="product-list.php?brand=Frooce-The Juice Bar"><img src="banner/frooceBanner-lg.jpg" width="100%" alt="frooceBanner-lg.jpg"></a>
					</div>
					<div class="item" id="itm4">
						<a href="product-list.php?brand=Kanha"><img src="banner/kanhaBanner-lg.jpg" width="100%" alt="kanhaBanner-lg.jpg"></a>
					</div>
				 
				</div>

			</div>
		</div>
			
	</div>	
</div>
<!--carousel-->
<br>

<div id="categories" class="container outer-box">
<h3 class="container-head">Shop By Category</h3>
<div class="container-fluid box">
	<div class="row text-center">
		<div class="col-xs-6 col-md-3 category-item">
			<a href="product-list.php?category=Dairy">
				<img src="images\milk.png" />
				<p class="cap">Dairy</p>
			</a>
		</div>
		<div class="col-xs-6 col-md-3 category-item">
			 <a href="product-list.php?category=Desert">
				<img src="images\cake.png"/>
				<p class="cap">Deserts</p>
			</a>
		</div>
		<div class="col-xs-6 col-md-3 category-item">
			<a href="product-list.php?category=Fast Food">
				<img src="images\burger.png" />
				<p class="cap">Fast Foods</p>
			</a>
		</div>
		<div class="col-xs-6 col-md-3 category-item">
			<a href="product-list.php?category=Tiffins">
				<img src="images\tiffin.png"  />
				<p class="cap">Tiffins</p>
			</a>
		</div>
	</div>
	
	<div class="row text-center">
		<div class="col-xs-6 col-md-3 category-item">
			<a href="product-list.php?category=Thali">
				<img src="images\thali.png" />
				<p class="cap">Thali</p>
			</a>
		</div>
		<div class="col-xs-6 col-md-3 category-item">
			 <a href="product-list.php?category=Bakery">
				<img src="images\cookie.png" />
				<p class="cap">Bakery</p>
			</a>
		</div>
		<div class="col-xs-6 col-md-3 category-item">
			<a href="product-list.php?category=Drink">
				<img src="images\drink.png" />
				<p class="cap">Drinks &amp; Beverages</p>
			</a>
		</div>
		<div class="col-xs-6 col-md-3 category-item">
			<a href="product-list.php?category=Sweets">
				<img src="images\sweet.png" />
				<p class="cap">Sweets</p>
			</a>
		</div>
	</div>	
	
</div>	
</div>
<br>

<div id="new-products" class="container-fluid outer-box">
<h3 class="container-head">Best Indian Sweets</h3>
<div class="container-fluid box text-center">
  
  <?php 
	include('conx.php');
	
	if($stmt = $conn->prepare("SELECT register.firm_name, products.p_img, products.p_id, products.p_name, products.p_ori_cost, products.p_cost, products.cost_on, products.measure_unit, products.p_discount, products.p_discount_type FROM products, register WHERE register.mbl_no=products.server AND products.p_category='Sweets' ORDER BY RAND() DESC LIMIT 4")) {
		$stmt->execute();
		$stmt->bind_result($db_firm, $db_img, $db_p_id, $db_p_name, $db_p_ori_cost, $db_p_cost, $db_cost_on, $db_measure_unit, $db_p_discount, $db_p_discount_type);

						while($stmt->fetch()){
							if($db_p_discount!=NULL){
								if($db_p_discount_type=="Percent off"){
									$cut=round(($db_p_cost*$db_p_discount)/100);
									$showCost=$db_p_cost-$cut;
									$flag1=1;
									$showDiscount=$db_p_discount.'%<br>Off';									
								}
								if($db_p_discount_type=="Money off"){
									$showCost=$db_p_cost-$db_p_discount;
									$flag1=1;
									$showDiscount='Rs.'.$db_p_discount.'<br>Off';
								}
							}
							else{
								$showCost=$db_p_cost;
								$flag1=0;
							}																		
							
							echo '<div class="col-sm-3 col-xs-6" style="padding:5px;">
									<div class="panel panel-default" style="padding:0px;">';
										if($flag1==1){
											echo '<h5 class="showDiscount">'.$showDiscount.'</h5>';
										}
										echo '<a href="view-product.php?p_id='.base64_encode($db_p_id).'&item='.base64_encode($db_p_name).'">											
											<div class="panel-body">												
												<img src="'.$db_img.'" alt="'.$db_p_id.'" class="newly_add_img img-responsive">
												<h4 class="p_name">'.$db_p_name.'</h4>
												<h5 class="p_cost">Rs.'.$showCost.'</h5>
												<h5 class="brand"><span class="brand-name">Sold By<br></span> '.$db_firm.'</h5>																									
											</div>
										</a>
									</div>
								</div>';
						}						
						
	}
  
  ?>    	    

</div>
</div>
<br>


<div id="new-products" class="container-fluid outer-box">
<h3 class="container-head">Remove Your Thirst</h3>
<div class="container-fluid box text-center">
  
  <?php 
	include('conx.php');
	
	if($stmt = $conn->prepare("SELECT register.firm_name, products.p_img, products.p_id, products.p_name, products.p_ori_cost, products.p_cost, products.cost_on, products.measure_unit, products.p_discount, products.p_discount_type FROM products, register where register.mbl_no=products.server AND products.p_category='Drink' ORDER BY RAND() DESC LIMIT 4")) {
		$stmt->execute();
		$stmt->bind_result($db_firm, $db_img, $db_p_id, $db_p_name, $db_p_ori_cost, $db_p_cost, $db_cost_on, $db_measure_unit, $db_p_discount, $db_p_discount_type);

						while($stmt->fetch()){
							if($db_p_discount!=NULL){
								if($db_p_discount_type=="Percent off"){
									$cut=round(($db_p_cost*$db_p_discount)/100);
									$showCost=$db_p_cost-$cut;
									$flag1=1;
									$showDiscount=$db_p_discount.'%<br>Off';									
								}
								if($db_p_discount_type=="Money off"){
									$showCost=$db_p_cost-$db_p_discount;
									$flag1=1;
									$showDiscount='Rs.'.$db_p_discount.'<br>Off';
								}
							}
							else{
								$showCost=$db_p_cost;
								$flag1=0;
							}																		
							
							echo '<div class="col-sm-3 col-xs-6" style="padding:5px;">
									<div class="panel panel-default" style="padding:0px;">';
										if($flag1==1){
											echo '<h5 class="showDiscount">'.$showDiscount.'</h5>';
										}
										echo '<a href="view-product.php?p_id='.base64_encode($db_p_id).'&item='.base64_encode($db_p_name).'">									
											<div class="panel-body">												
												<img src="'.$db_img.'" alt="'.$db_p_id.'" class="newly_add_img img-responsive">
												<h4 class="p_name">'.$db_p_name.'</h4>
												<h5 class="p_cost">Rs.'.$showCost.'</h5>
												<h5 class="brand"><span class="brand-name">Sold By<br></span> '.$db_firm.'</h5>																									
											</div>
										</a>
									</div>
								</div>';
						}						
						
	}
  
  ?>    	    

</div>
</div>
<br>

<div id="new-products" class="container-fluid outer-box">
<h3 class="container-head">Newly Added</h3>
<div class="container-fluid box text-center">
  
  <?php 
	include('conx.php');
	
	if($stmt = $conn->prepare("SELECT register.firm_name, products.p_img, products.p_id, products.p_name, products.p_ori_cost, products.p_cost, products.cost_on, products.measure_unit, products.p_discount, products.p_discount_type FROM products, register where register.mbl_no=products.server ORDER BY products.add_date DESC LIMIT 4")) {
		$stmt->execute();
		$stmt->bind_result($db_firm, $db_img, $db_p_id, $db_p_name, $db_p_ori_cost, $db_p_cost, $db_cost_on, $db_measure_unit, $db_p_discount, $db_p_discount_type);

						while($stmt->fetch()){
							if($db_p_discount!=NULL){
								if($db_p_discount_type=="Percent off"){
									$cut=round(($db_p_cost*$db_p_discount)/100);
									$showCost=$db_p_cost-$cut;
									$flag1=1;
									$showDiscount=$db_p_discount.'%<br>Off';									
								}
								if($db_p_discount_type=="Money off"){
									$showCost=$db_p_cost-$db_p_discount;
									$flag1=1;
									$showDiscount='Rs.'.$db_p_discount.'<br>Off';
								}
							}
							else{
								$showCost=$db_p_cost;
								$flag1=0;
							}																		
							
							echo '<div class="col-sm-3 col-xs-6" style="padding:5px;">
									<div class="panel panel-default" style="padding:0px;">';
										if($flag1==1){
											echo '<h5 class="showDiscount">'.$showDiscount.'</h5>';
										}
										echo '<a href="view-product.php?p_id='.base64_encode($db_p_id).'&item='.base64_encode($db_p_name).'">						
											<div class="panel-body">												
												<img src="'.$db_img.'" alt="'.$db_p_id.'" class="newly_add_img img-responsive">
												<h4 class="p_name">'.$db_p_name.'</h4>											
												<h5 class="brand"><span class="brand-name">Sold By<br></span> '.$db_firm.'</h5>																									
											</div>
										</a>
									</div>
								</div>';
						}						
						
	}
  
  ?>    	    

</div>
</div>
<br>

<div id="new-products" class="container-fluid outer-box">
<h3 class="container-head">Recommended For You</h3>
<div class="container-fluid box text-center">
  
  <?php 
	include('conx.php');
	
	if($stmt = $conn->prepare("SELECT register.firm_name, products.p_img, products.p_id, products.p_name, products.p_ori_cost, products.p_cost, products.cost_on, products.measure_unit, products.p_discount, products.p_discount_type FROM products, register where register.mbl_no=products.server ORDER BY RAND() DESC LIMIT 4")) {
		$stmt->execute();
		$stmt->bind_result($db_firm, $db_img, $db_p_id, $db_p_name, $db_p_ori_cost, $db_p_cost, $db_cost_on, $db_measure_unit, $db_p_discount, $db_p_discount_type);

						while($stmt->fetch()){
							if($db_p_discount!=NULL){
								if($db_p_discount_type=="Percent off"){
									$cut=round(($db_p_cost*$db_p_discount)/100);
									$showCost=$db_p_cost-$cut;
									$flag1=1;
									$showDiscount=$db_p_discount.'%<br>Off';									
								}
								if($db_p_discount_type=="Money off"){
									$showCost=$db_p_cost-$db_p_discount;
									$flag1=1;
									$showDiscount='Rs.'.$db_p_discount.'<br>Off';
								}
							}
							else{
								$showCost=$db_p_cost;
								$flag1=0;
							}																		
							
							echo '<div class="col-sm-3 col-xs-6" style="padding:5px;">
									<div class="panel panel-default" style="padding:0px;">';
										if($flag1==1){
											echo '<h5 class="showDiscount">'.$showDiscount.'</h5>';
										}
										echo '<a href="view-product.php?p_id='.base64_encode($db_p_id).'&item='.base64_encode($db_p_name).'">											
											<div class="panel-body">												
												<img src="'.$db_img.'" alt="'.$db_p_id.'" class="newly_add_img img-responsive">
												<h4 class="p_name">'.$db_p_name.'</h4>
												<h5 class="p_cost">Rs.'.$showCost.'</h5>
												<h5 class="brand"><span class="brand-name">Sold By<br></span> '.$db_firm.'</h5>																									
											</div>
										</a>
									</div>
								</div>';
						}						
						
	}
  
  ?>    	    

</div>
</div>
<br>



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
	$(window).load(function(){
		$("#li-home").addClass("active");
	});	
</script>
<script>
	var width=$(window).width();		
	if(width<768){
		$("#itm1").html("<a href='product-list.php?brand=Bombay Misthan Bhandar'><img src='banner/BMBBanner.jpg' width='100%' alt='BMBBanner.jpg'></a>");
		$("#itm2").html("<a href='product-list.php?brand=Dunkin Donuts'><img src='banner/dunkinBanner.jpg' width='100%' alt='dunkinBanner.jpg'></a>");
		$("#itm3").html("<a href='product-list.php?brand=Frooce-The Juice Bar'><img src='banner/frooceBanner.jpg' width='100%' alt='frooceBanner.jpg'></a>");
		$("#itm4").html("<a href='product-list.php?brand=Kanha'><img src='banner/kanhaBanner.jpg' width='100%' alt='kanhaBanner.jpg'></a>");
	}
</script>

</body>
</html>
