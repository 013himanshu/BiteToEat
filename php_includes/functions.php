<?php
	
	//function to add logout cart into database on login.
	function logoutCart(){
		if(isset($_SESSION['bte_cart']) && is_array($_SESSION['bte_cart'])){
			$max=count($_SESSION['bte_cart']);
			$i=0;								
			while($i<$max){
				date_default_timezone_set("Asia/Kolkata");									
																
				include('conx.php');
				if($stmt=$conn->prepare("SELECT server FROM products WHERE p_id=?")){
					if($stmt->bind_param("i",$_SESSION['bte_cart'][$i]['p_id'])){
						$stmt->execute();
						$stmt->bind_result($seller);
						$stmt->fetch();											
						$stmt->close();
						$conn->close();
					}
				}
					
				$customer=$_SESSION["check"];
				$p_id=$_SESSION['bte_cart'][$i]['p_id'];
				$qty=$_SESSION['bte_cart'][$i]['qty'];
				$add_date=date("Y-m-d");				
				$add_time=date("h:i:sa");
				include('conx.php');
				if($stmt = $conn->prepare("INSERT INTO cart (seller, customer, product_id, qty, add_date, add_time) VALUES (?, ?, ?, ?, ?, ?)")){
					if($stmt->bind_param("ssiiss", $seller, $customer, $p_id, $qty, $add_date, $add_time)){
						$stmt->execute();
						$stmt->close();
						$conn->close();
					}
				}
				$i++;
			}
			unset($_SESSION['bte_cart']);								
		}
	}
	
	function emailSellerOrder($fseller, $morder_id){																	
								
								include('conx.php');
								if($stmt = $conn->prepare("SELECT email, firm_name FROM register WHERE mbl_no=?")){
									if($stmt->bind_param("s", $fseller)){
										$stmt->execute();
										$stmt->bind_result($email, $firm_name);
										$stmt->fetch();
										$stmt->close();
										$conn->close();
									}
								}
								
								include('conx.php');
								if($stmt = $conn->prepare("SELECT orders_child.order_parent_id, orders_child.product_id, orders_child.selling_price, orders_child.discount, orders_child.discount_type, orders_child.net_price, orders_child.qty, orders_child.measure_unit, orders_child.subtotal, orders_parent.add_date, orders_parent.add_time, products.p_name FROM orders_child, orders_parent, products WHERE orders_parent.order_id=orders_child.order_parent_id AND orders_child.product_id=products.p_id AND orders_child.seller=? AND orders_parent.customer_mbl=? AND orders_child.order_parent_id=? ORDER BY orders_child.order_parent_id DESC LIMIT 1")){
									if($stmt->bind_param("ssi", $fseller, $_SESSION["check"], $morder_id)){
										$stmt->execute();
										$stmt->bind_result($forder_id, $fp_id, $fprice, $fdiscount, $fdiscount_type, $fnet_price, $fqty, $fmeasure_unit, $fsubtotal, $fo_date, $fo_time, $fp_name);
										$stmt->fetch();
										$stmt->close();
										$conn->close();
									}
								}
								
								if($fdiscount!=NULL){
									if($fdiscount_type=="Percent off"){																													
										$showDiscount=$fdiscount.' '.'%Off';
									}
									if($fdiscount_type=="Money off"){										
										$showDiscount='Rs.'.$fdiscount.' Off';
									}																																																									
								}
								else{									
									$showDiscount='None';	
								}																
								
								//mail starts
								$to=$email;	
								$subject="New Order [".$forder_id."] - You have a new order from BiteToEat.";
								
								date_default_timezone_set("Asia/Kolkata");
								$date=$time="";
								$date=date("Y-m-d");				
								$time=date("h:i:sa");								
								
								require '../PHPMailer/PHPMailerAutoload.php';

								$mail = new PHPMailer;

								$mail->isSMTP();

								$mail->SMTPOptions = array(
									'ssl' => array(
										'verify_peer' => false,
										'verify_peer_name' => false,
										'allow_self_signed' => true
									)
								);
																 
								$mail->Host = 'mail.bitetoeat.in';  
								$mail->SMTPAuth = true;                               
								$mail->Username = 'mail@bitetoeat.in';                 
								$mail->Password = 'i0=i3i2(q7Rr';                           
								$mail->SMTPSecure = 'tls';                          
								$mail->Port = 587;                                    

								$mail->setFrom('mail@bitetoeat.in', 'BiteToEat');
								$mail->addAddress($to);     

								$mail->addReplyTo('mail@bitetoeat.in');

								$mail->isHTML(true);                                  

								$mail->Subject = $subject;
								$mail->Body    = '<div class="container" style="color:#1cb01c;font-family:arial;text-align:center;width:500px;border:2px solid;">
														<div class="logoText" style="background-color:#1cb01c;">
															<a href="sell.php"><img class="img-responsive" src="https://bitetoeat.in/images/logoW.png" alt="BiteToEat" style="width:70%;" /></a>
														</div>
														<div class="body">
															<h3 style="border-bottom:2px dashed;padding:5px;">Order For, '.$firm_name.'.</h3>
															<h2><u>Your Order Details</u></h2>
														</div>		
														<div class="details" style="text-align:left;padding:20px;">															
															<h3>Order Id: '.$forder_id.'</h3>
															<h3>Item: '.$fp_name.'</h3>															
															<h3>Price: Rs.'.$fprice.'</h3>
															<h3>Discount: '.$showDiscount.'</h3>
															<h3>Net Price: Rs.'.$fnet_price.'</h3>
															<h3>Quantity: '.$fqty.$fmeasure_unit.'</h3>																																													
															<h3 style="display:inline;">Subtotal: </h3><h2 style="display:inline;font-weight:bold;">Rs.'.$fsubtotal.'</h2>															
															<h5>Order Placed On: '.$fo_date.' | '.$fo_time.'</h5>
														</div>
														<div class="footer" style="text-align:left;border-top:2px dashed;">			
															<h5 style="padding:5px;">mail@bitetoeat.in <span style="float:right;">Mail Sent On, ['.$date.','.$time.']</span></h5>			
														</div>
													</div>';
								$mail->AltBody = '<h3>Order Id: '.$forder_id.'</h3>
													<h3>Item: '.$fp_name.'</h3>															
													<h3>Price: Rs.'.$fprice.'</h3>
													<h3>Discount: '.$showDiscount.'</h3>
													<h3>Net Price: Rs.'.$fnet_price.'</h3>
													<h3>Quantity: '.$fqty.$fmeasure_unit.'</h3>																																													
													<h3 style="display:inline;">Subtotal: </h3><h2 style="display:inline;font-weight:bold;">Rs.'.$fsubtotal.'</h2>															
													<h5>Order Placed On: '.$fo_date.' | '.$fo_time.'</h5>';

								if(!$mail->send()) {
									exit(0);
								}																																
					}

					function emailcustomerOrder($fseller, $fcustomer, $morder_id){
						
						include('conx.php');
						if($stmt = $conn->prepare("select register.firm_name, c_info.email, c_info.name from register, c_info, orders_child, orders_parent where orders_child.seller=register.mbl_no AND register.mbl_no=? AND  orders_parent.customer_mbl=c_info.mbl_no AND c_info.mbl_no=?")){
							if($stmt->bind_param("ss", $fseller, $fcustomer)){
								$stmt->execute();
								$stmt->bind_result($firm_name, $email, $cname);
								$stmt->fetch();
								$stmt->close();
								$conn->close();
							}
						}
						
						include('conx.php');
						if($stmt = $conn->prepare("SELECT orders_child.order_parent_id, orders_child.product_id, orders_child.selling_price, orders_child.discount, orders_child.discount_type, orders_child.net_price, orders_child.qty, orders_child.measure_unit, orders_child.subtotal, orders_parent.delivery_fee, orders_parent.amt_pay, orders_parent.add_date, orders_parent.add_time, products.p_name FROM orders_child, orders_parent, products WHERE orders_parent.order_id=orders_child.order_parent_id AND orders_child.product_id=products.p_id AND orders_child.seller=? AND orders_parent.customer_mbl=? AND orders_child.order_parent_id=? ORDER BY orders_child.order_parent_id DESC LIMIT 1")){
							if($stmt->bind_param("ssi", $fseller, $fcustomer, $morder_id)){
								$stmt->execute();
								$stmt->bind_result($forder_id, $fp_id, $fprice, $fdiscount, $fdiscount_type, $fnet_price, $fqty, $fmeasure_unit, $fsubtotal, $fdelivery_fee, $famt_pay, $fo_date, $fo_time, $fp_name);
								$stmt->fetch();
								$stmt->close();
								$conn->close();
							}
						}
								
						if($fdiscount!=NULL){
							if($fdiscount_type=="Percent off"){														
								$showDiscount=$fdiscount.' '.'%Off';
							}
							if($fdiscount_type=="Money off"){								
								$showDiscount='Rs.'.$fdiscount.' Off';							
							}																																																									
						}
						else{							
							$showDiscount='None';	
						}						
						
						if($fdelivery_fee<1){
							$fdelivery_fee="Free";
						}
						else{
							$fdelivery_fee='Rs.'.$fdelivery_fee;
						}
						
						
								//mail starts
								$to=$email;	
								$subject="Order Placed [".$forder_id."] - You order has been placed from BiteToEat.";
								
								date_default_timezone_set("Asia/Kolkata");
								$date=$time="";
								$date=date("Y-m-d");				
								$time=date("h:i:sa");																							

								$mail = new PHPMailer;

								$mail->isSMTP();

								$mail->SMTPOptions = array(
									'ssl' => array(
										'verify_peer' => false,
										'verify_peer_name' => false,
										'allow_self_signed' => true
									)
								);
								
								$mail->Host = 'mail.bitetoeat.in';  
								$mail->SMTPAuth = true;                               
								$mail->Username = 'mail@bitetoeat.in';                 
								$mail->Password = 'i0=i3i2(q7Rr';                           
								$mail->SMTPSecure = 'tls';                          
								$mail->Port = 587;                                    

								$mail->setFrom('mail@bitetoeat.in', 'BiteToEat');
								$mail->addAddress($to);     

								$mail->addReplyTo('mail@bitetoeat.in');

								$mail->isHTML(true);                                  

								$mail->Subject = $subject;
								$mail->Body    = '<div class="container" style="color:#1cb01c;font-family:arial;text-align:center;width:500px;border:2px solid;">
														<div class="logoText" style="background-color:#1cb01c;">
															<a href="sell.php"><img class="img-responsive" src="https://bitetoeat.in/images/logoW.png" alt="BiteToEat" style="width:70%;" /></a>
														</div>
														<div class="body">
															<h3 style="border-bottom:2px dashed;padding:5px;">Hi, '.$cname.'.</h3>
															<h2><u>Your Order Details</u></h2>
														</div>		
														<div class="details" style="text-align:left;padding:20px;">
															<h3>Order Id: '.$forder_id.'</h3>
															<h3>Item: '.$fp_name.'</h3>
															<h3>Sold By: '.$firm_name.'</h3>
															<h3>Price: Rs.'.$fprice.'</h3>
															<h3>Discount: '.$showDiscount.'</h3>
															<h3>Net Price: Rs.'.$fnet_price.'</h3>
															<h3>Quantity: '.$fqty.$fmeasure_unit.'</h3>															
															<h3>Subtotal: Rs.'.$fsubtotal.'</h3>
															<h3>Delivery Fee: '.$fdelivery_fee.'</h3>
															<h3 style="display:inline;">Amount Payable: </h3><h2 style="display:inline;font-weight:bold;">Rs.'.$famt_pay.'</h2>															
															<h5>Order Placed On: '.$fo_date.' | '.$fo_time.'</h5>
														</div>
														<div class="footer" style="text-align:left;border-top:2px dashed;">			
															<h5 style="padding:5px;">mail@bitetoeat.in <span style="float:right;">Mail Sent On, ['.$date.','.$time.']</span></h5>			
														</div>
													</div>';
								$mail->AltBody = '<h3>Order Id: '.$forder_id.'</h3>
													<h3>Item: '.$fp_name.'</h3>
													<h3>Sold By: '.$firm_name.'</h3>
													<h3>Price: Rs.'.$fprice.'</h3>
													<h3>Discount: '.$showDiscount.'</h3>
													<h3>Net Price: Rs.'.$fnet_price.'</h3>
													<h3>Quantity: '.$fqty.$fmeasure_unit.'</h3>													
													<h3>Subtotal: Rs.'.$fsubtotal.'</h3>
													<h3>Delivery Fee: '.$fdelivery_fee.'</h3>
													<h3 style="display:inline;">Amount Payable: </h3><h2 style="display:inline;font-weight:bold;">Rs.'.$famt_pay.'</h2>															
													<h5>Order Placed On: '.$fo_date.' | '.$fo_time.'</h5>';

								if(!$mail->send()) {
									exit(0);
								}
						
					}
	
?>