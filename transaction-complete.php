<?php
require_once 'inc/config.inc.php';
// echo convertRate(1100,"BDT");
// exit();
if (!isset($_SESSION['loggedIn']) && !isset($_SESSION['userData'])) {
    header("location: login.php");
    exit();
}

if (!isset($_SESSION['transaction_data'])) {
	header("location: wallet.php");
    exit();
}

$transaction = $_SESSION['transaction_data'];

// $title = "Transaction Complete";
$customer_id = $_SESSION['userData']['customer_id'];
$customerData = getUserData($customer_id);

$countryAccounts =getAccountByCountryId($customerData['customer_country_id']);
$countryData = getCountryData($customerData['customer_country_id']);

$transactions = getTransactions($customerData['customer_id']);

?>


<?php require_once 'inc/header.inc.php'; ?>
    
    <!-- Footer Bar -->
    <?php require_once 'inc/footer_bar.inc.php'; ?>

    <!-- Page Content - Only Page Elements Here-->
    <div class="page-content footer-clear">

        <!-- Page Title-->
        <?php require_once 'inc/page_title.inc.php'; ?>
        <?php if (isset($_SESSION['success']) && !empty($_SESSION['success'])) { ?>
        <!--Account Activity Notification-->
        <div class="alert p-0 alert-dismissible fade show mb-n3" role="alert">
            <div class="card card-style gradient-green shadow-bg shadow-bg-s">
                <div class="content">

                        <div class="d-flex">
                            <div class="align-self-center">
                                <h1 class="mb-0 font-40"><i class="bi bi-check-circle color-white pe-3"></i></h1>
                            </div>
                            <div class="align-self-center">
                                <h5 class="color-white font-700 mb-0 mt-0">
                                    <?=$_SESSION['success']?>
                                </h5>
                            </div>
                            <div class="align-self-center ms-auto">
                                <span data-bs-dismiss="alert" class="icon-l"><i class="bi bi-x font-20 pt-1 d-block color-white"></i></span>
                            </div>
                        </div>
                        
                </div>
            </div>
        </div>
        <?php } ?>

        
        <div class="card card-style">
            <div class="content">
                <!-- <h3>Transaction Complete</h3> -->
                <a href="#" class="d-flex py-1 pb-4">
                    <div class="align-self-center">
                        <span class="icon rounded-s me-2 gradient-green shadow-bg shadow-bg-xs"><i class="bi bi-person-circle font-18 color-white"></i></span>
                    </div>
                    <div class="align-self-center ps-1">
                        <h5 class="pt-1 mb-n1">Transaction Complete</h5>
                        <p class="mb-0 font-11 opacity-70">Success</p>
                    </div>
                    <!-- <div class="align-self-center ms-auto text-end">
                        <h4 class="pt-1 font-14 mb-n1 color-yellow-dark">PENDING</h4>
                        <p class="mb-0 font-11"> ID-315-6123</p>
                    </div> -->
                </a>
                <div class="row">
                    <strong class="col-5 color-theme">Type</strong>
                    <strong class="col-7 text-end"><?=ucfirst($transaction['transaction_type'])?></strong>
                    <div class="col-12 mt-2 mb-2"><div class="divider my-0"></div></div>
                    <strong class="col-5 color-theme">Date</strong>
                    <strong class="col-7 text-end"><?=$transaction['transaction_date_time']?></strong>
                    <div class="col-12 mt-2 mb-2"><div class="divider my-0"></div></div>
                   <?php
                   $fromUser = "";
                   $toUser = "";
                   $transactionAmount = 0;
                   $transactionAmountType="";
                   $transaction_hash = $transaction['transaction_hash'];

                    if ($transaction['transaction_type']=="deposit" && $transaction['to_customer_id']==$customer_id) {
                    	$fromUser = getAccountByAccountId($transaction['from_customer_id'])['account_name'];
                    	$toUser = "Self";
                    	$transactionAmount = $transaction['transaction_amount'];
                    	$transactionAmountType = $transaction['transaction_amount_type'];
                    	?>
                    	<strong class="col-5 color-theme">Via</strong>
                    	<strong class="col-7 text-end"><?=$fromUser?></strong>

                    <?php }else if ($transaction['transaction_type']=="withdraw" && $transaction['from_customer_id']==$customer_id) {
                    	$fromUser = getAccountByAccountId($transaction['to_customer_id'])['account_name'];
                    	$toUser = "Self";
                    	$transactionAmount = $transaction['transaction_amount'];
                    	$transactionAmountType = $transaction['transaction_amount_type'];
                    	?>
                    	<strong class="col-5 color-theme">Via</strong>
                    	<strong class="col-7 text-end"><?=$fromUser?></strong>

                    	
                    <?php }else if ($transaction['transaction_type']=="transfer") {
                            $suffix = "";
                            $iconClass = "bi-suffle";
                            $transactionAmountType = $transaction['transaction_amount_type'];
                            $transactionAmount = $transaction['transaction_amount'];
                            if ($transaction['from_customer_id']==$customer_id) {
                                $fromUser = "You";
                                $toUser = getUserData($transaction['to_customer_id'])['customer_username'];
                                $suffix = "Out";
                                $iconClass = "bi-arrow-up";
                            }else{
                                $fromUser = getUserData($transaction['from_customer_id'])['customer_username'];
                                $toUser = "You";
                                $suffix = "In";
                                $iconClass = "bi-arrow-down";
                                if ($transaction['transaction_amount_type']!= $countryData['country_currency']) {
                                    $convertedTransaction = convertRate($transactionAmount, $transactionAmountType, $countryData['country_currency']);
                                    $transactionAmountType = $convertedTransaction['type'];
                                    $transactionAmount = $convertedTransaction['amount'];
                                }
                            }
                            ?>
                            <strong class="col-5 color-theme">From</strong>
                            <strong class="col-7 text-end color-highlight"><?=$fromUser?></strong>
                            <div class="col-12 mt-2 mb-2"><div class="divider my-0"></div></div><strong class="col-5 color-theme">To</strong>
                            <strong class="col-7 text-end color-highlight"><?=$toUser?></strong>

                           <?php } ?>

                    <div class="col-12 mt-2 mb-2"><div class="divider my-0"></div></div>
                    <strong class="col-5 color-theme">Amount</strong>
                    <strong class="col-7 text-end color-highlight"><?=$transactionAmountType?> <?=$transactionAmount?></strong>
                    <div class="col-12 mt-2 mb-2"><div class="divider my-0"></div></div>
                    <?php if ($transaction['transaction_type']=="transfer") {
                    	?>
                    <div class="col-6">
                        <a href="SFT/details.php?transaction_hash=<?=$transaction_hash?>" target="_blank" class="btn btn-s btn-full gradient-red shadow-bg shadow-bg-xs">View Hash</a>
                    </div>
                <?php } ?>
                </div>

            </div>
        </div>
        
        


    </div>

    <?php unset($_SESSION['transaction_data']); ?>
    <!-- End of Page Content-->

    <!-- Off Canvas and Menu Elements-->
    <!-- Always outside the Page Content-->

    <!-- Notifications Bell -->
    <div id="menu-notifications" data-menu-load="menu-notifications.php"
        class="offcanvas offcanvas-top offcanvas-detached rounded-m">
    </div>

    <!-- Main Sidebar Menu -->
    <div id="menu-sidebar"
        data-menu-active="nav-pages"
        data-menu-load="menu-sidebar.php"
        class="offcanvas offcanvas-start offcanvas-detached rounded-m">
    </div>
	
	<!-- Highlights Menu -->
	<div id="menu-highlights"
		data-menu-load="menu-highlights.html"
		class="offcanvas offcanvas-bottom offcanvas-detached rounded-m">
	</div>
    
    


</div>
<!-- End of Page ID-->
<script type="text/javascript">
    // $("#submit").click(function () {
    //     // var text = $("#textarea").val();
    //     // $("#modal_body").html(text);
    // });

    // function getDetails(transaction_hash) {
    //     if (transaction_hash.length>0) {
    //         $.ajax({
    //             url: "getTransactionDetails.php?transaction_hash="+transaction_hash,
    //             type:"GET",
    //             dataType:"json",
    //             success: function(result){
    //                 if (result.success==true) {
    //                     $("#viewHashId").attr("href","SFT/details.php?transaction_hash="+result.data.transaction_hash);
    //                 }
    //             }
    //         });
    //     }
    // }
</script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->

<script src="scripts/bootstrap.min.js"></script>
<script src="scripts/custom.js"></script>
</body>
