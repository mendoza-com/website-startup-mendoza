<?php

extract(shortcode_atts(array(
	'title' => false,
	'style' => 'simple',
	'icon' => '',
	'icon_color' => '',
	'pane_bg' => '',
	"el_class" => '',
), $atts));

$id = uniqid();
$output = '';

if (!empty($icon)) {
	$icon = (strpos($icon, 'mk-') !== FALSE) ? ($icon) : ('mk-' . $icon);
} else {
	$icon = '';
}

$output .= '<div id="mk-toggle-' . $id . '" class="mk-toggle mk-shortcode ' . $style . '-style ' . $el_class . '">';
$output .= '<div class="mk-toggle-title"><i style="color:' . $icon_color . '" class="' . $icon . '"></i>' . $title . '</div>';
$output .= '<div class="mk-toggle-pane"><div style="background-color:' . $pane_bg . '" class="inner-box">' . wpb_js_remove_wpautop(do_shortcode(trim($content))) . '</div></div></div>';
echo $output;
