<?php
/*
 *
 * This script sets up a global-level settings page.
 *
 */

if ( ! function_exists( 'acf_add_options_page' ) )
	return;

acf_add_options_page( [
	'page_title' => 'Metadata',
	'menu_title' => 'Metadata',
	'menu_slug' => 'metadata',
	'capability' => 'edit_posts',
	'parent_slug' => '',
	'position' => false,
	'icon_url' => 'dashicons-info'
] );
