<?php
//to remove an item from cart. 
session_start();
function test_input($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);	
	return $data;
}
if(isset($_POST['key1'])){	
	if(isset($_POST['id'])){
		$id=test_input($_POST['id']);
		if(!isset($_SESSION["check"]) && isset($_SESSION['bte_cart']) && is_array($_SESSION['bte_cart'])){				
			$max=count($_SESSION['bte_cart']);
			if($max>1){
				while($id<$max-1){
					$_SESSION['bte_cart'][$id]=$_SESSION['bte_cart'][$id+1];
					$_SESSION['bte_cart'][$id]['id']=$_SESSION['bte_cart'][$id]['id']-1;			
					$id++;
				}
				unset($_SESSION['bte_cart'][$max-1]);
				echo count($_SESSION['bte_cart']);
			}
			else{
				unset($_SESSION['bte_cart']);
				echo 0;
			}
		}
		else{
			include('conx.php');
			$cartTotal=0;
			if($stmt = $conn->prepare("DELETE FROM cart WHERE cart_id=?")) {
				if($stmt->bind_param("i", $id)){
					$stmt->execute();				
					$stmt->close();
					$conn->close();				
				}
			}
			include('conx.php');
			if($stmt = $conn->prepare("SELECT count(cart_id) FROM cart WHERE customer=?")) {
				if($stmt->bind_param("s", $_SESSION["check"])){
					$stmt->execute();
					$stmt->bind_result($cartTotal);										
					$stmt->fetch();
					$stmt->close();
					$conn->close();					
				}
			}
			echo $cartTotal;
		}
	}	
}	
?>