<?php 
	

function test_input($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);	
	return $data;
}

if($_SERVER["REQUEST_METHOD"]=="POST"){
	if(isset($_POST["availabilityBtn"])){
		$pin=test_input($_POST['pin']);
		
		if(empty($pin)){
			//Empty field				
			echo '<span class="glyphicon glyphicon-ban-circle"></span> Pincode cannot be empty';
		}
		else if(!preg_match("/^[0-9]{6}+$/",$pin)){
			//Invalid Entry				
			echo '<span class="glyphicon glyphicon-ban-circle"></span> Pincode must contain only 6 digit numbers.';
		}
		else{
		
			include('../conx.php');
				if($stmt = $conn->prepare("SELECT pin from pincode WHERE pin=? LIMIT 1")) {
					if($stmt->bind_param("s", $pin)){
						$stmt->execute();
						$stmt->bind_result($dbpin);
						$stmt->fetch();
						$stmt->close();
						$conn->close();
						if($pin==$dbpin){
							echo '<span class="glyphicon glyphicon-ok"></span> Delivery available in this area.';
						}
						else{
							echo '<span class="glyphicon glyphicon-remove"></span> Sorry, we do not deliver in this area currently.';
						}
					}
				}
		
		}
		
	}
}
else{
	header("Location:index.php");
	exit(0);
}	


	
?>