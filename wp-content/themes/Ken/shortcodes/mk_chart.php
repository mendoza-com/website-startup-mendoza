<?php

extract( shortcode_atts( array(
			'desc' => '',
			'percent' => '',
			'bar_color' => '',
			'track_color' => '',
			'line_width' => '',
			'bar_size' => '',
			'content' => '',
			'content_type' => '',
			'icon' => '',
			'icon_size' => '32px',
			'font_size' => '18',
			'font_weight' => 'default',
			'custom_text' => '',
			'el_class' => '',
			'animation' => '',
		), $atts ) );


if(!empty( $icon )) {
    $icon = (strpos($icon, 'mk-') !== FALSE) ? ( $icon ) : ( 'mk-'.$icon );    
} else {
    $icon = '';
}

$animation_css = ($animation != '') ? (' mk-animate-element ' . $animation . ' ') : '';
$output = '<div class="'.$animation_css.'">';
$output .= '<div class="mk-chart" style="width:'.$bar_size.'px;height:'.$bar_size.'px;line-height:'.$bar_size.'px" data-percent="'.$percent.'" data-barColor="'.$bar_color.'" data-trackColor="'.$track_color.'" data-lineWidth="'.$line_width.'" data-barSize="'.$bar_size.'">';
if ( $content_type == 'icon' ) {
	$output .= '<i style="line-height:'.$bar_size.'px;color:'.$bar_color.'; font-size: '.$icon_size.';" class="'.$icon.'"></i>';
} elseif ( $content_type == 'custom_text' ) {
	$output .= '<span class="chart-custom-text" style="font-size:'.$font_size.'px; color:'.$bar_color.'; font-weight:'.$font_weight.';">'.$custom_text.'</span>';
} else {
	$output .= '<div class="chart-percent" style="font-size:'.$font_size.'px; color:'.$bar_color.'; font-weight:'.$font_weight.';"><span>'.$percent.'</span>%</div>';
}
$output .= '</div>';
$output .= '<div class="mk-chart-desc">'.$desc.'</div>';
$output .= '</div>';
echo $output;
