<?php 
/*
Plugin Name: Sticky WooCommerce Header Cart
Plugin URI: https://xpertdeveloperz.com/woo-header-sticky-cart
Description: This plugin activates Woo Commerce sticky cart header once user scroll down on single product detail page. 
Version: 1.0
Author: Xpert Developers
Author URI: https://xpertdeveloperz.com
Text Domain: https://xpertdeveloperz.com
*/


/**
* Get Scripts files 
**/
require_once('inc/swhc-scripts.php');

/**
* Add Setting Page Submenu
*/
if( !function_exists('swhc_add_submenu_page') ){
	
function swhc_add_submenu_page() {
	add_submenu_page( 
		'options-general.php', 
		'Sticky WooCommerce Header Cart by XpertDeveloperz', 
		'Sticky WooCommerce Header Cart', 
		'manage_options',  
		'swhc_setting', 
		'swhc_settings_callback' 
	);
}
}
add_action( 'admin_menu', 'swhc_add_submenu_page' );


/**
* Design Setting Page
**/
if( !function_exists('swhc_settings_callback') ){
function swhc_settings_callback(){ ?>
<div class="wrap">
<h1>Sticky WooCommerce Header Cart - Xpert Developerz</h1>

<form method="post" action="options.php" id="swhc_option_form">
    <?php settings_fields( 'swhc-plugin-settings-group' ); ?>
    <?php do_settings_sections( 'swhc-plugin-settings-group' ); ?>

	<table class="form-table">
		<tr>
			<td class="left-col">
			<!-- Wrapper One Start -->
				<div id="postimagediv" class="postbox">    
					<a class="header" >
						<span id="poststuff"> 
							<h2 class="hndle">Main Settings</h2>
						</span>
					</a>

						<div class="inside">
							<table class="form-table">
                            
							<p><strong>Woo Sticky Header Cart adds sticky header with cart options. A row to top header will be added with a thumbnail, title, quantity and add to cart button.</strong></p>

<p><strong>There is no need to add any code on your theme core file. Just install and activate it. </strong></p>

<strong><a href="https://xpertdeveloperz.com/" target="_blank">By Xpert Developerz</a></strong>
								
							</table>
						</div>
			
				</div>
				<!-- Wrapper One end -->
				


			</td>
			<!--<td class="right-col">
				<h2>How to Use?</h2>
				
				

			</td>-->
		</tr>
	</table>
	
    <?php swhc_ajax_save_btn(); ?>
	
</form>
</div>



<?php }
}

/*
* Register settings fields to database
*/
if( !function_exists('register_swhc_plugin_settings') ){
function register_swhc_plugin_settings() {
	
	// wrapper one option data 
	register_setting( 'swhc-plugin-settings-group', 'swhc_wrapper_class' );
	register_setting( 'swhc-plugin-settings-group', 'swhc_load_class' );
	register_setting( 'swhc-plugin-settings-group', 'swhc_item_show' );
	register_setting( 'swhc-plugin-settings-group', 'swhc_item_load' );
	register_setting( 'swhc-plugin-settings-group', 'swhc_load_label' );
	register_setting( 'swhc-plugin-settings-group', 'swhc_item_pagination' );
	register_setting( 'swhc-plugin-settings-group', 'asr_swhc_css_class' );
	
	
}
}
add_action( 'admin_init', 'register_swhc_plugin_settings' );

/**
 * Adds plugin action links.
 *
 * @since 1.0.0
 * @version 4.0.0
 */
 if( !function_exists('swhc_plugin_action_links') ){
function swhc_plugin_action_links( $links ) {
	$plugin_links = array(
		'<a href="options-general.php?page=swhc_setting">' . esc_html__( 'Settings', 'swhc' ) . '</a>',
	);
	return array_merge( $plugin_links, $links );
}
 }
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'swhc_plugin_action_links' );