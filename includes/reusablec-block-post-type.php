<?php
/**
 * Register  Reusable Content Blocks post type.
 *
 * @package reusablec-block
 *
 */
  
$labels = array(
	'name'               => _x( 'Reusable Blocks', 'reusablec-block' ),
	'singular_name'      => _x( 'Reusable Block', 'reusablec-block' ),
	'add_new'            => _x( 'Add New', 'reusablec-block' ),
	'add_new_item'       => _x( 'Add New Block', 'reusablec-block' ),
	'edit_item'          => _x( 'Edit Block', 'reusablec-block' ),
	'new_item'           => _x( 'New Block', 'reusablec-block' ),
	'all_items'          => _x( 'All Blocks', 'reusablec-block' ),
	'view_item'          => _x( 'View Blocks', 'reusablec-block' ),
	'search_items'       => _x( 'Search Blocks', 'reusablec-block' ),
	'not_found'          =>  _x( 'No Blocks found', 'reusablec-block' ),
	'not_found_in_trash' => _x( 'No Blocks found in Trash', 'reusablec-block' ),
	'parent_item_colon'  => '',
	'menu_name'          => _x( 'Reusable Blocks', 'reusablec-block' )
);

$args = array(
	'labels'             => $labels,
	'public'             => true,
	'publicly_queryable' => true,
	'exclude_from_search'=> true,
	'show_ui'            => true,
	'show_in_menu'       => true,
	'show_in_nav_menus'  => false,
	'query_var'          => true,
	'rewrite'            => array( 'slug' => 'rcblocks' ),
	'capability_type'    => 'post',
	'has_archive'        => false,
	'hierarchical'       => false,
	'menu_position'      => null,
	'menu_icon'          => 'dashicons-clipboard',
	'supports'           => array( 'title', 'editor')
);

register_post_type( 'rc_blocks', $args );

//add Reusable Blocks shortcode to post list view
add_filter('manage_rc_blocks_posts_columns', 'rcb_columns_head_rc_blocks', 10);
add_action('manage_rc_blocks_posts_custom_column', 'rcb_columns_content_rc_blocks', 10, 2);
 
//re arrange post list columns order and add new
function rcb_columns_head_rc_blocks($defaults) {
	$new = array();
	foreach($defaults as $key => $title) {
    if ($key=='date') // Put the Thumbnail column before the Author column
		$new['rcb_shortcode'] = esc_html__( 'Usage', 'reusablec-block' );
		$new[$key] = $title;
	}
	
    return $new;
}
function rcb_columns_content_rc_blocks($column_name, $post_ID) {
    if ($column_name == 'rcb_shortcode') {
		echo rcb_get_usage_codes( $post_ID, $width = false );
    }
}

//add Reusable Blocks shortcode to Publish metabox
add_action('post_submitbox_misc_actions', 'add_tcpshortcode_to_publish_meta_box');
function add_tcpshortcode_to_publish_meta_box($post_obj) {
 
  global $post;
  $post_type = 'rc_blocks'; 
  $pid = $post_obj->ID;
  
  if($post_type==$post->post_type) {

    echo "<div class='misc-pub-section misc-pub-section-last'>";
    echo rcb_get_usage_codes( $pid, $width = true );
    echo "</div>";
	
  }
}

function rcb_get_usage_codes( $pid, $width ) {

	$shortocde = '[rcblock id="'.$pid.'"]';
	$function = '<?php rcblock_by_id( "'.$pid.'" ); ?>';
	
	$class = ($width ) ? "class='widefat'" : "style='width:230px'";
	
	$codes = esc_html( 'Shortcode:', 'reusablec-block' )." <input type='text' value='".$shortocde."'".$class." readonly></br>";
	$codes .= esc_html( 'Function: &nbsp;', 'reusablec-block' )." <input type='text' value='".$function."'".$class." readonly>";
	
	return $codes;
}
?>