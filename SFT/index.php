<?php
require_once '../inc/config.inc.php';
require_once 'header.inc.php';
$transactions = getAllTransactions();

?>

<?php 
if (isset($_SESSION['error'])) {
  echo "<div class='alert alert-danger'><b>".$_SESSION['error']."</b></div>";
  unset($_SESSION['error']);
}
?>
          
          


<div class="container mt-5">
  

<div class="col-md-12">
    <div class="row ">
        <div class="col-xl-3 col-lg-6">
            <div class="card l-bg-cherry">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large"></div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0">Pool Balance</h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0">
                                3,243
                            </h2>
                        </div>
                        <!-- <div class="col-4 text-right">
                            <span>12.5% <i class="fa fa-arrow-up"></i></span>
                        </div> -->
                    </div>
                    <div class="progress mt-1 " data-height="8" style="height: 8px;">
                        <div class="progress-bar l-bg-cyan" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card l-bg-blue-dark">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large"></div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0">Total Fund</h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0">
                                15.07k
                            </h2>
                        </div>
                        <!-- <div class="col-4 text-right">
                            <span>9.23% <i class="fa fa-arrow-up"></i></span>
                        </div> -->
                    </div>
                    <div class="progress mt-1 " data-height="8" style="height: 8px;">
                        <div class="progress-bar l-bg-green" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card l-bg-green-dark">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large"></div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0">Amount Sent Today</h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0">
                                578
                            </h2>
                        </div>
                        <!-- <div class="col-4 text-right">
                            <span>10% <i class="fa fa-arrow-up"></i></span>
                        </div> -->
                    </div>
                    <div class="progress mt-1 " data-height="8" style="height: 8px;">
                        <div class="progress-bar l-bg-orange" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card l-bg-orange-dark">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large"></div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0">Received Today</h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0">
                                $11.61k
                            </h2>
                        </div>
                        <!-- <div class="col-4 text-right">
                            <span>2.5% <i class="fa fa-arrow-up"></i></span>
                        </div> -->
                    </div>
                    <div class="progress mt-1 " data-height="8" style="height: 8px;">
                        <div class="progress-bar l-bg-cyan" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<div class="container">
    <table class="table" id="example">
        <thead>
          <tr>
            <th scope="col" >#</th>
            <th scope="col">Hash</th>
            <th scope="col">Time</th>
            <th scope="col">From</th>
            <th scope="col">To</th>
            <th scope="col">Amount(USD)</th>
            <th scope="col">Confirmation</th>
          </tr>
        </thead>
        <tbody>
        <?php $i=0; foreach ($transactions as $transaction) {
        $transaction_hash = $transaction['transaction_hash'];
        ?>
          <tr>
            <th scope="row"><?=++$i?></th>
            <td><a href="details.php?transaction_hash=<?=$transaction_hash?>">Hash View</a></td>
            <td><?=$transaction['transaction_date_time']?></td>
            <td><?php 
            $fromUser = getUserData($transaction['from_customer_id'])['customer_username'];
            echo substr($fromUser, 0,2)."*****".substr($fromUser, -2);
            ?></td>
            <td><?php
            $toUser=getUserData($transaction['to_customer_id'])['customer_username'];
            echo substr($toUser, 0,2)."*****".substr($toUser, -2);
            ?></td>
            <td>
              <?php
              $usdRate = convertPriceRate($transaction['transaction_amount'], $transaction['transaction_amount_type']);
              echo "$".$usdRate['amount'];
            ?>
              
            </td>
            <td>Success</td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
</div>
</div>


</div>




</div>
<!-- Footer -->
<footer class="bg-light text-center ">
  <!-- Grid container -->
  <div class="container p-4">

    <!-- Section: Social media -->
    <section class="mb-4">
      <!-- Facebook -->
      <a class="btn btn-primary btn-floating m-1" style="background-color: #3b5998" href="#!" role="button"><i class="fab fa-facebook-f"></i></a>

      <!-- Twitter -->
      <a class="btn btn-primary btn-floating m-1" style="background-color: #55acee" href="#!" role="button"><i class="fab fa-twitter"></i></a>

      <!-- Google -->
      <a class="btn btn-primary btn-floating m-1" style="background-color: #dd4b39" href="#!" role="button"><i class="fab fa-google"></i></a>

      <!-- Instagram -->
      <a class="btn btn-primary btn-floating m-1" style="background-color: #ac2bac" href="#!" role="button"><i class="fab fa-instagram"></i></a>

      <!-- Linkedin -->
      <a class="btn btn-primary btn-floating m-1" style="background-color: #0082ca" href="#!" role="button"><i class="fab fa-linkedin-in"></i></a>
      <!-- Github -->
      <a class="btn btn-primary btn-floating m-1" style="background-color: #333333" href="#!" role="button"><i class="fab fa-github"></i></a>
    </section>
    <!-- Section: Social media -->


    <!-- Section: Form -->
    <section class="">
      <form action="">
        <!--Grid row-->
        <div class="row d-flex justify-content-center">
          <!--Grid column-->
          <div class="col-auto">
            <p class="pt-2">
              <strong>Sign up for our newsletter</strong>
            </p>
          </div>
          <!--Grid column-->

          <!--Grid column-->
          <div class="col-md-5 col-12">
            <!-- Email input -->
            <div class="form-outline mb-4">
              <input type="email" id="form5Example2" class="form-control" />
            </div>
          </div>
          <!--Grid column-->

          <!--Grid column-->
          <div class="col-auto">

            <!-- Submit button -->
            <button type="submit" class="btn btn-primary mb-4">
              Subscribe
            </button>
          </div>
          <!--Grid column-->
        </div>
        <!--Grid row-->
      </form>
    </section>
    <!-- Section: Form -->


    <!-- Section: Text -->
    <section class="mb-4">
      <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt
        distinctio earum repellat quaerat voluptatibus placeat nam,
        commodi optio pariatur est quia magnam eum harum corrupti dicta,
        aliquam sequi voluptate quas.
      </p>
    </section>
    <!-- Section: Text -->


  </div>
  <!-- Grid container -->

  <!-- Copyright -->
  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
    © 2022 Copyright:
    <a class="text-dark" href="#">Crisis Entertainment</a>
  </div>
  <!-- Copyright -->

</footer>
<!-- Footer -->
<script type="text/javascript">
  $(document).ready(function () {
      $('#example').DataTable({
        searching:false
      });
  })

</script>

    <!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>
</html>