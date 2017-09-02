<!DOCTYPE html>
<html>
  <head>
    <title>Miro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
  </head>
  <body>
   
  <div class="main_white_background">
    <header>
      <div class="main_header">
        
        <div class="top_header">
          <img src="img/main_logo.png"/>

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
              <li><a href="#">HOME</a></li>
              <li><a href="#">PRODUCTS</a></li>
              <li><a href="#">PAYMENT INSTRUCTIONS</a></li>
              <li><a href="#">PREP INFO</a></li>
              <li><a href="#">CONTACT US</a></li>
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
            <p>SHOPPING CART</br>
            <span>2 PREP IN CART</span></p>
            <i class="fa fa-opencart cart">
                <span>2</span>
            </i>
          </div>
        </div>
        
          <div class="mobile_main_bar">
            <div id="navbar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;">
              <ul class="nav navbar-nav">
                  <li><a href="#">HOME</a></li>
                  <li><a href="#">PRODUCTS</a></li>
                  <li><a href="#">PAYMENT INSTRUCTIONS</a></li>
                  <li><a href="#">PREP INFO</a></li>
                  <li><a href="#">CONTACT US</a></li>
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">SHOPPING CARD<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                      <li><a href="#">Item 1</a></li>
                      <li><a href="#">Item 2</a></li>
                      <li><a href="#">Item 3</a></li>
                    </ul>
                  </li>
              </ul>
            </div>
          </div>

      </div>
    </header>
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

          <img src="img/main_logo_ll.png" class="link_image_send"/>
      </div>

      <h4 class="facebook_link_contact"><img src="img/facebook_img_white.png"/>You can contact us on facebook</h4>

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
        <div><img src="img/set_down.png"></div>
      </div>

      <div class="container">
        <div class="text_section_contact">
          <h3>Answer:</h3></br>
          <h3>Lorem Ipsum adalah contoh teks atau dummy dalam industri percetakan dan penataan huruf atau typesetting. Lorem Ipsum telah menjadi standar contoh teks sejak tahun 1500an, saat seorang tukang cetak yang tidak dikenal mengambil sebuah kumpulan teks dan mengacaknya untuk menjadi sebuah buku contoh huruf. Ia tidak hanya bertahan selama 5 abad, tapi juga telah beralih ke penataan huruf elektronik, tanpa ada perubahan apapun. Ia mulai dipopulerkan pada tahun 1960 dengan diluncurkannya lembaran-lembaran Letraset yang menggunakan kalimat-kalimat dari Lorem Ipsum, dan seiring munculnya perangkat lunak Desktop Publishing seperti Aldus PageMaker juga memiliki versi Lorem Ipsum. </h3>  
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
  .colored_text_section { width: 100%; background-color: #e6eff9; }
  .colored_text_section h4 { text-align: center; font-size: 28px; color: #54a1d9; padding: 15px 0px; }
  .section_select_button { width: 442px; background: #54a1d9; padding: 0px 0px; margin: auto;     border-top-right-radius: 5em;
    border-bottom-right-radius: 5em; height: 50px; transition: all 500ms; }
  .section_select_button p { text-align: center; margin: 0px; width: 391px; float: left; padding-top: 8px; font-size: 25px; color: white; }
  .section_select_button div { width: 39px; background: white; height: 39px; border-radius: 113px; float: right; margin-right: 7px; margin-top: 5px;     box-shadow: inset 2px 0px 6px 1px rgba(0, 0, 0, 0.5); }
  .section_select_button div img { width: 26px; margin: 10px 7px; }



  footer { position: relative; }
  .image_to_top { position: absolute; right: 5px; top: -50px; }

  .colored_text_section h4 { margin: 0px; }

  @media (max-width: 1199px){
  .contact_section h4 { font-size: 34px; }
}
@media (max-width: 991px){
  .contact_section h4 { font-size: 26px; }
}
@media(max-width: 450px){
  .section_select_button { width: 100%; }
  .section_select_button p { width: 80%; }
}

@media(max-width: 400px){
  .facebook_link_contact {
    width: 279px;
    font-size: 16px;
  }
}

</style>

<footer>
  <div class="image_to_top">
    <p> Back to top <img src="img/to_top.png"> </p>
  </div>
  <div class="footer_layout">

    <div class="bottom_bar">
      <ul>
        <li><a href="#">About Us</a></li>
        <li><a href="#">Support</a></li>
        <li><a href="#">Contact Us</a></li>
      </ul>
    </div>

    <div class="social_media_buttons">
      <ul>
        <li><a href="#"><img src="img/facebook_img.png"/></a></li>
        <li><a href="#"><img src="img/instagram_img.png"/></a></li>
      </ul>
    </div>

    <div class="credit">
      <p>Copyright © 2017 <b>buy</b>prepnow International</p>
    </div>

  </div>
</footer>
  </div>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/custom.js"></script>
  </body>
</html>

