<?php 
	session_start();
	
	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);		
		return $data;
	}
	
	if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_SESSION["sellcheck"])){
		if(isset($_POST['personalBtn']) && $_POST['personalBtn']=="personalBtn"){
			if(isset($_POST['name']) && isset($_POST['mbl'])){
				$name=test_input($_POST['name']);
				$mbl=test_input($_POST['mbl']);
				
				if(empty($name)){
					echo 'Owner name required.';
				}
				else if(!preg_match("/^[a-zA-Z\._,\- ]+$/",$name)){
					echo 'Invalid Entry : Owner Name.';
				}
				else if(strlen($name)>30){
					echo 'Owner name is out of character limit.';
				}
				else if(empty($mbl)){
					echo 'Mobile no. required.';
				}
				else if(!preg_match("/^[0-9]{10}+$/",$mbl)){
					echo 'Invalid Entry : Mobile No.';
				}
				else{
					include('conx.php');
					if($stmt = $conn->prepare("UPDATE register SET owner_name=?, mbl_no=?, store_status=? where mbl_no=?")) {
						$newProVal="1";
						if($stmt->bind_param("ssss", $name, $mbl, $newProVal, $_SESSION["sellcheck"])){
							$stmt->execute();																		
							$stmt->close();
							$conn->close();
							$_SESSION["sellcheck"]=$mbl;
							echo 'success';							
						}
						else{												
							$stmt->close();
							$conn->close();
							echo 'Oops! A problem occured. Please try again later.';
						}	
					}
					else{									
						$conn->close();						
						echo 'Oops! A problem occured. Please try again later.';
					}
				}								
			}
			else{
				session_unset();
				session_destroy();
				echo 'Oops! A problem occured. Logout &amp; try again later.';
			}
		}
		else{
			session_unset();
			session_destroy();
			echo 'Oops! A problem occured. Logout &amp; try again later.';
		}
	}
	else{
		session_unset();
		session_destroy();
		echo 'Oops! A problem occured. Logout &amp; try again later.';
	}
?>