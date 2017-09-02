<?php
/*
Template Name: Contact Page
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
	
   <div class="container">

      <div class="contact_box">
        <div class="contact_section">
          <h4>IF YOU HAVE ADDITIONAL QUESTIONS CONTACT US</h4>
          <div class="lines_colors lines_width">
            <span id="line_1"></span>
            <span id="line_2"></span>
            <span id="line_3"></span>
            <span id="line_4"></span>
            <span id="line_5"></span>
            <span id="line_6"></span>
          </div>   
        </div>
 
        <form method="post" action="#">
          <input type="text" name="name" placeholder="Name" class="form-control">
          <input type="text" name="email" placeholder="Email" class="form-control">
          <textarea name="message" rows="4" placeholder="Write your message" class="form-control"></textarea>
        </form>

          <img src="<?= get_template_directory_uri() ?>/img/main_logo_ll.png" class="link_image_send"/>
      </div>

      <h4 class="facebook_link_contact"><img src="<?= get_template_directory_uri() ?>/img/facebook_img_white.png"/>You can contact us on facebook</h4>

    </div>

    <div class="lines_colors lines_width">
      <span id="line_1"></span>
      <span id="line_2"></span>
      <span id="line_3"></span>
      <span id="line_4"></span>
      <span id="line_5"></span>
      <span id="line_6"></span>
    </div>    

    <div class="colored_text_section">
      <h4>REQUENTLY ASKED QUESTIONS</h4>
      <div class="section_select_button">
        <p>SELECT QUESTION</p>
        <div><img src="<?= get_template_directory_uri() ?>/img/set_down.png"></div>
      </div>

      <div class="container">
        <div class="text_section_contact">
          <h2>Answer:</h2></br>
          <h3>
              Lorem Ipsum adalah contoh teks atau dummy dalam industri percetakan dan penatan huruf atau typesetting. Lorem Ipsum telah menjadi standar contoh teks sejak tahun 1500an, saat seorang tukang cetak yang tidak dikenal mengambil sebuah kumpulan teks dan mengacaknya untuk menjadi sebuah buku contoh huruf. Ia tidak hanya bertahan selama 5 abad, tapi juga telah beralih ke penataan huruf elektronik, tanpa ada perubahan apapun. Ia mulai dipopulerkan pada tahun 1960 dengan diluncurkannya lembaran-lembaran Letraset yang menggunakan kalimat-kalimat dari Lorem Ipsum, dan seiring munculnya perangkat lunak Desktop Publishing seperti Aldus PageMaker juga memiliki versi Lorem Ipsum. 
          </h3>  
        </div>
      </div>
    
      <div class="container">
        <div class="rate_section">
          <center><h3>RATE OUR CUSTOMER SUPPORT</h3></center>
          <img src="<?= get_template_directory_uri() ?>/img/rating_stars.png" class="rating_stars">
        </div>
      </div>

    </div>

<style type="text/css">
 
   .contact_section { margin-bottom: 37px; }
  .contact_section h4 { color: white; font-size: 42px; }
  .contact_box { padding: 80px 25px 1px 25px; }
  .contact_box .link_image_send { width: 95px; margin: 5px auto; display: block; }
  .facebook_link_contact { width: 365px; margin: auto; font-size: 22px; color: #54a1d9; margin-top: 39px; margin-bottom: 23px; }
  .facebook_link_contact img { width: 40px; margin-right: 10px; }
  .colored_text_section { width: 100%; background-color: #e6eff9; margin-bottom: 120px; }
  .colored_text_section h4 { text-align: center; font-size: 28px; color: #54a1d9; padding: 15px 0px; }
  .section_select_button { width: 442px; background: #54a1d9; padding: 0px 0px; margin: auto;     border-top-right-radius: 5em;
    border-bottom-right-radius: 5em; height: 50px; transition: all 500ms; }
  .section_select_button p { text-align: center; margin: 0px; width: 391px; float: left; padding-top: 8px; font-size: 25px; color: white; }
  .section_select_button div { width: 39px; background: white; height: 39px; border-radius: 113px; float: right; margin-right: 7px; margin-top:5px; box-shadow: inset 2px 0px 6px 1px rgba(0, 0, 0, 0.5); }
  .section_select_button div img { width: 26px; margin: 10px 7px; }

  .text_section_contact h2 { color: #54a1d9; font-size: 24px; font-weight: 600; margin-bottom: 0px; }
  .text_section_contact h3 { color: #54a1d9; font-size: 20px; margin-bottom: 45px; line-height: 1.4; margin-top: 0px; }

  .rate_section { margin-bottom: 30px; }
  .rate_section img { margin:auto; display:flex; }



  footer { position: relative; }
  .image_to_top { position: absolute; right: 5px; top: -50px; }

  .colored_text_section h4 { margin: 0px;  }

  @media (max-width: 1199px){
  .contact_section h4 { font-size: 34px; }
}
@media (max-width: 991px){
  .contact_section h4 { font-size: 26px; }
}
@media(max-width: 450px){
  .section_select_button { width: 100%; }
  .section_select_button p { width: 80%; }
  .text_section_contact h3 { font-size: 17px; }
}

@media(max-width: 400px){
  .facebook_link_contact {
    width: 279px;
    font-size: 16px;
  }
}
@media(max-width: 365px){
  .rate_section img { width: 100%; }
}

</style>

<?php get_footer(); ?> 