<?php
/**
 * @package CustomTypesFields
 */
/**
 * class-text-field.php
 * TextField class which creates a standard text input (plus label). 
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
* Text_Field class. Simply implements the HTML required to draw out the text box and related label
*/
class Text_Field extends Field
{
	public function __toString( )
	{
		$value = $this->get_value( );
		$text = <<<EOS
		<p class="custom-meta">
		<label for="{$this->_name}">{$this->_text}</label>
		<input name="{$this->_name}" value="{$value}" />
		</p>
EOS;
	return $text;
	}
}