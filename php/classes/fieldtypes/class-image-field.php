<?php
/**
 * @package CustomTypesFields
 */
/**
 * class-image-field.php
 * Image_Field
 * Extends Field class to display an media library uplaod. Note: this file stores the image ID, 
 * so the image path needs to be extracted from this
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
* Image_Field class. Not complete
* @todo create HTML
*/
class Image_Field extends Field
{

	public function __toString( )
	{

		$existing_image = $this->get_value( );

		$text=<<<EOS
				<p class="custom-meta custom-image">
					<label for="{$this->_name}">{$this->_text} (click insert into post once uploaded): </label>
					<input class="image-field" id="{$this->_name}" type="text" name="{$this->_name}" value="{$this->get_value()}" />
					<input class="gu-upload" id="{$this->_name}_button" type="button" value="Upload Image" />
EOS;
		if ( !empty( $existing_image ) ) {
		    $image_URL = wp_get_attachment_url( $existing_image );
		    $text .= "<a href='{$image_URL}' class='thickbox'>"; 
			$text .= wp_get_attachment_image( $existing_image , 'thumbnail' , array( 'id' => 'gu-upload' ) );
			$text .= '</a>';
		}
		$text .= '</p>';


		return $text;
	}
}
