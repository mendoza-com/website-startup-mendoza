<?php

extract( shortcode_atts( array(
			'text' => '',
			'style' => '',
			'fill_color' => '',
			'el_class' => '',
		), $atts ) );

$fill_color_css = '';
if($style == 'custom') {
	$fill_color_css = ' style="background-color:'.$fill_color.';"';
}

echo '<span'.$fill_color_css.' class="mk-highlight '.$style.'-highlight '.$el_class.'">'.$text.'</span>';
