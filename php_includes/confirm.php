<?php 
	session_start();
	if(isset($_SESSION["check"])){
		if(isset($_POST['key1'])){
			$action=$_POST['key2'];
											
					if(isset($_POST['key3'])){
						$p_id=$_POST['key3'];
					}
					
					include('../conx.php');
					if($action=="direct_buy" && isset($p_id)){						
						$stmt = $conn->prepare("SELECT cart.cart_id, register.firm_name, products.p_id, products.p_name, products.p_img, cart.qty, products.cost_on, products.measure_unit, products.p_cost, products.p_discount, products.p_discount_type from cart, register, products WHERE register.mbl_no=cart.seller AND cart.product_id=products.p_id AND cart.customer=? AND products.p_id=? ORDER BY cart.cart_id DESC LIMIT 1");
						$stmt->bind_param("si", $_SESSION["check"], $p_id);
					}
					else{
						$stmt = $conn->prepare("SELECT cart.cart_id, register.firm_name, products.p_id, products.p_name, products.p_img, cart.qty, products.cost_on, products.measure_unit, products.p_cost, products.p_discount, products.p_discount_type from cart, register, products WHERE register.mbl_no=cart.seller AND cart.product_id=products.p_id AND cart.customer=? ORDER BY cart.cart_id DESC");
						$stmt->bind_param("s", $_SESSION["check"]);						
					}
					
					
					if($stmt->execute()){
							$stmt->bind_result($fcart_id, $fseller, $fp_id, $fp_name, $fp_img, $fqty, $fcost_on, $fmeasure_unit, $fp_cost, $fp_discount, $fp_discount_type);																		
							echo '<h3 id="confirmHead" class="banner-head"><span class="glyphicon side-glyph" style="padding-left:10px;font-family:abeezee;font-size:25px;">3</span> <span class="banner-text">Confirm Order</span></h3>
									<div id="confirmDiv" style="padding-bottom:10px;"><hr>
										<div class="table-responsive" style="padding-left:2%;padding-right:2%;padding-top:2%;max-height:400px;overflow:auto;">
											<table class="table table-hover">
												<thead>
													<tr>
														<th>Item</th>
														<th>Details</th>
														<th>Qty</th>
														<th>Subtotal</th>
													</tr>
												</thead>';												
												$savings=0; $e_total=0;
												while($stmt->fetch()){																																																	
													echo '<tbody class="style-txt">
														<td><img src="'.$fp_img.'" alt="'.$fp_name.'" height="60px" width="60px" /></td>
														<td><strong>'.$fp_name.'</strong><br><i>'.$fseller.'</i><br>Rs.'.$fp_cost.' Per '.$fcost_on,$fmeasure_unit.'<br>';
														if($fp_discount!=NULL){
															if($fp_discount_type=="Percent off"){
																	$cut=($fp_cost*$fp_discount)/100;											
																	$savings=$savings+$cut;
																	$net_price=$fp_cost-$cut;
																	echo $fp_discount.' %Off<br>';
															}
															if($fp_discount_type=="Money off"){
																$savings=$savings+$fp_discount;
																$net_price=$fp_cost-$fp_discount;
																echo 'Rs.'.$fp_discount.' Off<br>';
															}
														}
														else{
															$net_price=$fp_cost;
														}
														$subtotal=0;
														$subtotal=$net_price*$fqty;
														
														$e_total=$e_total+$subtotal;
														echo '<div style="color:#1cb01c;border:1px dashed #1cb01c;padding:2px;display:inline-block;font-weight:bold;">Net Price: Rs.'.$net_price.'</div>
														</td>
														<td class="qty" pid="'.$fcart_id.'" id="qty-pro_id">'.$fqty.'</td>
														<td style="vertical-align:top;"><strong>Rs.'.$subtotal.'</strong></td>																																																							
														</tbody>';													
												}												
											echo '</table>	
										</div>
										<div style="padding-left:2%;padding-top:3px;">';
											if($e_total<500){
												$delivery_fee='Rs.25';										
												$amt_pay=$e_total+25;
											}
											else{
												$delivery_fee='Free';										
												$amt_pay=$e_total+0;
											}											
											echo '
											<h4 class="style-txt" style="color:#1cb01c;">Estimated Total: Rs.'.$e_total.'</h4>
											<h4 class="style-txt" style="color:#1cb01c;">Delivery Fee: '.$delivery_fee.'</h4>
											<h3 class="style-txt">Amount Payable: Rs.'.$amt_pay.'</h3>
											<input type="button" class="go-btn" id="confirmBtn" value="Continue" />
										</div>
									</div>';														
					}
					else{
						echo '<h3 class="style-txt">Some problem occured. Please try again later.</h3>';
					}
				
			
		}
	}
	
		
?>