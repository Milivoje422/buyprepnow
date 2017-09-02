<?php
/*
Template Name: Sigle procudt Page
*/
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage HomeTheme
 * @since Home theme 1.0
 */
?>
<?php get_header(); ?>
	



 <div class="procudt_front_top">
 	<!-- <img src="<?= get_template_directory_uri() ?>/img/background_product.png" class="section_background_image"> -->
 	<div class="product_desc">
	 	<div class="product_desc_lowerBox">
			<div class="product_info_t">
				<h2>PRODUCT NAME</h2>
				<div class="lines_colors lines_width">
			        <span id="line_1"></span>
			        <span id="line_2"></span>
			        <span id="line_3"></span>
			        <span id="line_4"></span>
			        <span id="line_5"></span>
			        <span id="line_6"></span>
			  	</div>
		  	<p>It has survived not only five centuries, It has survived not only five centuries, but also the leap into electronic typesetting, It has survived...</p>

			<div class="form-group">
				<select id="region" class="form-control">
					<option value="">Select Region</option>
					<option value="europe">Europe</option>
					<option value="america">America</option>
					<option value="other">Other</option>
				</select>
			</div>


			<div class="form-group">
				<select id="countries" disabled class="form-control disable">
					<option value="">Select the region first</option>
				</select>
			</div>


			<div class="form-group">
				<select id="currency" disabled class="form-control">
					<option value="">Currency</option>
					<option value="dollar">US. Dollar</option>
					<option value="euro">EU Euro</option>
				</select>
			</div>
			<!-- <div class="dropdown">
				<a class="btn-primary dropdown-toggle down" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					select quantity
					<i class="glyphicon glyphicon-triangle-bottom"></i>
				</a>
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					<li><a href="#">1</a></li>
					<li><a href="#">2</a></li>
					<li><a href="#">3</a></li>
					<li><a href="#">4</a></li>
				</ul>
			</div>
 -->			<span class="price">$<l class="items_">0</l> <l class="number_produtcs" style="display: none;">x<l>0</l></l></span>
								
			</div>
		</div>
			
		<div class="product_list_order">

			<table style="width:100%">
		  <tr>
		    <td><img src="<?= get_template_directory_uri() ?>/img/product_ms_img.png">
		    	<form method="post" action="../payment-page/"><p>$<l name="price_1" class="produtcs_prices">0</l></p>
					<div class="info_buttons_row">
						<button class="add_to_card1 btn btn_style_ btn_style_big aasd_btn" name="submit" value="submit"><span>x1 Checkout</span></button>
					</div>
					<input type="hidden" value="" class="product1Price" name="price">
					<input type="hidden" value="" class="product1Currency" name="currency">
					<input type="hidden" value="" class="product1Provision" name="provision">
					<input type="hidden" value="" class="product1Country" name="country">
				</form>
		    </td>
		    <td><img src="<?= get_template_directory_uri() ?>/img/sample-img.png">
		    	<form method="post" action="../payment-page/"><p>$<l name="price_2" class="produtcs_prices1">0</l></p>
					<div class="info_buttons_row">
						<button class="add_to_card1 btn btn_style_ btn_style_big aasd_btn" name="submit" value="submit"><span>x3 Checkout</span></button>
					</div>
					<input type="hidden" value="" class="product2Price" name="price">
					<input type="hidden" value="" class="product2Currency" name="currency">
					<input type="hidden" value="" class="product2Provision" name="provision">
					<input type="hidden" value="" class="product2Country" name="country">
				</form>
		    </td> 
		    <td><img src="<?= get_template_directory_uri() ?>/img/sample-img2.png">
		    	<form method="post" action="../payment-page/"><p>$<l price="price_3" class="produtcs_prices2">0</l></p>
		    	 	<div class="info_buttons_row">
						<button class="add_to_card1 btn btn_style_ btn_style_big aasd_btn" name="submit" value="submit"><span>x6 Checkout</span></button>
					</div>
					<input type="hidden" value="" class="product3Price" name="price">
					<input type="hidden" value="" class="product3Currency" name="currency">
					<input type="hidden" value="" class="product3Provision" name="provision">
					<input type="hidden" value="" class="product3Country" name="country">
				</form>
		    </td>
		  </tr>
		</table>

		</div>

 	</div>
<!-- 
 	<div class="info_buttons_row">
		<button class="add_to_card btn btn_style_ btn_style_big aasd_btn"><span><i class="glyphicon glyphicon-shopping-cart"></i> Add To Card</span></button>
	</div> -->
	
 </div>

 	<div class="review-section">
		<div id="myCarousel" class="carousel slide custom-carousel">
	
			<div class="carousel-inner wrap slides_">
				<div class="item review active text-center">
					<h3>customers reviews</h3>
					<div class="stars text-center">
						<i class="glyphicon glyphicon-star"></i>
						<i class="glyphicon glyphicon-star"></i>
						<i class="glyphicon glyphicon-star"></i>
						<i class="glyphicon glyphicon-star"></i>
						<i class="glyphicon glyphicon-star"></i>
					</div>
					<blockquote>
						<p>"Awesome product! Best product on market. WOW! Thank you so much"</p>
						<span><strong>New Zeland,</strong> Brendon</span>
					</blockquote>
				</div>
				<div class="item review text-center">
					<h3>customers reviews</h3>
					<div class="stars text-center">
						<i class="glyphicon glyphicon-star"></i>
						<i class="glyphicon glyphicon-star"></i>
						<i class="glyphicon glyphicon-star"></i>
						<i class="glyphicon glyphicon-star"></i>
						<i class="glyphicon glyphicon-star"></i>
					</div>
					<blockquote>
						<p>"Awesome product! Best product on market. WOW! Thank you so much"</p>
						<span><strong>New Zeland,</strong> Brendon</span>
					</blockquote>
				</div>
				<div class="item review text-center">
					<h3>customers reviews</h3>
					<div class="stars text-center">
						<i class="glyphicon glyphicon-star"></i>
						<i class="glyphicon glyphicon-star"></i>
						<i class="glyphicon glyphicon-star"></i>
						<i class="glyphicon glyphicon-star"></i>
						<i class="glyphicon glyphicon-star"></i>
					</div>
					<blockquote>
						<p>"Awesome product! Best product on market. WOW! Thank you so much"</p>
						<span><strong>New Zeland,</strong> Brendon</span>
					</blockquote>
				</div>
			</div>

    		<!-- Controls -->
		    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
		        <div class="left_switch_slider m-l-n">
		            <span class="glyphicon glyphicon-triangle-left"></span>
		        </div>
		    </a>
		    <a class="right carousel-control" href="#myCarousel" data-slide="next">
		        <div class="right_switch_slider m-r-n">
		            <span class="glyphicon glyphicon-triangle-right"></span>
		        </div>
		    </a>

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

	<div class="feedback text-center">
		<a href="#" class="btn btn-primary btn-lg btn_style_big">Write your review</a>
		<p>Share on Facebook <img src="<?= get_template_directory_uri() ?>/img/facebook_img_white.png"></p>
	</div>
</div>



<?php get_footer(); ?> 
