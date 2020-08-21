<?php 

session_start();

if(isset($_SESSION["check"])){
	if(isset($_POST['key1'])){
		
		if(isset($_POST['key2'])){
			$action=$_POST['key2'];
		}
		if(isset($_POST['key3'])){
			$p_id=$_POST['key3'];
		}
			
					
				if($action=="direct_buy" && isset($p_id)){	
					include('../conx.php');				
					if($stmt = $conn->prepare("SELECT cart.cart_id, cart.seller, cart.customer, products.p_id, products.p_name, products.p_img, cart.qty, products.measure_unit, products.p_cost, products.p_discount, products.p_discount_type from cart, products WHERE cart.product_id=products.p_id AND cart.customer=? AND products.p_id=? ORDER BY cart.cart_id DESC LIMIT 1")) {
						if($stmt->bind_param("si", $_SESSION["check"], $p_id)){
							$stmt->execute();
							$stmt->bind_result($fcart_id, $fseller, $fcustomer, $fp_id, $fp_name, $fp_img, $fqty, $fmeasure_unit, $fp_cost, $fp_discount, $fp_discount_type);																		
							$stmt->fetch();	
							$stmt->close();
							$conn->close();	
						}
					}
					
					include('../conx.php');
					if($stmt = $conn->prepare("SELECT delivery_mbl, address, landmark, pincode, city FROM c_info WHERE mbl_no=?")) {
						if($stmt->bind_param("s", $fcustomer)){
							$stmt->execute();
							$stmt->bind_result($cdelivery_mbl, $caddress, $clandmark, $cpincode, $ccity);
							$stmt->fetch();
							$stmt->close();
							$conn->close();	
						}							
					}
					
					$caddress=$caddress.'<br>'.$ccity.'<br>'.$cpincode.'<br>'.$clandmark.'<br>'.'Ph. '.$cdelivery_mbl;
					
					if($fp_discount!=NULL){
						if($fp_discount_type=="Percent off"){
							$cut=($fp_cost*$fp_discount)/100;									
							$net_price=$fp_cost-$cut;															
						}
						if($fp_discount_type=="Money off"){
							$net_price=$fp_cost-$fp_discount;									
						}																																																									
					}
					else{
						$net_price=$fp_cost;																												
					}
					
					$subtotal=$net_price*$fqty;
												
					if($subtotal<500){
						$delivery_fee=25;
					}
					else{
						$delivery_fee=0;
					}
					
					$amt_pay=$subtotal+$delivery_fee;
					
					//require 'php_includes/functions.php';
					
					date_default_timezone_set("Asia/Kolkata");
					$date=$time="";
					$date=date("Y-m-d");				
					$time=date("h:i:sa");
					include('../conx.php');
					if($stmt = $conn->prepare("INSERT INTO orders_parent (customer_mbl, customer_address, subtotal, delivery_fee, amt_pay, add_date, add_time) VALUES (?, ?, ?, ?, ?, ?, ?)")) {						
						if($stmt->bind_param("ssdidss", $fcustomer, $caddress, $subtotal, $delivery_fee, $amt_pay, $date, $time)){							
							$stmt->execute();
							
							$order_parent_id=$conn->insert_id;
							
							include('../conx.php');
							if($stmt = $conn->prepare("INSERT INTO orders_child (order_parent_id, cart_id, seller, product_id, selling_price, discount, discount_type, net_price, qty, measure_unit, subtotal) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {								
								if($stmt->bind_param("iisiiisdisd", $order_parent_id, $fcart_id, $fseller, $fp_id, $fp_cost, $fp_discount, $fp_discount_type, $net_price, $fqty, $fmeasure_unit, $subtotal)){									
									$stmt->execute();
									$stmt->close();
									$conn->close();
								}
							}
														
							include('../conx.php');
							if($stmt = $conn->prepare("SELECT order_parent_id FROM orders_child WHERE cart_id=?")) {
								if($stmt->bind_param("i", $fcart_id)){									
									$stmt->execute();
									$stmt->bind_result($morder_id);
									$stmt->fetch();
									//emailSellerOrder($fseller, $morder_id);
									//emailcustomerOrder($fseller, $fcustomer, $morder_id);
									$stmt->close();
									$conn->close();
								}
							}
							include('../conx.php');
							if($stmt = $conn->prepare("DELETE FROM cart WHERE cart_id=?")){
								if($stmt->bind_param("i", $fcart_id)){
									$stmt->execute();
									$stmt->close();
									$conn->close();
								}
							}
							
							echo '<h3 id="payHead" class="banner-head"><span class="glyphicon glyphicon-ok side-glyph"></span> <span class="banner-text">Payment</span></h3>
							<div id="payDiv" style="padding-bottom:10px;"><hr>
								<div id="payInner" style="padding-left:2%;">
									<div>
										<h3 style="font-family:abeezee;color:#1cb01c;">Thank You! Your order is placed.</h3><br>
										<h4 class="style-txt" style="display:inline;">Please keep</h4><h3 class="style-txt" style="display:inline;"> Rs.'.$amt_pay.' </h3><h4 class="style-txt" style="display:inline;">in cash ready.</h4>
									</div><br>
										
									<input type="button" class="go-btn" id="continueShopBtn" value="Continue Shopping" /><br><br>
								</div>
							</div>';
									
						}
					}				
				}
				else{
				
					function cart_child_insert($order_parent_id, $cart_id, $seller, $p_id, $p_cost, $p_discount, $p_discount_type, $net_price, $qty, $measure_unit, $subtotal){
						include('../conx.php');	
						if($stmtI = $conn->prepare("INSERT INTO orders_child (order_parent_id, cart_id, seller, product_id, selling_price, discount, discount_type, net_price, qty, measure_unit, subtotal) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {								
							if($stmtI->bind_param("iisiiisdisd", $order_parent_id, $cart_id, $seller, $p_id, $p_cost, $p_discount, $p_discount_type, $net_price, $qty, $measure_unit, $subtotal)){									
								$stmtI->execute();
								$stmtI->close();
							}
						}
					}
					
					include('../conx.php');
					if($stmt = $conn->prepare("SELECT delivery_mbl, address, landmark, pincode, city FROM c_info WHERE mbl_no=?")) {
						if($stmt->bind_param("s", $_SESSION["check"])){
							$stmt->execute();
							$stmt->bind_result($cdelivery_mbl, $caddress, $clandmark, $cpincode, $ccity);
							$stmt->fetch();
							$stmt->close();
							$conn->close();	
						}							
					}
					$caddress=$caddress.'<br>'.$ccity.'<br>'.$cpincode.'<br>'.$clandmark.'<br>'.'Ph. '.$cdelivery_mbl;
					
					include('../conx.php');
					if($stmt = $conn->prepare("SELECT cart.cart_id, products.p_id, cart.qty, products.p_cost, products.p_discount, products.p_discount_type from cart, products WHERE cart.product_id=products.p_id AND cart.customer=? ORDER BY cart.cart_id DESC")){
						if($stmt->bind_param("s", $_SESSION["check"])){
							$stmt->execute();
							$stmt->bind_result($fcart_id, $fp_id, $fqty, $fp_cost, $fp_discount, $fp_discount_type);
							$subtotal=0;						
							while($stmt->fetch()){														
								if($fp_discount!=NULL){
									if($fp_discount_type=="Percent off"){
										$cut=($fp_cost*$fp_discount)/100;																				
										$net_price=$fp_cost-$cut;									
									}
									if($fp_discount_type=="Money off"){									
										$net_price=$fp_cost-$fp_discount;									
									}
								}
								else{
									$net_price=$fp_cost;
								}								
								$net_price=$net_price*$fqty;												
								$subtotal=$subtotal+$net_price;
							}
							if($subtotal<500){	
								$delivery_fee=25;
								$amt_pay=$subtotal+$delivery_fee;
							}
							else{	
								$delivery_fee=0;
								$amt_pay=$subtotal+$delivery_fee;
							}
							$stmt->close();
							$conn->close();	
							
							date_default_timezone_set("Asia/Kolkata");
							$date=$time="";
							$date=date("Y-m-d");				
							$time=date("h:i:sa");
							include('../conx.php');
							if($stmt = $conn->prepare("INSERT INTO orders_parent (customer_mbl, customer_address, subtotal, delivery_fee, amt_pay, add_date, add_time) VALUES (?, ?, ?, ?, ?, ?, ?)")) {						
								if($stmt->bind_param("ssdidss", $_SESSION["check"], $caddress, $subtotal, $delivery_fee, $amt_pay, $date, $time)){							
									$stmt->execute();									
									$order_parent_id=$conn->insert_id;
									$stmt->close();
									$conn->close();																												
								}
							}
							include('../conx.php');				
									if($stmt = $conn->prepare("SELECT cart.cart_id, cart.seller, products.p_id, cart.qty, products.measure_unit, products.p_cost, products.p_discount, products.p_discount_type from cart, products WHERE cart.product_id=products.p_id AND cart.customer=?")) {
										if($stmt->bind_param("s", $_SESSION["check"])){
											$stmt->execute();
											$stmt->bind_result($cart_id, $seller, $p_id, $qty, $measure_unit, $p_cost, $p_discount, $p_discount_type);																		
											$amt_pay=0;
											while($stmt->fetch()){												
												if($p_discount!=""){
													if($p_discount_type=="Percent off"){
														$cut=($p_cost*$p_discount)/100;																				
														$net_price=$p_cost-$cut;									
													}
													if($p_discount_type=="Money off"){									
														$net_price=$p_cost-$p_discount;									
													}
												}
												else{
													$net_price=$p_cost;
												}												
												$subtotal=$net_price*$qty;
												$amt_pay=$amt_pay+$subtotal;
												cart_child_insert($order_parent_id, $cart_id, $seller, $p_id, $p_cost, $p_discount, $p_discount_type, $net_price, $qty, $measure_unit, $subtotal);																																		
											}
											$stmt->close();
											$conn->close();											
										}
									}
									include('../conx.php');
									if($stmt = $conn->prepare("DELETE FROM cart WHERE customer=?")){
										if($stmt->bind_param("s", $_SESSION["check"])){
											$stmt->execute();
											$stmt->close();
											$conn->close();
										}
									}
									if($amt_pay<500){															
										$amt_pay=$amt_pay+25;
									}
									else{														
										$amt_pay=$amt_pay+0;
									}
									echo '<h3 id="payHead" class="banner-head"><span class="glyphicon glyphicon-ok side-glyph"></span> <span class="banner-text">Payment</span></h3>
							<div id="payDiv" style="padding-bottom:10px;"><hr>
								<div id="payInner" style="padding-left:2%;">
									<div>
										<h3 style="font-family:abeezee;color:#1cb01c;">Thank You! Your order is placed.</h3><br>
										<h4 class="style-txt" style="display:inline;">Please keep</h4><h3 class="style-txt" style="display:inline;"> Rs.'.$amt_pay.' </h3><h4 class="style-txt" style="display:inline;">in cash ready.</h4>
									</div><br>
										
									<input type="button" class="go-btn" id="continueShopBtn" value="Continue Shopping" /><br><br>
								</div>
							</div>';
							
							
						}
					}
					
					
				}
		
	}
}	

?>