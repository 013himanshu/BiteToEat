<?php
session_start();
//to get cart items.
if(isset($_POST['key1'])){
							$flag=0;
								if(!isset($_SESSION["check"]) && isset($_SESSION["bte_cart"])){									
									echo '<div class="container" style="background-color:#ffffff;padding:0px;box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);margin-bottom:10px;">				
										<div class="table-responsive" id="table-responsive" style="min-height:300px;overflow:auto;">
											<table class="table">
												<thead><br>
													<tr>								
														<th>Item</th>
														<th>Details</th>
														<th>Qty</th>
														<th>Subtotal</th>								
														<th>Action</th>
													</tr>
												</thead>
												<tbody>';
																		
									$max=count($_SESSION['bte_cart']);	
									$savings=0; $e_total=0; $max--;
									
									for($i=$max;$i>=0;$i--){
										$flag=0;	
										include('../conx.php');
										if($stmt=$conn->prepare("SELECT register.firm_name, products.p_img, products.p_name, products.p_cost, products.cost_on, products.measure_unit, products.p_discount, products.p_discount_type FROM register, products WHERE register.mbl_no=products.server AND products.p_id=? LIMIT 1")){
											$stmt->bind_param("i", $_SESSION['bte_cart'][$i]['p_id']);
											$stmt->execute();
											$stmt->bind_result($seller, $p_img, $p_name, $p_cost, $cost_on, $measure_unit, $p_discount, $p_discount_type);
											$stmt->fetch();
												
											echo '<tr>
													<td><img src="'.$p_img.'" alt="'.$p_name.'" height="60px" width="60px" /></td>
													<td><strong>'.$p_name.'</strong><br><i>'.$seller.'</i><br>Rs.'.$p_cost.'<br>Per '.$cost_on,$measure_unit.'<br>';
													if($p_discount!=NULL){
														if($p_discount_type=="Percent off"){
																$cut=($p_cost*$p_discount)/100;											
																$savings=$savings+$cut;
																$net_price=$p_cost-$cut;
																echo $p_discount.' %Off<br>';
														}
														if($p_discount_type=="Money off"){
															$savings=$savings+$p_discount;
															$net_price=$p_cost-$p_discount;
															echo 'Rs.'.$p_discount.' Off<br>';
														}
													}
													else{
														$net_price=$p_cost;
													}
													$subtotal=0;
													$subtotal=$net_price*$_SESSION['bte_cart'][$i]['qty'];
													$e_total=$e_total+$subtotal;
													echo '<div style="color:#1cb01c;border:1px dashed #1cb01c;padding:2px;display:inline-block;font-weight:bold;">Net Price: Rs.'.$net_price.'</div>
													</td>												
													<td style="vertical-align:top;">
														<select name="qty" class="qty" id="'.$_SESSION['bte_cart'][$i]['id'].'" style="background-color:transparent;padding:2px;outline:none;width:50px;" required>';															
															$count=1;									
															while($count<=5){																						
																echo '<option value="'.$count.'" '; if($_SESSION['bte_cart'][$i]['qty']==$count){ echo 'selected'; } echo '>'.$count.'</option>';
																$count++;
															}										
														echo '</select>
													</td>
													<td style="vertical-align:top;"><strong>Rs.'.$subtotal.'</strong></td>
													<td style="vertical-align:top;"><span class="glyphicon glyphicon-trash trash" id="'.$_SESSION['bte_cart'][$i]['id'].'"></span></td>
												</tr>';										
										}
										$flag=1;						
									}							
									echo '</tbody>
											</table>
										</div>							
									</div>';
								}
								else{
									$cartTotal=0;
									include('conx.php');
									if($stmt = $conn->prepare("SELECT count(cart_id) FROM cart WHERE customer=?")) {
										if($stmt->bind_param("s", $_SESSION["check"])){
											$stmt->execute();
											$stmt->bind_result($cartTotal);										
											$stmt->fetch();
											$stmt->close();
											$conn->close();											
										}
									}
									if($cartTotal>0){
										include('conx.php');
										if($stmt = $conn->prepare("SELECT cart.cart_id, cart.qty, register.firm_name, products.p_img, products.p_name, products.p_cost, products.cost_on, products.measure_unit, products.p_discount, products.p_discount_type FROM cart, register, products WHERE register.mbl_no=products.server AND cart.product_id=products.p_id AND cart.customer=? ORDER BY cart.cart_id DESC")) {										
											if($stmt->bind_param("s", $_SESSION["check"])){
												$stmt->execute();
												$stmt->bind_result($cart_id, $qty, $seller, $p_img, $p_name, $p_cost, $cost_on, $measure_unit, $p_discount, $p_discount_type);										
												
												echo '<div class="container" style="background-color:#ffffff;padding:0px;box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);margin-bottom:10px;">				
														<div class="table-responsive" id="table-responsive" style="min-height:300px;overflow:auto;">
															<table class="table">
																<thead><br>
																	<tr>								
																		<th>Item</th>
																		<th>Details</th>
																		<th>Qty</th>
																		<th>Subtotal</th>								
																		<th>Action</th>
																	</tr>
																</thead>
																<tbody>';
												$savings=0; $e_total=0;				
												while($stmt->fetch()){
													echo '<tr>
														<td><img src="'.$p_img.'" alt="'.$p_name.'" height="60px" width="60px" /></td>
														<td><strong>'.$p_name.'</strong><br><i>'.$seller.'</i><br>Rs.'.$p_cost.'<br>Per '.$cost_on,$measure_unit.'<br>';
														if($p_discount!=NULL){
															if($p_discount_type=="Percent off"){
																	$cut=($p_cost*$p_discount)/100;											
																	$savings=$savings+$cut;
																	$net_price=$p_cost-$cut;
																	echo $p_discount.' %Off<br>';
															}
															if($p_discount_type=="Money off"){
																$savings=$savings+$p_discount;
																$net_price=$p_cost-$p_discount;
																echo 'Rs.'.$p_discount.' Off<br>';
															}
														}
														else{
															$net_price=$p_cost;
														}
														$subtotal=0;
														$subtotal=$net_price*$qty;
														$e_total=$e_total+$subtotal;
														echo '<div style="color:#1cb01c;border:1px dashed #1cb01c;padding:2px;display:inline-block;font-weight:bold;">Net Price: Rs.'.$net_price.'</div>
														</td>												
														<td style="vertical-align:top;">
															<select name="qty" class="qty" id="'.$cart_id.'" style="background-color:transparent;padding:2px;outline:none;width:50px;" required>';															
																$count=1;									
																while($count<=5){																						
																	echo '<option value="'.$count.'" '; if($qty==$count){ echo 'selected'; } echo '>'.$count.'</option>';
																	$count++;
																}										
															echo '</select>
														</td>
														<td style="vertical-align:top;"><strong>Rs.'.$subtotal.'</strong></td>
														<td style="vertical-align:top;"><span class="glyphicon glyphicon-trash trash" id="'.$cart_id.'"></span></td>
													</tr>';
													$flag=1;
												}									
												echo '</tbody>
															</table>
														</div>							
													</div>';
											}
										}
									}
								}
							
							
					
					
						if($flag==1){
							echo '<div class="container" style="background-color:#ffffff;box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);margin-bottom:10px;padding:20px;">					
									<div class="row">
										<div class="col-sm-6">
											<h3 style="font-family:abeezee;color:#1cb01c;">Cart Totals</h3>';								
												$ttl_amt=$e_total;
												if($e_total<500){
													$delivery_fee='Rs.40';										
													$e_total=$e_total+40;
												}
												else{
													$delivery_fee='Free';										
													$e_total=$e_total+0;
												}
											
											echo '<table class="table" style="font-family:barOne;letter-spacing:1px;font-size:18px;">
												<tbody>													
													<tr>
														<td>Total Amount</td>
														<td>Rs.'.$ttl_amt.'</td>
													</tr>
													<tr>
														<td>Delivery Fee</td>
														<td>'.$delivery_fee.'</td>
													</tr>
													<tr>
														<td><h4>Amount Payable</h4></td>
														<td><h4><strong>Rs.'.$e_total.'</strong></h4></td>
													</tr>
												</tbody>
											</table>
											<div class="col-sm-5" style="padding:3px;">
												<button type="button" class="no-fill go-home" >&lt;&lt; Continue Shopping</button>
											</div>
											<div class="col-sm-6" style="padding:3px;">
												<form role="form" autocomplete="off" method="post" action="view-cart.php">
													<input type="submit" name="add_orderList" value="Place Order &gt;&gt;" class="fill" />
												</form>
											</div>	
										</div>
										<div class="col-sm-7"></div>
									</div>														
								</div>';
						}
						else{
							echo '<div class="container text-center" style="background-color:#ffffff;height:250px;padding:15px;padding-top:60px;box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);margin-bottom:10px;">
									<h3 style="color:#000;font-family:abeezee;letter-spacing:2px;">Your cart is empty.</h3>
									<button type="button" class="fill go-home">&lt;&lt; Continue Shopping</button>
								</div>';
						}						
}
else{	
	echo '<div class="container text-center" style="background-color:#ffffff;height:250px;padding:15px;padding-top:40px;box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);margin-bottom:10px;">
			<h3 style="color:#000;font-family:abeezee;letter-spacing:2px;">Oops! A problem occured. Please try again later.</h3><br>
			<button type="button" class="fill go-home">&lt;&lt; Continue Shopping</button>
		</div>';
}
?>
					