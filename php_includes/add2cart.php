<?php
	session_start();
    function logoutAddCart($pid,$q){				
		if(isset($_SESSION['bte_cart']) && is_array($_SESSION['bte_cart'])){			
			$max=count($_SESSION['bte_cart']);
			$_SESSION['bte_cart'][$max]['id']=$max;
			$_SESSION['bte_cart'][$max]['p_id']=$pid;
			$_SESSION['bte_cart'][$max]['qty']=$q;
		}
		else{
			$_SESSION['bte_cart']=array();
			$_SESSION['bte_cart'][0]['id']=0;
			$_SESSION['bte_cart'][0]['p_id']=$pid;
			$_SESSION['bte_cart'][0]['qty']=$q;
		}
	}
	
	function loginAddCart($pid, $qty){
		include('conx.php');
		if($stmt = $conn->prepare("SELECT server FROM products WHERE p_id=? LIMIT 1")) {
			if($stmt->bind_param("i", $pid)){
				$stmt->execute();
				$stmt->bind_result($seller);										
				$stmt->fetch();
									
				date_default_timezone_set("Asia/Kolkata");
				$date=$time="";
				$date=date("Y-m-d");				
				$time=date("h:i:sa");
				include('conx.php');
				if($stmt = $conn->prepare("INSERT INTO cart (seller, customer, product_id, qty, add_date, add_time) VALUES (?, ?, ?, ?, ?, ?)")) {
					if($stmt->bind_param("ssiiss", $seller, $_SESSION["check"], $pid, $qty, $date, $time)){
						$stmt->execute();
						$stmt->close();
						$conn->close();								
					}
				}								
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
				return $cartTotal;	
			}
		}
	}
	
	
      if(isset($_POST['pid']) && isset($_POST['qty'])){
		$pid = base64_decode($_POST['pid']);
		$qty = isset($_POST['qty'])?$_POST['qty']:1;
		$cartTotal=0;
		if(!isset($_SESSION["check"])){			
		    if((int)$pid > 0){				
				logoutAddCart($pid,$qty);                
                $cartTotal = count($_SESSION['bte_cart']);                                
                echo $cartTotal;
                exit();               
			}
		}
		else{
			if((int)$pid > 0){
				$cartTotal=loginAddCart($pid, $qty);
				echo $cartTotal;
			}
		}
          	
      }
	  
	  
?>