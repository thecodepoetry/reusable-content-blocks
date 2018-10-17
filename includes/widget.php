<?php
/**
 * Reusable Content Blocks widget.
 *
 * @package reusablec-block
 *
 * Provides a widget for inserting contnet into a widget area. can enable/disable from Reusable Blocks > Settings
 **/

if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

class Reusable_Block extends WP_Widget {
	// class constructor
	public function __construct() {
		
		// Load admin javascript for Widget options on admin page (widgets.php).
		add_action( 'sidebar_admin_page', array( $this, 'rcb_widget_admin_js' ) );

		// Load admin javascript for Widget options on theme customize page (customize.php).
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'rcb_widget_admin_js' ) );
		
		$widget_ops = array( 
			'classname' => 'reusable_block page',
			'description' =>  __( 'Insert Reusable Blocks.', 'reusablec-block' ),
			
		);
		
		// Call parent constructor to initialize the widget.
		parent::__construct( 'reusable_block', 'Reusable Block', $widget_ops );
	}
	
	public function rcb_widget_admin_js() {
		//load widget script
		wp_enqueue_script('reusablecb-widget', plugin_dir_url(__FILE__ ). 'js/reusablecb-widget.js' , array('jquery'));
	}
	
	// output the option form field in admin Widgets screen
	public function form( $instance ) {
		
		$instance = wp_parse_args( (array) $instance, array(
			'reusecb_title' => '',
			'data_source' => '',
			'id' => '',
			'othe_id' => '',

		));
		
			
		?>
        
		<div>
       
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'reusecb_title' ) ); ?>">
			<?php echo esc_html__( 'Title:', 'reusablec-block' ); ?>
		</label> 
		<input 
            class="widefat" 
            id="<?php echo esc_attr( $this->get_field_id( 'reusecb_title' ) ); ?>" 
            name="<?php echo esc_attr( $this->get_field_name( 'reusecb_title' ) ); ?>" 
            type="text" 
            value="<?php echo esc_attr( $instance['reusecb_title'] ); ?>">
		</p>
        
        <p><label for="<?php echo esc_attr( $this->get_field_id( 'data_source' ) ); ?>">
			<?php echo esc_html__( 'Select Data source:', 'reusablec-block' ); ?>
        </label>
        <select 
            class="widefat reusecb_data_source" 
            name="<?php echo esc_attr( $this->get_field_name( 'data_source' ) ); ?>" 
            id="<?php echo esc_attr( $this->get_field_id( 'data_source' ) ); ?>">
            
        	<option 
                value="reusable_block" <?php selected( $instance['data_source'], 'reusable_block' ); ?>>
                <?php echo esc_html__( 'Reusable Block', 'reusablec-block' ); ?></option>
                <option value="db_other" <?php selected( $instance['data_source'], 'db_other' ); ?>>
                <?php echo esc_html__( 'Other post types', 'reusablec-block' ); ?></option>
        </select></p>
        
        <p class="dynamic_block">
        <label for="<?php echo esc_attr( $this->get_field_id( 'id' ) ); ?>"><?php echo esc_html__( 'Select Block:', 'reusablec-block' ); ?></label>
		<select
            class="widefat"  
            name="<?php echo esc_attr( $this->get_field_name( 'id' ) ); ?>" 
            id="<?php echo esc_attr( $this->get_field_id( 'id' ) ); ?>"  >
            <?php echo rcb_get_posts_as_options( $instance['id'] ); ?>
		 </select></p>
         
        <p class="db_other"><label for"<?php echo esc_attr( $this->get_field_id( 'othe_id' ) ); ?>">
		<?php echo esc_html__( 'Enter post ID:', 'reusablec-block' ); ?></label><br />
        <input
            id="<?php echo esc_attr( $this->get_field_id( 'othe_id' ) ); ?>" 
            name="<?php echo esc_attr( $this->get_field_name( 'othe_id' ) ); ?>" 
            value="<?php echo esc_attr( $instance['othe_id'] ); ?>"
            class="widefat" 
            type="text" /></p>
		</div>
        
		<?php
	}

	// save options
	public function update( $new_instance, $old_instance ) {
	
		$instance = array();
		$instance['reusecb_title'] = ( ! empty( $new_instance['reusecb_title'] ) ) ? strip_tags( $new_instance['reusecb_title'] ) : '';
		$instance['data_source'] = ( ! empty( $new_instance['data_source'] ) ) ? strip_tags( $new_instance['data_source'] ) : '';
		$instance['id'] = ( ! empty( $new_instance['id'] ) ) ? strip_tags( $new_instance['id'] ) : '';
		$instance['othe_id'] = ( ! empty( $new_instance['othe_id'] ) ) ? absint( $new_instance['othe_id'] ) : '';
	
		return $instance;
	}
	
	// output the widget content on the front-end
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
	
		if( ! empty( $instance['id'] ) || ! empty( $instance['othe_id'] ) ){ 
			
			$pagid = ( $instance['data_source'] == 'db_other' ) ? $instance['othe_id'] : $instance['id'];
						
			echo rcb_get_content_func ( array( 
					'data_source' => $instance['data_source'],
					'id' => $instance['id'],
					'othe_id' => $instance['othe_id']
					));

			
		} else {
			echo esc_html__( 'No content selected!', 'reusablec-block' );	
		}
	
		echo $args['after_widget'];
	}
}

add_action( 'widgets_init', function(){
	register_widget( 'Reusable_Block' );
});
?>