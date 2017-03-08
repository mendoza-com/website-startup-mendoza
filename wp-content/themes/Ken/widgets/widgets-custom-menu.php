<?php

class Artbees_WP_Nav_Menu_Widget extends WP_Widget {

	function Artbees_WP_Nav_Menu_Widget() {
		$widget_ops = array( 'classname' => 'widget_custom_menu', 'description' => 'Displays a custom menu.' );
		$this->WP_Widget( 'custom_menu_widget', THEME_SLUG.' - '.'Custom Menu', $widget_ops );


	}
 
   function widget($args, $instance) {
       extract( $args );
       
       $nav_menu = !empty( $instance['nav_menu'] ) ? wp_get_nav_menu_object( $instance['nav_menu'] ) : false;
       $align = isset( $instance['align'] ) ? $instance['align'] : '';
       $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
       $color = isset( $instance['color'] ) ? $instance['color'] : '';
       $hover_color = isset( $instance['hover_color'] ) ? $instance['hover_color'] : '';
 
       if ( !$nav_menu )
           return;
 		$output = '';
		

		echo $before_widget;
		
		echo '<div class="mk-custom-menu align-'.$align.'">';	
		if ( $title ){
			echo $before_title . $title . $after_title;
		}
		
		echo wp_nav_menu( array( 'fallback_cb' => '', 'menu' => $nav_menu ) );
		echo '</div>';

		echo $after_widget;

   }
 
   function update( $new_instance, $old_instance ) {
       $instance['title'] = strip_tags( stripslashes($new_instance['title']) );
       $instance['nav_menu'] = (int) $new_instance['nav_menu'];
       $instance['align'] = $new_instance['align'];
       $instance['color'] = $new_instance['color'];
       $instance['hover_color'] = $new_instance['hover_color'];
       return $instance;
   }
 
   function form( $instance ) {
       $title = isset( $instance['title'] ) ? $instance['title'] : '';
       $nav_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';
       $align = isset( $instance['align'] ) ? $instance['align'] : '';
       $color = isset( $instance['color'] ) ? $instance['color'] : '';
       $hover_color = isset( $instance['hover_color'] ) ? $instance['hover_color'] : '';
 
       // Get menus
       $menus = wp_get_nav_menus( array( 'orderby' => 'name' ) );
 
       // If no menus exists, direct the user to go and create some.
       if ( !$menus ) {
           echo '<p>'. sprintf( __('No menus have been created yet. <a href="%s">Create some</a>.'), admin_url('nav-menus.php') ) .'</p>';
           return;
       }
       ?>
       
       <p>
           <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>
           <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
       </p>
       <p>
           <label for="<?php echo $this->get_field_id('nav_menu'); ?>"><?php _e('Select Menu:'); ?></label>
           <select id="<?php echo $this->get_field_id('nav_menu'); ?>" name="<?php echo $this->get_field_name('nav_menu'); ?>">
               <option value="0"><?php _e( '&mdash; Select &mdash;' ) ?></option>
       <?php
           foreach ( $menus as $menu ) {
               echo '<option value="' . $menu->term_id . '"'
                   . selected( $nav_menu, $menu->term_id, false )
                   . '>'. esc_html( $menu->name ) . '</option>';
           }
       ?>
           </select>
       </p>
       <p>
			<label for="<?php echo $this->get_field_id( 'align' ); ?>"><?php _e('Align:', 'mk_framework'); ?></label>
			<select name="<?php echo $this->get_field_name( 'align' ); ?>" id="<?php echo $this->get_field_id( 'align' ); ?>" class="widefat">
				<option value="left"<?php selected( $align, 'left');?>>Left</option>
				<option value="center"<?php selected( $align, 'center');?>>Center</option>
				<option value="right"<?php selected( $align, 'right');?>>Right</option>
			</select>
		</p>
       	<p>
			<label for="<?php echo $this->get_field_id( 'color' ); ?>"><?php _e('Color:', 'mk_framework'); ?></label>
			<div class="color-picker-holder"><input data-default-color="<?php $value['default']; ?>" class="color-picker" id="<?php echo $this->get_field_id( 'color' ); ?>" name="<?php echo $this->get_field_name( 'color' ); ?>" type="text" value="<?php echo $color; ?>" /></div>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'hover_color' ); ?>"><?php _e('Hover Color:', 'mk_framework'); ?></label>
			<div class="color-picker-holder"><input data-default-color="<?php $value['default']; ?>" class="color-picker" id="<?php echo $this->get_field_id( 'hover_color' ); ?>" name="<?php echo $this->get_field_name( 'hover_color' ); ?>" type="text" value="<?php echo $hover_color; ?>" /></div>
		</p>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				mk_color_picker();
			});
		</script>
       <?php
   }
}