<?php
/**
 * HWMenu Template: default menu skin
 */
$theme['styles'][] = 'style.css';
$theme['scripts'][] = 'js.js';
//$theme['scripts'][] = '';
$theme['args'] = array(
    //'ex_separator' => '<span class="separator"></span>',
    'submenu_container_class' => 'sub-menu sublist',
    'container_class' => 'hw-menu-def-container header-menu',
    'menu_item_class_focus' => "current-item",
    'menu_class' => 'menu1',
    //'before' => '<span>',
    //'after' => '</span>',
    //'link_before' => '<div>',
    //'link_after' => '</div>',
    'menu_id' => 'nav',
    'menu_class' => 'top-menu',
    'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',

);

//register filters for this skin
$theme['filters'] = array(
    'wp_nav_menu_items' => array(
        'type' => 'filter',
        'function' => 'hw_menu_def_add_home_link',
        'accepted_args' => 3,
        'priority' => 10
    )
);

//run this hook if current nav_menu enable by hw-menu plugin
if(!function_exists('hw_menu_def_add_home_link')):
    function hw_menu_def_add_home_link($items, $args,$theme)
    {
        //get theme args
        if(!isset($theme['do_filters_args_'.__FUNCTION__])) return $items;
        $theme = $theme['do_filters_args_'.__FUNCTION__];

        $menu = HW_NAVMENU::get_menu_name($args);    //get current menu
        if($menu != $theme['menu']) return $items;  //compare real-value to which value that keep in theme args

        $homeMenuItem='<li ><a class="home456546" href="' . home_url('/') . '">'. $args->link_before . 'XX' . $args->link_after . '</a>' . $args->after . '</li>';
        /*$menu = HW_NAVMENU::get_menu_name($args);
        if (is_front_page()) $class='active';else $class = '';

        $homeMenuItem='<li class="' . $class . '">' . $args->before . '<a class="home active" href="' . home_url('/') . '" title="Trang chủ">'. $args->link_before . '' . $args->link_after . '</a>' . $args->after . '</li>';

        $items=$homeMenuItem . $items;*/
        return $homeMenuItem.$items;
    }
endif;