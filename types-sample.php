<?php
/**
 * @package Custom_Types_Fields
 */
/**
 * exampletypes.php
 * Simple examples for using the plugin. Move this code to your active themes directory and rename it to
 * types.php to customize
 * 
 * PHP version 5.2
 *
 *
 * @author     David Linnard (www.davidlinnard.com)
 * @copyright  2011 Grand Union (www.thegrandunion.com)
 * @version	   1.0
 * @created	   14/10/11
 */

//club type:
$club = new Custom_Type( 'club' , 'Club' , 'Our Clubs' , array( 'supports' => array('title' , 'editor' , 'thumbnail' ) )
);

//section containing Club details:
$details = $club->add_section( 'details' , 'Club Details' , Section::CONTEXT_NORMAL , Section::PRIORITY_CORE );
$details->add_field( 'weekday' , 'Weekday' , Field::FIELD_TYPE_TEXT );
$details->add_field( 'time' , 'Time' , Field::FIELD_TYPE_TEXT );



//person type:
$people = new Custom_Type( 'person' , 'Person' , 'People' , array( 'supports'=>array( 'title' ) ) );
$people->add_taxonomy(
	'person' , array(
		'hierarchical' => true, 
		'label' => 'Departments', 
		'singular_label' => 'Department', 
		'rewrite' => true
	)
);						
//bio section:
$bio = $people->add_section( 'bio' , 'Biography' , Section::CONTEXT_NORMAL , Section::PRIORITY_CORE );

$bio->add_field( 'jobtitle' , 'Role' , Field::FIELD_TYPE_TEXT );
$bio->add_field( 'shortdesc' , 'Short description' , Field::FIELD_TYPE_TEXT );
$bio->add_field( 'bio' , 'Biography' , Field::FIELD_TYPE_MCE );
$bio->add_field( 'desertisland' , '3 desert island items', Field::FIELD_TYPE_TEXT );
$bio->add_field( 'specialtalent' , 'Special talent', Field::FIELD_TYPE_TEXT );

//images section: 
$images = $people->add_section( 'images' , 'Images' , Section::CONTEXT_NORMAL , Section::PRIORITY_LOW );
$images->add_field( 'hero' , 'Hero image' , Field::FIELD_TYPE_IMAGE );
$images->add_field( 'thumbnail' , 'Thumbnail' , Field::FIELD_TYPE_IMAGE );

//Links section:
$links = $people->add_section( 'links' , 'Links' , Section::CONTEXT_SIDE , Section::PRIORITY_DEFAULT );
$links->add_field( 'twitter' , 'Twitter' , Field::FIELD_TYPE_TEXT );
$links->add_field( 'facebook' , 'Facebook' , Field::FIELD_TYPE_TEXT );
$links->add_field( 'linkedin' , 'Linkedin' , Field::FIELD_TYPE_TEXT );
$links->add_field( 'blog' , 'Blog' , Field::FIELD_TYPE_TEXT );
$links->add_field( 'website' , 'Website' , Field::FIELD_TYPE_TEXT );

//People - club memberships:
$clubs = $people->add_section( 'clubs' , 'Clubs' , Section::CONTEXT_SIDE , Section::PRIORITY_DEFAULT );
//if clubs exist load them into array for use in selection:
$clubQuery = new WP_Query( 
    array( 
		'post_type' => 'club', 
		'posts_per_page' => -1, 
		'orderby' => 'title', 
		'order' => 'ASC'
    )
);

$clubArray = array();

while ( $clubQuery->have_posts( ) ) { 
	$clubQuery->the_post( );
	$clubArray[get_the_ID( )] = get_the_title( );
}

$clubs->add_field( 'clubs' , 'Clubs' , Field::FIELD_TYPE_SELECT , array() , $clubArray );

//product type:
$product = new Custom_Type( 'product' , 'Product' , 'Products' , array( 'supports' => array( 'title' , 'editor' , 'thumbnail' ) ) );

//section containing Price and other details:
$details = $product->add_section( 'details' , 'Product Details' , Section::CONTEXT_NORMAL , Section::PRIORITY_HIGH );
$details->add_field( 'price' , 'Price' , Field::FIELD_TYPE_TEXT );
$details->add_field( 'stock' , 'In Stock?' , Field::FIELD_TYPE_CHECKBOX, true );
$details->add_field('deliver', 'Deliver?', Field::FIELD_TYPE_CHECKBOX, true );
	
	
	
//default type additional fields:

//adding to Page:
$page = new Wordpress_Type( 'page' );
$header = $page->add_section( 'pagehero' , 'Header Bar' , Section::CONTEXT_NORMAL , Section::PRIORITY_HIGH );
$header->add_field( 'heroimage' , 'Header Background' , Field::FIELD_TYPE_IMAGE ); 
$insight = $page->add_section( 'quote' , 'Quote' , Section::CONTEXT_NORMAL , Section::PRIORITY_HIGH );
$insight->add_field( 'insightQuote' , 'Quote' , Field::FIELD_TYPE_MCE );
