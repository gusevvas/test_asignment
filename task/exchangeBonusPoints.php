	<?php
	session_start();
	if(isset($_SESSION["error"])){
	echo $_SESSION["error"];
	unset($_SESSION["error"]);
	}
	$exchangeAmount=$_SESSION["Exchange"];
	if(!preg_match("/^[0-9]*$/",$exchangeAmount)) {
		$_SESSION["error"] = "<p style='color:red;font-family:helvetica;font-size:20px;font-weight:bold;'>Only numbers are allowed</p>";

	}else{
		if(($exchangeAmount%$_SESSION['bonus_coefficient'] == 0)&&($exchangeAmount<=$_SESSION["money"])){
			$exchangedAmount=$exchangeAmount/$_SESSION['bonus_coefficient'];
			$newMoneyAm=$_SESSION["money"]-$exchangeAmount;
	

				$_SESSION["money"]=$newMoneyAm;
				$_SESSION["bonusPoints"]=$_SESSION["bonusPoints"]+$exchangedAmount;
			
		}else{
			$_SESSION["error"] = "<p style='color:blue;font-family:helvetica;font-size:20px;font-weight:bold;'>Can't be exchanged to bonus points. Your request is not dividable by ".$_SESSION['bonus_coefficient'] .".  Or you have a low money amount</p>";
		}
		
		
		

	}
	?>
