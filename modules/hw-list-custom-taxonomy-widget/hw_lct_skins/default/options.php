<?php
/**
 * Created by PhpStorm.
 * User: Hoang
 * Date: 24/06/2015
 * Time: 09:26
 */
$theme_options[] = array(
    'name' => 'title_li',
    'type' => 'text',
    'description' => 'Set the title and style of the outer list item. Defaults to "Categories".',
    'value' => '',
    'method' => 'override'
);
$theme_options[] = array(
    'name' => 'remove_wrap',
    'type' => 'checkbox',
    'description' => 'loại bỏ wrap bao ngoài toàn bộ danh mục.'
);
$theme_options[] = array(
    'name' => 'current_item_class',
    'type' => 'text',
    'description' => 'Current item class',
    'value' => 'current-item',
    'method' => 'append'
);