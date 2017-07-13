<?php
/**
 * @package Custom_Types_Fields
 */
/**
Plugin Name: Custom Types & Fields
Plugin URI: http://www.thegrandunion.com
Description: This plugin allows you to easily create new custom types or add 
custom fields to existing types.
Version: 1.0
Author: David Linnard
Author URI: http://www.davidlinnard.co.uk
License: GPLv2 or later
*/
/*

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

@define('CUSTOMTYPES_VERSION', '0.1');
@define('CUSTOMTYPES_PLUGIN_URL', plugin_dir_url(__FILE__));
@define('CUSTOMTYPES_PLUGIN_PATH', plugin_dir_path(__FILE__));

// Make sure we don't expose any info if called directly
if (!function_exists('add_action')) {
 exit();
}

include_once CUSTOMTYPES_PLUGIN_PATH . 'php/autoload.php';

if ( is_admin ( ) ) {
	include_once CUSTOMTYPES_PLUGIN_PATH . 'php/admin.php';
}


function custom_types_init() 
{
	//load types (look for types.php file in theme directory):
	$types_path = '../' . substr( get_bloginfo( 'template_directory' ), strlen( get_bloginfo( 'url' ) ) + 1 ) . '/types.php';

	if ( file_exists( $types_path ) ) {
		include $types_path;
	} else {
		include CUSTOMTYPES_PLUGIN_PATH . 'types-sample.php';
	}
}

add_action('init', 'custom_types_init');



	
