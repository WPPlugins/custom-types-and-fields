<?php
/**
 * @package CustomTypesFields
 */
/**
 * class-select-field.php
 * Select list which allows multiple selection
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
* Select_Field class. Has to override the save and retrieval of values from the base class. 
* Options are based on an additional param supplied by the user
*/
class Select_Field extends Field
{
	private $_options;
	public function __construct( $name , $text , $default , $options )
	{
		parent::__construct( $name , $text , $default );
		$this->_options = $options;
	}

	public function get_value( )
	{
		global $post;
		
		$custom = get_post_custom( $post->ID );
		
		if ( isset( $custom[ $this->_name ][ 0 ] ) && ! empty( $custom[ $this->_name ][ 0 ] ) ) {
			return unserialize( $custom[ $this->_name ][ 0 ] );
		}
		
		if ( !isset ( $custom[ $this->_name ][ 0 ] ) ) {
			return $this->_default;
		}
		return null;
	}

	public function save_data( &$data )
	{
		global $post;
		$clean = array( );
		
		if (isset( $data[ $this->_name ] ) ) {/*has data been posted?*/
			$clean = array( );
			foreach ( $data[ $this->_name ] as $key => $value ) {
				$clean[ $key ] = $value;
			}
		}
		
		update_post_meta( $post->ID , $this->_name , $clean );
		
	}

	public function __toString( )
	{
		$selected = $this->get_value( );
		$text = "<p class='custom-meta'><label for='{$this->_name}[]'>{$this->_text}</label>".
				"<select name='{$this->_name}[]' multiple='multiple' size='5'  class='gu'>";
		
		foreach ( $this->_options as $id => $name ) {
			$text .= "<option value='{$id}' ";
			
			if ( $selected && in_array( $id , $selected ) ) {
				$text .= 'selected=selected';
			}
			
			$text .= ">{$name}</option>";
		}

		
		$text .= '</select></p>';
		return $text;
	}
}
