	<?php
	session_start();
	$moneyAmount=$_SESSION["withdraw_money_amount"];
	if(!preg_match("/^[0-9]*$/",$moneyAmount)) {
		$_SESSION["error"] = "<p style='color:red;font-family:helvetica;font-size:20px;font-weight:bold;'>Only numbers are allowed</p>";
		
	}else{
		if($moneyAmount>$_SESSION["money"]){
			$_SESSION["error"] = "<p style='color:red;font-family:helvetica;font-size:20px;font-weight:bold;'>You can't withdraw this amount! You don't have enogh money</p>";
		}else{
			
			
			$ch = curl_init();
			$certificate_location = 'cacert.pem';
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $certificate_location);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $certificate_location);
		  // set url
			curl_setopt($ch, CURLOPT_URL, 'https://fixipay.com/api/v1');

		  // set method
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

		  // return the transfer as a string
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		  // set headers
			curl_setopt($ch, CURLOPT_HTTPHEADER, [
				'X-FIXIPAY-TOKEN: YOUR_TOKEN_HERE',
				'Content-Type: application/json; charset=utf-8',]);
			$body = '[
			{
				"Merchant": "MERCHANT_NAME",
				"Reference": "REFERENCE_NUMBER",
				"Amount": '.$moneyAmount.',
				"Currency": "EUR",
				"Fee Payer": "full",
				"Customer Number": 1234567,
				"Beneficiary": "BENEFICIARY NAME",
				"Address": "BENEFICIARY ADDRESS",
				"City": "BENEFICIARY CITY",
				"State": "BENEFICIARY STATE",
				"Postal Code": "BENEFICIARY ZIP",
				"Country": "UK",
				"Account Type": "IBAN",
				"Account Number": "",
				"IBAN": "IBAN_NUMBER",
				"National Bank Code Type": "",
				"National Bank Code": "",
				"SWIFT": "SWIFT_CODE",
				"Bank Name": "BANK NAME",
				"Branch": "",
				"Bank Address": "BANK ADDRESS",
				"Bank City": "BANK CITY",
				"Bank State": "",
				"Bank Postal Code": "BANK ZIP",
				"Bank Country": "UK"
			}
		]';
		$_SESSION["money"]=$_SESSION["money"]-$moneyAmount;
		  // set body
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
		

		  // send the request and save response to $response
		$response = curl_exec($ch);

		  // stop if fails
		if (!$response) {
			die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
		}

		echo 'HTTP Status Code: ' . curl_getinfo($ch, CURLINFO_HTTP_CODE) . PHP_EOL;
		echo 'Response Body: ' . $response . PHP_EOL;
		curl_close($ch);
		

	}
}
?>
