<?php
	session_start();
    include("php_includes/functions.php");
      if(isset($_POST['pid']) && isset($_POST['qty'])){
            $_SESSION["action"]="add_orderList";
          	$pid = base64_decode($_POST['pid']);
		    if((int)$pid > 0){
				$qty = isset($_POST['qty'])?$_POST['qty']:1;
				addtocart($pid,$qty);
                
                $qtytotal = get_totalqty();
                $ordertotal = get_order_total();
                
                echo json_encode(array('qty'=>$qtytotal , 'total' => $ordertotal));
                exit();
                
			}
      }
?>