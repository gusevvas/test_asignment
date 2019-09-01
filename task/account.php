<!DOCTYPE html>

<html>
<head>
	<title>Test Task Account</title>

	<link rel="stylesheet" type="text/css" href="style.css">
	<style type="text/css">
		img{
			display: block;
		}
		#popup{
			background-color: #0000b3;	 
			width: 160px;
			height: 300px;
			display: none;
		}
		#popup .wTextAr{
			width: 100px;
		}
		#withdraw-form{
			width: 100%;
			height: 200px;
			text-align: center;
			margin: 0;
		}
		#exPopup{
			background-color: #0355b3;	 
			width: 200px;
			height: 300px;
			display: none;
		}
		#exchange-form{
			width: 100%;
			height: 200px;
			text-align: center;
			margin: 0;
		}
		.yes{
			float:left;
			margin-left: 50px;

		}
		.no{
			float:right;
			margin-right: 50px;
		}
		#get-present{
			width:200px;
			height:50px;
			background-color:#33ff66;
			border:none;
		}
		#get-present:hover{
			cursor:pointer;
		}
	</style>
	<script type="text/javascript" >
		function SubForm(){
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("exchange-form").innerHTML = this.responseText;
				}
			};
			xhttp.open("POST", "exchangeBonusPoints.php", true);
			xhttp.send();
		}

		function withdrawMoney(){
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("withdraw-form").innerHTML = this.responseText;
				}
			};
			xhttp.open("POST", "sendMoneyViaBank.php", true);
			xhttp.send();
		}

	</script>	
</head>
<body style="background: linear-gradient(to bottom, #e1ffff 0%,#e1ffff 7%,#e1ffff 12%,#fdffff 12%,#e6f8fd 30%,#c8eefb 54%,#bee4f8 75%,#b1d8f5 100%);">
	
	<div class="page-wrap">
		<header><p>User: <p style="color:#7FFF00"><?php session_start(); echo $_SESSION['username'];?></p></p>
			<p>Money:<?php echo $_SESSION['money'];?>EUR</p>
			<p>Bonus points:<?php echo $_SESSION['bonusPoints'];?></p>
			<div class="buttons">
				<div class="withdraw-container">	
					<button id ="withdraw" style="margin: 5px; background-color: #8080ff;color: white; border: none; cursor: pointer;">Withdraw money</button>
					<div id="popup">
						<form  id="withdraw-form" method ="post" onsubmit="withdrawMoney()">
							<label for="text" style="margin:30px;color:#999;font-family: helvetica;font-weight: bold;font-style: italic;">Withdraw EUR amount:</label>
							<input type="text" name="withdraw-amount" class="wTextAr">

							<input type="submit" name="withdraw-money" value="Withdraw" style="margin: 0 auto;background-color: #8080ff;color: white; border: none; cursor: pointer;">
							<?php
							if(isset($_POST["withdraw-amount"])){
								$_SESSION["withdraw_money_amount"]=$_POST["withdraw-amount"];
							}
							?>
						</form>
					</div>

				</div>
				<div class="exchange-container">
					<button id="exchange" style="margin: 5px; background-color: #8080ff;color: white; border: none; cursor: pointer;">Exchange money to bon. points</button>
					<div id="exPopup">
						<form id="exchange-form" method="post" onsubmit="SubForm()">
							<label for="text" style="margin:30px;color:#999;font-family: helvetica;font-weight: bold;font-style: italic;">Convert bon. points to  money:</label>

							<input type="text" name="exchange-amount">
							<input type="submit" name="exchange-money" value="Exchange" style="margin: 0 auto;background-color: #8080ff;color: white; border: none; cursor: pointer;">

						</form>
						<?php 
						if(isset($_POST["exchange-amount"])){
							$_SESSION["Exchange"]=$_POST["exchange-amount"];
						}

						?>
						<p style="margin:20px;color:#990;font-family: helvetica;font-weight: bold;font-style: italic;font-size: 10px;">Convertation:<?php
						echo $_SESSION['bonus_coefficient'];
						?> loyalty points = 1 EUR</p>
					</div>
				</div>

			</div>
		</header>

		<script type="text/javascript">
			var btn = document.getElementById("withdraw");
			var modal=document.getElementById("popup");
			btn.onclick = function(){
				if(  modal.style.display == "block"){
					modal.style.display = "block"
				}else{
					modal.style.display = "block";


				}
			}
			var btn1=document.getElementById("exchange");
			var modal1=document.getElementById("exPopup");
			btn1.onclick = function(){
				if(  modal1.style.display == "block"){
					modal1.style.display = "none";
				}else{
					modal1.style.display = "block";
				}}
				var btn3=document.getElementById("get-present");
				var modal2=document.getElementById("confirmation");
				btn3.onclick = function(){
					if(modal2.style.display="none"){
						modal2.style.display="block";
					}

				}
				

			</script>
			<div class="container">

				<div class="present">
					<?php

					if( isset( $_REQUEST['present'] ))
					{

						$rand=mt_rand(1, $_SESSION['bonusCount']);
						define('DB_SERVER', 'localhost:3306');
						define('DB_USERNAME', 'root');
						define('DB_PASSWORD', '');
						define('DB_DATABASE', 'user');
						$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
						$bonusQ="SELECT name FROM bonus_type WHERE id=".$_SESSION['bonus_type'.$rand];
						$bonusR= mysqli_query($db,$bonusQ);

						while($row = mysqli_fetch_array($bonusR,MYSQLI_ASSOC)){
							$bonusName=$row['name'];
						}						
						switch ($bonusName){
							case 'Bonus Points':
							$bonusQ="SELECT name FROM bonus_type WHERE id=".$_SESSION['bonus_type'.$rand];
							$bonusR= mysqli_query($db,$bonusQ);

							while($row = mysqli_fetch_array($bonusR,MYSQLI_ASSOC)){
								$bonusName=$row['name'];
							}
							$randBonus=mt_rand($_SESSION['bonus_lower_limit'],$_SESSION['bonus_upper_limit']);

							echo "<p class='present-text'>" . $bonusName . ": " . $randBonus . " ". $_SESSION['bonus_name'.$rand]."</p>";
							$_SESSION['bonusPoints']=$_SESSION['bonusPoints']+$randBonus;
							$sessID = $_SESSION['bonus_id'.$rand];
							$bonusQ="INSERT INTO user_bonus(user_id, bonus_id) VALUES ('". $_SESSION['user_id']. "','". $sessID."')";
							if(mysqli_query($db,$bonusQ)){
								//	echo "record created successfully";
							}else{
								echo "Error: " . $sql . "" . mysqli_error($db);
							}

							# code...
							break;	
							
							case 'Item':
							$bonusQ="SELECT name FROM bonus_type WHERE id=".$_SESSION['bonus_type'.$rand];
							$bonusR= mysqli_query($db,$bonusQ);

							while($row = mysqli_fetch_array($bonusR,MYSQLI_ASSOC)){
								$bonusName=$row['name'];
							}

							$bonusItemQ="SELECT id FROM bonus_type WHERE name='Item'";
							$bonusItemR= mysqli_query($db,$bonusItemQ);	
							while($row = mysqli_fetch_array($bonusItemR,MYSQLI_ASSOC)){
								$bonusID=$row['id'];

							}		
							
							$bonusQer="SELECT user_bonus.id FROM user_bonus,bonus WHERE bonus.bonus_type=". $bonusID." AND user_bonus.user_id='". $_SESSION['user_id']. "' AND  bonus.id=user_bonus.bonus_id";
							$bonusRe= mysqli_query($db,$bonusQer);
							$count = mysqli_num_rows($bonusRe);
							if($count<=$_SESSION['maximum_item_amount']){
								echo "<p class='present-text'>You've got an ". $bonusName ." ". $_SESSION['bonus_name'.$rand] ."</p>";

								$sessID = $_SESSION['bonus_id'.$rand];
								$bonusQ="INSERT INTO user_bonus(user_id, bonus_id) VALUES ('". $_SESSION['user_id']. "','". $sessID."')";
								if(mysqli_query($db,$bonusQ)){
								//	echo "record created successfully";
								}else{
									echo "Error: " . $sql . "" . mysqli_error($db);
								}

							}else{
								$_SESSION["error"] = "<p style='color:red;font-family:helvetica;font-size:20px;font-weight:bold;'>You have reached ".$_SESSION['maximum_item_amount']." - your item limit</p>";
							}
							break;
							echo "<p class='present-text'>You've got an ". $bonusName ." ". $_SESSION['bonus_name'.$rand] ."</p>";

							$sessID = $_SESSION['bonus_id'.$rand];
							$bonusQ="INSERT INTO user_bonus(user_id, bonus_id) VALUES ('". $_SESSION['user_id']. "','". $sessID."')";
							if(mysqli_query($db,$bonusQ)){
								//	echo "record created successfully";
							}else{
								echo "Error: " . $sql . "" . mysqli_error($db);
							}
							break;
							case 'Money':


							$bonusQ="SELECT name FROM bonus_type WHERE id=".$_SESSION['bonus_type'.$rand];
							$bonusR= mysqli_query($db,$bonusQ);

							while($row = mysqli_fetch_array($bonusR,MYSQLI_ASSOC)){
								$bonusName=$row['name'];
							}
							if($_SESSION['money']>$_SESSION['user_money_limit']){
								$_SESSION["error"] = "<p style='color:red;font-family:helvetica;font-size:20px;font-weight:bold;'>Your Limit reached (".$_SESSION['user_money_limit'].") please withdraw</p>";
							}else{

								$moneyAmount=mt_rand($_SESSION['money_lower_limit'],$_SESSION['money_upper_limit']);
								$checkAmount=$_SESSION['money']+$moneyAmount;
								if($checkAmount<$_SESSION['user_money_limit']){
									echo "<p class='present-text'>". $bonusName.": " . $moneyAmount ." ".  $_SESSION['bonus_name'.$rand] ."</p>";
									
									$_SESSION['money']=$_SESSION['money']+$moneyAmount;
									$sessID = $_SESSION['bonus_id'.$rand];
									$bonusQ="INSERT INTO user_bonus(user_id, bonus_id) VALUES ('". $_SESSION['user_id']. "','". $sessID."')";
									if(mysqli_query($db,$bonusQ)){
									//echo "record created successfully";
									}else{
										echo "Error: " . $sql . "" . mysqli_error($db);
									}

								}else{
									$_SESSION["error"] = "<p style='color:red;font-family:helvetica;font-size:20px;font-weight:bold;'>The prise is too big, you have reached money limit.<br>
									Please withdraw or exchange to loyalty bonus points.</p>";

								}
							}
							
							break;
						}

					}
					if(isset($_SESSION["error"])){
						echo $_SESSION["error"];
						unset($_SESSION["error"]);
					}


					?>
			<!--<form id="confirmation">
				<input class="yes" name="yes" type="submit" value="Accept" >
				<input class="no" name="no" type="submit" value="Decline" >
			</form> -->
		</div>
	</div>
	<div class="play-form">
		<form method="post" action="">
			<input id="get-present" name="present" type="submit" value="Get your present!" >
		</form>
	</div>

</div>
<H1>Your items</H1>
<?php 


	/*	$bonusTypeIDQ="SELECT id,bonus_name FROM bonus WHERE bonus_type=".$bonusID;
		$bonusTypeIDR=mysqli_query($db,$bonusTypeIDQ);
		while($row1 = mysqli_fetch_array($bonusItemR,MYSQLI_ASSOC)){
			$bonus_typeIds[ $row1['id']] = $row1;
			$bonusNames[$row1['bonus_name']]=$row1;
		}	
		$personsBonusQ="SELECT id FROM users WHERE username=".$_SESSION['username'];
		$personsBonusR=mysqli_query($db,$personsBonusQ);
		while($row2 = mysqli_fetch_array($personsBonusQ,MYSQLI_ASSOC)){

			$personsID= $row2['id'];
			
		}	*/



		///выбрать ID бонусов, у которых тип=item
		?>
	</body>
	</html>