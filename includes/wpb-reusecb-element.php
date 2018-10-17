<?php
/**
 * Reusable Content Blocks widget.
 *
 * @package reusablec-block
 *
 * Provides an element in WBBakery page buldier for inserting contnet 
 **/
 
if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly
 
add_action( 'vc_before_init', 'rcb_shortcode_integrateWithVC' );

function rcb_shortcode_integrateWithVC() {
   vc_map( array(
      "name" => __( "Reusable Block", "reusablec-block" ),
      "base" => "rcblock",
      "class" => "reusecb_data_source",
      "category" => __( "Content", "reusablec-block"),
	  "icon"	=> "dashicons-clipboard",
	  //"admin_enqueue_css" => array( plugins_url( "/css/reusablec-block.css", __FILE__ ) ),
	  "front_enqueue_css" => array( plugins_url( "/css/reusablec-block.css", __FILE__ ) ),
	  "description" => __( "Insert post content", "reusablec-block" ),
      "params" => array(
         array(
		  'type' => 'dropdown',
		  'heading' => __( 'Data source',  "reusablec-block" ),
		  'param_name' => 'data_source',
		  'value' => array(
			__( 'Reusable Block',  'reusablec-block'  ) => 'reusable_block',
			__( 'Other Post types',  'reusablec-block'  ) => 'db_other',
		  ),
		  'description' => __( 'Select data source', 'reusablec-block' )
		),
		array(
		  "type" => "rcb_posts",
		  "class" => "reusecb_other_id",
		  "heading" => __( "Content Block", "reusablec-block" ),
		  "param_name" => "id",
		  "admin_label" => true,
		  "value" => __( "", "reusablec-block" ),
		  "dependency" => Array("element" => "data_source", "value" => array('reusable_block')),
		  "description" => __( "Select contnet block to display.", "reusablec-block" )
		),
		array(
		  "type" => "textfield",
		  "class" => "db_other",
		  "heading" => __( "Post ID", "reusablec-block" ),
		  "param_name" => "othe_id",
		  "admin_label" => true,
		  "value" => __( "", "reusablec-block" ),
		  "dependency" => Array("element" => "data_source", "value" => array('db_other')),
		  "description" => __( "Enter post ID.", "reusablec-block" )
		)
      )
   ) );
   
vc_add_shortcode_param( 'rcb_posts', 'rcb_posts_settings_field' );
function rcb_posts_settings_field( $settings, $value ) {
   return '<div class="data_rcb_post_block">'
             .'<select name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-input wpb-select dropdown' .
             esc_attr( $settings['param_name'] ) . ' ' .
             esc_attr( $settings['type'] ) . '_field">'. 
			rcb_get_posts_as_options( $value ).
         '</select></div>';         
}

}
?>