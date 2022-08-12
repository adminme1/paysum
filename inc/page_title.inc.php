<div class="pt-3">
    <div class="page-title d-flex">
        <div class="align-self-center me-auto">
            <p class="color-highlight">Hello there!</p>
            <h1 class="color-theme"><?php if (isset($title)) {
                echo $title;
            }else{
                echo "PAYSUM";
            } ?></h1>
        </div>
        <div class="align-self-center ms-auto">
            <a href="#"
            data-bs-toggle="offcanvas"
            data-bs-target="#menu-notifications"
            class="icon gradient-blue color-white shadow-bg shadow-bg-xs rounded-m">
                <i class="bi bi-bell-fill font-17"></i>
                <em class="badge bg-red-dark color-white scale-box">3</em>
            </a>
            <a href="#"
            data-bs-toggle="dropdown"
            class="icon gradient-blue shadow-bg shadow-bg-s rounded-m">
                <img src="images/pictures/user-avatar.png" width="45" class="rounded-m" alt="img">
            </a>
            <!-- Page Title Dropdown Menu-->
            <div class="dropdown-menu">
                <div class="card card-style shadow-m mt-1 me-1">
                    <div class="list-group list-custom list-group-s list-group-flush rounded-xs px-3 py-1">
                        <a href="wallet.php" class="list-group-item">
                            <i class="has-bg gradient-green shadow-bg shadow-bg-xs color-white rounded-xs bi bi-credit-card"></i>
                            <strong class="font-13">Wallet</strong>
                        </a>
                        <a href="activity.php" class="list-group-item">
                            <i class="has-bg gradient-blue shadow-bg shadow-bg-xs color-white rounded-xs bi bi-graph-up"></i>
                            <strong class="font-13">Activity</strong>
                        </a>
                        <a href="profile.php" class="list-group-item">
                            <i class="has-bg gradient-yellow shadow-bg shadow-bg-xs color-white rounded-xs bi bi-person-circle"></i>
                            <strong class="font-13">Account</strong>
                        </a>
                        <a href="logout.php" class="list-group-item">
                            <i class="has-bg gradient-red shadow-bg shadow-bg-xs color-white rounded-xs bi bi-power"></i>
                            <strong class="font-13">Log Out</strong>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>