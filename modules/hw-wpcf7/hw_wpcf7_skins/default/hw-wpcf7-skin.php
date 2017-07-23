<?php 
/**
 *Plugin Name: default 
 *note: hook callback (or handler) must different name for each other skin
 */
//$this->set_form_class();
//$theme['styles'][] = 'style.css';   //new way ->building
//$theme['scripts'][] = '';
$theme['template'] = '';

/**
 * modify form class attribute
 */
add_filter('hw_wpcf7_form_class_attr', '_hw_wpcf7_form_class_attr',$priority);
function _hw_wpcf7_form_class_attr(){
    return ' hw-wpcf-default'; //note leave a space in the left of string to separate new class         
}

add_action('hw_wpcf7_contact_form_css', 'hw_wpcf7_contact_form_css',$priority);   //old way
function hw_wpcf7_contact_form_css($form){
    wp_enqueue_style('hw-wpcf7-default-skin', HW_SKIN::current()->get_skin_url('style.css'));
    ?>

<?php 
}
#HW_SKIN::current_file_url('style.css',__FILE__);

?>