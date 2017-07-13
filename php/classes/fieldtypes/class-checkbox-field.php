<?php
/**
 * @package CustomTypesFields
 */
/**
 * class-checkbox-field.php
 * Checkbox_Field
 * Simple checkbox
 * Extends Field class
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
* Checkbox_Field class. Has to override the save and retrieval of values from the base class.
*/
class Checkbox_Field extends Field
{
	public function __construct( $name , $text , $default )
	{
		parent::__construct( $name , $text , $default );
	}

	public function get_value( )
	{
		global $post;
		
		$value = (int) get_post_meta( $post->ID , $this->_name , true );
		
		if (isset( $value ) && 1 === $value) {
			return 1;
		}
		
		if (! isset ( $value ) ) {
			return $this->_default;
		}
		
		return 0;
	}

	public function save_data( &$data )
	{
		global $post;
	  
		if ( isset( $data[ $this->_name ] ) ) {
			$clean = 1;
		} else {
			$clean = 0;
		}
		update_post_meta( $post->ID , $this->_name , $clean );
	}

	public function __toString( )
	{
		$selected = $this->get_value( );

		$text = "<p class='custom-meta'><label for='{$this->_name}'>{$this->_text}</label>".
				"<input type='checkbox' name='{$this->_name}'".
				(($this->get_value())? "checked='checked'":"")."></p>";
		return $text;
	}
}
