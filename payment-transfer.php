<?php
require_once 'inc/config.inc.php';
if (!isset($_SESSION['loggedIn']) && !isset($_SESSION['userData'])) {
    header("location: login.php");
    exit();
}

$_SESSION['errors'] = null;

if ($_SERVER['REQUEST_METHOD']=="POST") {
  if (empty($_POST['to_customer_username']) || empty($_POST['transaction_amount'])) {
    $_SESSION['errors']['required'] = "Required field is empty!";
  }else{
    $to_customer_username = $_POST['to_customer_username'];
    $transaction_amount = $_POST['transaction_amount'];
    $from_user_id = $_SESSION['userData']['customer_id'];

    $toCustomerData = getUserData($to_customer_username, "customer_username");
    $fromCustomerData = getUserData($from_user_id);
    $fromAccountBalance = currentBalance($from_user_id)['balance'];

    if ($toCustomerData==false) {
      $_SESSION['errors']['username'] = "To account not exists!";
    }
    if ($fromAccountBalance-$transaction_amount<0) {
      $_SESSION['errors']['InsufficientBalance'] = "Insufficient Balance!";
    }

    if ($_SESSION['errors']==null) {
      $transfer = transfer($from_user_id, $toCustomerData['customer_id'], $transaction_amount);

      if ($transfer) {
        $_SESSION['success'] = "Transfer successfull!";
        header("location:activity.php");
      }else{
        $_SESSION['error'] = "Failed to create account!";
      }
    }
  }
}
?>

<?php require_once 'inc/header.inc.php'; ?>

    <!-- Footer Bar -->
    <?php require_once 'inc/footer_bar.inc.php'; ?>

    <!-- Page Content - Only Page Elements Here-->
    <div class="page-content footer-clear">

        <!-- Page Title-->
        <?php require_once 'inc/page_title.inc.php'; ?>


        <div class="tabs tabs-links" id="tab-group-6">
            <div class="tab-controls bg-transparent mx-3 mb-3">
                <!-- <a class="font-12 rounded-s" data-bs-toggle="collapse" href="#tab-16" aria-expanded="true">To Friends</a> -->
                <a class="font-12 rounded-s" data-bs-toggle="collapse" href="#tab-17" aria-expanded="false">Custom Transfer</a>
                <!-- <a class="font-12 rounded-s" data-bs-toggle="collapse" href="#tab-18" aria-expanded="false">Between Accounts</a> -->
            </div>
            <div class="card card-style">
                <div class="content my-1">
                    <div class="collapse show" id="tab-17" data-bs-parent="#tab-group-6">
                        <form action="" method="post">
                            <div class="form-custom form-label form-icon mt-3">
                                <i class="bi bi-at font-16"></i>
                                <input type="text" name="to_customer_username" class="form-control rounded-xs" id="c2" placeholder="Requested To"/>
                                <label for="c2" class="color-highlight">Transfer To</label>
                                <span>(required)</span>
                            </div>
                            <div class="pb-2"></div>
                            <div class="form-custom form-label form-icon">
                                <i class="bi bi-currency-dollar font-14"></i>
                                <input type="number" name="transaction_amount" class="form-control rounded-xs" id="c32" placeholder="Requested Amount"/>
                                <label for="c32" class="color-highlight">Transfer Amount</label>
                                <span>(required)</span>
                            </div>
                            <div class="pb-2"></div>
                            <button type="submit" class="btn btn-full gradient-highlight rounded-s shadow-bg shadow-bg-xs mt-3 mb-3">Transfer Now</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- End of Page Content-->

    <!-- Off Canvas and Menu Elements-->
    <!-- Always outside the Page Content-->

    <div id="menu-request"  class="offcanvas offcanvas-bottom offcanvas-detached rounded-m">
        <!-- menu-size will be the dimension of your menu. If you set it to smaller than your content it will scroll-->
        <div class="menu-size" style="min-height:290px;">
            <div class="d-flex mx-3 mt-3 py-1">
                <div class="align-self-center">
                    <img src="images/pictures/5s.jpg" alt="img" width="40" class="rounded-s me-2 pe-1">
                </div>
                <div class="align-self-center">
                    <h3 class="mb-n1">Jane Doe</h3>
                    <p class="mb-0 font-11">You've never requested funds from Jane</p>
                </div>
                <div class="align-self-center ms-auto">
                    <a href="#" class="ps-4 shadow-0 me-n2" data-bs-dismiss="offcanvas">
                        <i class="bi bi-x color-red-dark font-26 line-height-xl"></i>
                    </a>
                </div>
            </div>
            <div class="divider divider-margins mt-2 mb-2"></div>
            <div class="content mt-0">
                <div class="pb-3"></div>
                <div class="form-custom form-label form-icon">
                    <i class="bi bi-code-square font-14"></i>
                    <input type="number" class="form-control rounded-xs" id="c43" placeholder="150.00"/>
                    <label for="c43" class="form-label-always-active color-highlight font-11">Amount</label>
                    <span class="font-10">( Currency: USD )</span>
                </div>
                <div class="pb-2"></div>
                <div class="form-custom form-label form-icon mb-3">
                    <i class="bi bi-pencil-fill font-12"></i>
                    <textarea class="form-control rounded-xs" placeholder="Transfer Details" style="height:50px!important;" id="c71"></textarea>
                    <label for="c7" class="color-highlight font-11">Transfer Details</label>
                </div>
                <div class="form-check form-check-custom">
                    <input class="form-check-input" type="checkbox" name="type" value="" id="c2a1">
                    <label class="form-check-label" for="c2a1">I accept the Transfer <a href="#">Terms of Service</a></label>
                    <i class="is-checked color-blue-dark font-14 bi bi-check-circle-fill"></i>
                    <i class="is-unchecked color-blue-dark font-14 bi bi-circle"></i>
                </div>
            </div>
            <a href="#" data-bs-dismiss="offcanvas" class="mx-3 btn btn-full gradient-green shadow-bg shadow-bg-s mb-4">Transfer Funds</a>
        </div>
    </div>

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

    <!-- Notifications Bell -->
    <div id="menu-notifications" data-menu-load="menu-notifications.html"
        class="offcanvas offcanvas-top offcanvas-detached rounded-m">
    </div>


</div>
<!-- End of Page ID-->

<script src="scripts/bootstrap.min.js"></script>
<script src="scripts/custom.js"></script>
</body>