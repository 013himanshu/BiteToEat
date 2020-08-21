<?php 
	session_start();
	
	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);		
		return $data;
	}
	
	if(isset($_SESSION["check"])){
		if(isset($_POST['change_info']) && $_POST['change_info']=="change_info"){
			if(isset($_POST['fname']) && isset($_POST['mbl']) && isset($_POST['email'])){
				$fname=test_input($_POST['fname']);
				$mbl=test_input($_POST['mbl']);
				$email=test_input($_POST['email']);
				
				if(empty($fname)){
					//Empty field	
					echo '<span class="glyphicon glyphicon-remove-circle"></span> Full Name required.';
				}
				else if(!preg_match("/^[a-zA-Z\.()_,\- ]+$/",$fname)){
					//Invalid Entry	
					echo '<span class="glyphicon glyphicon-remove-circle"></span> Invalid full name.';
				}
				else if(empty($mbl)){
					//Empty field				
					echo '<span class="glyphicon glyphicon-remove-circle"></span> Mobile No. required.';			
				}
				else if(!preg_match("/^[0-9]{10}+$/",$mbl)){
					//Invalid Entry				
					echo '<span class="glyphicon glyphicon-remove-circle"></span> Mobile No. must contain only 10 digit number.';
				}
				else if(empty($email)){
					//Empty field				
					echo '<span class="glyphicon glyphicon-remove-circle"></span> Email id required.';				
				}
				else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
					//Invalid Entry				
					echo '<span class="glyphicon glyphicon-remove-circle"></span> Invalid email id.';
				}				
				else{
					include('../conx.php');
					if($stmt = $conn->prepare("SELECT mbl_no FROM c_info WHERE mbl_no=?")){
						if($stmt->bind_param("s", $mbl)){
							$stmt->execute();
							$stmt->bind_result($db_mbl);
							if($stmt->fetch() && $_SESSION["check"]!=$db_mbl){								
								echo '<span class="glyphicon glyphicon-remove-circle"></span> An account already exists with this mobile no.';
							}
							else{								
								include('../conx.php');
								if($stmt = $conn->prepare("UPDATE c_info SET name=?, mbl_no=?, email=? WHERE mbl_no=? LIMIT 1")){
									if($stmt->bind_param("ssss", $fname, $mbl, $email, $_SESSION["check"])){
										$stmt->execute();
										$_SESSION["check"]=$mbl;
										$stmt->close();
										$conn->close();
										echo 'success';
									}
								}								
							}														
						}												
					}															
				}				
			}
		}
	}
?>