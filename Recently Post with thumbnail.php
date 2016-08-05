/**
 * Show recently post with thumbnail
 */
class Recelty_Post_Thumbnail_Widget extends WP_Widget
{
    /**
     * summary
     */
    public function __construct()
    {
    	$widget_option=array(
    		'classname='=>'recenlty_post_thumbnail',
    		'description'=>'Display recenlty post with thumbnail'
    	);
        parent::__construct(
        	'recenlty_post_thumbnail',// Base ID of widget
        	'Recently Post with thumbnail', // The title of widget
        	$widget_option// Description of widget (array)
        );
    }

    public function widget($args,$instance)
    {
    	
    	$title=apply_filters('widget_title',$instance['title']);
    	$NumberOfPost=$instance['NumberOfPost'];
    	$ShowTitle=isset($instance['ShowTitle'])?$instance['ShowTitle']:True;
    	$ShowDate=isset($instance['ShowDate'])?$instance['ShowDate']:True;

    	echo $args['before_widget'];

    		echo $args['before_title'];
    			if (!empty($title)) {
    				echo $title;
    			}else{
    				echo 'Recently Post with Thumbnails';
    			}
    		echo $args['after_title'];
    		$args_post=array(
    			'post_type'=>'post',
    			'posts_per_page'=>$NumberOfPost,
    		);
    		$recently_post=new WP_Query($args_post);
			if ( $recently_post->have_posts() ) {
				echo '<ul class="rig">';
				while ( $recently_post->have_posts() ) {
					$recently_post->the_post();
					echo '<li>';
					if ($ShowTitle==True) {
						echo '<h3>'.get_the_title().'</h3>';
					}
					$thumb=wp_get_attachment_image_src(get_post_thumbnail_id(),array('100px','200px'));
					echo '<a href="'.get_the_permalink().'">';
						echo '<img src="'.$thumb[0].'" alt="'.get_the_title().'" title="'.get_the_title().'">';
					echo '</a>';
					if ($ShowDate==True) {
						echo '<span>'.get_the_date().'</span>';
					}
					
					echo '</li>';
				}
				echo '</ul>';
				wp_reset_postdata();
			} else {
			}
    	echo $args['after_widget'];
    }

    public function form($instance)
    {
    	$title=$instance['title'];
    	if (isset($NumberOfPost)) {
    		$NumberOfPost=$instance['NumberOfPost'];
    	}else{
    		$NumberOfPost=2;
    	}
    	if (isset($instance['ShowTitle'])) {
    		$ShowTitle=True;
    	}else{
    		$ShowTitle=False;
    	}
    	if (isset($instance['ShowDate'])) {
    		$ShowDate=True;
    	}else{
    		$ShowDate=False;
    	}
    	?>
    	<p>
    	<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php echo __(esc_attr('Title: ')); ?></label>
    	<input class="widefat" type="text" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($title); ?>">
    	<em>The title of this widget, defautl Recenlty New with post-thumbnail</em>
    	</p>
    	<p style="border-bottom:4px double #eee;padding: 0 0 10px;">
    	<label for="<?php echo esc_attr($this->get_field_id('NumberOfPost')); ?>"><?php echo __(esc_attr('Number Of Post')); ?></label>
    	<input class="widefat" type="number" name="<?php echo esc_attr($this->get_field_name('NumberOfPost')); ?>" id="<?php echo esc_attr($this->get_field_id('NumberOfPost')); ?>" value="<?php echo esc_attr($NumberOfPost); ?>" width="100%">

    	<label for="<?php echo esc_attr($this->get_field_id('ShowTitle')); ?>"><?php echo __(esc_attr('Show post title')); ?></label>
    	<input class="widefat" type="checkbox" <?php checked($instance['ShowTitle'],true) ?> name="<?php echo esc_attr($this->get_field_name('ShowTitle')); ?>">

    	<label><?php echo __(esc_attr('Show Date')); ?></label>
    	<input <?php checked($instance['ShowDate'],true) ?> class="widefat" type="checkbox" id="<?php echo esc_attr($this->get_field_id('ShowDate')); ?>" name="<?php echo esc_attr($this->get_field_name('ShowDate')); ?>">

    	</p>
    	<?php 
    }

    public function update($new_instance,$old_instance)
    {
    	$instance=$old_instance;
    	$instance['title']=strip_tags($new_instance['title']);
    	$instance['NumberOfPost']=strip_tags($new_instance['NumberOfPost']);
    	$instance['ShowTitle']=$new_instance['ShowTitle']?1:0;
    	$instance['ShowDate']=$new_instance['ShowDate']?1:0;
    	return $instance;
    }
}

add_action('widgets_init',function(){
  register_widget('Recelty_Post_Thumbnail_Widget');
});
