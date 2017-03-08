<?php

extract( shortcode_atts( array(
			'src' => '',
			'animation' => '',
			'speed' => 2000,
			'height' => 300,
			'link' => '',
			'target' => '_self',
			'el_class' => '',
			'visibility' => ''
		), $atts ) );


$output = '';

$animation_css = ($animation != '') ? (' mk-animate-element ' . $animation . ' ') : '';


$output .= '<div class="mk-window-scroller '.$visibility.' '.$animation_css.$el_class.'" data-speed="'.$speed.'" data-height="'.$height.'">';

$image_id = mk_get_attachment_id_from_url($src);
$alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
$title = get_the_title($image_id);

$output .= '<div class="window-top-bar"><span></span></div>';

$output .= (!empty($link)) ? '<a target="'.$target.'" href="'.$link.'">' : '';
$output .= '<div class="image-holder" style="height:'.$height.'px"><img alt="'.$alt.'" title="'.$title.'" src="'.$src.'" /></div>';
$output .= (!empty($link)) ? '</a>' : '';

$output .= '<div class="clearboth"></div></div>';

echo $output;
