<?php
require_once 'inc/config.inc.php';

if (isset($_GET['transaction_hash'])) {
	$response = ['success'=>false];
	$transactions = getAllTransactions($_GET['transaction_hash']);
	if (empty($transactions) || count($transactions)<1) {
	  $response['error'] = "Invalid transaction hash..";
	}else{
		$response['data'] = $transactions[0];
		$response['success'] = true;
	}

	echo json_encode($response);
	
}
?>