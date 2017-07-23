<?php
/**
 * remember that file theme options named 'options.php' associated with current theme folder
 */
$theme_options[]=array(
    'name' => 'theme',
    'type' => 'select',
    'options' => array('clean','minimalist', 'round', 'square'),
    'description' => "Chọn theme cho slider, chấp nhận giá trị: 'clean','minimalist', 'round', 'square'."
);
$theme_options[] = array(
    'name' => 'fullscreen',
    'type' => 'checkbox',
    'description' => "Chế độ toàn màn hình."
);
$theme_options[] = array(
    'name' => 'numbers',
    'type' => 'checkbox',
    'description' => 'Nút số chỉ định chuyển slide. <img src=""/>'
);
$theme_options[] = array(
    'name' => 'numbers_align',
    'type' => 'select',
    'options' => 'center,left,right',
    'description' => 'Vị trí nút định hướng slides'
);
$theme_options[] = array(
    'name' => 'progressbar',
    'type' => 'checkbox',
    'description' => 'Hiển thị progressbar'
);
$theme_options[] = array(
    'name' => 'dots',
    'type' => 'checkbox',
    'description' => 'Hiển thị nút?'
);
$theme_options[] = array(
    'name' => 'preview',
    'type' => 'checkbox',
    'description' => 'Hiển thị xem trước ảnh xem slide hiện tại.'
);

$theme_options[] = array(
    'type' => 'checkbox',
    'name' => 'auto_play',
    'description' => 'Sets whether the slideshow will start automatically',
    'value'=>'1'
);
$theme_options[] = array(
    'name' => 'interval',
    'type' => 'text',
    'description' => 'Interval between transitions',
    'value' => '2500'
);
$theme_options[] = array(
    'name' => 'label',
    'type' => 'checkbox',
    'description' => 'Label display'
);
$theme_options[] = array(
    'name' => 'labelAnimation',
    'type' => 'select',
    'description' => 'Label animation type',
    'options' => 'slideUp,left,right,fixed'
);
$theme_options[] = array(
    'type' => 'select',
    'name' => 'animation',
    'description' => 'animation',
    'options' => 'cube,cubeRandom,block,cubeStop,cubeHide,cubeSize,horizontal,showBars,showBarsRandom,tube,fade,fadeFour,paralell,blind,blindHeight,blindWidth,directionTop,directionBottom,directionRight,directionLeft,cubeStopRandom,cubeSpread,cubeJelly,glassCube,glassBlock,circles,circlesInside,circlesRotate,cubeShow,upBars,downBars,hideBars,swapBars,swapBarsBack,swapBlocks,cut,random,randomSmart'
);
$theme_options[] = array(
    'name'=> 'enable_navigation_keys',
    'type'=> 'checkbox',
    'description' => 'Enable navigation keys',

);
$theme_options[] = array(
    'name' => 'hideTools',
    'type' => 'checkbox',
    'description' => 'Hide numbers and navigation'
);
$theme_options[] = array(
    'name' => 'show_randomly',
    'type' => 'checkbox',
    'description' => 'Randomly sliders'
);
$theme_options[] = array(
    'name' => 'stop_over',
    'type' => 'checkbox',
    'description' => 'Stop animation to move mouse over it.'
);
$theme_options[] = array(
    'name' => 'thumbs',
    'type' => 'checkbox',
    'description' => 'Navigation with thumbs'
);
$theme_options[] = array(
    'name' => 'velocity',
    'type' => 'text',
    'description' => 'Velocity of animation',
    'value'=> '1'
);
$theme_options[] = array(
    'name'=> 'width_label',
    'type' => 'text',
    'description' => 'Width label',
    'value' => '300px'
);
?>