<?php
#/.current_path/theme.php
/**
 * Class HW__Template_home
 */
class HW__Template_home extends HW__Template {
    public function enqueue_scripts() {

    }
    public function wp_head(){}
    public function wp_footer(){}

    /**
     * main loop content
     */
    public function Main(){

        do_action('hw_before_loop');
        $this->content();
        do_action('hw_after_loop');

    }

    /**
     * show content 404
     */
    private  function content() {
        ?>
        <h2><?php _e( 'Not found', 'hoangweb' ); ?></h2>
        <div class="defaultContent BlockContent">
            <p><?php _e( 'Sorry ! The data you are querying has no results.', 'hoangweb' ); ?></p>
            <?php get_search_form(); ?>
        </div>
        <?php
    }
    /**
     * trigger when invoke HW_HOANGWEB::register_class method
     */
    public static function __init(){

    }
}