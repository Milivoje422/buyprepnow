<?php 

function styles_files_all_theme() { 
wp_enqueue_style('mobileStyle', get_template_directory_uri() . '/css/jquery.mobile-1.4.5.min.css', array(), '1.0.0', 'all');
wp_enqueue_style('bootstrap_min', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '1.0.0', 'all');
wp_enqueue_style('custom_style', get_template_directory_uri() . '/css/main.css', array(), '1.0.0', 'all');


wp_enqueue_script('jquery_min', get_template_directory_uri(). '/js/jquery.min.js', array(), '1.0.0', false);
wp_enqueue_script('jquery-ui', get_template_directory_uri(). '/js/jquery-ui.min.js', array(), '1.0.0', true);
wp_enqueue_script('jquery_mobile', get_template_directory_uri(). '/js/jquery.mobile-1.4.5.min.js', array(), '1.0.0', true);
wp_enqueue_script('bootstrap', get_template_directory_uri(). '/js/bootstrap.min.js', array(), '1.0.0', true);
wp_enqueue_script('swipe_js', get_template_directory_uri(). '/js/swipe.min.js', array(), '1.0.0', false);
wp_enqueue_script('moneyjs', get_template_directory_uri(). '/js/money.js', array(), '1.0.0', true);
wp_enqueue_script('customjs', get_template_directory_uri(). '/js/custom.js', array(), '1.0.0', true);

}
add_action('wp_enqueue_scripts', 'styles_files_all_theme');

function scripts_files_all_theme() {
	
}
?>

