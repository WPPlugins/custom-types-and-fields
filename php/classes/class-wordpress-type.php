<?php 
/**
 * @package CustomTypesFields
 */
/**
 * 
 * class-wordpress-type.php
 * Stores a Wordpress type which can have custom fields added. Fields are grouped into section for 
 * logical display groupings. 
 * This acts as the base class for the CustomType class
 * 
 * PHP version 5.2
 *
 *
 * @author     David Linnard (www.davidlinnard.com)
 * @copyright  2011 Grand Union (www.thegrandunion.com)
 * @version    1.0
 * @created    14/10/11
 */

 /**
* Wordpress_Type class. Acts as a holder of custom fields. Extended for custom classes (customtype.php)
*/
class Wordpress_Type
{
	protected $_name;
	protected $_sections;
	protected static $_types = array();
	
	public function __construct( $name )
	{
		$this->_name = $name;
		$this->_sections = array( );
		self::$_types[] = $this;
	}

	public static function get_types( )
	{
		return self::$_types;	
	}

	public function get_name( )
	{
		return $this->_name;
	}

	public function get_sections( )
	{
		return $this->_sections;
	}

	/**
	* Sections can have all of the same details used when a meta field box is created 
	* (see add_meta_box in the wordpress codex)
	*/
	public function add_section( $name , $title , $column , $priority , $callback = null , $callback_args = array( ) )
	{
		$this->_sections [ urlencode ( $name ) ] = new Section(
			$name , $title , $column , $priority , $callback , $callback_args
		);
		return $this->_sections[ urlencode( $name ) ];
	}

	public function add_taxonomy( $name , $options )
	{
		register_taxonomy( $name , array( $this->_name ), $options );
	}

	public function save_data( &$data )
	{
		foreach ( $this->get_sections( ) as $key => $section ) {
			$section->save_data( $data );
		}
	}
}