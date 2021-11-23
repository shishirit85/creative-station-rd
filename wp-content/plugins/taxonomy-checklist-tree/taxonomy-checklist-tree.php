<?php
/*
Plugin Name: Taxonomy Checklist Tree
Plugin URI: http://wordpress.org/plugins/taxonomy-checklist-tree/
Description: Plugin sets hierarchical view for category and taxonomy checklist tree.
Version: 1.1
Author: webvitaly
Text Domain: taxonomy-checklist-tree
Author URI: http://web-profile.net/wordpress/plugins/
License: GPLv3
*/


if ( ! defined( 'ABSPATH' ) ) { // prevent full path disclosure
	exit;
}


class Taxonomy_Checklist_Tree {

	public static function init() {
		add_filter( 'wp_terms_checklist_args', array( __CLASS__, 'taxonomy_checklist_args' ), 1, 2 );
		add_filter( 'plugin_row_meta', array( __CLASS__, 'plugin_row_meta' ), 10, 2 );
	}


	public static function taxonomy_checklist_args( $args, $post_id ) {
		//if ( get_post_type( $post_id ) == 'post' && $args['taxonomy'] == 'category' ) {
		$args['checked_ontop'] = false;
		//}
		return $args;
	}


	public static function plugin_row_meta( $links, $file ) {
		if ( $file == plugin_basename( __FILE__ ) ) {
			$row_meta = array(
				'support' => '<a href="http://web-profile.net/wordpress/plugins/taxonomy-checklist-tree/" target="_blank">' . __( 'Taxonomy Checklist Tree', 'taxonomy-checklist-tree' ) . '</a>',
				'donate' => '<a href="http://web-profile.net/donate/" target="_blank">' . __( 'Donate', 'taxonomy-checklist-tree' ) . '</a>'
			);
			return array_merge( $links, $row_meta );
		}
		return (array) $links;
	}

}


Taxonomy_Checklist_Tree::init();

