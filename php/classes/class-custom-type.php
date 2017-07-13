<?php
/**
 * @package CustomTypesFields
 */
/**
 * class-custom-type.php
 * Acts as a holder of all sections of custom content types. Keeps track of these to allow 
 * each section to be displayed in the admin 
 * and on the front of site. 
 * 
 * PHP version 5.2
 *
 *
 * @author     David Linnard (www.davidlinnard.com)
 * @copyright  2011 Grand Union (www.thegrandunion.com)
 * @version	   1.0
 * @created	   14/10/11
 */

/**
* Custom_Type class. Acts as a holder of fields for custom content types.
*/


class Custom_Type extends Wordpress_Type
{
	/*object fields*/
	protected $_args;
	protected $_sections;
	
	public function __construct( $name, $singular_name , $plural_name , $args = array( ) )
	{
		parent::__construct( $name );
		
		//additional init needed for the default args:
		$default_args = self::get_default_args( $singular_name, $plural_name );
		if ( count( $args ) ) {
			$this->_args = array_merge( $default_args , $args );	
		} else {
			$this->_args = $default_args;	
		}
		
		$this->_sections = array( );//added later
		
		register_post_type( $this->_name , $this->_args );//registering the type with Wordpress
	}


	public function get_args()
	{
		return $this->_args;
	}



	private static function get_default_args( $singular_name , $plural_name )
	{
		$labels = array(
			'name' => _x( $plural_name , 'post type general name' ),
			'singular_name' => _x( $singular_name , 'post type singular name' ),
			'add_new' => _x( 'Add New', $singular_name ),
			'add_new_item' =>  __( 'Add New '.$singular_name ),
			'edit_item' => __( 'Edit Details' ),
			'new_item' => __( 'Add New ' . $singular_name ),
			'view_item' => __( 'View Details' ),
			'search_items' => __( 'Search ' . $plural_name ),
			'not_found' =>  __( 'Nothing found' ) ,
			'not_found_in_trash' => __( 'Nothing found in Trash' ) ,
			'parent_item_colon' => $plural_name
		);
		
		return array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array( 'title' ,'editor' , 'thumbnail' )
		);
	}
}