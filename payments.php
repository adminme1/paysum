<?php
require_once 'inc/config.inc.php';
if (!isset($_SESSION['loggedIn']) && !isset($_SESSION['userData'])) {
    header("location: login.php");
    exit();
}

$title = "Payments";
?>

<?php require_once 'inc/header.inc.php'; ?>

    <!-- Footer Bar -->
    <?php require_once 'inc/footer_bar.inc.php'; ?>

    <!-- Page Content - Only Page Elements Here-->
    <div class="page-content footer-clear">

        <!-- Page Title-->
        <?php require_once 'inc/page_title.inc.php'; ?>

        <div class="row text-center">
            <div class="col-6 mb-n2">
                <a href="payment-transfer.php" class="card card-style me-0" style="height:180px">
                    <div class="card-center">
                        <span class="icon icon-xl rounded-m gradient-blue shadow-bg shadow-bg-xs"><i class="bi bi-arrow-up-circle font-24 color-white"></i></span>
                        <h1 class="font-22 pt-3">Transfer</h1>
                    </div>
                    <div class="card-bottom">
                        <p class="font-11 mb-0 opacity-70">Move and Send</p>
                    </div>
                </a>
            </div>
            <div class="col-6 mb-n2">
                <a href="payment-request.php" class="card card-style ms-0" style="height:180px">
                    <div class="card-center">
                        <span class="icon icon-xl rounded-m gradient-yellow shadow-bg shadow-bg-xs"><i class="bi bi-arrow-down-circle font-24 color-white"></i></span>
                        <h1 class="font-22 pt-3">Request</h1>
                    </div>
                    <div class="card-bottom">
                        <p class="font-11 mb-0 opacity-70">Request or Deposit</p>
                    </div>
                </a>
            </div>
            
			<!-- <div class="col-12 mb-n2 text-start">
				<a href="page-payment-search.html" class="default-link card card-style" style="height:90px">
					<div class="card-center px-4">
						<div class="d-flex">
							<div class="align-self-center">
								<span class="icon icon-m rounded-s gradient-teal shadow-bg shadow-bg-xs"><i class="bi bi-search font-20 color-white"></i></span>
							</div>
							<div class="align-self-center ps-3 ms-1">
								<h1 class="font-20 mb-n1">Search</h1>
								<p class="mb-0 font-12 opacity-70">Filter your Transactions.</p>
							</div>
							<div class="align-self-center ms-auto">
								<span class="badge bg-red-dark line-height-xs font-9 rounded-xl">NEW</span>
							</div>
						</div>
					</div>
				</a>
			</div>
            <div class="col-12 mb-n2 text-start">
                <a href="page-reports.html" class="default-link card card-style" style="height:90px">
                    <div class="card-center px-4">
                        <div class="d-flex">
                            <div class="align-self-center">
                                <span class="icon icon-m rounded-s gradient-brown shadow-bg shadow-bg-xs"><i class="bi bi-bar-chart font-20 color-white"></i></span>
                            </div>
                            <div class="align-self-center ps-3 ms-1">
                                <h1 class="font-20 mb-n1">Account Reports</h1>
                                <p class="mb-0 font-12 opacity-70">See your Payment Statistics.</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div> -->
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

    <!-- Notifications Bell -->
    <div id="menu-notifications" data-menu-load="menu-notifications.html"
        class="offcanvas offcanvas-top offcanvas-detached rounded-m">
    </div>


</div>
<!-- End of Page ID-->

<script src="scripts/bootstrap.min.js"></script>
<script src="scripts/custom.js"></script>
</body>