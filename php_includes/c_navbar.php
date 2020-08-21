<?php
	function cartTotal(){
		if(isset($_SESSION['bte_cart']) && is_array($_SESSION['bte_cart'])){
			$cartTotal=count($_SESSION['bte_cart']);
		}
		else if(isset($_SESSION["check"])){
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
		}
		else{
			$cartTotal=0;
		}
		return $cartTotal;
	}
	
	if(isset($_SESSION["check"])){
		include('conx.php');
			
		if($stmt = $conn->prepare("SELECT name FROM c_info WHERE mbl_no=? LIMIT 1")) {
			if($stmt->bind_param("s", $_SESSION["check"])){
				$stmt->execute();
				$stmt->bind_result($cname);
				$stmt->fetch();				
				$parts = explode(' ', $cname);
				$cname = array_shift($parts);								
			}
		}
	}
	
	if(!isset($_SESSION["check"])){
		echo '<!--Navbar Start-->	
				<nav class="navbar navbar-default">
				  <div class="container-fluid">				  
					<div class="navbar-header">
					  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>                        
					  </button>
					  <a class="navbar-brand" href="index.php"><img src="images/logoW.png" class="logo" alt="logo-text" /></a>																	
					</div>
					
					<div class="searchbox">
						<form action="product-list.php" class="searchform" method="GET">
						<div class="row">
							<div class="col-md-10 col-xs-10 nopadding">
								<div class="serachfield">
									<input type="text" class="serachinput" id="search" name="search" value="" required placeholder="Search for Product">
								</div>
							</div>

							<div class="col-md-2 col-xs-2 nopadding">
								<button type="submit" class="searchbtn"><svg data-reactid="47" height="15px" width="15px" class="svgbtn"><path data-reactid="48" d="M11.618 9.897l4.224 4.212c.092.09.1.23.02.312l-1.464 1.46c-.08.08-.222.072-.314-.02L9.868 11.66M6.486 10.9c-2.42 0-4.38-1.955-4.38-4.367 0-2.413 1.96-4.37 4.38-4.37s4.38 1.957 4.38 4.37c0 2.412-1.96 4.368-4.38 4.368m0-10.834C2.904.066 0 2.96 0 6.533 0 10.105 2.904 13 6.486 13s6.487-2.895 6.487-6.467c0-3.572-2.905-6.467-6.487-6.467"/></svg></button>
							</div>
						</div>
						</form>
					</div>					

					<div class="collapse navbar-collapse" id="myNavbar">						
					  <ul class="nav navbar-nav navbar-right">
						<li id="li-home"><a href="index.php"><span class="glyphicon glyphicon-home"></span> Home</a></li> 		       
						<li id="li-order-now"><a href="product-list.php"><span class="glyphicon glyphicon-bookmark"></span> Order Now</a></li>
						<li id="li-sell"><a href="sell_logout.php"><span class="glyphicon glyphicon-tag"></span> Sell</a></li>
						<li id="li-signup"><a href="c_signup.php"><span class="glyphicon glyphicon-user"></span> SignUp</a></li>
						<li id="li-login"><a href="c_login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
						<li id="li-cart" class="cart-li"><a href="view-cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Cart (<span id="cart-no">'.cartTotal().'</span>)</a></li>						
					  </ul>					   
					</div>					
				  </div>
				</nav>
				<!--Navbar End-->';
	}
	else{
		echo '<!--Navbar Start-->	
				<nav class="navbar navbar-default">
				  <div class="container-fluid">
					<div class="navbar-header">
					  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>                        
					  </button>
					  <a class="navbar-brand" href="index.php"><img src="images/logoW.png" class="logo" alt="logo-text" /></a>
					</div>
					
					<div class="searchbox">
						<form action="product-list.php" class="searchform" method="GET">
							<div class="row">
								<div class="col-md-10 col-xs-10 nopadding">
									<div class="serachfield">
										<input type="text" class="serachinput" id="search" name="search" value="" required placeholder="Search for Product">
									</div>
								</div>

								<div class="col-md-2 col-xs-2 nopadding">
									<button type="submit" class="searchbtn"><svg data-reactid="47" height="15px" width="15px" class="svgbtn"><path data-reactid="48" d="M11.618 9.897l4.224 4.212c.092.09.1.23.02.312l-1.464 1.46c-.08.08-.222.072-.314-.02L9.868 11.66M6.486 10.9c-2.42 0-4.38-1.955-4.38-4.367 0-2.413 1.96-4.37 4.38-4.37s4.38 1.957 4.38 4.37c0 2.412-1.96 4.368-4.38 4.368m0-10.834C2.904.066 0 2.96 0 6.533 0 10.105 2.904 13 6.486 13s6.487-2.895 6.487-6.467c0-3.572-2.905-6.467-6.487-6.467"/></svg></button>
								</div>
							</div>
						</form>
					</div>
					
					<div class="collapse navbar-collapse" id="myNavbar">
					  <ul class="nav navbar-nav navbar-right">
						<li id="li-home"><a href="index.php"><span class="glyphicon glyphicon-home"></span> Home</a></li> 		       
						<li id="li-order-now"><a href="product-list.php"><span class="glyphicon glyphicon-bookmark"></span> Order Now</a></li>
						<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> Hi '.$cname.'<span class="caret"></span></a>
							<ul class="dropdown-menu" id="myac">
							<li id="li-my-ac"><a href="my-account.php"><span class="glyphicon glyphicon-user"></span> My Account</a></li>
							<li id="li-my-orders"><a href="my-orders.php"><span class="glyphicon glyphicon-bookmark"></span> My Orders</a></li>
							<li id="li-cart" class="cart-li"><a href="view-cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Cart (<span id="cart-no">'.cartTotal().'</span>)</a></li>
							<li id="li-settings"><a href="my-settings.php"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>					
							<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>												
						  </ul>
						</li>
					  </ul>
					</div>
				  </div>
				</nav>
				<!--Navbar End-->';
	}	
?>