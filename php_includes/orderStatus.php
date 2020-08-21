<?php 
session_start();

if(isset($_SESSION["sellcheck"])){
	if(isset($_POST['key1'])){
		if(isset($_POST['pid']) && isset($_POST['id']) && isset($_POST['opt'])){
			
			function test_input($data){
				$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars($data);		
				return $data;
			}
			
			$pid=test_input($_POST['pid']);
			$btype=test_input($_POST['id']);
			
			include('../conx.php');
			if($stmt = $conn->prepare("UPDATE orders_child SET ".$btype."=1 WHERE id=?")){
				if($stmt->bind_param("i", $pid)){
					$stmt->execute();
					$stmt->close();
					$conn->close();
					
					if($btype=="dispatch"){
						include('../conx.php');
						if($stmt = $conn->prepare("UPDATE orders_child SET receive=1 WHERE id=?")){
							if($stmt->bind_param("i", $pid)){
								$stmt->execute();
								$stmt->close();
								$conn->close();
							}
						}						
					}										
				}
			}			
		}
	}	
}
else{
	header("Location:../sell_logout.php");
	exit(0);
}

?>