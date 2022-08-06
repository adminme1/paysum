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
		$q1 = "SELECT * FROM customers WHERE customer_username=? AND customer_password=?";
		$stmt1 = $conn->prepare($q1);
		$stmt1->bind_param('ss',$data['customer_username'], $data['customer_password']);
		$stmt1->execute();
		$result1 = $stmt1->get_result();

		if ($result1->num_rows > 0) {
			$datas = $result1->fetch_assoc();
			$whiteListed = [
				'customer_id' => $datas['customer_id'],
				'customer_email' => $datas['customer_email'],
			];
			// print_r($datas);
			// die();
			return $whiteListed;
		}
	}

	return false;
}

function createCustomerAccount($data)
{
	if ($data) {
		$conn = connectDB();
		$stmt = $conn->prepare("INSERT INTO customers (customer_email, customer_username, customer_password, registration_datetime) VALUES (?, ?, ?, ?)");
		$stmt->bind_param("ssss", $customer_email, $customer_username, $customer_password, $registration_datetime);

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




function getTransactions( $transaction_id = null){
	$conn = connectDB();
	$questions = [];

	$q1 = "SELECT * FROM transactions";
	$result1 = $conn->query($q1);

	if ($question_id) {
		$question_id = htmlentities(trim(strip_tags(stripslashes($question_id))), ENT_NOQUOTES, "UTF-8");
		$q1 = "SELECT * FROM questions WHERE question_id=?";
		$stmt1 = $conn->prepare($q1);
		$stmt1->bind_param('i',$question_id);
		$stmt1->execute();
		$result1 = $stmt1->get_result();
	}
	

	if ($result1->num_rows > 0) {

		while($row1 = $result1->fetch_assoc()) {
			$q2 = "SELECT * FROM questions_options WHERE question_id=?";
			$stmt2 = $conn->prepare($q2);
			$stmt2->bind_param('i',$row1['question_id']);
			$stmt2->execute();
			$result2 = $stmt2->get_result();
			$options = [];
			while ($row2 = $result2->fetch_assoc()) {
				$options[]=$row2;
			}

			$currentDateTime = strtotime(date('Y-m-d H:i'));
			$voteStartDateTime = strtotime(date('Y-m-d H:i', strtotime($row1['start_time'])));
			$voteEndDateTime = strtotime(date('Y-m-d H:i', strtotime($row1['end_time'])));

			if ($voteStartDateTime<=$currentDateTime) {
				$row1['voteStart'] = true;
			}else{
				$row1['voteStart'] = false;
			}

			if ($voteEndDateTime<$currentDateTime) {
				$row1['voteEnd'] = true;
			}else{
				$row1['voteEnd'] = false;
			}
			

			$row1['options'] = $options;
			$questions[] = $row1;
			$stmt2->close();
		}

	}

	if ($question_id) {
		$stmt1->close();
	}
	$conn->close();

	return $questions;
}

function votes($question_id, $walletAddress = null)
{
	if ($question_id) {
		$conn = connectDB();

		$question_id = htmlentities(trim(strip_tags(stripslashes($question_id))), ENT_NOQUOTES, "UTF-8");
		$q1 = "SELECT * FROM votes WHERE question_id=? ";
		if ($walletAddress) {
			$walletAddress = htmlentities(trim(strip_tags(stripslashes($walletAddress))), ENT_NOQUOTES, "UTF-8");
			$q1 .= " AND voter_address=?";
		}

		$stmt1 = $conn->prepare($q1);
		if ($walletAddress) {
			$stmt1->bind_param('is', $question_id, $walletAddress);
		}else{
			$stmt1->bind_param('i', $question_id);
		}
		$stmt1->execute();
		$result1 = $stmt1->get_result();
		
		
		if ($walletAddress) {
			$data = $result1->fetch_assoc();
		}else{
			$data = $result1->fetch_all(MYSQLI_ASSOC);
		}

		$stmt1->close();

		$conn->close();
		return $data;

	}

}


function isTokenHolder($walletAddress){
	$tokenholders = "test_tokens.csv";
	$datas = ['found'=>false];
	if (($handle = fopen($tokenholders, "r")) !== FALSE) {
	  while (($data = fgetcsv($handle, 1000)) !== FALSE) {
	  	foreach ($data as $value) {
	  		if (strtolower($value)==$walletAddress) {
	  			//echo "$value";
	  			$datas['found']=true;
	  			$datas['data'] = $data;
	  			break;
	  		}
	  	}
	  	
	  }

	  fclose($handle);
	}
	return $datas;
}


function votingResult($question_id)
{
	if ($question_id) {
		$conn = connectDB();

		$question_id = htmlentities(trim(strip_tags(stripslashes($question_id))), ENT_NOQUOTES, "UTF-8");
		$q1 = "SELECT questions_options.option_name, COUNT(votes.option_id) AS count, (SELECT COUNT(vote_id) FROM votes WHERE question_id=?) AS max FROM votes INNER JOIN questions_options ON votes.option_id=questions_options.option_id WHERE votes.question_id=? GROUP BY option_name";


		$stmt1 = $conn->prepare($q1);
		// var_dump($conn);
		$stmt1->bind_param('ii', $question_id, $question_id);
		$stmt1->execute();
		$result1 = $stmt1->get_result();
		$data = $result1->fetch_all(MYSQLI_ASSOC);

		$stmt1->close();

		$conn->close();
		return $data;

	}	
}


function insertVote($walletAddress, $question_id, $option_id)
{
	$conn = connectDB();
	$tokenholderData = isTokenHolder($walletAddress);
	if ($tokenholderData['found']) {
		
		$voter_weight = $tokenholderData['data'][1];
		$stmt = $conn->prepare("INSERT INTO votes (voter_address, voter_weight, question_id, option_id, vote_date_time) VALUES (?, ?, ?, ?, ?)");
		$stmt->bind_param("siiis", $walletAddress1, $voter_weight1, $question_id1, $option_id1, $currentDateTime);

		$walletAddress1 = $walletAddress;
		$voter_weight1 = $voter_weight;
		$question_id1 = $question_id;
		$option_id1 = $option_id;
		$currentDateTime = date('Y-m-d H:i:s');

		if ($stmt->execute()) {
			return true;
		}
	}
	return false;
}