<?php
class HW_Frontend {
	function __construct() {
		add_filter('post_class', array($this, '_post_class') );
		add_filter( 'body_class', array($this, '_body_class') );
	}
	/**
     * adjust post_class
     * @param $classes
     */
    public function _post_class($classes){
        if(($key = array_search('page', $classes)) !== false) {     //remove default class generate by wordpress
            unset($classes[$key]);
        }
        $class_page = $this->get_nhp__content_classes('post_class');
        if($class_page) $classes[] = $class_page;
        //__save_session('classes',$classes);
        return $classes;
    }

    /**
     * get content_classes option base current context
     * @param $field field to return value
     * @return mixed
     */
    private function get_nhp__content_classes($field = 'post_class') {
        $classes_page = hw_template_vars('content_classes');
        
        //valid
        if(!in_array($field, array('post_class', 'body_class'))) return;

        if(is_array($classes_page)) {
            foreach ($classes_page as $page => $class) {
                if(HW__Template::check_template_page($page)) {
                    if(isset($class[$field])) return $class[$field];
                    else return '';
                    break;
                }
            }
        }
    }

    /**
     * body class
     * @param $classes
     */
    public function _body_class($classes) {
    	if ( ! is_multi_author() )
            $classes[] = 'single-author';

        $class_page = $this->get_nhp__content_classes('body_class');
        if($class_page) $classes[] = $class_page;

        return $classes;
    }
}
new HW_Frontend;