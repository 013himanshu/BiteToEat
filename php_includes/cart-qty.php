<?php 
session_start();
function test_input($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);	
	return $data;
}

if(isset($_POST['key1'])){	
	if(isset($_POST['id']) && isset($_POST['qty'])){
		$id=test_input($_POST['id']);
		$qty=test_input($_POST['qty']);
		
		if(!isset($_SESSION["check"]) && isset($_SESSION['bte_cart']) && is_array($_SESSION['bte_cart'])){	
			$_SESSION['bte_cart'][$id]['qty']=$qty;			
			echo 'success';						
		}
		else{
			include('conx.php');
			if($stmt = $conn->prepare("UPDATE cart SET qty=? WHERE cart_id=?")) {
				if($stmt->bind_param("ii", $qty, $id)){
					$stmt->execute();				
					$stmt->close();
					$conn->close();
					echo 'success';
				}
			}
		}
	}
}
?>