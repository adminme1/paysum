<?php
session_start();
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'solana_hackathon');

date_default_timezone_set("Asia/Dhaka");

function connectDB()
{	 
	/* Attempt to connect to MySQL database */
	$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

	// Check connection
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}
	return $conn;
}


function getRates($file='inc/rates.json')
{
	$json = file_get_contents($file);
  
	// Decode the JSON file
	$json_data = json_decode($json,true);
	$rates = $json_data['rates'];

	// Display data
	return $rates;
}

function convertRate($amount, $currencyType, $convertTo='USD')
{
	$rates = getRates();
	$currencyTypeAmount = $rates[$currencyType];
	if ($convertTo=="USD") {
		return ["amount"=>round(($amount / $currencyTypeAmount), 2), "type"=>$convertTo];
	}
	return ["amount"=> round((($amount / $currencyTypeAmount)*$rates[$convertTo]), 2), "type"=>$convertTo];
}

function isExists($field, $value)
{
	if ($field && $value) {
		$conn = connectDB();
		$q1 = "SELECT * FROM customers WHERE ".$field."=?";
		$stmt1 = $conn->prepare($q1);
		$stmt1->bind_param('s',$value);
		$stmt1->execute();
		$result1 = $stmt1->get_result();

		if ($result1->num_rows > 0) {
			return true;
		}
	}
	return false;
}


function login($data)
{
	if ($data) {
		$conn = connectDB();
		$q1 = "SELECT * FROM customers WHERE customer_username=? OR customer_email=? AND customer_password=?";
		$stmt1 = $conn->prepare($q1);
		$stmt1->bind_param('sss',$data['customer_username'], $data['customer_username'], $data['customer_password']);
		$stmt1->execute();
		$result1 = $stmt1->get_result();

		if ($result1->num_rows > 0) {
			$datas = $result1->fetch_assoc();
			$whiteListed = [
				'customer_id' => $datas['customer_id'],
				'customer_email' => $datas['customer_email'],
				'customer_country_id' => $datas['customer_country_id'],
			];
			// print_r($datas);
			// die();
			return $whiteListed;
		}
	}

	return false;
}

function insertNotification($text, $to_customer_id)
{
	$conn = connectDB();
	
	$stmt = $conn->prepare("INSERT INTO notifications (notification_to, notification_text, notification_seen, notification_date_time) VALUES (?, ?, ?, ?)");
	$stmt->bind_param("isss", $notification_to, $notification_text, $notification_seen, $notification_date_time);

	$notification_to = $to_customer_id;
	$notification_text = $text;
	$notification_seen = "0";
	$notification_date_time = date('Y-m-d H:i:s');

	if ($stmt->execute()) {
		return true;
	}
	return false;
}

function createCustomerAccount($data)
{
	if ($data) {
		$conn = connectDB();
		$stmt = $conn->prepare("INSERT INTO customers (customer_country_id, customer_email, customer_username, customer_password, registration_datetime) VALUES (?, ?, ?, ?, ?)");
		$stmt->bind_param("issss", $customer_country_id, $customer_email, $customer_username, $customer_password, $registration_datetime);

		$customer_country_id = $data['customer_country_id'];
		$customer_email = $data['customer_email'];
		$customer_username = $data['customer_username'];
		$customer_password = $data['customer_password'];
		$registration_datetime = date('Y-m-d H:i:s');

		if ($stmt->execute()) {
			return true;
		}
	}

	return false;
}


function getUserData($searchValue, $search_type='customer_id')
{
	if ($searchValue) {
		$conn = connectDB();
		$q1 = "SELECT * FROM customers WHERE ".$search_type."=?";
		$stmt1 = $conn->prepare($q1);
		if ($search_type=='customer_id') {
			$stmt1->bind_param('i',$searchValue);
		}else{
			$stmt1->bind_param('s',$searchValue);
		}
		
		$stmt1->execute();
		$result1 = $stmt1->get_result();

		// if ($result1->num_rows > 0) {
			$datas = $result1->fetch_assoc();
			$whiteListed = [
				'customer_id' => $datas['customer_id'],
				'customer_email' => $datas['customer_email'],
				'customer_name' => $datas['customer_name'],
				'customer_phone' => $datas['customer_phone'],
				'customer_username' => $datas['customer_username'],
				'customer_country_id' => $datas['customer_country_id'],
			];
			// print_r($datas);
			// die();
			return $whiteListed;
		// }
	}
	return false;
}

function getCountryList()
{
	$conn = connectDB();
	$q1 = "SELECT * FROM country";
	$stmt1 = $conn->prepare($q1);	
	$stmt1->execute();
	$result1 = $stmt1->get_result();

	$datas = [];

	while ($row = $result1->fetch_assoc()) {
		$datas[]=$row;
	}

	return $datas;
}


function getCountryData($country_id)
{
	$conn = connectDB();
	$q1 = "SELECT * FROM country WHERE country_id=? ";
	$stmt1 = $conn->prepare($q1);
	$stmt1->bind_param('i',$country_id);
	$stmt1->execute();
	$result1 = $stmt1->get_result();

	$datas = $result1->fetch_assoc();

	return $datas;
}

function getAccountByAccountId($accountId)
{
	$conn = connectDB();
	$q1 = "SELECT * FROM accounts WHERE account_id=? ";
	$stmt1 = $conn->prepare($q1);
	$stmt1->bind_param('i',$accountId);
	$stmt1->execute();
	$result1 = $stmt1->get_result();

	$datas = $result1->fetch_assoc();

	return $datas;

}

function getAccountByCountryId($countryId)
{
	$conn = connectDB();
	$q1 = "SELECT * FROM accounts WHERE country_id=? ";
	$stmt1 = $conn->prepare($q1);
	$stmt1->bind_param('i',$countryId);
	$stmt1->execute();
	$result1 = $stmt1->get_result();

	$datas = [];
	while ($row = $result1->fetch_assoc()) {
		$datas[] = $row;
	}


	return $datas;

}

function currentBalance($customer_id)
{
	if ($customer_id) {
		$conn1 = connectDB();
		$conn2 = connectDB();
		// $q1 = "SELECT SUM(transaction_amount) AS transaction_amount FROM transactions WHERE to_customer_id=? AND (transaction_type='deposit' OR transaction_type='transfer') ";
		$q1 = "SELECT * FROM transactions WHERE to_customer_id=? AND (transaction_type='deposit' OR transaction_type='transfer') ";
		// $q2 = "SELECT SUM(transaction_amount) AS transaction_amount FROM transactions WHERE from_customer_id=? AND (transaction_type='withdraw' OR transaction_type='transfer') ";
		$q2 = "SELECT * FROM transactions WHERE from_customer_id=? AND (transaction_type='withdraw' OR transaction_type='transfer') ";
		$stmt1 = $conn1->prepare($q1);
		$stmt2 = $conn2->prepare($q2);
		$stmt1->bind_param('i',$customer_id);
		$stmt2->bind_param('i',$customer_id);
		$stmt1->execute();
		$stmt2->execute();
		$result1 = $stmt1->get_result();
		$result2 = $stmt2->get_result();


		$customerData = getUserData($customer_id);
		$countryData = getCountryData($customerData['customer_country_id']);
		$nativeCurrency = $countryData['country_currency'];

		// $inBalance = $result1->fetch_assoc();
		// $outBalance = $result2->fetch_assoc();

		// $inBalance = ($inBalance['transaction_amount'])?$inBalance['transaction_amount']:0;
		// $outBalance = ($outBalance['transaction_amount'])?$outBalance['transaction_amount']:0;

		$inBalance = $outBalance = 0;

		while ( $row1 = $result1->fetch_assoc()) {
			if ($nativeCurrency==$row1['transaction_amount_type']) {
				$inBalance += $row1['transaction_amount'];
			}else{
				$convertedBalance = convertRate($row1['transaction_amount'], $row1['transaction_amount_type'], $nativeCurrency)['amount'];
				$inBalance += $convertedBalance;
				// echo $row1['transaction_amount']." $convertedBalance";
				// exit();
			}
		}

		while ( $row2 = $result2->fetch_assoc()) {
			if ($nativeCurrency==$row2['transaction_amount_type']) {
				$outBalance += $row2['transaction_amount'];
			}else{
				$convertedBalance = convertRate($row2['transaction_amount'], $row2['transaction_amount_type'], $nativeCurrency)['amount'];
				$outBalance += $convertedBalance;
			}
		}
		
		$whiteListed = [
			'balance' => $inBalance-$outBalance,
			'customer_id' => $customer_id,
		];

		return $whiteListed;
	}
}

function deposit($fromAccountId, $toAccountId, $depositAmount, $currencyType)
{
	$to_user_data = getUserData($toAccountId);
	$accountDetails = getAccountByAccountId($fromAccountId);
	$conn = connectDB();
	$stmt = $conn->prepare("INSERT INTO transactions (transaction_type, from_customer_id, to_customer_id, transaction_amount, transaction_amount_type, transaction_from_country_id, transaction_to_country_id, transaction_charge, transaction_date_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$stmt->bind_param("siiisiiis", $transaction_type, $from_account_id, $to_account_id, $balance_amount, $transaction_amount_type, $from_user_country_id, $to_user_country_id, $transaction_charge, $transaction_date_time);

	$transaction_type = "deposit";
	$from_account_id = $fromAccountId;
	$to_account_id = $toAccountId;
	$balance_amount = $depositAmount;
	$transaction_amount_type = $currencyType;
	$from_user_country_id = $accountDetails['country_id'];
	$to_user_country_id = $to_user_data['customer_country_id'];
	$transaction_charge = 0;
	$transaction_date_time = date('Y-m-d H:i:s');

	if ($stmt->execute()) {
		return [true];
	}
	return [false];

}

function withdraw($toAccountId, $fromAccountId, $withdrawAmount, $currencyType)
{
	$from_user_data = getUserData($fromAccountId);
	$accountDetails = getAccountByAccountId($toAccountId);
	$conn = connectDB();
	$stmt = $conn->prepare("INSERT INTO transactions (transaction_type, from_customer_id, to_customer_id, transaction_amount, transaction_amount_type, transaction_from_country_id, transaction_to_country_id, transaction_charge, transaction_date_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$stmt->bind_param("siiisiiis", $transaction_type, $from_account_id, $to_account_id, $balance_amount, $transaction_amount_type, $from_user_country_id, $to_user_country_id, $transaction_charge, $transaction_date_time);

	$transaction_type = "withdraw";
	$from_account_id = $fromAccountId;
	$to_account_id = $toAccountId;
	$balance_amount = $withdrawAmount;
	$transaction_amount_type = $currencyType;
	$from_user_country_id = $from_user_data['customer_country_id'];
	$to_user_country_id = $accountDetails['country_id'];
	$transaction_charge = 0;
	$transaction_date_time = date('Y-m-d H:i:s');

	if ($stmt->execute()) {
		return [true];
	}
	return [false];
}

function transfer($from_id, $to_id, $amount, $currencyType)
{
	if ($from_id && $to_id && $amount && $currencyType) {
		$from_user_data = getUserData($from_id);
		$to_user_data = getUserData($to_id);
		if ($from_user_data['customer_country_id']>0 && $to_user_data['customer_country_id']>0) {
			$conn = connectDB();
			$stmt = $conn->prepare("INSERT INTO transactions (transaction_type, transaction_hash, transaction_signature, from_customer_id, to_customer_id, transaction_amount, transaction_amount_type, transaction_from_country_id, transaction_to_country_id, transaction_charge, transaction_date_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("sssiiisiiis", $transaction_type, $transaction_hash, $transaction_signature, $from_account_id, $to_account_id, $balance_amount, $transaction_amount_type, $from_user_country_id, $to_user_country_id, $transaction_charge, $transaction_date_time);

			$transaction_type = "transfer";
			$transaction_hash = bin2hex(random_bytes(22));
			$transaction_signature = NULL;
			$from_account_id = $from_id;
			$to_account_id = $to_id;
			$balance_amount = $amount;
			$transaction_amount_type = $currencyType;
			$from_user_country_id = $from_user_data['customer_country_id'];
			$to_user_country_id = $to_user_data['customer_country_id'];
			$transaction_charge = 0;
			$transaction_date_time = date('Y-m-d H:i:s');

			if ($stmt->execute()) {
				$notification_msg = $from_user_data['customer_username']." transfered money to you.";
				insertNotification($notification_msg, $to_user_data);
				return [true];
			}
		}else{
			return [false, "Country is empty in profile!"];
		}
	}

	return [false];
}

function transferSignatureUpdate($signature, $transactionId)
{
	$conn = connectDB();
	$sql = "UPDATE transactions SET transaction_signature='$signature' WHERE transaction_id='$transactionId'";
	if ($cons->query($sql)) {
		return true;
	}

	return false;
}


function getTransactions($customerId, $limit=null, $transaction_id = null){
	$conn = connectDB();
	$transactions = [];

	$q1 = "SELECT * FROM transactions WHERE from_customer_id='$customerId' OR to_customer_id='$customerId' ORDER BY transaction_date_time DESC";
	if ($limit!=null && $limit>0) {
		$q1 .= " LIMIT ".$limit;
	}
	$result1 = $conn->query($q1);

	if ($transaction_id) {
		$q1 = "SELECT * FROM transactions WHERE transaction_id=? AND (from_customer_id=? OR to_customer_id=?) ORDER BY transaction_date_time DESC";
		if ($limit!=null && $limit>0) {
			$q1 .= " LIMIT ".$limit;
		}
		$stmt1 = $conn->prepare($q1);
		$stmt1->bind_param('iii', $transaction_id, $customerId, $customerId);
		$stmt1->execute();
		$result1 = $stmt1->get_result();
	}
	

	if ($result1->num_rows > 0) {
		while($row1 = $result1->fetch_assoc()) {
			// $q2 = "SELECT * FROM transactions WHERE from_customer_id=? OR to_customer_id=?";
			// $stmt2 = $conn->prepare($q2);
			// $stmt2->bind_param('ii', $customerId, $customerId);
			// $stmt2->execute();
			// $result2 = $stmt2->get_result();
			// while ($row2 = $result2->fetch_assoc()) {
				$transactions[]=$row1;
			// }


		}

	}


	return $transactions;
}

function getNotifications($customerId, $limit=3){
	$conn = connectDB();
	$notifications = [];

	$q1 = "SELECT * FROM notifications WHERE notification_to='$customerId' AND notification_seen='0' ORDER BY notification_date_time DESC LIMIT $limit ";
	$result1 = $conn->query($q1);

	 // var_dump($conn->error);

	

	if ($result1->num_rows > 0) {
		while($row1 = $result1->fetch_assoc()) {
			$notifications[]=$row1;
		}

	}


	return $notifications;
}


/*
*
* SFT Explorer
*
*/

function insertBlockData($data, $transfer_id)
{
	$conn = connectDB();
	$stmt = $conn->prepare("INSERT INTO blockchain_transactions (transaction_hash, transaction_block, transaction_from, transaction_to, registration_datetime) VALUES (?, ?, ?, ?, ?)");
	$stmt->bind_param("issss", $customer_country_id, $customer_email, $customer_username, $customer_password, $registration_datetime);

	$customer_country_id = $data['customer_country_id'];
	$customer_email = $data['customer_email'];
	$customer_username = $data['customer_username'];
	$customer_password = $data['customer_password'];
	$registration_datetime = date('Y-m-d H:i:s');

	if ($stmt->execute()) {
		return true;
	}
}