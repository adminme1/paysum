<?php
require_once '../inc/config.inc.php';
require_once 'header.inc.php';
$transactions = getAllTransactions($_GET['transaction_hash']);
if (empty($transactions) || count($transactions)<1) {
  $_SESSION['error'] = "Invalid transaction hash..";
  header("location:index.php");
}
$transaction = $transactions[0];
?>

          <div class="container-fluid-details">
            <div class="row">
                <div class="col-12 text-center">
                    <h1>Transaction Details</h1>
                </div>
                <!-- <div class="col-5">
                    <div class="container h-100">
                        <div class="d-flex justify-content-center h-100">
                          
                          <div class="searchbar">
                            <input class="search_input" type="text" name="" placeholder="Search For Anything">
                            <a href="#" class="search_icon"><i class="fas fa-search"></i></a>
                          </div>
                        </div>
                      </div>
                </div> -->
            </div>
            <br><br><br>
            <div class="container">
                <div class="row">
                    <div class="col-3">
                        <ul>Transaction Hash</ul>
                        <ul>Timestamp</ul>
                        <!-- <ul>Result</ul> -->
                        <ul>Sender </ul>
                        <ul>To </ul>
                    </div>
                    <div class="col-9">
                        <ul><?=$transaction['transaction_hash']?></ul>
                        <ul><?=$transaction['transaction_date_time']?></ul>
                        <!-- <ul>Success</ul> -->
                        <ul>
                          <?php 
            $fromUser = getUserData($transaction['from_customer_id'])['customer_username'];
            echo substr($fromUser, 0,2)."*****".substr($fromUser, -2);
            ?>
                        </ul>
                        <ul>
                          <?php
            $toUser=getUserData($transaction['to_customer_id'])['customer_username'];
            echo substr($toUser, 0,2)."*****".substr($toUser, -2);
            ?>
                        </ul>
                    </div>
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
  
  
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

</body>
</html>