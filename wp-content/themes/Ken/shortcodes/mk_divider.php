<?php

extract( shortcode_atts( array(
			'el_class' => '',
			'icon' => '',
			'divider_width' => 'full',
			'custom_width' => '',
			'align' => '',
			'style' => 'line',
			'divider_color' => '',
			'margin_top' => '20',
			'thickness' => '2',
			'margin_bottom' => '20',

		), $atts ) );
$output = $style_css = $custom_css = $align_css = '';

$custom_css = $divider_width == 'custom_width' ? 'width:'.$custom_width.'px;' : '';

if($align == 'left'){
	$align_css = '';
}else if ($align == 'center') {
	$align_css = 'margin: 0 auto;';	
}else{
	$align_css = 'margin: 0 0 0 auto;';
}

$style_id = uniqid();

$style_css .= '<style type="text/css">';
if($style == 'single'){
	$style_css .= '
        #divider-'.$style_id.' .divider-inner{
            border-width:'.$thickness.'px;
            height:'.$thickness.'px;
            '.$custom_css.'
            '.$align_css.'
        }
        ';	
}else{
	$style_css .= '
        #divider-'.$style_id.' .divider-inner{
            '.$custom_css.'
            '.$align_css.'
        }
        ';
}

$style_css .= '</style>';

$output .= '<div id="divider-'.$style_id.'" style="padding: '.$margin_top.'px 0 '.$margin_bottom.'px;" class="mk-divider divider_'.$divider_width.' divider-'.$style.' '.$el_class.'">';

	$border_color = (!empty($divider_color)) ? (' style="border-color:'.$divider_color.'"') : '';
	$output .= '<div'.$border_color.' class="divider-inner"></div>';
$output .= $style_css;
$output .= '</div><div class="clearboth"></div>';


echo $output;
