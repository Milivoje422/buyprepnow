<?php
/*
Template Name: Prep Info Page
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
	
<div class="front_section_per_info_top">
	<div class="container" style="position: relative; height: 100%;">
		<div class="product_description">
			<div class="product_title">
				<h3>PRODUCT NAME</h3>
				<div class="lines_colors lines_width">
				    <span id="line_1"></span>
				    <span id="line_2"></span>
				    <span id="line_3"></span>
				    <span id="line_4"></span>
				    <span id="line_5"></span>
				    <span id="line_6"></span>
				</div>
			</div>
			<div class="product_desc1">
				<p>
					Contrary to popular belief, Lorem Ipsum is 
					not simply random text. It has roots in a 
					piece of classical Latin literature from 45 
					BC, making it over 2000 years old. Richard 
					McClintock, a Latin professor...
				</p>
			</div>
			<button class="product_info_btn btn btn_style_big btn_style_">
				<span>Read More</span>
			</button>
		</div>

		<button class="buy_now_per_info btn btn_style_big btn_style_"><span class="glyphicon glyphicon-shopping-cart"></span> BUY NOW</button>
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
<div class="product_main_section">
	<div class="container" style="position: relative;">
		<div class="dest_product">
			<h3>PRODUCT NAME</h3>
			<p>It has survived not only five centuries, It has survived not only five centuries, but also the leap into electronic typesetting, It has survived</p>
			<p>It has survived not only five centuries, It has survived not only five centuries, but also the leap into electronic typesetting, It has survived not only five centuries, It has survived not only five centuries, </p>
			<p id="last_in_arr">It has survived not only five centuries, It has survived not only five centuries, but also the leap into electronic typesetting, It has survived not only five centuries, It has survived not only five centuries, </p>
		</div>

		<div class="product_image_ms">
			<img src="<?= get_template_directory_uri() ?>/img/product_ms_img.png">
		</div>



	</div>
</div>
<div class="buttins_nav_section">
<button class="btn btn_style_big btn_style_">BUY NOW</button>
<button class="btn btn_style_big btn_style_">HOW TO BUY</button>
<button class="btn btn_style_big btn_style_">PRODUCTS</button>
</div>
<div id="myCarousel" class="carousel slide custom-carousel">

	<div class="carousel-inner wrap slides_ slider_box_height">
		<div class="item review active text-center items_style">
			<h3>customers reviews</h3>
		</div>
		<div class="item review text-center items_style">
			<h3>customers reviews</h3>
		</div>
		<div class="item review text-center items_style">
			<h3>customers reviews</h3>
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
<div class="last_section_stars">
	<div class="stars text-center">
		<i class="glyphicon glyphicon-star"></i>
		<i class="glyphicon glyphicon-star"></i>
		<i class="glyphicon glyphicon-star"></i>
		<i class="glyphicon glyphicon-star"></i>
		<i class="glyphicon glyphicon-star"></i>
	</div>
	<blockquote>
		<p>"Awesome product! Best product on market. WOW!"</p>
	</blockquote>
</div>








<?php get_footer(); ?> 