<?php
$el_class = $width = $el_position = '';

extract( shortcode_atts( array(
			'el_class' => '',
			'style' => 'style1',
		), $atts ) );

$output = '';

$output .= "\n\t".'<div class="'.$el_class.'"><div class="mk-fancy-table mk-shortcode table-'.$style.'">';
$output .= "\n\t\t\t".wpb_js_remove_wpautop( $content );
$output .= "\n\t".'</div></div>';

echo $output;
