<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>BuyPrepNow</title>
	<?php wp_head(); ?>
</head>
	<body>
<div class="main_white_background">
<header>

  <div class="main_header">
    
    <div class="top_header">
      <img src="<?= get_template_directory_uri() ?>/img/main_logo.png"/>
       <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>

    <div class="main_navbar">
      <div class="navber_items_line">
        <ul>
          <li><a href="../">HOME</a></li>
          <li><a href="../product-page/">PRODUCTS</a></li>
          <li><a href="../payment/">PAYMENT INSTRUCTIONS</a></li>
          <li><a href="../prep-info/">PREP INFO</a></li>
          <li><a href="../contact-us/">CONTACT US</a></li>
        </ul>
        <div class="lines_colors lines_width">
          <span id="line_1"></span>
          <span id="line_2"></span>
          <span id="line_3"></span>
          <span id="line_4"></span>
          <span id="line_5"></span>
          <span id="line_6"></span>
        </div>
      </div>

    <div class="curved">
        <b>SHOPPING CART</br>
        <span><l class="number_produtcs"><l>0</l></l> PREP IN CART</span></b>
        <i class="glyphicon glyphicon-shopping-cart">
            <span></span>
        </i>
    

        <div class="price_lightbox">
          <div class="lines_colors lines_width">
              <span id="line_1"></span>
              <span id="line_2"></span>
              <span id="line_3"></span>
              <span id="line_4"></span>
              <span id="line_5"></span>
              <span id="line_6"></span>
            </div>

            <div class="box_items_buy" id="myList">
              <span class="card_text_tit">Card:</span>
              <ul>

              </ul>
              <div class="total_price_box">
                <h3>Total: $<l class="produtcs_prices3"><span>0</span></l></h3>
              </div>
              <button class="btn checkput_box_btn">
                <span>PROCEED TO CHEKOUT</span>
              </button>
          </div>
        </div>

      </div>
    </div>
    
      <div class="mobile_main_bar">
        <div id="navbar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;">
          <ul class="nav navbar-nav">
              <li><a href="../">HOME</a></li>
              <li><a href="../product-page/">PRODUCTS</a></li>
              <li><a href="../payment/">PAYMENT INSTRUCTIONS</a></li>
              <li><a href="../prep-info/">PREP INFO</a></li>
              <li><a href="./contact-us/">CONTACT US</a></li>
              <li class="dropdown" id='smallitems'>
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">SHOPPING CARD<span class="caret"></span></a>
                <ul class="dropdown-menu">
                </ul>
              </li>
          </ul>
        </div>
      </div>

  </div>

</header>
