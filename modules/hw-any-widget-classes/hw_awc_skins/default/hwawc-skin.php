<?php
/**
 * Plugin Name: default
 */
$theme['styles'][] = 'style.css';   //register stylesheet

//sidebar widget params
$theme['params']['before_title'] = '<div class="tab-menu" style="%1$s {css_title}">';
$theme['params']['after_title'] = '</div><div class="tab-Content" style="%1$s {css_box}"><div class="body-tabser">';
$theme['params']['before_widget'] = '<div id="%1$s" class="bdtab %2$s">';
$theme['params']['after_widget'] = '</div></div> </div>';
$theme['css_title_selector']='.hw-awc-override .tab-menu';
$theme['css_content_selector'] = '.hw-awc-override .tab-Content';