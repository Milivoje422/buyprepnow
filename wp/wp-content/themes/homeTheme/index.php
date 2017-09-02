<?php
/*

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
<div class="contents_container_body container p-null">
    <div class="slider_top_header">

        <div id="myCarousel" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner sliders_images" role="listbox">
            <div class="item active">
              <img class="d-block img-fluid" src="<?= get_template_directory_uri() ?>/img/slide1.jpg" alt="First slide">

                <div class="slide-caption">
                    <h2>Lorem Ipsum</h2>
                    <p>is simply dummy text of the printing and typesetting industry. 
                        Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and 
                        scrambled it to make a type specimen book.</p>
                    <a href="#" class="btn btn-primary btn-sm btns_">READ MORE</a>
                    <a href="#" class="btn btn-primary btn-sm btns_">ADD TO CART</a>
                </div>

            </div>
            <div class="item">
              <img class="d-block img-fluid" src="<?= get_template_directory_uri() ?>/img/slide1.jpg" alt="Second slide">  

                <div class="slide-caption">
                    <h2>Lorem Ipsum</h2>
                    <p>is simply dummy text of the printing and typesetting industry. 
                        Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and 
                        scrambled it to make a type specimen book.</p>
                    <a href="#" class="btn btn-primary btn-sm btns_">READ MORE</a>
                    <a href="#" class="btn btn-primary btn-sm btns_">ADD TO CART</a>
                </div>

            </div>
            <div class="item">
              <img class="d-block img-fluid" src="<?= get_template_directory_uri() ?>/img/slide1.jpg" alt="Third slide">

              <div class="slide-caption">
                    <h2>Lorem Ipsum</h2>
                    <p>is simply dummy text of the printing and typesetting industry. 
                        Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and 
                        scrambled it to make a type specimen book.</p>
                    <a href="#" class="btn btn-primary btn-sm btns_">READ MORE</a>
                    <a href="#" class="btn btn-primary btn-sm btns_">ADD TO CART</a>
                </div>

            </div>
          </div>
        <!-- Controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <div class="left_switch_slider">
                <span class="glyphicon glyphicon-triangle-left"></span>
            </div>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <div class="right_switch_slider">
                <span class="glyphicon glyphicon-triangle-right"></span>
            </div>
        </a>
        </div>

    </div>



    <!-- Page Content -->
    <div class="container-fluid main-section">
        <!-- Main Section -->
        <div class="row">
            <div class="col-md-6 step-sect">
                <h2 class="heading2">
                buyprepnow online in 3 easy steps:
                </h2>
                <ol class="steps">
                    <li>Select your shipping country below 
    & add products to cart.</li>
                    <li>Checkout.</li>
                    <li>Pay online. </li>
                </ol>
                <a href="#" class="btn btn-primary btn-lg pull-right btn_buy_1 btn_style_big" style="margin-top: -50px;">SHOP NOW</a>
            </div>
            <div class="col-md-6">
                <img src="<?= get_template_directory_uri() ?>/img/sample-img.png" alt="/" style="max-width: 90%;" class="img-responsive m-a-tb-l">
            </div>
            <!-- <div style="width: 100%;"> -->
            <a href="#" class="btn btn-primary btn-lg btn_buy_2" style=" padding: 11px 60px; font-size: 30px; justify-content: center;     width: 40%; margin: auto;">SHOP NOW</a>    
            <!-- </div> -->
        </div>
        <!-- /.row -->
        <!-- Portfolio Section -->
        <div class="row">
            <div class="col-md-12 all-products">
                <div class="jumbotron custom-jumbo">
                  <div class="container-fluid">
                    <div class="col-md-6">
                        <div class="row">
                        <h2 style="color: white; margin-top: 0;">VIEW ALL PRODUCTS</h2>
                        <p>It has survived not only five centuries, 
                but also the leap into electronic typesetting, 
                remaining essentially unchanged. 
                It was popularised in the 1960s with the 
                release of Letraset sheets containing </p>
                        <p><a class="btn btn-primary btn-lg p-m-l" href="#" style="padding: 10px 40px;" role="button">PRODUCTS</a>
                        <a class="btn btn-primary btn-lg p-m-l" href="#" style="padding: 10px 40px;" role="button">BEST SELLER</a></p>
                        </div>
                      </div>
                    <div class="col-md-6">
                    <img src="<?= get_template_directory_uri() ?>/img/sample-img2.png" alt="/" class="img-responsive">
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
        </div>
                    <!-- /.row -->
        <!-- Features Section -->
        <div class="row about-us">
            <div class="col-md-12">
                <h2 class="page-header">About us</h2>
            </div>
            <div class="col-md-12 about">
                <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature.</p>
            </div>
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
<?php get_footer(); ?> 