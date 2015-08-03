<?php
/**
* @package TextFileWidget
* @version 1.21
*/
/* Plugin Name: Text File Widget 
Plugin URI: http://www.q292u.com/plugins/text-file-widget
Author URI: http://www.q292u.com
Description: Display contents of a text file as a sidebar widget
Version: 1.21
Author: Paul Rak

*/

class TextFileWidget extends WP_Widget {
          function TextFileWidget() {
                    $widget_ops = array(
                    'classname' => 'TextFileWidget',
                    'description' => 'Display contents of a text file as a sidebar widget'
          );

          $this->WP_Widget(
                    'TextFileWidget',
                    'Text File Widget',
                    $widget_ops
          );
} //end function textfilewidget

function widget($args, $instance) { // widget sidebar output
                    extract($args);
                    $title 		= apply_filters('widget_title', $instance['title']);
        			$filename 	= $instance['filename'];
                    echo $before_widget; // pre-widget code from theme
                    if ( $title )
                    {
                        echo $before_title . $title . $after_title;
                    }
                    $txt=file_get_contents($filename);
                    $txt=nl2br($txt); // translate end-of-line to html..
	                $txt=strip_tags($txt,'<br><br/>');	// strip all tags except line breaks..                    
					echo "<ul><li>".$txt."</li></ul>";
                    echo $after_widget; // post-widget code from theme
}

/** @see WP_Widget::update -- do not rename this */
function update($new_instance, $old_instance) {		
		$instance = $old_instance;
		$instance['title']    = strip_tags($new_instance['title']);
		$instance['filename'] = strip_tags($new_instance['filename']);
        return $instance;
}
 
/** @see WP_Widget::form -- do not rename this */
function form($instance) {	
 
        $title 		= esc_attr($instance['title']);
        $filename	= esc_attr($instance['filename']);
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		  <label for="<?php echo $this->get_field_id('filename'); ?>"><?php _e('Filename:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('filename'); ?>" name="<?php echo $this->get_field_name('filename'); ?>" type="text" value="<?php echo $filename; ?>" />
        </p>
        <?php 
}
}//end class

add_action(
          'widgets_init',
          create_function('','return register_widget("TextFileWidget");')
);


 
?>