<?php
/**
 * @package CustomTypesFields
 */
/**
 * class-section.php
 * Acts as a holder of multiple fields. Can be shown in either column as required 
 * (all Wordpress based option available)
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
* Section class. Acts as a holder of multiple fields. Can be shown in either column as 
* required (all Wordpress based option available)
*/
class Section
{

	/**
	* Constants required for location of this section plus it's priority within the column.
	*/
	const CONTEXT_NORMAL = 0;
	const CONTEXT_ADVANCED = 1;
	const CONTEXT_SIDE = 2;
	
	const PRIORITY_DEFAULT = 0;
	const PRIORITY_LOW = 1;
	const PRIORITY_CORE = 2;
	const PRIORITY_HIGH = 3;
	
	/*static lists of contexts and priorities, for internal use*/
	private static $_contexts = array(
		self::CONTEXT_NORMAL=>'normal', 
		self::CONTEXT_ADVANCED=>'advanced', 
		self::CONTEXT_SIDE=>'side'
	);
	private static $_priorities = array(
		self::PRIORITY_HIGH=>'high', 
		self::PRIORITY_CORE=>'core', 
		self::PRIORITY_DEFAULT=>'default', 
		self::PRIORITY_LOW=>'low'
	);
	
	/*object level vars, storing the details of each section:*/
	private $_id;
	private $_name;
	private $_title;
	private $_context;
	private $_priority;//based on wordpress priorities
	private $_callback;//use for custom styling
	private $_callback_args;//if using a custom function, are custom args required?
	
	private $_fields;
	private $_fieldsLoaded = false;

	public function __construct( $name , $title , $context , $priority , $callback = null , $callback_args = array( ) )
	{
		$this->_name = $name;
		$this->_title = $title;
		$this->_context = $context;
		$this->_priority = $priority;
		$this->_callback = $callback;
		$this->_callback_args = $callback_args;
		$this->_fields = array();
	}

	/**
	* addField requires the name of the field (no spaces please), text to 
	* use for the label and type (using the constants in class Field). 
	* args is used for additional params (e.g. options of a select list)
	*/
	public function add_field( $name , $text , $type , $default = null , $args = array( ) )
	{
		switch( $type ){
			case Field::FIELD_TYPE_TEXT:
				$this->_fields[ $name ] = new Text_Field( $name , $text , $default );
				break;
			case Field::FIELD_TYPE_MCE:
				$this->_fields[ $name ] = new MCE_Field( $name , $text , $default );
				break;
			case Field::FIELD_TYPE_IMAGE:
				$this->_fields[ $name ] = new Image_Field( $name , $text , $default );
				break;
			case Field::FIELD_TYPE_SELECT:
				$this->_fields[ $name ] = new Select_Field( $name , $text , $default , $args );
				break;
			case Field::FIELD_TYPE_CHECKBOX:
				$this->_fields[ $name ] = new Checkbox_Field( $name , $text , $default );
				break;
			default:
				throw new Exception( "Invalid Field Type" );
				break;
		}
	}

	public function get_ID( )
	{
		return $this->_id;
	}

	/**
	 * Standard getter for the name 
	 */
	public function get_name( )
	{
		return $this->_name;
	}

	/**
	 * Standard getter for the title/fields 
	 */
	public function get_title( )
	{
		return $this->_title;
	}

	/**
	 * WP text based context field 
	 */	
	public function get_context( )
	{
		if ( array_key_exists( $this->_context, self::$_contexts ) ) {
			return self::$_contexts[ $this->_context ];
		} else {
			return self::$_contexts[ 0 ];
		}
	}

	/**
	 * WP text based priority field 
	 */
	public function get_priority()
	{
		if (array_key_exists($this->_priority, self::$_priorities)) {
			return self::$_priorities[$this->_priority];
		} else {
			return self::$_priorities[0];
		}
	}

	/**
	* generateHTML calls each field in turn to get the HTML required to 
	* display each field this is then echo'd rather than returned as per 
	* other wordpress functions
	*/
	public function generate_HTML()
	{
		$html = '';

			foreach ($this->_fields as $field) {
				$html .= $field;

			}
		
		echo $html;
	}

	/**
	* save calls each field in turn and uses the save method of the field to save it to the wordpress DB
	*/
	public function save_data(&$data)
	{
		foreach ($this->_fields as $field) {
			$field->save_data($data);
		}
	}

}