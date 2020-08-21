<?php 
	session_start();
	
	if(isset($_SESSION["sellcheck"])){
		if(isset($_POST['key1'])){
			echo '<h3 id="storeHead" class="banner-head"><span class="glyphicon glyphicon-home"></span> Store Info.</h3>
			<div id="storeDiv"><hr>
				<form role="form" id="storeForm" name="storeForm" class="setup-forms" autocomplete="off">
					<span id="store-err"></span>
					<div class="form-group">
						<label for="address">Store Address</label>
						<textarea class="form-control" id="address" name="address" placeholder="Enter your store address." required></textarea>
					</div>
					<div class="form-group">
						<label for="pan_card_no">Pan Card No.</label>
						<input type="text" class="form-control" name="pan" placeholder="Enter your pan card no." required />
					</div>
					<div class="form-group">
						<label for="tin_no">Tin No.</label>
						<input type="text" class="form-control" name="tin" placeholder="(Optional)" />
					</div>
					<div class="form-group" id="storeBtnDiv">
						<input type="submit" value="Proceed" id="storeBtn" name="storeBtn" />	
					</div>
				</form>
			</div>';
		}		
	}
	
?>