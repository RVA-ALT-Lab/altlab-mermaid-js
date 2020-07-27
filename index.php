<?php
/**
 * Plugin Name: ALT LAB - Mermaid flow chart
 * Plugin URI: https://github.com/woodwardtw/
 * Description: loads the mermaid flowchart css and js and loads whatever is in #

 * Version: 1.7
 * Author: Tom Woodward
 * Author URI: http://bionicteaching.com
 * License: GPL2
 */
 
 /*   2016 Tom  (email : bionicteaching@gmail.com)
 
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.
 
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
 
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
 
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


function mermaid_load_scripts(){
    wp_enqueue_style( 'mermaid-css', 'https://cdnjs.cloudflare.com/ajax/libs/mermaid/6.0.0/mermaid.css' );
    wp_enqueue_script('mermaid-js', 'https://cdnjs.cloudflare.com/ajax/libs/mermaid/6.0.0/mermaid.js', null, 1, true);
    wp_enqueue_script('mermaid-basic',  plugin_dir_url( __FILE__ ) . 'js/mermaid-basic.js', 'mermaid-js', 1, true);
}
      
add_action('wp_enqueue_scripts', 'mermaid_load_scripts');



 add_filter( 'the_content', 'write_mermaid_data' ); 
 
 function write_mermaid_data( $content ) { 
    $post_id = get_the_ID(); 
    if (  get_post_meta($post_id, 'mermaid', true)) {
        $mermaid_data = get_post_meta($post_id, 'mermaid', true);

        $content =  '<div class="mermaid">' . $mermaid_data . '</div>' . $content; // puts above content . . . . 
        
        }

    return $content;
}


//takes submitter to the post create on submissions that create posts if set to redirect (regardless of destination)
add_action('gform_after_submission', 'alt_gform_redirect_on_post', 10, 2);
function alt_gform_redirect_on_post($entry, $form) {
    if($form["confirmation"]["type"] === 'redirect'){
        $post_id = $entry['post_id'];
        $url = get_site_url() . "/?p=" . $post_id;
        wp_redirect($url);
        exit;
    }
    
}
