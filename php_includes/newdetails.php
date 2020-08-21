<?php 
session_start();

function test_input($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);	
	return $data;
}

if($_SERVER["REQUEST_METHOD"]=="POST"){
	if(isset($_POST["deliveryBtn"])){
		if(isset($_SESSION["check"])){			
			$mbl=test_input($_POST["mbl"]);
			$pin=test_input($_POST["pin"]);
			$address=test_input($_POST["address"]);
			$landmark=test_input($_POST["landmark"]);
			
			if(empty($mbl)){
				//Empty field				
				echo "Mobile no. cannot be empty";
			}
			else if(!preg_match("/^[0-9]{10}+$/",$mbl)){
				//Invalid Entry				
				echo "Mobile no. must contain only 10 digit numbers.";
			}	
			else if(empty($pin)){
				//Empty field				
				echo "Pincode cannot be empty";
			}
			else if(!preg_match("/^[0-9]{6}+$/",$pin)){
				//Invalid Entry				
				echo "Pincode must contain only 6 digit numbers.";
			}		
			else if(empty($address)){
				//Empty field				
				echo "Address cannot be empty";
			}
			else if(!preg_match("/^[a-zA-Z0-9\.\+()_,\-\/ ]+$/",$address)){
				//Invalid Entry				
				echo "Address must contain only alpha-numeric characters and special characters(.+()_,\/-)";
			}
			else if(strlen($landmark)>0 && !preg_match("/^[a-zA-Z0-9\.\+()_,\-\/ ]*$/",$landmark)){
				//Invalid Entry				
				echo "Landmark must contain only alpha-numeric characters and special characters(.+()_,\/-)";
			}
			else{
				
				
				if($landmark==""){
					$landmark=NULL;
				}
				include('../conx.php');
				if($stmt = $conn->prepare("SELECT pin from pincode WHERE pin=? LIMIT 1")) {
					if($stmt->bind_param("s", $pin)){
						$stmt->execute();
						$stmt->bind_result($dbpin);
						$stmt->fetch();
						if($pin==$dbpin){							

							include('../conx.php');
							
							if($stmt = $conn->prepare("UPDATE c_info SET delivery_mbl=?, pincode=?, address=?, landmark=? WHERE mbl_no=? LIMIT 1")) {
								if($stmt->bind_param("sssss", $mbl, $pin, $address, $landmark, $_SESSION["check"])){
									$stmt->execute();									
									$stmt->close();
									$conn->close();
									echo "success";	
								}
							}																																
						}
						else{
							echo "Sorry, we do not deliver in this area currently.";
						}
					}					
				}												
			}
		}
	}	
}


?>