<?php

abstract class HW__Theme_Options {

}
/**
 * Class HW__Template_Condition
 */
abstract class HW__Template_Condition extends HW__Theme_Options{
	
}
/**
 * Class HW__Template_Configuration
 */
class HW__Template_Configuration /*extends HW_SimpleXMLElement*/{
	/**
     * theme configuration file
     */
    const DEFAULT_THEME_CONFIG_FILE = 'theme.xml';
    /**
     * @var
     */
    public  $configuration = array();
    /**
     * current theme configuration
     * @var
     */
    public static $theme_config = array();
    /**
     * parse theme config using wrx format
     * @param $file
     */
    public function parse($file) {
        $site = $menus = $assets = $libs = $modules = $plugins = $positions = $configuration = array();

        if(!class_exists('HW_WXR_Parser_SimpleXML') /*|| !hw_system_loaded()*/)
            return;
        $result = wp_cache_get( 'hoangweb.parse_theme_xml.'. $file, 'hoangweb.theme_config');
        if(false !== $result) {
            return $result; //maybe_serialize(
        }
        $xml = HW_WXR_Parser_SimpleXML::read_simplexml_object($file);
        if(is_wp_error($xml)) return ;

        $namespaces = $xml->namespaces;
        $xml = $xml->xml;

        $xml_parser = new HW_WXR_Parser();//::get_instance();
        $simplexml_parser = $xml_parser->simplexml_parser;

        //site meta
        if(isset($xml->site)) {
            $hw = $xml->site->children($namespaces['hw']);
            if(isset($hw->name)) $site['name'] = (string)$hw->name;
            if(isset($hw->description)) $site['description'] = (string)$hw->description;
            if(isset($hw->logo)) $site['logo'] = (string)$hw->logo;
            if(isset($hw->banner)) $site['banner'] = (string)$hw->banner;
            if(isset($hw->phone)) $site['phone'] = (string)$hw->phone;
            if(isset($hw->email)) $site['admin_email'] = (string)$hw->email;
            if(isset($hw->address)) $site['address'] = (string)$hw->address;
            if(isset($hw->testimonials)) $site['testimonials'] = (string)$hw->testimonials;
            if(!empty($hw->footer_text)) $site['footer'] = (string) $hw->footer_text;
        }
        //configuration
        if(isset($xml->configuration)) {
            $hw = $xml->configuration->children($namespaces['hw']);
            $configuration['sample_data'] =(string) $hw->sample_data;
            $media = $hw->media;//->children('hw');

            $configuration['media'] = array();
            foreach($media as $image) {
                foreach($image as $size) {
                    $atts = $size->attributes();
                    $configuration['media'][$size->getName()] = array(
                        'width'=> (string)$atts->width, 'height' => (string)$atts->height,
                        'crop' => (string) $atts->crop
                    );
                }
            }
            /*if(!empty($media->thumbnail)) $configuration['media']['thumbnail'] = (string) $media->thumbnail;
            if(!empty($media->medium)) $configuration['media']['medium'] = (string) $media->medium;
            if(!empty($media->large)) $configuration['media']['large'] = (string) $media->large;*/

            if((string)$hw->locale) $configuration['locale'] = (string)$hw->locale;
            else $configuration['locale'] = 'en';
            //settings
            if(!empty($hw->settings)) {
                //$settings = $hw->settings;
                $configuration['settings'] = $simplexml_parser->recursive_option_data($hw->settings[0]->children())->option;
            }
        }

        //fetch menus
        foreach ($xml->xpath('/theme/menus/hw:nav_menu') as $menu) {
            $atts = $menu->attributes();
            $menus[(string) $atts['slug']] = (string)$menu;
        }
        //fetch sidebars
        $sidebars = array();#$simplexml_parser->grab_sidebars($xml->xpath('/theme')[0], $namespaces);
        foreach ($xml->xpath('/theme/sidebars/hw:sidebar') as $sidebar_widgets) {
            $atts = $sidebar_widgets->attributes();
            $skin = (string) $atts['skin']; //sidebar skin
            $sidebar_name = (string)$atts['name'];
            if(!isset($sidebars[(string)$atts['name']] )) {
                $sidebars[$sidebar_name] = array('skin' => $skin, 'widgets' => array(),'params'=>array() );
            }

            //get widgets in sidebar
            $hw = $sidebar_widgets->children($namespaces['hw']);
            foreach ($hw->widget as $widget) {
                $name = (string) $widget->attributes()->name;
                $sidebars[$sidebar_name]['widgets'][] = $name;
            }
            //sidebar params
            $sidebars[$sidebar_name]['params'] = array('name' => $sidebar_name);
            if(!empty($hw->params)) {
                $sidebars[$sidebar_name]['params'] = array_merge($sidebars[$sidebar_name]['params'], $simplexml_parser->recursive_option_data($hw->params[0]->children())->option );
            }

        }
        //fetch assets
        foreach ($xml->xpath('/theme/assets') as $items) {
            $atts = $items->attributes();
            $page = isset($atts['page'])? (string) $atts['page'] : '__all__';
            //group by page
            if( !isset($assets[$page])) {
                $assets[$page] = array();
            }
            foreach($items as $item) {
                $atts = $item->attributes();
                $_file = array();
                $_file['type'] = !empty($atts['type'])? (string) $atts['type'] : '';
                //dependencies
                if(!empty($atts['depends'])) {
                    $_file['depends'] = explode(',', (string) $atts['depends']);
                }
                else $_file['depends'] = false;
                //handle
                if(!empty($atts['handle'])) $_file['handle'] = (string) $atts['handle'];
                if(!empty($atts['ver'])) $_file['ver'] = (string) $atts['ver']; //version

                $_file['name'] = (string) $item;
                $assets[$page][] = $_file;
            }
        }

        //fetch libs
        foreach ($xml->xpath('/theme/libs/lib') as $item) {
            $atts = $item->attributes();
            $lib = isset($atts['name'])? (string) $atts['name'] : (string) $item;
            $libs[] = $lib;
        }
        //fetch modules
        $modules_list = $xml->xpath('/theme/modules');
        if($modules_list) $only_list = (string)$modules_list[0]->attributes()->only_list;
        else $only_list = 0;

        if(!$only_list && class_exists('HW_TGM_Module_Activation')) {
            $installed_modules =HW_TGM_Module_Activation::get_register_modules(array('active'=>1,'core'=>1), 'or');#HW_Logger::log_file($installed_modules);   //get installed modules, refer to core modules
            foreach ($installed_modules as $slug=>$module) {
                $modules[$slug] = array('name' => $slug, 'status'=>1, 'core'=> !empty($module['force_activation']), 'active'=>1 );
            }
        }

        foreach ($xml->xpath('/theme/modules/module') as $item) {
            $atts = $item->attributes();
            $module['name'] = isset($atts['name'])? (string) $atts['name'] : (string) $item;
            $module['status'] = isset($atts['status'])? (string) $atts['status'] : 1;   //active module as default
            $modules[$module['name']] = $module;
        }
        //fetch wp plugins
        foreach ($xml->xpath('/theme/plugins/plugin') as $item) {
            $atts = $item->attributes();
            $plugin['name'] = isset($atts['name'])? (string) $atts['name'] : (string) $item;
            $plugin['status'] = isset($atts['status'])? (string)$atts['status'] : 1;   //active plugin as default
            $plugins[$plugin['name']] = $plugin;
        }
        //positions
        foreach ($xml->xpath('/theme/positions/position') as $item) {
            $atts = $item->attributes();
            //valid hook name
            $name = isset($atts['name'])? (string) $atts['name'] : (string) $item;
            $name = strtolower(HW_Validation::valid_objname($name));
            //display text
            $text = (string) $item;
            if(empty($text) && $name) $text = $name;

            //$positions[] = array('name' => $name, 'text' => $text);
            $positions[$name] = $text;
        }
        unset($xml);
        $data = array(
            'assets' => $assets,
            'libs' => $libs,
            'modules' => $modules,
            'plugins' => $plugins,
            'positions' => $positions,
            'sidebars' => $sidebars,
            'menus' => $menus,
            'site' => $site,
            'configuration' => $configuration
        );
        wp_cache_set( 'hoangweb.parse_theme_xml.'. $file, $data, 'hoangweb.theme_config');//_print($data);
        return $data;
    }

    /**
     * parse theme config data
     * @return object
     */
    public static function parse_theme_config($config = '') {
        //static $theme_config;
        //if(!empty(self::$theme_config[$config])) return self::$theme_config[$config];

        if(!$config ) $config = self::get_config_file();
        if(file_exists($config)  ) {
            if(!isset(self::$theme_config[$config])) self::$theme_config[$config] = new self(null) ;
            //because call the hook of after_setup_theme before do init hook we open all which to call this method
            //and after_setup_theme cause data load a half so data must tobe refresh, all i know about that
            if(1|| !HW_TGM_Module_Activation::is_complete_load() ||empty(self::$theme_config[$config]->configuration)) {
                self::$theme_config[$config]->configuration = self::$theme_config[$config]->parse( $config );
            }
            return self::valid_theme_config(self::$theme_config[$config]->configuration)? self::$theme_config[$config] : null;
        }

    }

    /**
     * get theme configs item
     * @param $item
     */
    public function item($item='') {
        if(!$this->configuration || ($item && empty($this->configuration[$item]))) return;
        if($item ) return $this->configuration[$item] ;
        else return $this->configuration;
    }

    /**
     * import theme configuration
     * @param $data
     */
    public function import($data) {
        if(is_string($data)) $data = $this->parse($data);
        if(is_array($data));
        foreach($data as $item => $config) {
            if(isset($this->configuration[$item]) && is_array($this->configuration[$item])) {
                $this->configuration[$item] = array_merge($this->configuration[$item], $config);
            }
            else $this->configuration[$item]= $config;
        }
    }
    /**
     * return current theme config file
     * @Param $page theme config file for specific page
     * @return string
     */
    public static function get_config_file($page = '') {
        if(!empty($page)) $page = '-'. trim($page);
        return get_stylesheet_directory(). '/config/theme'.$page.'.xml';
    }

    /**
     * validate theme configuration file
     * @param $file
     */
    public static function valid_theme_config($file='') {
        if(empty($file)) $file = self::get_config_file();
        if(is_array($file)) $config_data = $file;
        else {
            $config =new self();
            $config_data = $config->parse($file);
        }

        //if(!isset($config_data['configuration']['sample_data'])) return false;    //available options if not found
        return true;
    }
}

/**
 * Class HW__Template
 */
abstract class HW__Template extends HW__Template_Configuration{
    /**
     * text domain
     */
    const DOMAIN = 'hoangweb';
    /**
     * store all instances with fragments (singleton)
     * @var array
     */
    private static  $instances = array();
    /**
     * @var
     */
    private static $layouts;

    /**
     * current template object
     * @var null
     */
    protected static $current_template = null;
    /**
     * active theme config
     * @var null
     */
    protected static $current_theme_config = null;
    /**
     * theme config for certain page
     * @var array
     */
    public $config_data = array();

    /**
     * return parent class instance
     * @return HW__Theme_Options
     */
    public static function getInstance() {
        $parent = get_called_class();
        //if(property_exists(get_called_class(), 'instance')) {
            if( !isset(self::$instances[$parent])) {

                self::$instances[$parent] = new $parent;
            }
            return self::$instances[$parent];
        //}
    }
    

    /**
     * get all pages
     * @param bool $empty_item
     * @return array
     */
    public static function get_pages_select($empty_item = true) {
        $pages = get_pages();
        $options = array();
        foreach ($pages as $page) {
            $options[$page->ID] = $page->post_title;
        }
        if($empty_item && class_exists('HW_UI_Component') ) HW_UI_Component::empty_select_option($options);
        return $options;
    }
    /**
     * return all templates working on frontend
     * @return array
     */
    public static  function getTemplates() {
        self::$layouts = array(
            'single'=> 'Single',
            'archive' => 'Archive',
            'taxonomy'=>'Category/Taxonomy',
            'home' => 'Home',
            'page' => 'Page',
            '404' => '404',
            'author' => 'Author'
        );
        return self::$layouts ;
    }
    
    /**
     * return current list of loaded templates, used by get_template_part
     * @return string[]
     */
    static public function get_current_template_file() {
        if(isset($GLOBALS['hw_current_theme_template'])) return $GLOBALS['hw_current_theme_template'];  //get current template file in hook 'template_include'

        $included_files = get_included_files();
        $stylesheet_dir = str_replace( '\\', '/', get_stylesheet_directory() );
        $template_dir   = str_replace( '\\', '/', get_template_directory() );

        foreach ( $included_files as $key => $path ) {

            $path   = str_replace( '\\', '/', $path );

            if ( false === strpos( $path, $stylesheet_dir ) && false === strpos( $path, $template_dir ) )
                unset( $included_files[$key] );
        }

        return ( $included_files );
    }
    /**
     * check current page
     * @param $page
     * @param $result: return result of checking current context
     * @return bool
     */
    public static function check_template_page ($page, $result = true){
        //get template class name
        $template_class = 'HW__Template_'.$page;

        $data = array();

        switch($page) //return is_single();
        {
            case 'single':
                $data['result'] = is_single();break;
                //return array('result' => is_single(), 'object' => new HW__Template_category());

            case 'home': $data['result'] = is_home() || is_front_page();break;   //return array('result' => is_home() || is_front_page());
            case 'page': $data['result'] = is_page();break;   //return array('result' => is_page() );
            case 'taxonomy':
                global $wp_query;
                $data['result']= $wp_query->tax_query && (is_category() || is_tax());
                break;
            case 'archive': $data['result'] = is_archive();
                break;
            case 'author': $data['result'] = is_author(); break;
            case '404': $data['result'] = is_404();break;
            case 'admin': $data['result'] = is_admin() ; break;
        }
        if($data['result'] && class_exists($template_class) ) {
            $data['object'] = $template_class::getInstance();//new $template_class();
        }
        //added to fix
        //hw_load_class('HW__Template_home');
        /*if(!isset($data['object']) && class_exists('HW__Template_home')) {
            $data['object'] = HW__Template_home::getInstance();
        }*/

        return $result == true? $data['result'] : $data;
    }

    /**
     * get current template name
     */
    public static function get_current_template_name() {
        /*foreach(self::getTemplates() as $name => $text) {
            $result = self::check_template_page($name);
            if($result == true) return $name;
        }*/
        $data = self::get_current_template(false);
        return isset($data['name'])? $data['name'] : '';
    }

    /**
     * determine current template
     * @param bool $main_template
     * @return self::$current_template
     */
    public static function get_current_template($main_template=true) {
        if(empty(self::$current_template)) {
            //determine current template
            $pages = array_keys(self::getTemplates()) ;
            $pages[] = 'admin';
            foreach(array_filter($pages) as $page) {
                $temp_result = self::check_template_page($page, false);
                //main config
                $config = HW__Template_Configuration::parse_theme_config();

                if( ($temp_result['result'] == true && isset($temp_result['object'])) ) {//die;
                    $temp_result['name'] = $page;
                    $child_config = array();
                    //parse theme config
                    if(file_exists(self::get_config_file($page))) {
                        $child_config = HW__Template_Configuration::parse_theme_config(self::get_config_file($page))->configuration;
                    }
                    //main config
                    if($config && is_array( $config->configuration ))
                    foreach($config->configuration as $name=> &$data) {
                        if(!empty($child_config[$name]) && is_array($data)) {
                            $data = array_merge($data, $child_config[$name]);   //override
                        }
                    }
                    unset($child_config);   //free memory
                    $temp_result['object']->config_data = $config;

                    self::$current_template = $temp_result;
                    break;
                }
            }
        }
        return $main_template? (isset(self::$current_template['object'])? self::$current_template['object']:null) : self::$current_template;
    }

    /**
     * get current theme config data
     * @param string $item
     * @return array|null
     */
    public static function get_active_theme_config_data($item='') {
        $current = self::get_current_template();
        if(empty($current)) return;
        $config = $current->get_config_data();
        //return $item? (isset($config[$item])? $config[$item]: null) : $config;
        if(!$config) return null;
        return $item? ($config->item($item)? $config->item($item): null) : $config->item();
    }
    /**
     * get current context loop template
     */
    public static function get_current_context_loop_template (){
        //$context = self::get_current_template_file();   //get current template
        //get loop templates options
        $loop_temps = hw_get_setting(array('my_templates','main_loop_content_style'));
        if(is_array($loop_temps))
        foreach ($loop_temps as $item) {
            $is_temp = self::check_template_page($item['layout'],false);
            if($is_temp['result'] ) {
                if(isset($is_temp['object'])) $item['template_object'] = $is_temp['object'];
                return $item;
                break;
            }
        }

    }
    
    
    /**
     * get footer, instead of calling get_header()
     * @param $slug from get_header() param
     */
    public static function get_header($slug) {
        get_header($slug);
        do_action('hw_get_header'); //do before hook `hw_after_header`
    }
    /**
     * return template file match any standard file that refer to files theme
     * @param $header_data: file header data in array, if not given get default any template header file in wordpress
     */
    public static function list_active_theme_templates($header_data = array()){
        static $result = null;
        if($result) return $result;
        if(!empty($header_data)) $template_header_data = $header_data;
        else {
            $template_header_data = array(
                'name'          => 'Template Name',
                'description'   => 'Description',
                'author'        => 'Author',
                'uri'           => 'Author URI',
            );
        }
        $result = array();
        //iterator
        $theme_dir_path = get_stylesheet_directory();   //get current theme directory
        $skins_iterator = new RecursiveDirectoryIterator( $theme_dir_path );
        $RecursiveIterator = new RecursiveIteratorIterator( $skins_iterator );
        //$RecursiveIterator->setMaxDepth(1); //max depth to 1
        foreach ( $RecursiveIterator as $file ) {
            if(basename( $file ) == '.' || basename( $file ) == '..') continue;
            $data = get_file_data($file, $template_header_data);
            if(!$data['name']) continue;
            $data['path'] = (dirname( $file )).DIRECTORY_SEPARATOR.basename($file);
            $data['file'] = basename($file);
            $result[] = $data;
        }

        return $result;
    }

    /**
     * register theme deactivation hook
     * @param $code  Code of the theme. This must match the value you provided in wp_register_theme_activation_hook function as $code
     * @param $function Function to call when theme gets deactivated.
     */
    public static function register_theme_deactivation_hook($code, $function) {
        // store function in code specific global
        $GLOBALS["wp_register_theme_deactivation_hook_function" . $code]=$function;

        // create a runtime function which will delete the option set while activation of this theme and will call deactivation function provided in $function
        $fn=create_function('$theme', ' call_user_func($GLOBALS["wp_register_theme_deactivation_hook_function' . $code . '"]); delete_option("theme_is_activated_' . $code. '");');

        // add above created function to switch_theme action hook. This hook gets called when admin changes the theme.
        // Due to wordpress core implementation this hook can only be received by currently active theme (which is going to be deactivated as admin has chosen another one.
        // Your theme can perceive this hook as a deactivation hook.)
        add_action("switch_theme", $fn);
    }

    /**
     * register theme activation hook
     * @param $code Code of the theme. This can be the base folder of your theme. Eg if your theme is in folder 'mytheme' then code will be 'mytheme'
     * @param $function Function to call when theme gets activated.
     */
    public static function register_theme_activation_hook($code, $function) {
        $optionKey="theme_is_activated_" . $code;
        if(!get_option($optionKey)) {
            call_user_func($function);
            update_option($optionKey , 1);
        }
    }
    /**
     * init
     */
    public static function init() {
        //parse config file
        _hw_global('theme_config', self::get_theme_config());
        //$config['sidebars'];

        //determine current template
        _hw_global('current_template',self::get_current_template() );

        //register positions for current theme
        self::register_theme_positions();
    }
    /**
     * setup hooks
     */
    public static  function setup() {
        //init hooks
        add_action('init', array(__CLASS__,'init'), 11); //should be run after 'init' hook from class-tgm-hw-private-plugin-activation.php file

        if(self::validate_theme()) add_action('wp_enqueue_scripts', array(__CLASS__,'_custom_enqueue_scripts'));
        add_action('wp_enqueue_scripts', array(__CLASS__, 'wp_enqueue_scripts'));

        add_action('wp_head', array(__CLASS__, '_print_header'));
        add_action('wp_footer', array(__CLASS__, '_print_footer'));
        add_action( 'widgets_init', array(__CLASS__, '_widgets_init' ));
        add_action('after_setup_theme', array(__CLASS__, '_after_setup_theme'));
        add_action( 'after_switch_theme', array(__CLASS__, '_after_switch_theme'), 1 );

        //add_action('shutdown', array(__CLASS__, '_test'));
        //register template pages
        require_once(__DIR__. '/templates/template-category-taxonomy.php');
        require_once(__DIR__. '/templates/template-404.php');
        require_once(__DIR__. '/templates/template-page.php');
        require_once(__DIR__. '/templates/template-single.php');
        //require_once(__DIR__. '/templates/template-admin.php');
        require_once(__DIR__. '/templates/template-home.php');
        require_once(__DIR__. '/templates/template-archive.php');
        require_once(__DIR__. '/templates/template-author.php');
    }
    //just test
    static function _test(){
        HW_Logger::log_file('------------');
    }
    /**
     * return current template
     * @return null
     */
    public static function get_current() {
        return self::$current_template;
    }

    /**
     * load theme positions
     */
    protected static function register_theme_positions() {
        $positions = self::get_active_theme_config_data('positions');
        if(!empty($positions) && is_array($positions)) {
            foreach($positions as $pos => $text) {
                register_position($pos, $text);
            }
        }
        //default hook
        //register_position('the_content', 'the_content');
    }

    /**
     * register navmenus
     */
    protected static function register_navmenus() {
        $menus = self::get_active_theme_config_data('menus');//_print($menus);
        if(!empty($menus))
        foreach($menus as $menu => $name) {
            // This theme uses wp_nav_menu() in one location.
            register_nav_menu( $menu, __( $name, self::DOMAIN ) );
        }
    }
    /**
     * setup wp theme
     * @hook after_setup_theme
     */
    public static function _after_setup_theme() {
        /*
         * Makes hoangweb available for translation.
         *
         * Translations can be added to the /languages/ directory.
         * If you're building a theme based on hoangweb, use a find and replace
         * to change 'hoangweb' to the name of your theme in all the template files.
         */
        load_theme_textdomain( self::DOMAIN, get_stylesheet_directory() . '/languages' );

        // This theme styles the visual editor with editor-style.css to match the theme style.
        add_editor_style();

        // Adds RSS feed links to <head> for posts and comments.
        add_theme_support( 'automatic-feed-links' );

        // This theme supports a variety of post formats.
        add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'status' ) );
        // This theme uses a custom image size for featured images, displayed on "standard" posts.
        add_theme_support( 'post-thumbnails' );

        /*
         * This theme supports custom background color and image, and here
         * we also set up the default background color.
         */
        add_theme_support( 'custom-background', array(
            'default-color' => 'e6e6e6',
        ) );
        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support( 'title-tag' );

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array(
            'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
        ) );

        /*
         * Enable support for Post Formats.
         * See https://codex.wordpress.org/Post_Formats
         */
        add_theme_support( 'post-formats', array(
            'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
        ) );

        //register nav menus
        self::register_navmenus();
    }

    public static function _after_switch_theme() {
        global $pagenow;

        if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' ) {
            return;
        }
        // Image sizes
        $config = self::get_theme_config();
        if(!$config) return ;
        $configuration = $config->item('configuration');
        if(!empty($configuration['media'])) {
            foreach($configuration['media'] as $name=> $arg) {
                update_option( $name, $arg );
            }
        }
        //update options
        if(!empty($configuration['settings'])) {
            foreach($configuration['settings'] as $key=> $value) {
                if(!is_numeric($key) && is_string($key)) update_option( $key, $value );
            };
        }
    }
    /**
     * Registers our main widget area and the front page widget areas.
     * @hook widgets_init
     */
    public static function _widgets_init() {
        $config = self::get_theme_config();
        if(!$config) return ;
        //get sidebars
        //$sidebars = array();
        $sidebars = $config->item('sidebars');
        if($sidebars)
        foreach ($sidebars as $id=>$sidebar) {
            if(isset($sidebar['params'])) $args = $sidebar['params'];
            else $args = $sidebar;
            if(!isset($args['id'])) $args['id'] = $id;
            register_sidebar($args);
        }
    }

    /**
     * default scripts & stylesheets
     */
    public static function wp_enqueue_scripts() {
        //default js
        //if(!is_admin()) HW_Libraries::enqueue_jquery_libs('pageload/nprogress');    //show progressbar while page loading
    }
    /**
     * enqueue assets for js+css file
     * @hook wp_enqueue_scripts
     */
    public static function _custom_enqueue_scripts() {
        global $wp_styles;
        $current = self::get_current_template(false);
        $config = $current['object']->get_config_data();    #$current['object']
        $active_assets = array();
        $assets = $config->item('assets')? $config->item('assets'): array();//->item('assets');

        /*
         * From WP
         * Adds JavaScript to pages with the comment form to support
         * sites with threaded comments (when in use).
         */
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
            wp_enqueue_script( 'comment-reply' );

        //common assets
        if(!empty($assets['__all__'])) {
            $active_assets = array_merge($active_assets, $assets['__all__']);
        }

        if(!empty($assets[$current['name']])) {  //get assets for current context
            $active_assets = array_merge($active_assets, $assets[$current['name']]);
        }
        foreach($active_assets as $file) {
            //valid file path
            if(!is_dir($file['name']) && !file_exists($file['name'])) {
                $url = get_stylesheet_directory_uri() . '/' .$file['name'];
            }
            else $url = $file['name'];
            if(!HW_URL::valid_url($url)) continue;
            $handle = isset($file['handle'])? $file['handle'] : md5($file['name']);
            //for js
            if($file['type'] == 'js') {

                if(HW_URL::valid_url($url)) {
                    wp_enqueue_script($handle, $url, $file['depends']);
                }
                continue;
            }
            //for stylesheet
            elseif($file['type'] == 'css') {
                wp_enqueue_style(md5($file['name']),  $url, $file['depends']);
                continue;
            }
        }
        if(is_object($current) && method_exists($current, 'enqueue_scripts')) {
            call_user_func(array($current, 'enqueue_scripts')); //addition stuff
        }

    }

    /**
     * print some tags in head tag
     * @hook wp_head
     */
    public static function _print_header() {
        $current = self::get_current_template();
        if(is_object($current) && method_exists($current, 'wp_head')) {
            call_user_func(array($current, 'wp_head'));
        }
    }

    /**
     * print something at bottom of page
     * @hook wp_footer
     */
    public static function _print_footer(){
        $current = self::get_current_template();
        if(is_object($current) && method_exists($current, 'wp_footer')) {
            call_user_func(array($current, 'wp_footer'));
        }

    }


    /**
     * return config data for current context
     * @param string $item
     * @return array
     */
    public function get_config_data($item='') {
        return $item? ($this->config_data->item($item)? $this->config_data->item($item) : '') : $this->config_data;
    }

    /**
     * parse theme config file
     * @return null|object
     */
    public static function get_theme_config($config='') {
        return HW__Template_Configuration::parse_theme_config($config);
    }

    /**
     * valid theme
     * @param $theme_name theme name
     */
    public static function validate_theme($theme_name='') {
        if(!$theme_name) {
            $theme_name = wp_get_theme()->get_template();#get_stylesheet_directory();
        }
        $my_theme = wp_get_theme( $theme_name );
        if ( $my_theme->exists() ) {
            #$my_theme->get( 'Name' );
            #$my_theme->get( 'Version' );
            $config_files = $my_theme->get_files('xml',-1, true);
            if(count($config_files) && isset($config_files['config/'.self::DEFAULT_THEME_CONFIG_FILE])) {
                return true;
            }
        }
        return false;
    }
    public static function reload_configration() {
        $file = self::get_config_file();
        wp_cache_delete('hoangweb.parse_theme_xml.'. $file, 'hoangweb.theme_config');
    }
}

/**
 * load layouts
 */
HW__Template::setup();
