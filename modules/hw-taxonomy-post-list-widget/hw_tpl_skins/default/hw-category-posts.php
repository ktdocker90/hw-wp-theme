<?php
/**
Plugin Name: Box
**/
?>
<?php 
if(empty($instance['thumb_w'])) $instance['thumb_w']='60';
if(empty($instance['thumb_h'])) $instance['thumb_h']='60';

include('theme-setting.php');
//show view all link
#echo $view_all_link;
HW_HOANGWEB::load_class('HW_POST');
HW_HOANGWEB::load_class('HW_String');

//other way to track count items
HW_POST::reset_item_counter();


//fancybox
if(isset($wfeatures['fancybox'])) {
    $fancybox_g1 = $wfeatures['fancybox']['data']->fancybox_group;
    $fancy_group = $wfeatures['fancybox']['data']->fancybox_group_rel;
}
else {
    $fancybox_g1 = '';
    $fancy_group = '';
}

echo $before_widget;
// Widget title
echo $before_title.$open_title_link;
if(isset($instance["widget_title"])) echo $instance["widget_title"];
echo $close_title_link.$after_title;//_print($cat_posts);
?>
<div id="<?php echo $hwtpl_wrapper_id?>" class="hwtpl-wrapper">
	<div class="<?php echo $hwtpl_scrollbar_wrapper_class?>">
	<div class="tpl-content"><!-- class="smoothDivScroll" ->for scrolling content option -->

		<?php
        while ( $cat_posts->have_posts() )
			{ 
				$cat_posts->the_post(); 
				$classes=array();
if( 0 == $cat_posts->current_post || 0 == $cat_posts->current_post % 4 )
          $classes[] = 'first';
	 if(($cat_posts->current_post+1) % 4 == 0) $classes[]='lastcolumn';
        //other way
            //HW_POST::get_item_class();

                if(isset($awc_enable_grid_posts) && $awc_enable_grid_posts && class_exists('HW_POST') && !empty($awc_grid_posts_cols)) {
                    $classes = HW_POST::get_item_class($awc_grid_posts_cols , $classes);
                }

                //display post custom fields
                if(in_array('duration',$metaFields)){
                    $duration = get_post_meta(get_the_ID(),'duration',true);
                }
                $classes = implode(' ',$classes);
                //feature image
                $full_image_src = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );     //for fancybox

                ?>
                <div class="col-md-3 box-user">
                    <a href="<?php the_permalink()?>">
                        <?php
                        if (
                            function_exists('the_post_thumbnail') &&
                            current_theme_supports("post-thumbnails") &&
                            //in_array("thumb",$arrExlpodeFields) &&
                            has_post_thumbnail()
                        ) :
                            ?>
                            <?php the_post_thumbnail( $image_size, array(
                            'style'=>""
                        ,'class'=>'img')); ?>
                        <?php
                        else:
                            ?>
                            <img src="<?php echo HW_SKIN::current()->get_skin_url('images/placeholder.png')?>" width="50px"/>
                        <?php
                        endif;
                        ?>

                    </a>
                    <a href="<?php the_permalink()?>"><strong class="title-shop">
                            <?php if(function_exists('hwtpl_limit_str')) echo hwtpl_limit_str(get_the_title());
                            else the_title();
                            ?>
                        </strong></a>
                    <div class="txtAddress">
                        <?php echo get_post_meta(get_the_ID(), 'address', true)?>
                    </div>
                    <div class="content-user">
                        <?php if(in_array('excerpt', $arrExlpodeFields)) the_excerpt()?>
                    </div>
                </div>

    <?php }
        wp_reset_postdata();
    ?>

		</div>
	</div>
			<div class="clearfix"></div>
	
<!-- show pagination -->
<?php 
#$this->load_pagination($hwtpl_pagination_class);
?>
</div>
<?php
echo $after_widget;
?>