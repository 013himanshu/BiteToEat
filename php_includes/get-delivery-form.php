<?php 
session_start();

if(isset($_SESSION["check"])){
	if(isset($_POST['action']) && $_POST['action']=='direct_buy'){
		if(isset($_POST['key1']) && isset($_POST['key2'])){			
			$p_id=$_POST['key1'];
			$qty=$_POST['key2'];	
			include('../conx.php');
			if($stmt = $conn->prepare("SELECT server FROM products WHERE p_id=? LIMIT 1")) { 
				if($stmt->bind_param("i", $p_id)){
					$stmt->execute();
					$stmt->bind_result($dbseller);										
					$stmt->fetch();
								
					date_default_timezone_set("Asia/Kolkata");
					$date=$time="";
					$date=date("Y-m-d");				
					$time=date("h:i:sa");
					include('../conx.php');
					if($stmt = $conn->prepare("INSERT INTO cart (seller, customer, product_id, qty, add_date, add_time) VALUES (?, ?, ?, ?, ?, ?)")) {
						if($stmt->bind_param("ssiiss", $dbseller, $_SESSION["check"], $p_id, $qty, $date, $time)){
							$stmt->execute();
							$stmt->close();
							$conn->close();
						}
					}								
				}
			}
		}
	}
		
		include('../conx.php');
		
		if($stmt = $conn->prepare("SELECT mbl_no, delivery_mbl, address, landmark, pincode, city, state, country FROM c_info WHERE mbl_no=? LIMIT 1")) {
			if($stmt->bind_param("s", $_SESSION["check"])){
				$stmt->execute();
				$stmt->bind_result($mbl, $delivery_mbl, $address, $landmark, $pincode, $city, $state, $country);
				$stmt->fetch();			
			}	
			$stmt->close();
			$conn->close();
		}
		
		if($delivery_mbl==NULL){
			$delivery_mbl=$mbl;
		}
		if($address==NULL){
			$address="";
		}
		if($landmark==NULL){
			$landmark="";
		}
		if($pincode==NULL){
			$pincode="";
		}	
		if($city==NULL){
			$city="";
		}
		if($state==NULL){
			$state="";
		}
		if($country==NULL){
			$country="";
		}

	
		echo '<h3 id="deliveryHead" class="banner-head"><span class="glyphicon side-glyph" style="padding-left:10px;font-family:abeezee;font-size:25px;">2</span> <span class="banner-text">Delivery Details</span></h3>
			<div id="deliveryDiv" style="padding-bottom:10px;"><hr>
				<form role="form" id="deliveryForm" name="deliveryForm" style="padding-left:2%;" autocomplete="off">
					<p id="delivery-err" style="font-size:15px;font-family:muli;padding:10px;"></p>
					<div class="form-group">
						<label for="mbl">Mobile No.</label>
						<input type="tel" class="form-control" id="delivery-mbl" name="delivery-mbl" minlength="10" maxlength="10" placeholder="Enter your mobile no." value="'.$delivery_mbl.'" required />					
					</div>
					<div class="form-group">
						<label for="pin">Pincode</label>
						<input type="tel" class="form-control" id="delivery-pincode" name="delivery-pincode" minlength="6" maxlength="6" placeholder="Enter your pincode." value="'.$pincode.'" required />					
					</div>
					<div class="form-group">
						<label for="address">Address</label><br>
						<textarea name="delivery-address" id="delivery-address" rows="3" cols="10" maxlength="200" placeholder="Enter your address." required style="resize:none;">'.$address.'</textarea>
					</div>
					<div class="form-group">
						<label for="landmark">Landmark</label>
						<input type="text" class="form-control" id="delivery-landmark" name="delivery-landmark" placeholder="(Optional)" value="'.$landmark.'" />					
					</div>
					<div class="form-group">
						<label for="city">City <span style="color:#000000;font-size:12px;">(Service currently available only in Jaipur)</span></label>													
					</div>
					<div class="form-group">
						<label for="state">State <span style="color:#000000;font-size:12px;">(Service currently available only in Rajasthan)</span></label>													
					</div>
					<div class="form-group">
						<label for="country">Country <span style="color:#000000;font-size:12px;">(Service currently available only in India)</span></label>													
					</div>
					<input type="submit" value="Continue" id="deliveryBtn" name="deliveryBtn" />
				</form>
			</div>';
		
}
else{
	echo '<h3 id="deliveryHead" class="banner-head"><span class="side-glyph" style="padding-left:10px;">2</span> <span class="banner-text">Delivery Details</span></h3>
			<div id="deliveryDiv" style="padding-bottom:10px;"><hr>
				<h5 style="padding-left:2%;">Some problem occured, please try again later.</h5>
			</div>';
}
	
?>