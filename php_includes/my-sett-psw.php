<?php 
session_start();
	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);		
		return $data;
	}
	
	if(isset($_SESSION["check"])){
		if(isset($_POST['change_psw']) && $_POST['change_psw']=="change_psw"){
			if(isset($_POST['mbl']) && isset($_POST['cpsw']) && isset($_POST['psw'])){
				$mbl=test_input($_POST['mbl']);
				$cpsw=test_input($_POST['cpsw']);
				$psw=test_input($_POST['psw']);
				
				if(empty($mbl)){
					//Empty field	
					echo '<span class="glyphicon glyphicon-remove-circle"></span> Mobile No. required.';
				}
				else if(!preg_match("/^[0-9]{10}+$/",$mbl)){
					//Invalid Entry				
					echo '<span class="glyphicon glyphicon-remove-circle"></span> Mobile No. must contain only 10 digit number.';
				}
				else if(empty($cpsw)){
					//Empty field	
					echo '<span class="glyphicon glyphicon-remove-circle"></span> Current password required.';
				}
				else if(!preg_match("/^[a-zA-Z0-9\W ]{4,8}+$/",$cpsw)){
					//Invalid Entry
					echo '<span class="glyphicon glyphicon-remove-circle"></span> Invalid current password.';
				}	
				else if(empty($psw)){
					//Empty field	
					echo '<span class="glyphicon glyphicon-remove-circle"></span> New password required.';
				}
				else if(!preg_match("/^[a-zA-Z0-9\W ]{4,8}+$/",$psw)){
					//Invalid Entry
					echo '<span class="glyphicon glyphicon-remove-circle"></span> Invalid new current password.';
				}
				else if($_SESSION["check"]!=$mbl){
					//mbl not match
					echo '<span class="glyphicon glyphicon-remove-circle"></span> Invalid mobile no.';
				}
				else{
					include('../conx.php');
					if($stmt=$conn->prepare("SELECT mbl_no, password FROM c_login WHERE mbl_no=? LIMIT 1")){
						if($stmt->bind_param("s", $_SESSION["check"])){
							$stmt->execute();
							$stmt->bind_result($dbmbl, $dbcpsw);
							if($stmt->fetch()){
								if($dbmbl!=$_SESSION["check"] && $dbmbl!=$mbl){
									//mbl not match
									echo '<span class="glyphicon glyphicon-remove-circle"></span> Invalid mobile no.';
								}
								else if($dbcpsw!=$cpsw){
									//cpsw not match
									echo '<span class="glyphicon glyphicon-remove-circle"></span> Invalid current password.';
								}
								else{
									
									include('../conx.php');
									if($stmt=$conn->prepare("UPDATE c_login SET password=? where mbl_no=? LIMIT 1")){
										if($stmt->bind_param("ss", $psw, $_SESSION["check"])){
											$stmt->execute();
											echo 'success';
										}
									}
									
								}
							}
							else{
								echo '<span class="glyphicon glyphicon-remove-circle"></span> Sorry! Please try again later.';
							}
							
						}
					}
				}
				
				
			}
		}
	}
?>