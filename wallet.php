<?php
require_once 'inc/config.inc.php';
// echo convertRate(1100,"BDT");
// exit();
if (!isset($_SESSION['loggedIn']) && !isset($_SESSION['userData'])) {
    header("location: login.php");
    exit();
}

$title = "Wallet";
$customer_id = $_SESSION['userData']['customer_id'];
$customerData = getUserData($customer_id);

$countryAccounts =getAccountByCountryId($customerData['customer_country_id']);
$countryData = getCountryData($customerData['customer_country_id']);
// var_dump($currentBalance);
// exit();
?>

<?php
if ($_SERVER['REQUEST_METHOD']=="POST") {
    if ($_POST['formType']=="deposit") {
        if (!empty($_POST['depositFrom']) && !empty($_POST['depositAmount'])) {
            $customer_id= $_SESSION['userData']['customer_id'];
            $deposited = deposit($_POST['depositFrom'], $customer_id, $_POST['depositAmount'], $countryData['country_currency']);
            $_SESSION['success']= "Deposit successfull from ".getAccountByAccountId($_POST['depositFrom'])['account_name'];
        }else{
            $_SESSION['error'] = "Required filed is empty.";
        }
    }else if ($_POST['formType']=="withdraw") {
        if (!empty($_POST['withdrawVia']) && !empty($_POST['withdrawAmount'])) {
            $withdrawed = withdraw($_POST['withdrawVia'], $customer_id, $_POST['withdrawAmount'], $countryData['country_currency']);
            $_SESSION['success']= "Withdraw successfull from ".getAccountByAccountId($_POST['withdrawVia'])['account_name'];
        }else{
            $_SESSION['error'] = "Required filed is empty.";
        }
    }else if ($_POST['formType']=="transfer") {
        if (empty($_POST['to_customer_username']) || empty($_POST['transaction_amount'])) {
            $_SESSION['errors']['required'] = "Required field is empty!";
        }else{
            $to_customer_username = $_POST['to_customer_username'];
            $transaction_amount = $_POST['transaction_amount'];
            // $from_user_id = $_SESSION['userData']['customer_id'];

            $toCustomerData = getUserData($to_customer_username, "customer_username");
            $fromCustomerData = getUserData($customer_id);
            $fromAccountBalance = currentBalance($customer_id)['balance'];

            if ($toCustomerData==false) {
              $_SESSION['errors']['username'] = "To account not exists!";
            }
            if ($fromAccountBalance-$transaction_amount<0) {
              $_SESSION['errors']['InsufficientBalance'] = "Insufficient Balance!";
            }

            if (!isset($_SESSION['errors'])) {
                // echo "start";
                // exit();
              $transfer = transfer($customer_id, $toCustomerData['customer_id'], $transaction_amount, $countryData['country_currency']);

              if ($transfer[0]==true) {
                $_SESSION['success'] = "Transfer successfull!";
                // header("location:activity.php");
              }else{
                $_SESSION['errorsDB'] = "Failed to transfer amount!";
              }
            }
        }
    }
}
$currentBalance = currentBalance($customerData['customer_id'])['balance'];
$transactions = getTransactions($customerData['customer_id']);
?>

<?php require_once 'inc/header.inc.php'; ?>
    
    <!-- Footer Bar -->
    <?php require_once 'inc/footer_bar.inc.php'; ?>

    <!-- Page Content - Only Page Elements Here-->
    <div class="page-content footer-clear">

        <!-- Page Title-->
        <?php require_once 'inc/page_title.inc.php'; ?>
        
        <!-- Card Stack - The Stack Height Below will be the card height-->
        <div class="card-stack card-stack-active" data-stack-height="180">
           
            <!-- Card Open on Click-->
            <div class="card-stack-click no-click"></div>
            
            <!-- Card 1-->
            <!-- <div class="card card-style bg-5">
                <div class="card-top p-3">
                    <a href="#" data-bs-toggle="offcanvas" data-bs-target="#menu-card-more" class="icon icon-xxs bg-white color-black float-end"><i class="bi bi-three-dots font-18"></i></a>
                </div>
                <div class="card-center">
                    <div class="bg-theme px-3 py-2 rounded-end d-inline-block">
                        <h1 class="font-13 my-n1">
                            <a class="color-theme" data-bs-toggle="collapse" href="#balance3" aria-controls="balance2">Click for Balance</a>
                        </h1>
                        <div class="collapse" id="balance3"><h2 class="color-theme font-26">$26,315</h2></div>
                    </div>
                </div>
                <strong class="card-top no-click font-12 p-3 color-white font-monospace">Main Account</strong>
                <strong class="card-bottom no-click p-3 text-start color-white font-monospace">1234 5678 1234 5661</strong>
                <strong class="card-bottom no-click p-3 text-end color-white font-monospace">08 / 2025</strong>
                <div class="card-overlay bg-black opacity-50"></div>
            </div> -->
            
            <!-- Card 2 -->
            <div class="card card-style bg-7">
                <!-- <div class="card-top p-3">
                    <a href="#" data-bs-toggle="offcanvas" data-bs-target="#menu-card-more" class="icon icon-xxs bg-white color-black float-end"><i class="bi bi-three-dots font-18"></i></a>
                </div> -->
                <div class="card-center">
                    <div class="bg-theme px-3 py-2 rounded-end d-inline-block">
                        <h1 class="font-13 my-n1">
                            <a class="color-theme" data-bs-toggle="collapse" href="#balance1" aria-controls="balance1">Click for Balance</a>
                        </h1>
                        <div class="collapse" id="balance1">
                            <h2 class="color-theme font-26"><?=$countryData['country_currency']?> <?=$currentBalance?></h2>
                            <h2 class="color-theme font-26"><?php $convertedCurrency =  convertRate($currentBalance,$countryData['country_currency']);
                            echo $convertedCurrency['type']." ".$convertedCurrency['amount'];
                            ?></h2>
                        </div>
                    </div>
                </div>
                <!-- <strong class="card-top no-click font-12 p-3 color-white font-monospace">Company Account</strong> -->
                <!-- <strong class="card-bottom no-click p-3 text-start color-white font-monospace">1234 5678 1234 5661</strong> -->
                <!-- <strong class="card-bottom no-click p-3 text-end color-white font-monospace">08 / 2025</strong> -->
                <div class="card-overlay bg-black opacity-50"></div>
            </div>
            
            <!-- Card 3 -->
            <!-- <div class="card card-style bg-1">
                <div class="card-top p-3">
                    <a href="#" data-bs-toggle="offcanvas" data-bs-target="#menu-card-more" class="icon icon-xxs bg-white color-black float-end"><i class="bi bi-three-dots font-18"></i></a>
                </div>
                <div class="card-center">
                    <div class="bg-theme px-3 py-2 rounded-end d-inline-block">
                        <h1 class="font-13 my-n1">
                            <a class="color-theme" data-bs-toggle="collapse" href="#balance2" aria-controls="balance2">Click for Balance</a>
                        </h1>
                        <div class="collapse" id="balance2"><h2 class="color-theme font-26">$15,100</h2></div>
                    </div>
                </div>
                <strong class="card-top no-click font-12 p-3 color-white font-monospace">Savings Account</strong>
                <strong class="card-bottom no-click p-3 text-start color-white font-monospace">1234 5678 1234 5661</strong>
                <strong class="card-bottom no-click p-3 text-end color-white font-monospace">08 / 2025</strong>
                <div class="card-overlay bg-black opacity-50"></div>
            </div> -->
        </div>
        
        <!-- Card Stack Info Message / Hides when deployed -->
        <!-- <h6 class="btn-stack-info color-theme opacity-80 text-center mt-n2 mb-3">Tap the Cards to Expand your Wallet</h6> -->
        <!-- Card Stack Button / shows when deployed -->
        <a href="#" class="disabled btn-stack-click btn mx-3 mb-4 btn-full gradient-highlight shadow-bg shadow-bg-xs">Close my Wallet</a>

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
<?php unset($_SESSION['success']); } ?>
<?php if (isset($_SESSION['error']) && !empty($_SESSION['error'])) { ?>
<!--Account Activity Notification-->
<div class="alert p-0 alert-dismissible fade show mb-n3" role="alert">
    <div class="card card-style gradient-red shadow-bg shadow-bg-s">
        <div class="content">

                <div class="d-flex">
                    <div class="align-self-center">
                        <h1 class="mb-0 font-40"><i class="bi bi-x-circle color-white pe-3"></i></h1>
                    </div>
                    <div class="align-self-center">
                        <h5 class="color-white font-700 mb-0 mt-0">
                            <?=$_SESSION['error']?>
                        </h5>
                    </div>
                    <div class="align-self-center ms-auto">
                        <span data-bs-dismiss="alert" class="icon-l"><i class="bi bi-x font-20 pt-1 d-block color-white"></i></span>
                    </div>
                </div>
                
        </div>
    </div>
</div>
<?php  unset($_SESSION['error']); } ?>

<?php
   if (isset($_SESSION['errors'])) {
    foreach ($_SESSION['errors'] as $errKey => $errValue) {
      echo "<div class=' text-center'> <span class='text-danger'><b>".ucfirst($errKey).":</b> $errValue </span></div><br>";
    }
    echo "<br>";
    unset($_SESSION['errors']);
   }

   if (isset($_SESSION['errorsDB'])) {
    echo "<div class='alert alert-danger text-center'>".$_SESSION['errorsDB']."</div><br>";
    unset($_SESSION['errorsDB']);
   }
?>
        <!-- Tabs-->
        <div class="card card-style">
            
            <div class="content mb-0">
                
                <!-- Tab Wrapper-->
                <div class="tabs tabs-pill" id="tab-group-2">
                    <!-- Tab Controls -->
                    <div class="tab-controls rounded-m p-1">
                        <!-- <a class="font-13 rounded-m" data-bs-toggle="collapse" href="#tab-4" aria-expanded="true">Settings</a> -->
                        <a class="font-13 rounded-m" data-bs-toggle="collapse" href="#tab-6" aria-expanded="true">Deposit</a>
                        <a class="font-13 rounded-m" data-bs-toggle="collapse" href="#tab-7" aria-expanded="false">Withdraw</a>
                        <a class="font-13 rounded-m" data-bs-toggle="collapse" href="#tab-17" aria-expanded="false">Transfer</a>
                        <a class="font-13 rounded-m" data-bs-toggle="collapse" href="#tab-5" aria-expanded="false">History</a>
                        <!-- <a class="font-13 rounded-m" data-bs-toggle="collapse" href="#tab-x" aria-expanded="false">Activity</a> -->
                    </div>
                    
                    <!-- Tab 1 -->
                    <div class="mt-3"></div>
                    <!-- <div class="collapse show" id="tab-4" data-bs-parent="#tab-group-2">
                        <div class="list-group list-custom list-group-m list-group-flush rounded-xs px-1">
                            <a href="#" class="list-group-item pe-2" data-trigger-switch="switch-5">
                                <i class="has-bg gradient-green color-white shadow-bg shadow-bg-xs rounded-xs bi bi-gear-fill"></i>
                                <div><strong> Use Online Payments</strong><span>Use this card to pay online</span></div>
                                <div class="form-switch ios-switch switch-green switch-s">
                                    <input type="checkbox" class="ios-input" id="switch-5">
                                    <label class="custom-control-label" for="switch-5"></label>
                                </div>
                            </a>
                            <a href="#" class="list-group-item pe-2" data-trigger-switch="switch-51">
                                <i class="has-bg gradient-magenta color-white shadow-bg shadow-bg-xs rounded-xs bi bi-wifi"></i>
                                <div><strong> Use NFC Payments</strong><span>Pay With Card Contactless</span></div>
                                <div class="form-switch ios-switch switch-green switch-s">
                                    <input type="checkbox" class="ios-input" id="switch-51" checked>
                                    <label class="custom-control-label" for="switch-51"></label>
                                </div>
                            </a>
                            <a href="#" class="list-group-item pe-2" data-trigger-switch="switch-5">
                                <i class="has-bg gradient-blue color-white shadow-bg shadow-bg-xs rounded-xs bi bi-filter-circle"></i>
                                <div><strong>Change Card Name</strong></div>
                                <i class="bi bi-chevron-right"></i>
                            </a>
                            <a href="#" class="list-group-item pe-2" data-trigger-switch="switch-5">
                                <i class="has-bg gradient-red color-white shadow-bg shadow-bg-xs rounded-xs bi bi-x-circle"></i>
                                <div><strong>Remove this Card</strong></div>
                                <i class="bi bi-chevron-right"></i>
                            </a>
                            <a href="#" class="list-group-item pe-2" data-trigger-switch="switch-5">
                                <i class="has-bg gradient-yellow color-white shadow-bg shadow-bg-xs rounded-xs bi bi-question-circle"></i>
                                <div><strong>Report Lost or Stolen</strong></div>
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </div>
                    </div> -->

                    <div class="collapse show" id="tab-6" data-bs-parent="#tab-group-2">
                        <form action="" method="post">

                            <input type="hidden" name="formType" value="deposit">
                            <div class="form-custom form-label form-icon mt-3">
                                <i class="bi bi-caret-up-fill font-16"></i>
                                <select class="form-select" id="from-2" name="depositFrom">
                                    <?php
                                    foreach ($countryAccounts as $account) {
                                        echo "<option value='".$account['account_id']."'>".$account['account_name']."</option>";
                                    }
                                    ?>
                                    <!-- <option>pAccount</option>
                                    <option>bKash</option>
                                    <option>Bank</option> -->
                                </select>
                                <label for="from-2" class="color-highlight">Deposit From</label>
                            </div>
                            <div class="pb-2"></div>
                            <div class="form-custom form-label form-icon mt-3">
                                <!-- <i class="bi bi-currency-dollar font-16"></i> -->
                                <input type="text" name="depositAmount" class="form-control rounded-xs" id="c2" placeholder="Deposit Native Amount"/>
                                <label for="c2" class="color-highlight">Deposit Native Amount</label>
                                <span><?=$countryData['country_currency']?></span>
                            </div>
                            <div class="pb-2"></div>
                            
                            <button type="submit" class="btn btn-full btn-info">Deposit</button>
                        </form>
                        

                    </div>

                    <div class="collapse" id="tab-7" data-bs-parent="#tab-group-2">
                        <form action="" method="post">

                            <input type="hidden" name="formType" value="withdraw">
                            <div class="form-custom form-label form-icon mt-3">
                                <i class="bi bi-caret-up-fill font-16"></i>
                                <select class="form-select" id="from-2" name="withdrawVia">
                                    <?php
                                    foreach ($countryAccounts as $account) {
                                        echo "<option value='".$account['account_id']."'>".$account['account_name']."</option>";
                                    }
                                    ?>
                                    <!-- <option>pAccount</option>
                                    <option>bKash</option>
                                    <option>Bank</option> -->
                                </select>
                                <label for="from-2" class="color-highlight">Withdraw Via</label>
                            </div>
                            <div class="pb-2"></div>
                            <div class="form-custom form-label form-icon mt-3">
                                <!-- <i class="bi bi-currency-dollar font-16"></i> -->
                                <input type="text" name="withdrawAmount" class="form-control rounded-xs" id="c2" placeholder="Withdraw Native Currency"/>
                                <label for="c2" class="color-highlight">Enter Native Currency</label>
                                <span><?=$countryData['country_currency']?></span>
                            </div>
                            <div class="pb-2"></div>
                            
                            <button type="submit" class="btn btn-full btn-info">Withdraw</button>
                        </form>
                    </div>

                    <div class="collapse" id="tab-17" data-bs-parent="#tab-group-2">
                        <form action="" method="post">
                            <input type="hidden" name="formType" value="transfer">
                            <div class="form-custom form-label form-icon mt-3">
                                <i class="bi bi-at font-16"></i>
                                <input type="text" name="to_customer_username" class="form-control rounded-xs" id="c2" placeholder="Transfer To"/>
                                <label for="c2" class="color-highlight">Transfer To</label>
                                <span>(required)</span>
                            </div>
                            <div class="pb-2"></div>
                            <div class="form-custom form-label form-icon">
                                <!-- <i class="bi bi-currency-dollar font-14"></i> -->
                                <input type="number" name="transaction_amount" class="form-control rounded-xs" id="c32" placeholder="Transfer Amount"/>
                                <label for="c32" class="color-highlight">Transfer Amount</label>
                                <span><?=$countryData['country_currency']?></span>
                            </div>
                            <div class="pb-2"></div>
                            <button type="submit" class="btn btn-full gradient-highlight rounded-s shadow-bg shadow-bg-xs mt-3 mb-3">Transfer Now</button>
                        </form>

                    </div>
                    
                    <!-- Tab 2-->
                    <div class="collapse " id="tab-5" data-bs-parent="#tab-group-2">
                        <div class="form-custom form-label form-border form-icon mt-0 mb-0">
                            <i class="bi bi-check-circle font-13"></i>
                            <select class="form-select rounded-xs" id="c6" aria-label="Floating label select example">
                                <option selected>Latest Activity</option>
                                <option value="1">Last 30 Days</option>
                                <option value="2">Last 90 Days</option>
                                <option value="3">Last 6 Months</option>
                            </select>
                        </div>

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
                            }
                            ?>
                                <a href="#" class="list-group-item">
                                    <i class="has-bg gradient-magenta color-white rounded-xs bi <?=$iconClass?>"></i>
                                    <div><strong>Transfer <?=$suffix?></strong><span> From <?=$from?> To <?=$to?> </span> </div>
                                    <span class="badge bg-transparent color-theme text-end font-15">
                                       <?=$transaction['transaction_amount_type']?> <?=$transaction['transaction_amount']?> <br>
                                       <em class="fst-normal font-12 opacity-30"><?=$transaction['transaction_date_time']?></em>
                                    </span>
                                </a>

                           <?php } ?>



                        <?php } ?>
                        </div>
                    </div>



                    
                    <!-- Tab 3 -->
                    <!-- <div class="collapse" id="tab-x" data-bs-parent="#tab-group-2">
                        <a href="page-activity.html" class="d-flex py-1">
                            <div class="align-self-center">
                                <span class="icon rounded-s me-2 gradient-orange shadow-bg shadow-bg-xs"><i class="bi bi-google color-white"></i></span>
                            </div>
                            <div class="align-self-center ps-1">
                                <h5 class="pt-1 mb-n1">Google Ads</h5>
                                <p class="mb-0 font-11 opacity-70">14th March <span class="copyright-year"></span></p>
                            </div>
                            <div class="align-self-center ms-auto text-end">
                                <h4 class="pt-1 mb-n1 color-red-dark">$150.55</h4>
                                <p class="mb-0 font-11">Bill Payment</p>
                            </div>
                        </a>
                        <div class="divider my-2 opacity-50"></div>
                        <a href="page-activity.html" class="d-flex py-1">
                            <div class="align-self-center">
                                <span class="icon rounded-s me-2 gradient-blue shadow-bg shadow-bg-xs"><i class="bi bi-cloud-fill color-white"></i></span>
                            </div>
                            <div class="align-self-center ps-1">
                                <h5 class="pt-1 mb-n1">Cloud Storage</h5>
                                <p class="mb-0 font-11 opacity-70">14th March <span class="copyright-year"></span></p>
                            </div>
                            <div class="align-self-center ms-auto text-end">
                                <h4 class="pt-1 mb-n1 color-red-dark">$15.55</h4>
                                <p class="mb-0 font-11">Subscription</p>
                            </div>
                        </a>
                        <div class="divider my-2 opacity-50"></div>
                        <a href="page-activity.html" class="d-flex py-1">
                            <div class="align-self-center">
                                <span class="icon rounded-s me-2 gradient-orange shadow-bg shadow-bg-xs">
                                    <img src="images/pictures/31s.jpg" width="46" class="rounded-s" alt="img">
                                </span>
                            </div>
                            <div class="align-self-center ps-1">
                                <h5 class="pt-1 mb-n1">Jane Son</h5>
                                <p class="mb-0 font-11 opacity-70">14th March <span class="copyright-year"></span></p>
                            </div>
                            <div class="align-self-center ms-auto text-end">
                                <h4 class="pt-1 mb-n1 color-green-dark">$130.55</h4>
                                <p class="mb-0 font-11">Direct Transfer</p>
                            </div>
                        </a>
                        <div class="divider my-2 opacity-50"></div>
                        <a href="page-activity.html" class="d-flex py-1">
                            <div class="align-self-center">
                                <span class="icon rounded-s me-2 gradient-green shadow-bg shadow-bg-xs"><i class="bi bi-caret-up-fill color-white"></i></span>
                            </div>
                            <div class="align-self-center ps-1">
                                <h5 class="pt-1 mb-n1">Bitcoin</h5>
                                <p class="mb-0 font-11 opacity-70">14th March <span class="copyright-year"></span></p>
                            </div>
                            <div class="align-self-center ms-auto text-end">
                                <h4 class="pt-1 mb-n1 color-blue-dark">+0.315%</h4>
                                <p class="mb-0 font-11">Stock Update</p>
                            </div>
                        </a>
                        <div class="divider my-2 opacity-50"></div>
                        <a href="page-activity.html" class="d-flex py-1">
                            <div class="align-self-center">
                                <span class="icon rounded-s me-2 gradient-yellow shadow-bg shadow-bg-xs"><i class="bi bi-pie-chart-fill color-white"></i></span>
                            </div>
                            <div class="align-self-center ps-1">
                                <h5 class="pt-1 mb-n1">Dividends</h5>
                                <p class="mb-0 font-11 opacity-70">13th March <span class="copyright-year"></span></p>
                            </div>
                            <div class="align-self-center ms-auto text-end">
                                <h4 class="pt-1 mb-n1 color-green-dark">$950.00</h4>
                                <p class="mb-0 font-11">Wire Transfer</p>
                            </div>
                        </a>
                        <div class="pb-3"></div>
                    </div> -->
                    
                    <!-- End of Tabs-->
                </div>
                
                <!-- End of Tab Wrapper-->
            </div>
        </div>
                
    </div>
    <!-- End of Page Content-->

    <!-- Off Canvas and Menu Elements-->
    <!-- Always outside the Page Content-->

    <?php require_once 'inc/offscreen.inc.php'; ?>



</div>
<!-- End of Page ID-->

<script src="scripts/bootstrap.min.js"></script>
<script src="scripts/custom.js"></script>
</body>