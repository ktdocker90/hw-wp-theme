<?php
/**
Plugin Name: theme
*/
//rememer that you should use different name to enqueue file correctly
include('theme-setting.php');

echo $before_widget;
echo '<div id="hwlct-widget-'.$tax.'-container" class="list-custom-taxonomy-widget">';
if ( $title ) echo $before_title . $title . $after_title;

if($dropdown){
    echo '<form action="'. get_bloginfo('url'). '" method="get">';
    wp_dropdown_categories($args);
    echo '<input type="submit" value="go &raquo;" /></form>';
}
else{ ?>
    <div id="lct-widget-<?php echo $tax ?>" class="hwlct-container hwlct-travel-box">
    <?php
    //wp_list_categories($args);
    HW_POST::reset_item_counter();
    //$data = get_categories($args);
    foreach($terms_data as $i =>$term){
        $classes= array('item-box');
        if($awc_enable_grid_posts && isset($awc_grid_posts_cols) && class_exists('HW_POST')) {
            $classes = HW_POST::get_item_class($awc_grid_posts_cols,$classes);
        }

        ?>
        <div  <?php HW_POST::item_class($classes)?> id="<?php echo $term->term_id?>">
            <div class="category-item">
                <div class="picture">
                    <a href="<?php echo get_term_link($term);?>" title="<?php echo $term->name; ?>">
                        <?php
                    
                    if(hwz_taxonomy_image_url($term->term_id)) $image = hwz_taxonomy_image_url($term->term_id);
                    elseif(function_exists('get_field')) $image = get_field('image',$term);                    
                    else $image = '';
                    if(!$image) $image = HW_SKIN::current()->get_skin_url('images/placeholder.png');
                            ?>

                            <img src="<?php echo $image?>" width="150px"/>

                    </a>
                </div>
                <div class="picture-shadow"></div>
                <h2 class="title">
                    <a href="<?php echo get_term_link($term);?>" title="<?php echo $term->name; ?>">
                        <?php echo $term->name?>
                    </a>
                </h2>
                <div class="category-description">
                    <?php ECHO $term->description?>
                </div>
                <a href="<?php echo esc_url( get_edit_term_link( $term, $term->taxonomy) ); ?>">Edit</a>
            </div>
        </div>
<?php
    } ?>
    </div>
<?php
}
echo '</div><div class="clearfix"></div>';
echo $after_widget;
?>
<style>

</style>