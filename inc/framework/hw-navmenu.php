<?php
require_once(__DIR__. '/hw-walker-navmenu.php');

/**
 * from HW_NAVMENU
 * Class HW_CustomNavMenu
*/
class HW_CustomNavMenu {
	/**
     * save current menu args
     * @var null
     */

    private $menu_args = array();
    /**
     * construct
     */
    public function __construct(){
    	$this->setup_hooks();   //init hooks
    }
    /**
     * seting up hooks
     */
    private function setup_hooks(){
        //list hooks for nav menu
        //add_filter('wp_nav_menu_items', array($this, '_add_custom_navmenu'), 10, 2);
        add_filter( 'wp_page_menu_args', array($this, '_page_menu_args' ));
        add_filter('nav_menu_link_attributes',array($this, '_nav_menu_link_attributes'),10,4);
        add_filter('nav_menu_css_class', array($this, '_addspecial_nav_class'), 10, 2);
        //add_filter('walker_nav_menu_start_el', array($this,'_walker_nav_menu_start_el'), 10, 4);
        add_filter('wp_nav_menu', array($this, '_filter_wp_nav_menu'));
        add_filter( 'wp_nav_menu_args', array($this, '_modify_nav_menu_args' ));

        //my filters
        add_filter('hw_navmenu_link_attributes', array($this, '_hw_navmenu_link_attributes'), 10, 5);
        add_filter('hw_wp_nav_menu', array($this, '_hw_wp_nav_menu'), 10);

    }
    /**
     * get default wp_nav_menu args
     */
    public static function get_default_navmenu_args(){
        return array(
            'container' => 'div',
            'container_id' => '',
            'menu_class' => 'menu',
            'echo' => true
        );
    }
    /**
     * get menu slug
     * @param mixed $menu: menu args or menu name
     */
    public static function get_menu_name($menu = ''){
        //get current menu
        if(is_object($menu) || is_array($menu)){
            $menu = (object)$menu;  //cast to object
            if(!empty($menu->theme_location)) $menu =  $menu->theme_location;
            elseif(!empty($menu->menu) ) {
                if(is_string($menu->menu)) $menu = $menu->menu;
                else $menu = $menu->menu->name; //for custom menu widget
            }
        }

        return is_string($menu)? $menu : '';
    }
    /**
     * filter wp_nav_menu output
     * @param $output: output of wp_nav_menu function
     */
    public function _filter_wp_nav_menu($output){
        $args = $this->menu_args;   //get current menu args
        /**
         * nav item class
         */
        $first_nav_item_class = !empty($args->first_menu_item_class)? $args->first_menu_item_class.' ' : '';
        $last_nav_item_class = !empty($args->last_menu_item_class)? $args->last_menu_item_class.' ' : '';

        //add first class & last class to nav menu item
        $output = preg_replace( '/class="menu-item/', 'class="'.$first_nav_item_class.'menu-item ', $output, 1 );
        $output = substr_replace( $output, 'class="'.$last_nav_item_class.' menu-item', strripos( $output, 'class="menu-item' ), strlen( 'class="menu-item' ) );

        //valid
        if(!isset($args->container)) $args->container = 'div';
        if(!isset($args->allow_tags_nav_menu)) $args->allow_tags_nav_menu = '';

        /**
         * remove ul,li tags surround menu output
         */
        if(isset($args->only_anchor_tag_nav_menu)) {
            $args->allow_tags_nav_menu .= '<a>';
        }
        $args->allow_tags_nav_menu .= "<{$args->container}>";   //allow container tag

        if(isset($args->only_anchor_tag_nav_menu) && $args->only_anchor_tag_nav_menu && !empty($args->allow_tags_nav_menu)) {

            $output = strip_tags($output,$args->allow_tags_nav_menu);
        };
        return $output;
    }
    /**
     * modify nav menu link anchor tag
     * note: if this callback of the hook that mean you not link specific menu to wp_nav_menu
     * @param $attributes
     * @param $output
     * @param $item
     * @param $depth
     * @param $args
     * @return mixed
     */
    public function _hw_navmenu_link_attributes($attributes, $output, $item, $depth, $args){

        return $attributes;
    }
    /**
     * filter menu output
     * @hook hw_wp_nav_menu
     * @param $menus
     */
    public function _hw_wp_nav_menu($menus) {
        $args = $this->menu_args;   //get current menu args

        if(isset($args->show_lang_buttons_outside) && isset($args->langs_switcher)
            && ($args->show_lang_buttons_outside == 'on' || $args->show_lang_buttons_outside)
            /*&& $depth==0*/) {
            $menus .= '<div class="hw-langs-switcher">'. $args->langs_switcher . '</div>';
        }
        return $menus;
    }
    /**
     * if this callback of the hook that mean you not link specific menu to wp_nav_menu
     * @hook filter 'wp_nav_menu_args'
     * @param $args
     */
    public function _modify_nav_menu_args($args){
    	//get current menu name
        $menu = self::get_menu_name($args);
        $args['container'] = false;
        $opts = hw_template_vars('navmenu', array());
        $args = array_merge($args, isset($opts[$menu])? $opts[$menu]: array());//_print($args);

        $args['walker'] = new HW_Walker_Nav_Menu();

        $this->menu_args = (object)$args;   //save current menu args

        return $args;
    }

    /**
     * callback for action 'nav_menu_link_attributes'
     * note: if this callback of the hook that mean you not link specific menu to wp_nav_menu
     * @param $atts
     * @param $item
     * @param $args
     * @return mixed
     */
    public function _nav_menu_link_attributes($atts, $item, $args, $walker){
        //for qtranslate plugin
        // Integration with qTranslate Plugin
        #if($item->url=='/' && function_exists('qtrans_convertURL')){    //home item
        if(function_exists('qtrans_convertURL') && isset($atts['href'])) {
            $atts['href'] = qtrans_convertURL($item->url);
        }
        #}

        //anchor class name
        if(isset($args->anchor_class) && trim($args->anchor_class)) {
            #if(!isset($atts['class'])) $atts['class'] = '';
            if(!in_array($args->anchor_class, $atts['class'])) $atts['class'][] = (!empty($atts['class'])?' ':'').$args->anchor_class;  //add class to anchor tag
        }

        return $atts;
    }
    /**
     * filter nav menu item
     * note: if this callback of the hook that mean you not link specific menu to wp_nav_menu
     * @param $output
     * @param $item
     * @param $depth
     * @param $args
     */
    //no longer use
    public function _walker_nav_menu_start_el($output, $item, $depth, $args){
        $data['args'] = $args;  //extend args data
        $args = (object) $args;     //cast to object
        $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';

        $attributes .=!empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';

        $attributes .=!empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';

        // Integration with qTranslate Plugin
        /*if(function_exists('qtrans_convertURL')){
            $item->url = qtrans_convertURL($item->url);
        }*/

        $attributes .=!empty($item->url) ? ' href="' . esc_attr( $item->url ) . '"' : '';

        $output = $args->before;
        $attributes .= apply_filters('hw_navmenu_link_attributes', $attributes, $output, $item, $depth, $args); //filter link attributes for wp theme
        $data['attributes'] = $attributes;
        $data['title'] = apply_filters('the_title', $item->title, $item->ID);

        $output .= '<a' . $attributes . '>';

        $output .= $args->link_before . $data['title'] . $args->link_after;

        $output .= '</a>';

        $output .= $args->after;

        return $output;
    }
    /**
     * customize menu css
     * @param $classes: classes for current menu item
     * @param $item: nav item object
     */
    public function _addspecial_nav_class($classes, $item){
        //valid
        //if(empty($item->classes) || !is_array($item->classes))
        //menu_item_class_focus;
        if(in_array('current-menu-item',(array)$item->classes)){    //current item
            $classes[]='hw-menu-item-focus';
            if(!empty($this->menu_args->menu_item_class_focus)) {
                $classes[] = $this->menu_args->menu_item_class_focus;
            }
        }
        else {
            $classes[]='hw-menu-item-normal';
            if(!empty($this->menu_args->menu_item_class)) {
                $classes[] = $this->menu_args->menu_item_class;
            }
        }
        /*other of purpose
        preg_match('/[^\/]+$/', trim($item->url, '/'), $r); //get page

        if (is_page() && is_page($r[0]))
            $classes[]='active';
*/
        return $classes;
    }

    /**
     * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
     *
     * @since hoangweb 1.0
     */
    public function _page_menu_args( $args ) {
        //get current menu
        $current_menu = self::get_menu_name($args);
        $show_home = 1;
        //$show_home = HW_NavMenu_Metabox_settings::get_menu_setting('show_home_menu', $current_menu);    //show home item in the navmenu?

        if($show_home){
            if ( ! isset( $args['show_home'] ) )
                $args['show_home'] = true;
        }
        return $args;
    }
}
new HW_CustomNavMenu();