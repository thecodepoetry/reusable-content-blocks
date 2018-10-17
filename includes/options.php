<?php
/**
 * Render the Reusable Content Blocks Settings page.
 *
 * @package reusablec-block
 *
 * @return void
 */

add_action('admin_menu', 'rcb_register_options_page'); //init plugin options menu

//register plugin options menu
function rcb_register_options_page() {

	add_submenu_page( 'edit.php?post_type=rc_blocks', 'Reusable Content Blocks Options', 'Options', 'manage_options', 'reusablecb-options', 'rcb_options_page_callback' ); 
	
	add_action( 'admin_init', 'rcb_register_settings' );
}

function rcb_register_settings() {

	register_setting( 'rcb-settings-group', 'rcb_enable_widget' );
	register_setting( 'rcb-settings-group', 'rcb_css_metakeys' );
}

//plugin options page function
function rcb_options_page_callback() {
	?>
	<div class="wrap">
	<h2><?php echo esc_html__( 'Reusable Content Blocks Options', 'reusablec-block' ); ?></h2>	
    <form method="post" action="options.php">
	
    <?php settings_fields( 'rcb-settings-group' ); ?>
    <?php do_settings_sections( 'rcb-settings-group' ); ?>
   
    <table class="form-table">
       
        <tr valign="top">
        <th scope="row"><?php echo esc_html__( 'Enable widget support:', 'reusablec-block' ); ?></th>
        <td><input type="checkbox" name="rcb_enable_widget" value="enable" <?php checked( get_option('rcb_enable_widget'), 'enable', true ); ?>/></td>
        <td><?php _e( 'If your Theme support shortcodes in Widget areas, you can use shortcodes in Text/HTML Widget as well.', 'reusablec-block' ); ?>
        </td>
        </tr>
        
        <tr valign="top">
        <th scope="row"><?php echo esc_html__( 'CSS Metakeys:', 'reusablec-block' ); ?></th>
        <td><textarea name="rcb_css_metakeys" rows="5" cols="40"><?php echo get_option('rcb_css_metakeys'); ?></textarea></td>
        <td><?php echo sprintf( __( '(Optional) Some page builders save element\'s custom CSS as meta keys and render it when the page is viewed. If elements 		from your theme or page builder addons missing style when inserted with shortcode, add your meta keys here one in a line. Refer  %s documentation %s 		for detailed instruction.', 'reusablec-block' ), '<a href="http://www.thecodepoetry.com/plugins/wordpress-reusable-content-blocks/#!/cssmetakeys" 	target="_blank">', '</a>' );  ?>
        
        </td>
        </tr>
        
    </table>
    
    <?php submit_button();  ?>
    </form>
    <h3><?php echo esc_html__( 'Tips:', 'reusablec-block' ); ?></h3>
    
    <p><?php if ( is_plugin_active( 'js_composer/js_composer.php' ) ) {
	echo sprintf( __( '* If WP Bakery page builder not available for Reusable block post type, please enable it from %s here.%s (Select Post type: Custom and enable for rc_blocks and other required post types', 'reusablec-block' ), '<a href="'.admin_url( 'admin.php?page=vc-roles').'" target="_blank">', '</a>' ); } ?></p>
    
    <p><?php if ( is_plugin_active( 'Ultimate_VC_Addons/Ultimate_VC_Addons.php' ) ) {
	echo sprintf( __( '* If you are using Ultimate addon for WP Bakery in Reusbale blocks, please enable Load script and styles Globally from %s here.', 'reusablec-block' ), '<a href="'.admin_url( 'admin.php?page=ultimate-debug-settings').'" target="_blank">', '</a>' );    
    } ?>
    
    </p>
    <p><?php echo esc_html__( '* Single page view of Reusable block post types is necessary to preview the blocks. So if you don\'t want to search engines to Index them, make sure to set to noindex from your SEO plugin settings. They are already excluded from search and Archive pages are disabled.', 'reusablec-block' ); ?></p>
    
    <p><?php echo esc_html__( '* It is not a good practice to activate multiple page builders at the same time. Most likely plugins itself will conflict each other.
    ', 'reusablec-block' ); ?></p>
    <p><?php echo sprintf( __( '* Please refer to %s Plugins page $s for fucntion usage examples', 'reusablec-block' ), '<a href="http://www.thecodepoetry.com/plugins/wordpress-reusable-content-blocks/#!/functionusage" target="_blank">', '</a>' ); ?></p>
	</div>
<?php  }


