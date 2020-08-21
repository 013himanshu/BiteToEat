<?php 
session_start();


	if(isset($_POST['key1'])){
		if(isset($_POST['opt'])){			
			
			if($_POST['opt']=="today"){				
				include('../../conx.php');
				
				date_default_timezone_set("Asia/Kolkata");						
				$date=date("Y-m-d");			
				if($stmt = $conn->prepare("SELECT orders_child.id, orders_child.order_parent_id, products.p_name, products.p_img, products.cost_on, orders_child.selling_price, orders_child.discount, orders_child.discount_type, orders_child.net_price, orders_child.qty, orders_child.measure_unit, orders_child.subtotal, orders_child.receive, orders_child.dispatch, orders_child.complete, orders_parent.add_date, orders_parent.add_time, register.firm_name, orders_parent.customer_address, c_info.name FROM orders_child, orders_parent, register, c_info, products WHERE orders_child.order_parent_id=orders_parent.order_id AND orders_child.seller=register.mbl_no AND orders_child.product_id=products.p_id AND orders_parent.customer_mbl=c_info.mbl_no AND orders_parent.add_date=? ORDER BY orders_child.id Desc, orders_child.order_parent_id DESC")){					
					if($stmt->bind_param("s", $date)){					
						$stmt->execute();
						$stmt->bind_result($id, $order_id, $p_name, $p_img, $cost_on, $selling_price, $discount, $discount_type, $net_price, $qty, $measure_unit, $subtotal, $receive, $dispatch, $complete, $add_date, $add_time, $seller, $caddress, $cname);	
						
						echo '<table class="table table-hover" id="orders-table">
							<thead>
							<tr>								
								<th>Id</th>
								<th>Item</th>
								<th>Details</th>								
								<th>Subtotal</th>
								<th>Date,Time</th>
								<th>Customer</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody id="orders-table-body">';
						$flag=0;
						while($stmt->fetch()){																						
							if($complete==1){
								$action='<button type="button" class="order-action-ok"><span class="glyphicon glyphicon-ok"></span> Delivered</button>';
							}
							else if($receive==1 && $dispatch==1 && $complete==0){
								$action='<button type="button" class="order-action-ok"><span class="glyphicon glyphicon-ok"></span> Received</button> <button type="button" class="order-action-ok"><span class="glyphicon glyphicon-ok"></span> Dispatched</button>';
							}
							else if($receive==1 && $dispatch==0 && $complete==0){
								$action='<button type="button" class="order-action-ok"><span class="glyphicon glyphicon-ok"></span> Received</button> <button type="button" class="order-action" pid="'.$id.'" id="dispatch">Dispatched?</button>';
							}
							else{
								$action='<button type="button" class="order-action" pid="'.$id.'" id="receive">Received?</button> <button type="button" class="order-action" pid="'.$id.'" id="dispatch">Dispatched?</button>';
							}
							
							echo '<tr id="'.$order_id.'">
								<td>'.$order_id.'</td>
								<td><img src="../'.$p_img.'" alt="'.$order_id.'image" height="60px" width="60px" /></td>													
								<td><strong>'.$p_name.'</strong><br><i><u>'.$seller.'</u></i><br>Rs.'.$selling_price.'<br>Per '.$cost_on,$measure_unit.'<br>';													
								if($discount!=NULL){
									if($discount_type=="Percent off"){
											echo $discount.' %Off<br>';
									}
									if($discount_type=="Money off"){
										echo 'Rs.'.$discount.' Off<br>';
									}
								}													
								echo '<div style="color:#1cb01c;border:1px dashed #1cb01c;padding:2px;display:inline-block;font-weight:bold;">Net Price: Rs.'.$net_price.'</div><br><div style="color:#1cb01c;border:1px dashed #1cb01c;padding:2px;display:inline-block;font-weight:bold;">Quantity: '.$qty.'</div></td>';												
								echo '<td><strong>Rs.'.$subtotal.'</strong></td>
									<td>'.$add_date.'<br>'.$add_time.'</td>
									<td><strong>'.$cname.'</strong><br>'.$caddress.'</td>
									<td>'.$action.'</td>
									</tr>';
							$flag=1;
						}
						echo '</tbody>';							
						if($flag==0){
							echo '<h3 class="style-txt">No orders till now.</h3>';
						}
					}
				}				
			}
			else if($_POST['opt']=="month"){
				include('../../conx.php');
				
				date_default_timezone_set("Asia/Kolkata");						
				$year=date("Y");
				$month=date("m");
				if($stmt = $conn->prepare("SELECT orders_child.id, orders_child.order_parent_id, products.p_name, products.p_img, products.cost_on, orders_child.selling_price, orders_child.discount, orders_child.discount_type, orders_child.net_price, orders_child.qty, orders_child.measure_unit, orders_child.subtotal, orders_child.receive, orders_child.dispatch, orders_child.complete, orders_parent.add_date, orders_parent.add_time, register.firm_name, orders_parent.customer_address, c_info.name FROM orders_child, orders_parent, register, c_info, products WHERE orders_child.order_parent_id=orders_parent.order_id AND orders_child.seller=register.mbl_no AND orders_child.product_id=products.p_id AND orders_parent.customer_mbl=c_info.mbl_no AND EXTRACT(YEAR FROM orders_parent.add_date)=? AND EXTRACT(MONTH FROM orders_parent.add_date)=? ORDER BY orders_child.id Desc, orders_child.order_parent_id DESC")){					
					if($stmt->bind_param("ss", $year, $month)){					
						$stmt->execute();
						$stmt->bind_result($id, $order_id, $p_name, $p_img, $cost_on, $selling_price, $discount, $discount_type, $net_price, $qty, $measure_unit, $subtotal, $receive, $dispatch, $complete, $add_date, $add_time, $seller, $caddress, $cname);	
						
						echo '<table class="table table-hover" id="orders-table">
							<thead>
							<tr>
								<th>Id</th>
								<th>Item</th>
								<th>Details</th>								
								<th>Subtotal</th>
								<th>Date,Time</th>
								<th>Customer</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody id="orders-table-body">';
						$flag=0;
						while($stmt->fetch()){																						
							if($complete==1){
								$action='<button type="button" class="order-action-ok"><span class="glyphicon glyphicon-ok"></span> Delivered</button>';
							}
							else if($receive==1 && $dispatch==1 && $complete==0){
								$action='<button type="button" class="order-action-ok"><span class="glyphicon glyphicon-ok"></span> Received</button> <button type="button" class="order-action-ok"><span class="glyphicon glyphicon-ok"></span> Dispatched</button>';
							}
							else if($receive==1 && $dispatch==0 && $complete==0){
								$action='<button type="button" class="order-action-ok"><span class="glyphicon glyphicon-ok"></span> Received</button> <button type="button" class="order-action" pid="'.$id.'" id="dispatch">Dispatched?</button>';
							}
							else{
								$action='<button type="button" class="order-action" pid="'.$id.'" id="receive">Received?</button> <button type="button" class="order-action" pid="'.$id.'" id="dispatch">Dispatched?</button>';
							}
							
							echo '<tr id="'.$order_id.'">
								<td>'.$order_id.'</td>
								<td><img src="../'.$p_img.'" alt="'.$order_id.'image" height="60px" width="60px" /></td>													
								<td><strong>'.$p_name.'</strong><br><i><u>'.$seller.'</u></i><br>Rs.'.$selling_price.'<br>Per '.$cost_on,$measure_unit.'<br>';													
								if($discount!=NULL){
									if($discount_type=="Percent off"){
											echo $discount.' %Off<br>';
									}
									if($discount_type=="Money off"){
										echo 'Rs.'.$discount.' Off<br>';
									}
								}													
								echo '<div style="color:#1cb01c;border:1px dashed #1cb01c;padding:2px;display:inline-block;font-weight:bold;">Net Price: Rs.'.$net_price.'</div><br><div style="color:#1cb01c;border:1px dashed #1cb01c;padding:2px;display:inline-block;font-weight:bold;">Quantity: '.$qty.'</div></td>';												
								echo '<td><strong>Rs.'.$subtotal.'</strong></td>
									<td>'.$add_date.'<br>'.$add_time.'</td>
									<td><strong>'.$cname.'</strong><br>'.$caddress.'</td>
									<td>'.$action.'</td>
									</tr>';
								$flag=1;
						}
						echo '</tbody>';
						if($flag==0){
							echo '<h3 class="style-txt">No orders till now.</h3>';
						}
					}
				}
			}
			else{
				
				include('../../conx.php');
								
				if($stmt = $conn->prepare("SELECT orders_child.id, orders_child.order_parent_id, products.p_name, products.p_img, products.cost_on, orders_child.selling_price, orders_child.discount, orders_child.discount_type, orders_child.net_price, orders_child.qty, orders_child.measure_unit, orders_child.subtotal, orders_child.receive, orders_child.dispatch, orders_child.complete, orders_parent.add_date, orders_parent.add_time, register.firm_name, orders_parent.customer_address, c_info.name FROM orders_child, orders_parent, register, products, c_info WHERE orders_child.order_parent_id=orders_parent.order_id AND orders_child.seller=register.mbl_no AND orders_child.product_id=products.p_id AND orders_parent.customer_mbl=c_info.mbl_no ORDER BY orders_child.id Desc, orders_child.order_parent_id DESC")){					
						$stmt->execute();
						$stmt->bind_result($id, $order_id, $p_name, $p_img, $cost_on, $selling_price, $discount, $discount_type, $net_price, $qty, $measure_unit, $subtotal, $receive, $dispatch, $complete, $add_date, $add_time, $seller, $caddress, $cname);	
						
						echo '<table class="table table-hover" id="orders-table">
							<thead>
							<tr>
								<th>Id</th>
								<th>Item</th>
								<th>Details</th>								
								<th>Subtotal</th>
								<th>Date,Time</th>
								<th>Customer</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody id="orders-table-body">';
						$flag=0;
						while($stmt->fetch()){
							if($complete==1){
								$action='<button type="button" class="order-action-ok"><span class="glyphicon glyphicon-ok"></span> Delivered</button>';
							}
							else if($receive==1 && $dispatch==1 && $complete==0){
								$action='<button type="button" class="order-action-ok"><span class="glyphicon glyphicon-ok"></span> Received</button> <button type="button" class="order-action-ok"><span class="glyphicon glyphicon-ok"></span> Dispatched</button>';
							}
							else if($receive==1 && $dispatch==0 && $complete==0){
								$action='<button type="button" class="order-action-ok"><span class="glyphicon glyphicon-ok"></span> Received</button> <button type="button" class="order-action" pid="'.$id.'" id="dispatch">Dispatched?</button>';
							}
							else{
								$action='<button type="button" class="order-action" pid="'.$id.'" id="receive">Received?</button> <button type="button" class="order-action" pid="'.$id.'" id="dispatch">Dispatched?</button>';
							}
							
							echo '<tr id="'.$order_id.'">
								<td>'.$order_id.'</td>
								<td><img src="../'.$p_img.'" alt="'.$order_id.'image" height="60px" width="60px" /></td>													
								<td><strong>'.$p_name.'</strong><br><i><u>'.$seller.'</u></i><br>Rs.'.$selling_price.'<br>Per '.$cost_on,$measure_unit.'<br>';													
								if($discount!=NULL){
									if($discount_type=="Percent off"){
											echo $discount.' %Off<br>';
									}
									if($discount_type=="Money off"){
										echo 'Rs.'.$discount.' Off<br>';
									}
								}													
								echo '<div style="color:#1cb01c;border:1px dashed #1cb01c;padding:2px;display:inline-block;font-weight:bold;">Net Price: Rs.'.$net_price.'</div><br><div style="color:#1cb01c;border:1px dashed #1cb01c;padding:2px;display:inline-block;font-weight:bold;">Quantity: '.$qty.'</div></td>';												
								echo '<td><strong>Rs.'.$subtotal.'</strong></td>
									<td>'.$add_date.'<br>'.$add_time.'</td>
									<td><strong>'.$cname.'</strong><br>'.$caddress.'</td>
									<td>'.$action.'</td>
									</tr>';
								$flag=1;
						}
						echo '</tbody>';
						if($flag==0){
							echo '<h3 class="style-txt">No orders till now.</h3>';
						}
					
				}
	
			}
			
		}
	}


?>