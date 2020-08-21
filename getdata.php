 <?php 	
	
	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);		
		return $data;
	}
	
 if($_GET['term']){
 $word =  test_input($_GET['term']);
 include('conx.php');
 $result=mysqli_query($conn,"SELECT products.p_name FROM products, register WHERE products.p_name LIKE '$word%' AND register.mbl_no=products.server AND register.proceed='Y' AND register.acc_status='active' LIMIT 6");
		if(mysqli_num_rows($result)>0){
			$lemma = array();
          while($row=mysqli_fetch_assoc($result)){
            $lemma[] = $row['p_name'];
          }
		}
		mysqli_close($conn);

	 echo json_encode($lemma);
	 exit();
    
}
