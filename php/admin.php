<?php
/**
 * @package CustomTypesFields
 */
/**
 * admin.php
 * Initialising admin functionality for the plugin
 * 
 * PHP version 5.2
 *
 *
 * @author     David Linnard (www.davidlinnard.com)
 * @copyright  2011 Grand Union (www.thegrandunion.com)
 * @version	   1.0
 * @created	   14/10/11
 */
 

function custom_types_admin_init() 
{
	global $wp_version;
	
	// all admin functions are disabled in old versions
	if ( version_compare( $wp_version , '3.0' , '<' ) ) {

		function custom_types_version_warning( ) 
		{
			echo '<div id="customtypes-warning" class="updated"><p><strong>'.
			'Custom Types requires WordPress 3.0 or higher.'.
			'</strong></p></div>';
		}
		add_action( 'admin_notices' , 'custom_types_version_warning' ); 
		
		return; 
	}
    
	//additional init will be needed in the admin for any custom fields/types:
	$wordpress_types = Wordpress_Type::get_types( );
   
	if ( count( $wordpress_types ) ) {
		foreach ( $wordpress_types as $wordpress_type ) {
			//registering how each field will be displayed:
			foreach ( $wordpress_type->get_sections() as $section ) {
				add_meta_box("{$section->get_name()}-meta", $section->get_title(), "write_section", $wordpress_type->get_name(), 
					$section->get_context(), $section->get_priority(), array($section)
				);
			}
		}
        
		//if we have custom fields or types, we need to make sure we save them:
		add_action( 'save_post' , 'custom_save' );
	}

	//Registering custom CSS and javascript:
	wp_register_style( 'customtypes.css' , CUSTOMTYPES_PLUGIN_URL . 'css/customtypes.css' );
	wp_enqueue_style( 'customtypes.css' );
	wp_register_script( 'customtypes.js' , CUSTOMTYPES_PLUGIN_URL . 'js/customtypes.js' , array( 'jquery' ) );
	wp_enqueue_script( 'customtypes.js' );
	
    wp_enqueue_script( 'thickbox' , null , array( 'jquery' ) );
    wp_enqueue_style( 'thickbox.css' , '/' . WPINC . '/js/thickbox/thickbox.css' , null , '1.0' );
	

}


add_action( 'admin_init', 'custom_types_admin_init' );


/**
* Helper functions below are used as the Wordpress hooks. Anonymous functions don't seem to work so I've created 
* these here
*/
 

/**
* generating each section's HTML
*/
function write_section( )
{
	$call_details = func_get_arg( 1 );//argument @ 1 are the sections to be shown (sections are the field groupings)
	$section = $call_details [ 'args' ][ 0 ];
	$section->generate_HTML( );
}


/**
* Saving form submissions:
*/
function custom_save( )
{
	$wordpress_types = Wordpress_Type::get_types() ;

	foreach ( $wordpress_types as $type ) {
		$type->save_data( $_POST );
	}
}




