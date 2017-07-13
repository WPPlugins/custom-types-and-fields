<?php
/**
 * @package CustomTypesFields
 */
/**
 * autoload.php
 * Autoloader for other classes in the plugin
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
* Basic autoloader class, for use with the spl_autoload_register function. 
* Requires SPL library to be installed for usage.
*/
class Custom_Types_Autoloader
{
	static public function load($class) 
	{
		$path = CUSTOMTYPES_PLUGIN_PATH . 'php/classes/';
        
		$class = 'class-' . strtolower( str_replace( "_" , "-" , $class) );

		if ( strpos( $class, 'field' ) > 0 && strcmp( 'class-field' , $class ) !== 0 ) {
			$path .= 'fieldtypes/';
		}
		       
		@include( $path . $class . '.php' );
		
	}
}

spl_autoload_register( 'Custom_Types_Autoloader::load' );
