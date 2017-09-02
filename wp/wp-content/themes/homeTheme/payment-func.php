<?php
/**
  Template Name: Payments
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

 get_header(); ?>
  <?php 
    if(isset($_POST['submit'])){ ?>
    <div class="container">
      <div class="content_text">

        <div style="width: 178px;">
          <h2>PAYMENTS</h2>
          <div class="lines_colors lines_width">
            <span id="line_1"></span>
            <span id="line_2"></span>
            <span id="line_3"></span>
            <span id="line_4"></span>
            <span id="line_5"></span>
            <span id="line_6"></span>
          </div>
        </div>
        
       
<?php
          $ammount = $_POST['price'] + $_POST['provision'];
          // $ammount1 = ;
                  // print_r($ammount1);
        define('MERCHANTID', 26684);
        define('SECRETCODE', "w6JNm43HyYa7s9X8ZtGn5p9B8EgRj6k3P4LbFq57"); 

        // Include the API
          require_once('icepay_api/icepay-2.5.3/src/icepay_api_basic.php');

        /* Apply logging rules */
        $logger = Icepay_Api_Logger::getInstance();
        $logger->enableLogging()
                ->setLoggingLevel(Icepay_Api_Logger::LEVEL_ALL)
                ->logToFile()
                ->setLoggingDirectory(realpath("../logs"))
                ->setLoggingFile("basicmode.txt")
                ->logToScreen();

        /* Set the paymentObject */
        $paymentObj = new Icepay_PaymentObject();
        $paymentObj->setAmount(number_format($ammount, 2))
                    ->setCountry("US")
                    ->setLanguage("EN")
                    ->setReference("My Sample Website")
                    ->setDescription("My Sample Payment")
                    ->setCurrency("EUR")
                    ->setOrderID(rand());

        try {
            // Merchant Settings
            $basicmode = Icepay_Basicmode::getInstance();
            $basicmode->setMerchantID(MERCHANTID)
                    ->setSecretCode(SECRETCODE)
                    ->validatePayment($paymentObj);

         } catch (Exception $e){
            echo($e->getMessage());
        }
        ?>




    <div class="item_box_area" style="    
    padding-top: 50px;
    position: relative;
    bottom: 50px;">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
          <div class="col-sm-6">
            <img src="<?= get_template_directory_uri() ?>/img/product_ms_img.png" class="img-responsive">
          </div>
          <div class="col-sm-6">

          <div style="width: 100%;">

            <p>Product price: <b>$ <?= $_POST['price'].'.00';?></b><p>
            <p>Deliver price: <b>$ <?= $_POST['provision'].'.00'; ?></b><p>
            <p>Total price: <b>$ <?= $ammount ?>.00</b></p>
            
          </div>
          <div>
            <a href="<?= $basicmode->getURL() ?>" class="btn btn-success">Pay Here</a>
          </div>

        </div>
       </div>
      <div class="col-sm-2"></div>
    </div>

      </div>
    </div>




    <div class="lines_colors lines_width">
      <span id="line_1"></span>
      <span id="line_2"></span>
      <span id="line_3"></span>
      <span id="line_4"></span>
      <span id="line_5"></span>
      <span id="line_6"></span>
    </div>       

    </div>
    <?php }else { ?>

    <div style="height:500px;
    width: 100%;">
      <center>
      <h2>
      Page is not available!
      </h2>
      </center>
    </div>


    <?php } ?>
 <?php get_footer(); ?>