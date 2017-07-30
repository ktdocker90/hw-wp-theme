<?php
/**
 * @param $name
 * @param $class
 * @param bool $autoload
 * @return HW_Admin_Options singleton for class
 */
function _hw_global($name, $class='', $autoload=false) {
    if(!isset($GLOBALS['hoangweb'])) $GLOBALS['hoangweb'] = array();
    if(!isset($GLOBALS['hoangweb'][$name]) && $class ) {
        if( is_string($class) && class_exists($class ,$autoload)  ) {
            if(method_exists($class, 'get_instance')) $GLOBALS['hoangweb'][$name] = call_user_func(array($class, 'get_instance'));
            else $GLOBALS['hoangweb'][$name] =  new $class;
        }
        elseif(is_object($class)) {
            $GLOBALS['hoangweb'][$name] = $class;
        }
    }

    return isset($GLOBALS['hoangweb'][$name])? $GLOBALS['hoangweb'][$name] : null;
}

/**
 * @param string $key
 * @param string $defVal
 * @return mixed|string
 */
if(!function_exists('hw_template_vars')) :
function hw_template_vars($key='', $defVal='') {
    static $data = array();
    //$t = HW__Template::get_current();
    $theme_dir = get_stylesheet_directory();

    if(!count($data) && file_exists($theme_dir. '/hw-templates.php')) {
        $data = include ($theme_dir. '/hw-templates.php');
    }
    if($key && isset($data[$key])) return $data[$key];
    return $key? $defVal : $data;
}
endif;

/**
 * @param $file
 * @param $args
 * @return string
 */
if(!function_exists('hw_fetch_tpl')) :
function hw_fetch_tpl($file, $args=array()) {
    static $data=array();
    if(isset($data[$file])) return $data[$file];
    if(!is_file($file)) {
        $file = get_stylesheet_directory(). '/'. $file;
    }
    //echo $file;
    if(file_exists($file)) {
        ob_start();
        extract($args);
        include ($file);
        $text = ob_get_contents();//
        ob_get_clean();//if(strpos($file,'rating')!==false)_print(nl2br($text));
        $data[$file] = $text;
        return $text;
    }
}
endif;

if(!function_exists('_print')) :
	function _print($txt) {
		echo '<textarea>';
		print_r($txt);
		echo '</textarea>';
	}
endif;
