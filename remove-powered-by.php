<?php
/*
Plugin Name: GP Remove Powered By
Plugin URI: http://glot-o-matic.com/gp-remove-powered-by
Description: Remove the "Powered by" line in the footer of GlotPress.
Version: 0.5
Author: GregRoss
Author URI: http://toolstack.com
Tags: glotpress, glotpress plugin 
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

class GP_Remove_Powered_By {
	public $id = 'remove-powered-by';

	public function __construct() {
		wp_register_script( 'remove-powered-by', plugins_url( 'remove-powered-by.js', __FILE__ ), array( 'jquery' ) );
		
		add_action( 'gp_pre_tmpl_load', array( $this, 'gp_pre_tmpl_load' ), 10, 2 );
		add_action( 'gp_footer', array( $this, 'gp_footer' ), 1, 2 );
	}

	public function gp_pre_tmpl_load( $template, $args ) {

		$url = gp_url_public_root();

		if ( is_ssl() ) {
			$url = gp_url_ssl( $url );
		}

		gp_enqueue_script( 'remove-powered-by' );

	}

	public function gp_footer() {
		echo '<span style="display: none;">--GP_RPB_MARKER--</span>&nbsp;';
		
	}
}

// Add an action to WordPress's init hook to setup the plugin.  Don't just setup the plugin here as the GlotPress plugin may not have loaded yet.
add_action( 'gp_init', 'gp_remove_powered_by_init' );

// This function creates the plugin.
function gp_remove_powered_by_init() {
	GLOBAL $gp_remove_powered_by;
	
	$gp_remove_powered_by = new GP_Remove_Powered_By;
}