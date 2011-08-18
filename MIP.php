<?php
/**
 * @package Mercury Internet Project Plugin
 * @version .01
 */
/*
Plugin Name: Mercury Internet Project Plugin
Plugin URI: 
Description: A plugin that removes a markdown link and replaces it with a link javascript can find and add a tooltip to.
Author: Brad Davis
Version: .01
Author URI: http://braddavis.cc/
*/

add_action('wp_footer','footer_tipsy');

function footer_tipsy(){
print "<script>jQuery(document).ready(function(){";
print "jQuery('#product').tipsy({html:true});});</script>";
}

function my_callback($matches){
  $link = 'http://vivid-meadow-496.herokuapp.com//001/products/' . $matches[1];
   $response = file_get_contents($link);  
   $response = json_decode($response);
   
    $return = '<a id="product"';
    $return .= 'title="<b>' . $response[0]->desc;
    $return .= '</b><br> in stock: ' . $response[0]->stock . '"';
    $return .= 'href="' . $link . '">';
    $return .= $matches[2];
    $return .= '</a>';
    return $return;
  }  

function my_the_content_filter($content) {
  $pattern = '/\[id\:(\d+)\]\((\w+\s?\w+\s?\w+)\)/';

  $newcontent = preg_replace_callback($pattern,'my_callback',$content); 

  return $newcontent;


}

add_filter( 'the_content', 'my_the_content_filter' );

function my_init_method() {
    wp_register_script( 'tipsy', WP_PLUGIN_URL . '/MIP/tipsy/jquery.tipsy.js');
    wp_enqueue_script( 'tipsy' );
    wp_register_style('myStyleSheets', WP_PLUGIN_URL . '/MIP/tipsy/tipsy.css');
    wp_enqueue_style( 'myStyleSheets');
}    
 
add_action('init', 'my_init_method');
add_action('init', 'add_my_stylesheet');

function add_my_stylesheet() {
        $myStyleUrl = WP_PLUGIN_URL . '/MIP/tipsy/style.css';
        $myStyleFile = WP_PLUGIN_DIR . '/MIP/tipsy/style.css';
    }

?>
