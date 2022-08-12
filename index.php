<?php
require_once 'inc/config.inc.php';

if (!isset($_SESSION['loggedIn']) && !isset($_SESSION['userData'])) {
    header("location: login.php");
    exit();
}
$customer_id = $_SESSION['userData']['customer_id'];
$customerData = getUserData($customer_id);

$countryAccounts =getAccountByCountryId($customerData['customer_country_id']);
$countryData = getCountryData($customerData['customer_country_id']);

$currentBalance = currentBalance($customerData['customer_id'])['balance'];
$transactions = getTransactions($customerData['customer_id'], 4);
?>

<?php require_once 'inc/header.inc.php'; ?>

    <!-- Footer Bar -->
    <?php require_once 'inc/footer_bar.inc.php'; ?>

    <!-- Page Content - Only Page Elements Here-->
    <div class="page-content footer-clear">

        <!-- Page Title-->
        <?php require_once 'inc/page_title.inc.php'; ?>

        <svg id="header-deco" viewBox="0 0 1440 600" xmlns="http://www.w3.org/2000/svg" class="transition duration-300 ease-in-out delay-150">
            <path id="header-deco-1" d="M 0,600 C 0,600 0,120 0,120 C 92.36363636363635,133.79904306220095 184.7272727272727,147.59808612440193 287,148 C 389.2727272727273,148.40191387559807 501.4545454545455,135.40669856459328 592,129 C 682.5454545454545,122.5933014354067 751.4545454545455,122.77511961722489 848,115 C 944.5454545454545,107.22488038277511 1068.7272727272727,91.49282296650718 1172,91 C 1275.2727272727273,90.50717703349282 1357.6363636363635,105.25358851674642 1440,120 C 1440,120 1440,600 1440,600 Z"></path>
            <path id="header-deco-2" d="M 0,600 C 0,600 0,240 0,240 C 98.97607655502392,258.2105263157895 197.95215311004785,276.4210526315789 278,282 C 358.04784688995215,287.5789473684211 419.16746411483257,280.5263157894737 524,265 C 628.8325358851674,249.4736842105263 777.377990430622,225.47368421052633 888,211 C 998.622009569378,196.52631578947367 1071.3205741626793,191.57894736842107 1157,198 C 1242.6794258373207,204.42105263157893 1341.3397129186603,222.21052631578948 1440,240 C 1440,240 1440,600 1440,600 Z"></path>
            <path id="header-deco-3" d="M 0,600 C 0,600 0,360 0,360 C 65.43540669856458,339.55023923444975 130.87081339712915,319.1004784688995 245,321 C 359.12918660287085,322.8995215311005 521.9521531100479,347.1483253588517 616,352 C 710.0478468899521,356.8516746411483 735.3205741626795,342.3062200956938 822,333 C 908.6794258373205,323.6937799043062 1056.7655502392345,319.62679425837325 1170,325 C 1283.2344497607655,330.37320574162675 1361.6172248803828,345.1866028708134 1440,360 C 1440,360 1440,600 1440,600 Z"></path>
            <path id="header-deco-4" d="M 0,600 C 0,600 0,480 0,480 C 70.90909090909093,494.91866028708137 141.81818181818187,509.8373205741627 239,499 C 336.18181818181813,488.1626794258373 459.6363636363636,451.5693779904306 567,446 C 674.3636363636364,440.4306220095694 765.6363636363636,465.88516746411483 862,465 C 958.3636363636364,464.11483253588517 1059.8181818181818,436.8899521531101 1157,435 C 1254.1818181818182,433.1100478468899 1347.090909090909,456.555023923445 1440,480 C 1440,480 1440,600 1440,600 Z"></path>
        </svg>

        <div class="p-2">
            <div class="card card-style m-0 bg-7 shadow-card shadow-card-m" style="height:200px">
                <div class="card-center">
                    <div class="bg-theme px-3 py-2 rounded-end d-inline-block">
                        <h1 class="font-13 my-n1">
                            <a class="color-theme" data-bs-toggle="collapse" href="#balance3" aria-controls="balance2">Click for Balance</a>
                        </h1>
                        <div class="collapse" id="balance3">
                            <h2 class="color-theme font-26"><?=$countryData['country_currency']?> <?=$currentBalance?></h2>
                            <h2 class="color-theme font-26"><?php $convertedCurrency =  convertRate($currentBalance,$countryData['country_currency']);
                            echo $convertedCurrency['type']." ".$convertedCurrency['amount'];
                            ?></h2>
                        </div>
                    </div>
                </div>
                <strong class="card-top no-click font-12 p-3 color-white font-monospace">Main Account</strong>
                <!-- <strong class="card-bottom no-click p-3 font-12 text-start color-white font-monospace">1234 5678 1234 5661</strong> -->
                <div class="card-overlay bg-black opacity-50"></div>
            </div>
        </div>

        


        <!-- Quick Actions -->
        <!-- <div class="content py-2">
            <div class="d-flex text-center">
                <div class="m-auto">
                    <a href="payments.php" class="icon icon-xxl rounded-m bg-theme shadow-m"><i class="font-28 color-green-dark bi bi-arrow-up-circle"></i></a>
                    <h6 class="font-13 opacity-80 font-500 mb-0 pt-2">Payments</h6>
                </div>
                <div class="m-auto">
                    <a href="#" data-bs-toggle="offcanvas" data-bs-target="#menu-request" class="icon icon-xxl rounded-m bg-theme shadow-m"><i class="font-28 color-red-dark bi bi-arrow-down-circle"></i></a>
                    <h6 class="font-13 opacity-80 font-500 mb-0 pt-2">Request</h6>
                </div>
            </div>
        </div> -->
<br>
        <!-- Recent Activity Title-->
        <div class="content my-0 mt-n2 px-1">
            <div class="d-flex">
                <div class="align-self-center">
                    <h3 class="font-16 mb-2">Recent Activity</h3>
                </div>
                <div class="align-self-center ms-auto">
                    <a href="activity.php" class="font-12 pt-1">View All</a>
                </div>
            </div>
        </div>

        <!-- Recent Activity Cards-->
        <div class="card card-style">
            <div class="content">
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
                        
                <!-- <a href="activity.php" class="d-flex py-1">
                    <div class="align-self-center">
                        <span class="icon rounded-s me-2 gradient-orange shadow-bg shadow-bg-s"><i class="bi bi-google color-white"></i></span>
                    </div>
                    <div class="align-self-center ps-1">
                        <h5 class="pt-1 mb-n1">Google Ads</h5>
                        <p class="mb-0 font-11 opacity-50">14th March <span class="copyright-year"></span></p>
                    </div>
                    <div class="align-self-center ms-auto text-end">
                        <h4 class="pt-1 mb-n1 color-red-dark">$150.55</h4>
                        <p class="mb-0 font-11">Bill Payment</p>
                    </div>
                </a>
                <div class="divider my-2 opacity-50"></div>
                <a href="activity.php" class="d-flex py-1">
                    <div class="align-self-center">
                        <span class="icon rounded-s me-2 gradient-green shadow-bg shadow-bg-s"><i class="bi bi-caret-up-fill color-white"></i></span>
                    </div>
                    <div class="align-self-center ps-1">
                        <h5 class="pt-1 mb-n1">Bitcoin</h5>
                        <p class="mb-0 font-11 opacity-50">14th March <span class="copyright-year"></span></p>
                    </div>
                    <div class="align-self-center ms-auto text-end">
                        <h4 class="pt-1 mb-n1 color-blue-dark">+0.315%</h4>
                        <p class="mb-0 font-11">Stock Update</p>
                    </div>
                </a>
                <div class="divider my-2 opacity-50"></div>
                <a href="activity.php" class="d-flex py-1">
                    <div class="align-self-center">
                        <span class="icon rounded-s me-2 gradient-yellow shadow-bg shadow-bg-s"><i class="bi bi-pie-chart-fill color-white"></i></span>
                    </div>
                    <div class="align-self-center ps-1">
                        <h5 class="pt-1 mb-n1">Dividends</h5>
                        <p class="mb-0 font-11 opacity-50">13th March <span class="copyright-year"></span></p>
                    </div>
                    <div class="align-self-center ms-auto text-end">
                        <h4 class="pt-1 mb-n1 color-green-dark">$950.00</h4>
                        <p class="mb-0 font-11">Wire Transfer</p>
                    </div>
                </a> -->
            </div>
        </div>

    </div>
    <!-- End of Page Content-->

    <!-- Off Canvas and Menu Elements-->
    <!-- Always outside the Page Content-->

    <?php // require_once 'inc/offscreen.inc.php'; ?>

    <!-- Main Sidebar Menu -->
    <div id="menu-sidebar" data-menu-active="nav-welcome" data-menu-load="menu-sidebar.php"
        class="offcanvas offcanvas-start offcanvas-detached rounded-m">
    </div>

    <!-- Card Menu More -->
    <div id="menu-card-more" data-menu-load="menu-card-settings.html"
        class="offcanvas offcanvas-bottom offcanvas-detached rounded-m">
    </div>

    <!-- Transfer Button Menu -->
    <div id="menu-transfer" data-menu-load="menu-transfer.html"
        class="offcanvas offcanvas-bottom offcanvas-detached rounded-m">
    </div>

    <!-- Transfer Friends Menu -->
    <!-- <div id="menu-friends-transfer" data-menu-load="menu-friends-transfer.html"
        class="offcanvas offcanvas-bottom offcanvas-detached rounded-m">
    </div> -->

    <!-- Request Button Menu -->
    <!-- <div id="menu-request" data-menu-load="menu-request.html"
        class="offcanvas offcanvas-bottom offcanvas-detached rounded-m">
    </div> -->

    <!-- Exchange Button Menu -->
    <!-- <div id="menu-exchange" data-menu-load="menu-exchange.html"
        class="offcanvas offcanvas-bottom offcanvas-detached rounded-m">
    </div> -->

    <!-- Notifications Bell -->
    <div id="menu-notifications" data-menu-load="menu-notifications.php"
        class="offcanvas offcanvas-top offcanvas-detached rounded-m">
    </div>

    <!-- Highlights Menu -->
    <div id="menu-highlights"
        data-menu-load="menu-highlights.html"
        class="offcanvas offcanvas-bottom offcanvas-detached rounded-m">
    </div>

	<div class="offcanvas offcanvas-bottom rounded-m offcanvas-detached" id="menu-install-pwa-ios">
		   <div class="content">
		   <img src="images/preload-logo.png" alt="img" width="80" class="rounded-m mx-auto my-4">
			  <h1 class="text-center">Install PAYSUM</h1>
			  <p class="boxed-text-xl">
				  Install PAYSUM on your home screen, and access it just like a regular app. Open your Safari menu and tap "Add to Home Screen".
			  </p>
			   <a href="#" class="pwa-dismiss close-menu color-theme text-uppercase font-900 opacity-50 font-11 text-center d-block mt-n2" data-bs-dismiss="offcanvas">Maybe Later</a>
		   </div>
	   </div>

	   <div class="offcanvas offcanvas-bottom rounded-m offcanvas-detached" id="menu-install-pwa-android">
		   <div class="content">
			   <img src="images/preload-logo.png" alt="img" width="80" class="rounded-m mx-auto my-4">
			   <h1 class="text-center">Install PAYSUM</h1>
			   <p class="boxed-text-l">
				   Install PAYSUM to your Home Screen to enjoy a unique and native experience.
			   </p>
			   <a href="#" class="pwa-install btn btn-m rounded-s text-uppercase font-900 gradient-highlight shadow-bg shadow-bg-s btn-full">Add to Home Screen</a><br>
			   <a href="#" data-bs-dismiss="offcanvas" class="pwa-dismiss close-menu color-theme text-uppercase font-900 opacity-60 font-11 text-center d-block mt-n1">Maybe later</a>
		   </div>
	   </div>



</div>
<!-- End of Page ID-->

<script src="scripts/bootstrap.min.js"></script>
<script src="scripts/custom.js"></script>
</body>