<?php
function rates($file='../inc/rates.json')
{
	$json = file_get_contents($file);
  
	// Decode the JSON file
	$json_data = json_decode($json,true);
	$rates = $json_data['rates'];

	// Display data
	return $rates;
}

function convertPriceRate($amount, $currencyType, $convertTo='USD')
{
	$rates = rates();
	$currencyTypeAmount = $rates[$currencyType];
	if ($convertTo=="USD") {
		return ["amount"=>round(($amount / $currencyTypeAmount), 2), "type"=>$convertTo];
	}
	return ["amount"=> round((($amount / $currencyTypeAmount)*$rates[$convertTo]), 2), "type"=>$convertTo];
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link rel="stylesheet" href="style.css?id=<?=date('is')?>">
    <link rel="stylesheet" href="styleHome.css?id=<?=date('is')?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">



<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">


    <title>SFTP Explorer</title>
</head>
<body>

<div class="body-background">
    <div class="container-fluid-main">
        <div class="container-fluid-header ">
            <div class="row">
              <div class="col-lg-8 col-md-4 col-sm-2 justify-content-center"><a style="text-decoration: none; font-family:Roboto,sans-serif; color: white;" href="index.php">SFTP Explorer</a></div>
              <div class="col-lg-1 col-md-2 col-sm-2 "><a style="text-decoration: none; font-family:Roboto,sans-serif; color: white;" href="poolTransaction.php">Pool</a></div>
              <div class="col-lg-1 col-md-2 col-sm-2 "><a style="text-decoration: none; font-family:Roboto,sans-serif; color: white;" href="./about.html">About</a></div>
              <div class="col-lg-1 col-md-2 col-sm-2 "><a style="text-decoration: none;font-family:Roboto,sans-serif; color: white;" href="./contact.html">Contact</a></div>
            </div>
        </div>
        
                 
             </div>        
              
          </div>
          <br>
          <div class="container text-dark">
          <div class="justify-content-center">
          	<div class="input-group">
			    <input type="search" id="form1" class="form-control" placeholder="Search transaction...." />
			  <button type="button" class="btn btn-primary">
			    <i class="fas fa-search"></i>
			  </button>
			</div>

          </div>
        </div>
          
