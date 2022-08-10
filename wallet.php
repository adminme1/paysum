<?php
require_once 'inc/config.inc.php';

if (!isset($_SESSION['loggedIn']) && !isset($_SESSION['userData'])) {
    header("location: login.php");
    exit();
}

$title = "Wallet";
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
                <div class="card-top p-3">
                    <a href="#" data-bs-toggle="offcanvas" data-bs-target="#menu-card-more" class="icon icon-xxs bg-white color-black float-end"><i class="bi bi-three-dots font-18"></i></a>
                </div>
                <div class="card-center">
                    <div class="bg-theme px-3 py-2 rounded-end d-inline-block">
                        <h1 class="font-13 my-n1">
                            <a class="color-theme" data-bs-toggle="collapse" href="#balance1" aria-controls="balance1">Click for Balance</a>
                        </h1>
                        <div class="collapse" id="balance1"><h2 class="color-theme font-26">$65,500</h2></div>
                    </div>
                </div>
                <strong class="card-top no-click font-12 p-3 color-white font-monospace">Company Account</strong>
                <strong class="card-bottom no-click p-3 text-start color-white font-monospace">1234 5678 1234 5661</strong>
                <strong class="card-bottom no-click p-3 text-end color-white font-monospace">08 / 2025</strong>
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
                        <div class="form-custom form-label form-icon mt-3">
                            <i class="bi bi-currency-dollar font-16"></i>
                            <input type="text" name="to_customer_username" class="form-control rounded-xs" id="c2" placeholder="Deposit Amount"/>
                            <label for="c2" class="color-highlight">Deposit Amount</label>
                            <span>(required)</span>
                        </div>
                        <div class="pb-2"></div>
                        <div class="form-custom form-label form-icon mt-3">
                            <i class="bi bi-caret-up-fill font-16"></i>
                            <select class="form-select">
                                <option>pAccount</option>
                                <option>bKash</option>
                                <option>Bank</option>
                            </select>
                        </div>

                    </div>

                    <div class="collapse" id="tab-7" data-bs-parent="#tab-group-2">
                        
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
                            <a href="#" class="list-group-item">
                                <i class="has-bg gradient-green color-white rounded-xs bi bi-cash-coin"></i>
                                <div><strong>Savings</strong><span>14  Transactions</span></div>
                                <span class="badge bg-transparent color-theme text-end font-15">
                                   $414<br>
                                   <em class="fst-normal font-12 opacity-30">13.5%</em>
                                </span>
                            </a>
                            <a href="#" class="list-group-item">
                                <i class="has-bg gradient-yellow color-white rounded-xs bi bi-droplet"></i>
                                <div><strong>Utilities</strong><span>11 Transactions</span></div>
                                <span class="badge bg-transparent color-theme text-end font-15">
                                    $631<br>
                                    <em class="fst-normal font-12 opacity-30">20.3%</em>
                                </span>
                            </a>
                            <a href="#" class="list-group-item">
                                <i class="has-bg gradient-blue color-white rounded-xs bi bi-bag"></i>
                                <div><strong>Shopping</strong><span>23 Transactions</span></div>
                                <span class="badge bg-transparent color-theme text-end font-15">
                                    $950<br>
                                    <em class="fst-normal font-12 opacity-30">45.7%</em>
                                </span>
                            </a>
                            <a href="#" class="list-group-item">
                                <i class="has-bg gradient-red color-white rounded-xs bi bi-gear"></i>
                                <div><strong>Construction</strong><span>34 Transactions</span></div>
                                <span class="badge bg-transparent color-theme text-end font-15">
                                    $315<br>
                                    <em class="fst-normal font-12 opacity-30">19.5%</em>
                                </span>
                            </a>
                            <a href="#" class="list-group-item">
                                <i class="has-bg gradient-magenta color-white rounded-xs bi bi-shuffle"></i>
                                <div><strong>Other Costs</strong><span>15 Transactions</span></div>
                                <span class="badge bg-transparent color-theme text-end font-15">
                                    $530<br>
                                    <em class="fst-normal font-12 opacity-30">35.5%</em>
                                </span>
                            </a>
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

    <!-- Add Card -->
    <div id="menu-add-card"
        data-menu-load="menu-add-card.html"
        class="offcanvas offcanvas-bottom offcanvas-detached rounded-m">
    </div>
    
    <!-- Menu Card More -->
    <div id="menu-card-more"
        data-menu-load="menu-card-settings.html"
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