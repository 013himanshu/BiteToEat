<?php 
	session_start();	
?>
<?php
	if(!isset($_SESSION["check"])){
		header("Location:index.php");
	}

	if(isset($_SESSION["check"])){
		include('conx.php');
			
		if($stmt = $conn->prepare("SELECT name, mbl_no, email FROM c_info WHERE mbl_no=? LIMIT 1")) {
			if($stmt->bind_param("s", $_SESSION["check"])){
				$stmt->execute();
				$stmt->bind_result($name, $mbl, $email);
				$stmt->fetch();								
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>

	<title>My Settings | BiteToEat</title>
	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="Description" content="Order anything to eat or drink from the top brands in the market. BiteToEat provide its customers sweets deserts, dairy products, and services like juice, tiffin, etc. at reasonable prices within an hour at their doorstep." />
    <meta name="robots" content="index, follow">
	<meta name="googlebot" content="index, follow">	
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery.min.js"></script>
	<link href="css/jquery-ui.css" rel="stylesheet">
	<script src="js/bootstrap.min.js"></script>			
	<link rel="stylesheet" href="css/c_navbar.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/fonts.css">	
	
	<style>		

		
		body{background-color:#edecec;}				
		
		/*tabs css starts*/
		.tabs h1{color:#1cb01c;padding:15px;}
		
		.nav-tabs { border-bottom: 3px solid #ddd; }
		
		.nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover { border-width: 0; }
		
		.nav-tabs > li > a { padding-left:25px;padding-right:25px; border:none; color:#666; font-family:muli; font-size:18px;  }
		
		.nav-tabs > li.active > a, .nav-tabs > li > a:hover { border: none; color: #1cb01c !important; background: transparent; }
		
		.nav-tabs > li > a::after { content: ""; background: #1cb01c; height: 2px; position: absolute; width: 100%; left: 0px; bottom: -1px; transition: all 250ms ease 0s; transform: scale(0); }
		
		.nav-tabs > li.active > a::after, .nav-tabs > li:hover > a::after { transform: scale(1); }
		
		.tab-pane { padding-bottom:15px; }
		
				
		
		.tabs{background:#fff none repeat scroll 0% 0%; box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3); margin-top:10px;margin-bottom:10px;}										
		/*tabs css ends*/
		
		.tabs input[type=tel], .tabs input[type=email], .tabs input[type=text], .tabs input[type=password]{
			border-radius:0px;
			outline:none;
			font-family:abeezee;
			color:#1cb01c;
			letter-spacing:1px;
			font-size:15px;
			width:300px;
		}
		
		.tabs input[type=tel]:focus, .tabs input[type=email]:focus, .tabs input[type=text]:focus, .tabs input[type=password]:focus{
			border:0.5px solid #1cb01c;
			box-shadow:0 0 5px 1px #1cb01c;
		}
		
		.tabs input[type=submit]{
			border-radius:0px;
			background-color:#1cb01c;
			color:#ffffff;
			width:300px;
			border:none;
			padding:7px;
			font-size:20px;
			font-family:barOne;
			letter-spacing:2px;
			outline:none;
		}
		
		.tabs input[type=submit]:hover, .tabs input[type=submit]:focus{
			background-color:#189a18;
		}
		
		.tabs .form-group label{
			color:#1cb01c;
			letter-spacing:2px;
			font-size:16px;
			font-family:abeezee;
		}
	</style>		
</head>
	
<body id="home">
<?php 
	require 'php_includes/c_navbar.php';
?>

<div class="container tabs">
  <h2 style="font-family:abeezee;letter-spacing:2px;">Settings</h2><br>
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#chng-info"><span class="glyphicon glyphicon-info-sign"></span> <span class="tab-text">Info.</span></a></li>
    <li><a data-toggle="tab" href="#chng-psw"><span class="glyphicon glyphicon-lock"></span> <span class="tab-text">Password</span></a></li>	
  </ul>

  <div class="tab-content">        
    <div id="chng-info" class="tab-pane fade in active">
		<h3 style="font-family:barOne;color:#1cb01c;">Edit My Information</h3>
		<h4 style="font-family:muli;">Fields marked with * are compulsory.</h4>
		<br>
		<form role="form" id="info-form" name="info-form" autocomplete="off">
			<span id="info-err"></span>
			<div class="form-group">
				<label for="i-fname">*Full Name</label>
				<input type="text" class="form-control" id="i-fname" name="i-fname" placeholder="Enter your full name." value="<?php if(isset($name)){echo $name;} ?>" required />
			</div>
			<div class="form-group">
				<label for="i-mbl">*Mobile No.</label>
				<input type="tel" class="form-control" id="i-mbl" name="i-mbl" minlength="10" maxlength="10" placeholder="Enter your mobile no." value="<?php if(isset($mbl)){echo $mbl;} ?>" required />
			</div>
			<div class="form-group">
				<label for="i-email">*Email Id</label>
				<input type="email" class="form-control" id="i-email" name="i-email" placeholder="Enter your email id." value="<?php if(isset($email)){echo $email;} ?>" required />
			</div>
			<input type="submit" value="Save Changes" name="change_info" id="change_info" />
		</form>
    </div>
	
    <div id="chng-psw" class="tab-pane fade">
		<h3 style="font-family:barOne;color:#1cb01c;">Change Password</h3>
		<br>
		<form role="form" id="psw-form" name="psw-form" autocomplete="off">
			<span id="psw-err"></span>
			<div class="form-group">
				<label for="p-mbl">Mobile No.</label>
				<input type="tel" class="form-control" id="p-mbl" name="p-mbl" minlength="10" maxlength="10" placeholder="Enter your mobile no." required />
			</div>
			<div class="form-group">
				<label for="p-cpsw">Current Password</label>
				<input type="password" class="form-control" id="p-cpsw" name="p-cpsw" minlength="4" maxlength="8" placeholder="Enter your current password." required />
			</div>
			<div class="form-group">
				<label for="p-psw">New Password</label>
				<input type="password" class="form-control" id="p-psw" name="p-psw" minlength="4" maxlength="8" placeholder="Enter your new password." required />
			</div>
			<input type="submit" value="Save Changes" name="change_psw" id="change_psw" />
		</form>
    </div>
	
  </div>
</div>

<script src="js/jquery-ui.js"></script>
<script type="text/javascript">
$(function() {
    $( "#search" ).autocomplete({
      source: 'getdata.php',
      minLength: 1
    });
  });
 </script>
<script>
	$(document).on("submit", "#info-form", function(event){				
		event.preventDefault();									
		var fname=document.forms["info-form"]["i-fname"].value;
		var mbl=document.forms["info-form"]["i-mbl"].value;
		var email=document.forms["info-form"]["i-email"].value;					
		var formData={ change_info:"change_info", fname: fname, mbl: mbl, email: email };						
		$.ajax({
			method: "POST",
			url: "php_includes/my-sett-info.php",
			data: formData
		}).done(function(msg){							
			if(msg!="success"){
				$("#info-err").html("<p style='font-size:15px;font-family:barOne;display:inline-block;padding:10px;color:#D8000C;background-color:#FFBABA;letter-spacing:1px;'>"+msg+"</p>");
			}
			else{				
				$("#change_info").val("Done");
				setTimeout(function(){ location.reload(); }, 2000);				
			}
		});																
	});						
</script>
<script>
	$(document).on("submit", "#psw-form", function(event){				
		event.preventDefault();											
		var mbl=document.forms["psw-form"]["p-mbl"].value;
		var cpsw=document.forms["psw-form"]["p-cpsw"].value;	
		var psw=document.forms["psw-form"]["p-psw"].value;
		var formData={ change_psw:"change_psw", mbl: mbl, cpsw: cpsw, psw: psw };						
		$.ajax({
			method: "POST",
			url: "php_includes/my-sett-psw.php",
			data: formData
		}).done(function(msg){							
			if(msg!="success"){
				$("#psw-err").html("<p style='font-size:15px;font-family:barOne;display:inline-block;padding:10px;color:#D8000C;background-color:#FFBABA;letter-spacing:1px;'>"+msg+"</p>");
			}
			else{				
				$("#change_psw").val("Done");
				$("#psw-err").html("<p style='font-size:15px;font-family:barOne;display:inline-block;padding:10px;color:#3c763d;background-color:#dff0d8;letter-spacing:1px;'><span class='glyphicon glyphicon-ok-circle'></span> Password successfully changed.</p>");
				setTimeout(function(){ $("#change_psw").val("Save Changes"); }, 2000);
				document.getElementById("psw-form").reset();
			}
		});																
	});						
</script>
<script>
	$(window).load(function(){		
		$("#li-settings").addClass("active");
	});	
</script>
</body>
</html>