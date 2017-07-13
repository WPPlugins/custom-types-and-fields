<?php
/**
 * @package CustomTypesFields
 */
/**
 * class-mce-field.php
 * Textarea with html editor used by wordpress 
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
* MCE_Field class. A field which is a text area with the richtext editor
*/
class MCE_Field extends Field
{

	/*overwriting save function to ensure formatting is applied correctly (if required):*/
	public function save_data( &$data )
	{
		global $post;
		
		if ( isset( $data[ $this->_name ] ) ) {
			$value = trim( $data[ $this->_name ] );

			
			if ( strpos( $value , "<p" ) === false && strlen( $value ) ) {
				$value = wpautop( $value );
			} 
			update_post_meta( $post->ID , $this->_name , $value );
		}
	}

	public function __toString( )
	{
		$mcejsurl = get_bloginfo( 'wpurl' ) . "/wp-content/tiny_mce/tiny_mce.js";
        $value = $this->get_value( );

        //getting editor (note: have to use output buffer to prevent echo being used to display)
		ob_start( );
		the_editor( $this->get_value( ) , $this->_name );
		$editor = ob_get_contents( );
		ob_end_clean( );
		$text = <<<EOS
			<div class="mce-field custom-meta">
			<label for="{$this->_name}" class="mce">{$this->_text}</label>
			<div class="mce-editor">
			{$editor}
			</div>
			</div>
EOS;
		return $text;
	}
}