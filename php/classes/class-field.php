<?php
/**
 * @package CustomTypesFields
 */
/**
 * class-field.php
 * Field base class to be extended into specific types of field
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
 * Field provides a base class used by text fields and other fields type to build on. 
 * In some cases methods such as save will need overwriting. HTML implementations of 
 * the resulting fields are created using the __toString method of each field
 */
abstract class Field
{
	/**
	* Types of fields possible to go here. Note these are used within the section 
	* class when deciding which field type to use so that class will need updating as 
	* well as adding the constants here
	*/
	const FIELD_TYPE_TEXT = 0;
	const FIELD_TYPE_MCE = 1;//HTML editor
	const FIELD_TYPE_IMAGE = 2;
	const FIELD_TYPE_SELECT = 3;
	const FIELD_TYPE_CHECKBOX = 4;
	/**
	* Other basic vars - protected to allow field implementations to access them
	*/
	protected $_id;
	protected $_name;
	protected $_text;
	protected $_default;
	/**
	* Constructor only sets basic details. Overidden where necessary to add additional fields
	*/
	public function __construct( $name , $text , $default = null )
	{
		$this->_name = $name;
		$this->_text = $text;
		if ($default !== null) {
			$this->_default = $default;
		}
	}

	public function get_name( )
	{
		return $this->_name;
	}
	
	public function get_text( )
	{
		return $this->_text;
	}

	/**
	* save functions gets the data and stores it into wordpress
	*/
	public function save_data( &$data )
	{
		global $post;
	
		if ( isset( $data[ $this->_name])) {
			$value = strip_tags( trim( $data[ $this->_name ] ) );
			update_post_meta( $post->ID , $this->_name , $value );
		}
	}


	/**
	* retrieving the value of the field from wordpress
	*/
	protected function get_value()
	{
		$custom = get_post_custom( );
		$value = $custom[ $this->_name ][ 0 ];
		
		
		if ( strpos( $value , "<p>" )===0) {
			$value = str_replace( "<p>" , "" , $value );
			$value = str_replace( "</p>" , "\n" , $value );
		}
		if ( empty( $value) && !empty( $this->_default ) ) {
			$value = $this->_default;	
		}
		return $value;
	}

}