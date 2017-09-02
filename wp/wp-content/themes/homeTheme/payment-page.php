<?php
/**
  Template Name: Payment page
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

    <div class="container">
      <div class="content_text">

        <div class="main_title_text">
          <h2>PAYMENT INSTRUCTIONS</h2>
          <div class="lines_colors lines_width">
            <span id="line_1"></span>
            <span id="line_2"></span>
            <span id="line_3"></span>
            <span id="line_4"></span>
            <span id="line_5"></span>
            <span id="line_6"></span>
          </div>
        </div>
        
        <div class="main_content_text">
         <p><b>Using the Exchange 4 Free Payment Portal </br>Once you have completed uploading the documents necessary for your purchase you will be ready to start the payment process.</b></p>

        <p><b>Please click on the “Process My Payment” button. You will then be taken to the Exchange4Free payment gateway so that the U.S. dollar amount can be converted to your local currency and you can complete your payment.</br>

        Here you will need to complete your information before being given the local currency amount to pay :</br>
        Country paying from – select the country where you are living.</br>
        Payer type – select individual</br>
        First Name – enter your first name</br>
        Last Name – enter your last name</br>
        Passport/ID number – enter 0000000</br>
        Payment Method – select either EFT or card transaction</br>
        Transfer Reason – select pay invoice</br>
        Invoice Amount – enter U.S. dollar amount of your invoice</br>
        Payment Reference Type – select Invoice Number</br>

        Payment Reference – insert your order number which is found below the PAY NOW button</br>
        Email Address – insert your email address</br>
        Country – Insert the country where you live</br>
        Mobile number – enter your mobile number (do not enter the ‘0’ at the start of your number)</br>
        </b></p>
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

  <div class="container">
    <div class="contact_section">
      <h4>If you have additional questions CONTACT US</h4>

      <div class="contact_box">
      <img src="<?= get_template_directory_uri() ?>/img/contact_img.png" class="contact_img_png">
        <form method="post" action="#">
          <input type="text" name="name" placeholder="Name" class="form-control">
          <input type="text" name="email" placeholder="Email" class="form-control">
          <textarea name="message" rows="4" placeholder="Write your message" class="form-control"></textarea>
        </form>
      </div>

    </div>
 <?php get_footer(); ?>