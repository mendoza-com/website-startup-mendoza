<?php
extract( shortcode_atts( array(
			'size' => 'medium',
			'style' => 'default',
			'icon' => '',
			'color' => '',
			'bg_color' => '',
			'border_color' => '',
			'hover_color' => '',
			'bg_hover_color' => '',
			'border_hover_color' => '',
			'padding_horizental' => 4,
			'padding_vertical' => 4,
			'align' => '',
			'animation' => '',
			'infinite_animation' => '',
			'link' => '',
			'remove_frame' => '',
			'border_width' => '',
			'el_class' => '',
		), $atts ) );

global $mk_accent_color;

$icon_css = $style_css = '';


$infinite_animation = !empty($infinite_animation) ? (' mk-'.$infinite_animation) : '';
$animation_css = ($animation != '') ? ' mk-animate-element ' . $animation . ' ' : '';
$style_id = uniqid();

if(!empty( $icon )) {
    $icon = (strpos($icon, 'mk-') !== FALSE) ? ( $icon ) : ( 'mk-'.$icon );
} else {
    $icon = '';
}

$style_css .= '<style type="text/css">';

if ( $style == 'default' ) {
    $style_css .= '
        #icon-font-'.$style_id.' i{
            color:'.$mk_accent_color.';
        }
        ';
}else if($style == 'filled'){
	$style_css .= '
        #icon-font-'.$style_id.' i{
            background-color:'.$mk_accent_color.';
            color:'.$color.';
        }
        ';
}else if($style == 'custom'){
	$style_css .= '
        #icon-font-'.$style_id.' i {
            background-color:'.$bg_color.';
            color:'.$color.';
            border-color:'.$border_color.';
        }
        #icon-font-'.$style_id.' i:hover {
            background-color:'.$bg_hover_color.';
            color:'.$hover_color.';
            border-color:'.$border_hover_color.';
        }
        ';
}
$style_css .= '</style>';

	$remove_frame_css = ($remove_frame == 'true') ? ' remove-frame' : '';


$output = '<span id="icon-font-'.$style_id.'" class="mk-font-icons mk-shortcode icon-align-'.$align.$remove_frame_css.' '.$animation_css.$el_class.'">';
if ( $link ) {
	$output .= '<a class="mk-smooth" href="'.$link.'">';
}
$output .= '<i style="margin:'.$padding_vertical.'px '.$padding_horizental.'px; border-width:'.$border_width.'px; '.$icon_css.'" class="'.$icon.' '.$style.'-font-icon mk-size-'.$size.$infinite_animation.'"></i>';

if ( $link ) {
	$output .= '</a>';
}
$output .= '</span>';
$output .= $style_css;

echo $output;
