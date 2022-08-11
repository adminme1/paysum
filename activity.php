<?php
require_once 'inc/config.inc.php';
if (!isset($_SESSION['loggedIn']) && !isset($_SESSION['userData'])) {
    header("location: login.php");
    exit();
}
$title = "Activity";
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
                <div class="tabs tabs-pill" id="tab-group-2">
                    <div class="tab-controls rounded-m p-1 overflow-visible">
                        <a class="font-13 rounded-m shadow-bg shadow-bg-s" data-bs-toggle="collapse" href="#tab-4" aria-expanded="true">Transactions</a>
                        <!-- <a class="font-13 rounded-m shadow-bg shadow-bg-s" data-bs-toggle="collapse" href="#tab-5" aria-expanded="false">Transfers</a> -->
                        <!-- <a class="font-13 rounded-m shadow-bg shadow-bg-s" data-bs-toggle="collapse" href="#tab-6" aria-expanded="false">Payments</a> -->
                    </div>
                    <div class="mt-3"></div>
                    <!-- Tab Group 1 -->
                    <div class="collapse show" id="tab-4" data-bs-parent="#tab-group-2">
                        <div class="list-group list-custom list-group-m list-group-flush rounded-xs">
                            <?php
                            foreach ($transactions as $transaction) { 

                                if ($transaction['transaction_type']=="deposit" && $transaction['to_customer_id']==$customer_id) {

                            ?>
                            <a href="#" class="list-group-item">
                                <i class="has-bg gradient-green color-white rounded-xs bi bi-cash-coin"></i>
                                <div><strong>Deposit</strong><span> From <?=getAccountByAccountId($transaction['from_customer_id'])['account_name']?></span> </div>
                                <span class="badge bg-transparent color-theme text-end font-15">
                                   <?=$transaction['transaction_amount_type']?> <?=$transaction['transaction_amount']?> <br>
                                   <em class="fst-normal font-12 opacity-30"><?=$transaction['transaction_date_time']?></em>
                                </span>
                            </a>

                            <?php }else if ($transaction['transaction_type']=="withdraw" && $transaction['from_customer_id']==$customer_id) { ?>
                                <a href="#" class="list-group-item">
                                    <i class="has-bg gradient-red color-white rounded-xs bi bi-cash-coin"></i>
                                    <div><strong>Withdraw</strong><span> Via <?=getAccountByAccountId($transaction['to_customer_id'])['account_name']?></span> </div>
                                    <span class="badge bg-transparent color-theme text-end font-15">
                                       <?=$transaction['transaction_amount_type']?> <?=$transaction['transaction_amount']?> <br>
                                       <em class="fst-normal font-12 opacity-30"><?=$transaction['transaction_date_time']?></em>
                                    </span>
                                </a>

                           <?php }else if ($transaction['transaction_type']=="transfer") {
                            $from = "";
                            $to = "";
                            $suffix = "";
                            $iconClass = "bi-suffle";
                            $transactionAmountType = $transaction['transaction_amount_type'];
                            $transactionAmount = $transaction['transaction_amount'];
                            if ($transaction['from_customer_id']==$customer_id) {
                                $from = "You";
                                $to = getUserData($transaction['to_customer_id'])['customer_username'];
                                $suffix = "Out";
                                $iconClass = "bi-arrow-up";
                            }else{
                                $from = getUserData($transaction['from_customer_id'])['customer_username'];
                                $to = "You";
                                $suffix = "In";
                                $iconClass = "bi-arrow-down";
                                if ($transaction['transaction_amount_type']!= $countryData['country_currency']) {
                                    $convertedTransaction = convertRate($transactionAmount, $transactionAmountType, $countryData['country_currency']);
                                    $transactionAmountType = $convertedTransaction['type'];
                                    $transactionAmount = $convertedTransaction['amount'];
                                }
                            }
                            ?>
                                <a href="#" class="list-group-item">
                                    <i class="has-bg gradient-magenta color-white rounded-xs bi <?=$iconClass?>"></i>
                                    <div><strong>Transfer <?=$suffix?></strong><span> From <?=$from?> To <?=$to?> </span> </div>
                                    <span class="badge bg-transparent color-theme text-end font-15">
                                       <?=$transactionAmountType?> <?=$transactionAmount?> <br>
                                       <em class="fst-normal font-12 opacity-30"><?=$transaction['transaction_date_time']?></em>
                                    </span>
                                </a>

                           <?php } ?>



                        <?php } ?>
                        </div>

                        <!-- <a href="#" class="d-flex py-1" data-bs-toggle="offcanvas" data-bs-target="#menu-activity-1">
                            <div class="align-self-center">
                                <span class="icon gradient-red me-2 shadow-bg shadow-bg-s rounded-s">
                                    <img src="images/pictures/6s.jpg" width="45" class="rounded-s" alt="img">
                                </span>
                            </div>
                            <div class="align-self-center ps-1">
                                <h5 class="pt-1 mb-n1">Karla Black</h5>
                                <p class="mb-0 font-11 opacity-70">12th March <span class="copyright-year"></span></p>
                            </div>
                            <div class="align-self-center ms-auto text-end">
                                <h4 class="pt-1 mb-n1 color-green-dark">$150.55</h4>
                                <p class="mb-0 font-11"> Received</p>
                            </div>
                        </a>
                        <div class="divider my-2 opacity-50"></div>
                        <a href="#" class="d-flex py-1" data-bs-toggle="offcanvas" data-bs-target="#menu-activity-2">
                            <div class="align-self-center">
                                <span class="icon rounded-s me-2 gradient-brown shadow-bg shadow-bg-xs"><i class="bi bi-wallet color-white"></i></span>
                            </div>
                            <div class="align-self-center ps-1">
                                <h5 class="pt-1 mb-n1">Withdrawal</h5>
                                <p class="mb-0 font-11 opacity-70">12th March <span class="copyright-year"></span></p>
                            </div>
                            <div class="align-self-center ms-auto text-end">
                                <h4 class="pt-1 mb-n1 color-blue-dark">$345.31</h4>
                                <p class="mb-0 font-11">Main Account</p>
                            </div>
                        </a>
                        <div class="divider my-2 opacity-50"></div>
                        <a href="#" class="d-flex py-1" data-bs-toggle="offcanvas" data-bs-target="#menu-activity-3">
                            <div class="align-self-center">
                                <span class="icon rounded-s me-2 gradient-orange shadow-bg shadow-bg-xs"><i class="bi bi-google color-white"></i></span>
                            </div>
                            <div class="align-self-center ps-1">
                                <h5 class="pt-1 mb-n1">Google Ads</h5>
                                <p class="mb-0 font-11 opacity-70">14th March <span class="copyright-year"></span></p>
                            </div>
                            <div class="align-self-center ms-auto text-end">
                                <h4 class="pt-1 mb-n1 color-red-dark">$324.55</h4>
                                <p class="mb-0 font-11">Bill Payment</p>
                            </div>
                        </a>
                        <div class="divider my-2 opacity-50"></div>
                        <a href="#" class="d-flex py-1" data-bs-toggle="offcanvas" data-bs-target="#menu-activity-4">
                            <div class="align-self-center">
                                <span class="icon rounded-s me-2 gradient-green shadow-bg shadow-bg-xs"><i class="bi bi-person-circle font-18 color-white"></i></span>
                            </div>
                            <div class="align-self-center ps-1">
                                <h5 class="pt-1 mb-n1">Karla Black</h5>
                                <p class="mb-0 font-11 opacity-70">Awaiting Approval</p>
                            </div>
                            <div class="align-self-center ms-auto text-end">
                                <span class="btn btn-xxs gradient-green shadow-bg shadow-bg-xs">Details</span>
                            </div>
                        </a>
                        <div class="divider my-2 opacity-50"></div>
                        <a href="#" class="d-flex py-1" data-bs-toggle="offcanvas" data-bs-target="#menu-activity-5">
                            <div class="align-self-center">
                                <span class="icon rounded-s me-2 gradient-blue shadow-bg shadow-bg-xs"><i class="bi bi-lock-fill font-18 color-white"></i></span>
                            </div>
                            <div class="align-self-center ps-1">
                                <h5 class="pt-1 mb-n1">Verification</h5>
                                <p class="mb-0 font-11 opacity-70">Action Required</p>
                            </div>
                            <div class="align-self-center ms-auto text-end">
                                <span class="btn btn-xxs gradient-blue shadow-bg shadow-bg-xs">Verify</span>
                            </div>
                        </a> -->
                    </div>
                    <!-- Tab Group 2 -->
                    <!-- <div class="collapse" id="tab-5" data-bs-parent="#tab-group-2">
                        <a href="#" class="d-flex py-1" data-bs-toggle="offcanvas" data-bs-target="#menu-activity-1">
                            <div class="align-self-center">
                                <span class="icon gradient-yellow me-2 shadow-bg shadow-bg-xs rounded-s">
                                    <img src="images/pictures/21s.jpg" width="45" class="rounded-s" alt="img"></span>
                            </div>
                            <div class="align-self-center ps-1">
                                <h5 class="pt-1 mb-n1">Jane Doe</h5>
                                <p class="mb-0 font-11 opacity-70">12th March <span class="copyright-year"></span></p>
                            </div>
                            <div class="align-self-center ms-auto text-end">
                                <h4 class="pt-1 mb-n1 color-red-dark">$250.00</h4>
                                <p class="mb-0 font-11">Transfered</p>
                            </div>
                        </a>
                        <div class="divider my-2 opacity-50"></div>
                        <a href="#" class="d-flex py-1" data-bs-toggle="offcanvas" data-bs-target="#menu-activity-1">
                            <div class="align-self-center">
                                <span class="icon gradient-red me-2 shadow-bg shadow-bg-s rounded-s">
                                    <img src="images/pictures/6s.jpg" width="45" class="rounded-s" alt="img"></span>
                            </div>
                            <div class="align-self-center ps-1">
                                <h5 class="pt-1 mb-n1">Karla Black</h5>
                                <p class="mb-0 font-11 opacity-70">12th March <span class="copyright-year"></span></p>
                            </div>
                            <div class="align-self-center ms-auto text-end">
                                <h4 class="pt-1 mb-n1 color-green-dark">$150.55</h4>
                                <p class="mb-0 font-11"> Received</p>
                            </div>
                        </a>
                        <div class="divider my-2 opacity-50"></div>
                        <a href="#" class="d-flex py-1" data-bs-toggle="offcanvas" data-bs-target="#menu-activity-2">
                            <div class="align-self-center">
                                <span class="icon rounded-s me-2 gradient-brown shadow-bg shadow-bg-xs"><i class="bi bi-wallet color-white"></i></span>
                            </div>
                            <div class="align-self-center ps-1">
                                <h5 class="pt-1 mb-n1">Withdrawal</h5>
                                <p class="mb-0 font-11 opacity-70">12th March <span class="copyright-year"></span></p>
                            </div>
                            <div class="align-self-center ms-auto text-end">
                                <h4 class="pt-1 mb-n1 color-blue-dark">$345.31</h4>
                                <p class="mb-0 font-11">Main Account</p>
                            </div>
                        </a>
                        <div class="divider my-2 opacity-50"></div>
                        <a href="#" class="d-flex py-1" data-bs-toggle="offcanvas" data-bs-target="#menu-activity-4">
                            <div class="align-self-center">
                                <span class="icon rounded-s me-2 gradient-green shadow-bg shadow-bg-xs"><i class="bi bi-person-circle font-18 color-white"></i></span>
                            </div>
                            <div class="align-self-center ps-1">
                                <h5 class="pt-1 mb-n1">Karla Black</h5>
                                <p class="mb-0 font-11 opacity-70">Awaiting Approval</p>
                            </div>
                            <div class="align-self-center ms-auto text-end">
                                <span class="btn btn-xxs bg-green-dark shadow-bg shadow-bg-xs">Details</span>
                            </div>
                        </a>
                    </div> -->
                    <!-- Tab Group 3 -->
                    <!-- <div class="collapse" id="tab-6" data-bs-parent="#tab-group-2">
                        <a href="#" class="d-flex py-1" data-bs-toggle="offcanvas" data-bs-target="#menu-activity-3">
                            <div class="align-self-center">
                                <span class="icon rounded-s me-2 gradient-orange shadow-bg shadow-bg-xs"><i class="bi bi-google color-white"></i></span>
                            </div>
                            <div class="align-self-center ps-1">
                                <h5 class="pt-1 mb-n1">Google Ads</h5>
                                <p class="mb-0 font-11 opacity-70">14th March <span class="copyright-year"></span></p>
                            </div>
                            <div class="align-self-center ms-auto text-end">
                                <h4 class="pt-1 mb-n1 color-red-dark">$324.55</h4>
                                <p class="mb-0 font-11">Bill Payment</p>
                            </div>
                        </a>
                        <div class="divider my-2 opacity-50"></div>
                        <a href="#" class="d-flex py-1" data-bs-toggle="offcanvas" data-bs-target="#menu-activity-4">
                            <div class="align-self-center">
                                <span class="icon rounded-s me-2 gradient-green shadow-bg shadow-bg-xs"><i class="bi bi-caret-up-fill color-white"></i></span>
                            </div>
                            <div class="align-self-center ps-1">
                                <h5 class="pt-1 mb-n1">Bitcoin</h5>
                                <p class="mb-0 font-11 opacity-70">13th March <span class="copyright-year"></span></p>
                            </div>
                            <div class="align-self-center ms-auto text-end">
                                <h4 class="pt-1 mb-n1 color-blue-dark">+0.315%</h4>
                                <p class="mb-0 font-11">Stock Update</p>
                            </div>
                        </a>
                        <div class="divider my-2 opacity-50"></div>
                        <a href="#" class="d-flex py-1" data-bs-toggle="offcanvas" data-bs-target="#menu-activity-2">
                            <div class="align-self-center">
                                <span class="icon rounded-s me-2 gradient-yellow shadow-bg shadow-bg-xs"><i class="bi bi-pie-chart-fill color-white"></i></span>
                            </div>
                            <div class="align-self-center ps-1">
                                <h5 class="pt-1 mb-n1">Dividends</h5>
                                <p class="mb-0 font-11 opacity-70">14th March <span class="copyright-year"></span></p>
                            </div>
                            <div class="align-self-center ms-auto text-end">
                                <h4 class="pt-1 mb-n1 color-green-dark">$950.00</h4>
                                <p class="mb-0 font-11">Wire Transfer</p>
                            </div>
                        </a>
                        <div class="divider my-2 opacity-50"></div>
                        <a href="#" class="d-flex py-1" data-bs-toggle="offcanvas" data-bs-target="#menu-activity-5">
                            <div class="align-self-center">
                                <span class="icon rounded-s me-2 gradient-blue shadow-bg shadow-bg-xs"><i class="bi bi-lock-fill font-18 color-white"></i></span>
                            </div>
                            <div class="align-self-center ps-1">
                                <h5 class="pt-1 mb-n1">Verification</h5>
                                <p class="mb-0 font-11 opacity-70">Action Required</p>
                            </div>
                            <div class="align-self-center ms-auto text-end">
                                <span class="btn btn-xxs gradient-blue shadow-bg shadow-bg-xs">Verify</span>
                            </div>
                        </a>
                    </div> -->
                </div>
            </div>
        </div>
        
        


    </div>
    <!-- End of Page Content-->

    <!-- Off Canvas and Menu Elements-->
    <!-- Always outside the Page Content-->

    <!-- Main Sidebar Menu -->
    <div id="menu-sidebar"
        data-menu-active="nav-pages"
        data-menu-load="menu-sidebar.html"
        class="offcanvas offcanvas-start offcanvas-detached rounded-m">
    </div>
	
	<!-- Highlights Menu -->
	<div id="menu-highlights"
		data-menu-load="menu-highlights.html"
		class="offcanvas offcanvas-bottom offcanvas-detached rounded-m">
	</div>

    <!-- Transaction Action Sheet -->
    <div id="menu-activity-1" class="offcanvas offcanvas-bottom offcanvas-detached rounded-m">
        <!-- menu-size will be the dimension of your menu. If you set it to smaller than your content it will scroll-->
        <div class="menu-size" style="height:385px;">
            <div class="content">
                <a href="#" class="d-flex py-1 pb-4">
                    <div class="align-self-center">
                        <span class="icon gradient-red me-2 shadow-bg shadow-bg-s rounded-s">
                            <img src="images/pictures/6s.jpg" width="45" class="rounded-s" alt="img"></span>
                    </div>
                    <div class="align-self-center ps-1">
                        <h5 class="pt-1 mb-n1">Karla Black</h5>
                        <p class="mb-0 font-11 opacity-70">12th March <span class="copyright-year"></span></p>
                    </div>
                    <div class="align-self-center ms-auto text-end">
                        <h4 class="pt-1 font-14 mb-n1 color-green-dark">APPROVED</h4>
                        <p class="mb-0 font-11"> ID-315-6123</p>
                    </div>
                </a>
                <div class="row">
                    <strong class="col-5 color-theme">Type</strong>
                    <strong class="col-7 text-end">Incoming</strong>
                    <div class="col-12 mt-2 mb-2"><div class="divider my-0"></div></div>
                    <strong class="col-5 color-theme">Date</strong>
                    <strong class="col-7 text-end">12th March</strong>
                    <div class="col-12 mt-2 mb-2"><div class="divider my-0"></div></div>
                    <strong class="col-5 color-theme">Amount</strong>
                    <strong class="col-7 text-end color-highlight">$150.55</strong>
                    <div class="col-12 mt-2 mb-2"><div class="divider my-0"></div></div>
                    <strong class="col-5 color-theme">Sent Via</strong>
                    <strong class="col-7 text-end">Credit Card</strong>
                    <div class="col-12 mt-2 mb-2"><div class="divider my-0"></div></div>
                    <strong class="col-5 color-theme">Added To</strong>
                    <strong class="col-7 text-end">Main Account</strong>
                    <div class="col-12 mt-2 mb-2"><div class="divider my-0"></div></div>
                </div>
            </div>
            <a href="#" data-bs-dismiss="offcanvas" class="mx-3 btn btn-full gradient-highlight shadow-bg shadow-bg-s">Back to Activity</a>
        </div>
    </div>
    
    <!-- Transaction Action Sheet -->
    <div id="menu-activity-2" class="offcanvas offcanvas-bottom offcanvas-detached rounded-m">
        <!-- menu-size will be the dimension of your menu. If you set it to smaller than your content it will scroll-->
        <div class="menu-size" style="height:385px;">
            <div class="content">
                <a href="#" class="d-flex py-1 pb-4">
                    <div class="align-self-center">
                        <span class="icon rounded-s me-2 gradient-brown shadow-bg shadow-bg-xs"><i class="bi bi-wallet color-white"></i></span>
                    </div>
                    <div class="align-self-center ps-1">
                        <h5 class="pt-1 mb-n1">Withdrawal</h5>
                        <p class="mb-0 font-11 opacity-70">12th March <span class="copyright-year"></span></p>
                    </div>
                    <div class="align-self-center ms-auto text-end">
                        <h4 class="pt-1 font-14 mb-n1 color-green-dark">APPROVED</h4>
                        <p class="mb-0 font-11"> ID-315-6123</p>
                    </div>
                </a>
                <div class="row">
                    <strong class="col-5 color-theme">Type</strong>
                    <strong class="col-7 text-end">Withdrawal</strong>
                    <div class="col-12 mt-2 mb-2"><div class="divider my-0"></div></div>
                    <strong class="col-5 color-theme">Date</strong>
                    <strong class="col-7 text-end">12th March</strong>
                    <div class="col-12 mt-2 mb-2"><div class="divider my-0"></div></div>
                    <strong class="col-5 color-theme">Amount</strong>
                    <strong class="col-7 text-end color-highlight">$345.31</strong>
                    <div class="col-12 mt-2 mb-2"><div class="divider my-0"></div></div>
                    <strong class="col-5 color-theme">Withdrawn To</strong>
                    <strong class="col-7 text-end">Credit Card</strong>
                    <div class="col-12 mt-2 mb-2"><div class="divider my-0"></div></div>
                    <strong class="col-5 color-theme">Withdraw From</strong>
                    <strong class="col-7 text-end">Main Account</strong>
                    <div class="col-12 mt-2 mb-2"><div class="divider my-0"></div></div>
                </div>
            </div>
            <a href="#" data-bs-dismiss="offcanvas" class="mx-3 btn btn-full gradient-highlight shadow-bg shadow-bg-s">Back to Activity</a>
        </div>
    </div>
    
    <!-- Transaction Action Sheet -->
    <div id="menu-activity-3" class="offcanvas offcanvas-bottom offcanvas-detached rounded-m">
        <!-- menu-size will be the dimension of your menu. If you set it to smaller than your content it will scroll-->
        <div class="menu-size" style="height:385px;">
            <div class="content">
                <a href="#" class="d-flex py-1 pb-4">
                    <div class="align-self-center">
                        <span class="icon rounded-s me-2 gradient-orange shadow-bg shadow-bg-xs"><i class="bi bi-google color-white"></i></span>
                    </div>
                    <div class="align-self-center ps-1">
                        <h5 class="pt-1 mb-n1">Google Ads</h5>
                        <p class="mb-0 font-11 opacity-70">14th March <span class="copyright-year"></span></p>
                    </div>
                    <div class="align-self-center ms-auto text-end">
                        <h4 class="pt-1 font-14 mb-n1 color-red-dark">RECEIVED</h4>
                        <p class="mb-0 font-11"> ID-315-6123</p>
                    </div>
                </a>
                <div class="row">
                    <strong class="col-5 color-theme">Type</strong>
                    <strong class="col-7 text-end">Payment</strong>
                    <div class="col-12 mt-2 mb-2"><div class="divider my-0"></div></div>
                    <strong class="col-5 color-theme">Paid To</strong>
                    <strong class="col-7 text-end">GOOGLE LLC LTD</strong>
                    <div class="col-12 mt-2 mb-2"><div class="divider my-0"></div></div>
                    <strong class="col-5 color-theme">Date</strong>
                    <strong class="col-7 text-end">12th March</strong>
                    <div class="col-12 mt-2 mb-2"><div class="divider my-0"></div></div>
                    <strong class="col-5 color-theme">Amount</strong>
                    <strong class="col-7 text-end color-highlight">$324.55</strong>
                    <div class="col-12 mt-2 mb-2"><div class="divider my-0"></div></div>
                    <strong class="col-5 color-theme">Paid From</strong>
                    <strong class="col-7 text-end">Credit Card</strong>
                    <div class="col-12 mt-2 mb-2"><div class="divider my-0"></div></div>
                </div>
            </div>
            <a href="#" data-bs-dismiss="offcanvas" class="mx-3 btn btn-full gradient-highlight shadow-bg shadow-bg-s">Back to Activity</a>
        </div>
    </div>
    
     <!-- Transaction Action Sheet -->
    <div id="menu-activity-4" class="offcanvas offcanvas-bottom offcanvas-detached rounded-m">
        <!-- menu-size will be the dimension of your menu. If you set it to smaller than your content it will scroll-->
        <div class="menu-size" style="height:380px;">
            <div class="content">
                <a href="#" class="d-flex py-1 pb-4">
                    <div class="align-self-center">
                        <span class="icon rounded-s me-2 gradient-green shadow-bg shadow-bg-xs"><i class="bi bi-person-circle font-18 color-white"></i></span>
                    </div>
                    <div class="align-self-center ps-1">
                        <h5 class="pt-1 mb-n1">Karla Black</h5>
                        <p class="mb-0 font-11 opacity-70">Awaiting Approval</p>
                    </div>
                    <div class="align-self-center ms-auto text-end">
                        <h4 class="pt-1 font-14 mb-n1 color-yellow-dark">PENDING</h4>
                        <p class="mb-0 font-11"> ID-315-6123</p>
                    </div>
                </a>
                <div class="row">
                    <strong class="col-5 color-theme">Type</strong>
                    <strong class="col-7 text-end">Transfer</strong>
                    <div class="col-12 mt-2 mb-2"><div class="divider my-0"></div></div>
                    <strong class="col-5 color-theme">Paid To</strong>
                    <strong class="col-7 text-end">GOOGLE LLC LTD</strong>
                    <div class="col-12 mt-2 mb-2"><div class="divider my-0"></div></div>
                    <strong class="col-5 color-theme">Date</strong>
                    <strong class="col-7 text-end">12th March</strong>
                    <div class="col-12 mt-2 mb-2"><div class="divider my-0"></div></div>
                    <strong class="col-5 color-theme">Amount</strong>
                    <strong class="col-7 text-end color-highlight">$324.55</strong>
                    <div class="col-12 mt-2 mb-2"><div class="divider my-0"></div></div>
                    <strong class="col-5 color-theme">Paid From</strong>
                    <strong class="col-7 text-end">Credit Card</strong>
                    <div class="col-12 mt-2 mb-4"><div class="divider my-0"></div></div>
                    <div class="col-6">
                        <a href="#" data-bs-dismiss="offcanvas" class="btn btn-s btn-full gradient-green shadow-bg shadow-bg-xs">Approve</a>
                    </div>
                    <div class="col-6">
                        <a href="#" data-bs-dismiss="offcanvas" class="btn btn-s btn-full gradient-red shadow-bg shadow-bg-xs">Reject</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

     <!-- Transaction Action Sheet -->
    <div id="menu-activity-5" class="offcanvas offcanvas-bottom offcanvas-detached rounded-m">
        <!-- menu-size will be the dimension of your menu. If you set it to smaller than your content it will scroll-->
        <div class="menu-size" style="height:320px;">
            <div class="content">
                <a href="#" class="d-flex py-1 pb-4">
                    <div class="align-self-center">
                        <span class="icon rounded-s me-2 gradient-blue shadow-bg shadow-bg-xs"><i class="bi bi-lock-fill font-18 color-white"></i></span>
                    </div>
                    <div class="align-self-center ps-1">
                        <h5 class="pt-1 mb-n1">Verification</h5>
                        <p class="mb-0 font-11 opacity-70">Action Required</p>
                    </div>
                    <div class="align-self-center ms-auto text-end">
                        <h4 class="pt-1 font-14 mb-n1 color-yellow-dark">PENDING</h4>
                        <p class="mb-0 font-11"> ID-315-6123</p>
                    </div>
                </a>
                <div class="form-custom form-label form-icon mt-3">
                    <i class="bi bi-person-circle font-14"></i>
                    <input type="email" class="form-control rounded-xs" id="c32" placeholder="john@domain.com" />
                    <label for="c32" class="form-label-always-active color-theme font-11">Account Holder Email</label>
                    <span class="font-10">(required)</span>
                </div>
                <div class="form-custom form-label form-icon mt-4">
                    <i class="bi bi-person-circle font-14"></i>
                    <input type="number" class="form-control rounded-xs" id="c321" placeholder="ID-125-5132" />
                    <label for="c321" class="form-label-always-active color-theme font-11">Account Holder Security Code</label>
                    <span class="font-10">(required)</span>
                </div>
                <div class="row mt-4">
                    <div class="col-6">
                        <a href="#" data-bs-dismiss="offcanvas" class="btn btn-s btn-full gradient-green shadow-bg shadow-bg-xs">Verify</a>
                    </div>
                    <div class="col-6">
                        <a href="#" data-bs-dismiss="offcanvas" class="btn btn-s btn-full gradient-blue shadow-bg shadow-bg-xs">Later</a>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>
<!-- End of Page ID-->

<script src="scripts/bootstrap.min.js"></script>
<script src="scripts/custom.js"></script>
</body>