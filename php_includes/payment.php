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

		include('../conx.php');
		
		if($action=="direct_buy" && isset($p_id)){
			$stmt = $conn->prepare("SELECT cart.cart_id, cart.seller, cart.customer, products.p_id, products.p_name, products.p_img, cart.qty, products.measure_unit, products.p_cost, products.p_discount, products.p_discount_type from cart, products WHERE cart.product_id=products.p_id AND cart.customer=? AND products.p_id=? ORDER BY cart.cart_id DESC LIMIT 1");
			$stmt->bind_param("si", $_SESSION["check"], $p_id);
		}
		else{
			$stmt = $conn->prepare("SELECT cart.cart_id, cart.seller, cart.customer, products.p_id, products.p_name, products.p_img, cart.qty, products.measure_unit, products.p_cost, products.p_discount, products.p_discount_type from cart, products WHERE cart.product_id=products.p_id AND cart.customer=? ORDER BY cart.cart_id DESC");
			$stmt->bind_param("s", $_SESSION["check"]);
		}
				
					
					
					if($stmt->execute()){
						$stmt->bind_result($fcart_id, $fseller, $fcustomer, $fp_id, $fp_name, $fp_img, $fqty, $fmeasure_unit, $fp_cost, $fp_discount, $fp_discount_type);																		
						
						$e_total=0;						
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
							$subtotal=0;
							$subtotal=$net_price*$fqty;												
							$e_total=$e_total+$subtotal;
						}
						if($e_total<500){															
							$amt_pay=$e_total+25;
						}
						else{														
							$amt_pay=$e_total+0;
						}												
							echo '<h3 id="payHead" class="banner-head"><span class="glyphicon side-glyph" style="padding-left:10px;font-family:abeezee;font-size:25px;">4</span> <span class="banner-text">Payment</span></h3>
								  <div id="payDiv" style="padding-bottom:10px;"><hr>
									<div id="payInner" style="padding-left:2%;">
										<div>
											<h4 class="style-txt" style="display:inline;">You Pay: </h4><h3 style="display:inline;">Rs.'.$amt_pay.'</h3><br><br>								  
											<h4 class="style-txt" style="display:inline;">Payment Mode: </h4><h3 style="display:inline;">Cash On Delivery</h3>
										</div><br>
										<div id="payBtnDiv">
											<input type="button" class="go-btn" id="payBtn" value="Place Order" /><br><br>
										</div>
										<span style="font-family:abeezee;font-size:15px;color:#9e9e9e;">By placing the order, I have read and accepted the following :</span>
										<ul style="font-family:abeezee;font-size:13px;color:#9e9e9e;">
											<li>Order will be delivered within 60 minutes.</li>
											<li>Some delay might happen in delivery according to the situation.</li>
											<li>Once order is placed it cannot be returned or cancelled.</li>
										</ul>										
									</div>									  
								  </div>';
					}
					
					
											
			
		
	}
}

?>