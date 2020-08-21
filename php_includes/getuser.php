<?php
	session_start();
	
	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);		
		return $data;
	}
	
	if($_SERVER["REQUEST_METHOD"]=="POST"){
		if(isset($_POST["loginBtn"])){
			
			$mbl=test_input($_POST["mbl"]);
			$psw=test_input($_POST["psw"]);
			
			if(empty($mbl)){
				//Empty field				
				echo "Mobile no. cannot be empty";				
			}
			else if(!preg_match("/^[0-9]{10}+$/",$mbl)){
				//Invalid Entry				
				echo "Mobile no. must contain only 10 digit numbers.";
			}
			else if(empty($psw)){
				//Empty field				
				echo "Password cannot be empty";		
			}
			else if(!preg_match("/^[a-zA-Z0-9\W ]{4,8}+$/",$psw)){
				//Invalid Entry				
				echo "Password must be between 4 to 8 characters.";
			}
			else{
				require 'functions.php';
				
				include('../conx.php');												
				if($stmt = $conn->prepare("SELECT mbl_no, password from c_login WHERE mbl_no=? LIMIT 1")) {
					if($stmt->bind_param("s", $mbl)){
						$stmt->execute();
						$stmt->bind_result($dmbl, $dpsw);
						$stmt->fetch();
						if($dmbl==$mbl && $dpsw==$psw){
							$_SESSION["check"]=$mbl;							
							$stmt->close();
							$conn->close();
							logoutCart();		
							echo "success";
							exit(0);
						}
						else{											
							$stmt->close();
							$conn->close();
							echo "Invalid mobile no. or password.";
							exit(0);
						}
					}
					else{											
						$stmt->close();
						$conn->close();
						echo "Invalid mobile no. or password.";
						exit(0);
					}	
				}
				else{									
					$conn->close();
					session_unset();
					session_destroy();
					die('<h3>Sorry! Please Try Again Later.<br><br><a href="index.php">Go Back</a></h3>');
				}
				
			}
		}
	}	
	
?>