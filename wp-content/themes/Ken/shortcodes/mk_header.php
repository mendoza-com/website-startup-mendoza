<?php

extract( shortcode_atts( array(
			'menu_location' => '',
			'squeeze' => 'true',
			'align' => 'left',
			'wideness' => 'boxed',
			'show_logo' => 'true',
			'show_search' => 'true',
			'show_cart' => 'true',
			'el_class' => '',
		), $atts ) );


$output = '';

$menu_location = $menu_location ? $menu_location : 'primary-menu';

global $mk_settings;

$logo_height = (!empty($mk_settings['logo']['height'])) ? $mk_settings['logo']['height'] : 50;



if($squeeze == 'true') {
	$header_height = $logo_height/1.5 + ($mk_settings['header-padding']/2.4 * 2);
	$header_class = 'sticky-trigger-header ';
} else {
	$header_height = $logo_height + ($mk_settings['header-padding'] * 2);
	$header_class = '';
}



$output .= '<header id="mk-header" data-sticky-height="'.intval($header_height).'" class="mk-secondary-header show-cart-'.$show_cart.' show-search-'.$show_search.' show-logo-'.$show_logo.' '.$wideness.'-header header-align-'.$align.' header-structure-standard put-header-top mk-header-module '.$header_class.$el_class.'" data-header-style="block" data-header-structure="standard">';

if($wideness == 'boxed') {
	$output .= '<div class="mk-grid">';
}


ob_start();
do_action('main_navigation', $menu_location);

$output .= ob_get_contents();
ob_end_clean();


if($wideness == 'boxed') {
	$output .= '</div>';
}

if($mk_settings['side-dashboard']) :

	if(!isset($mk_settings['side-dashboard-icon']) && empty($mk_settings['side-dashboard-icon'])){ 
		$dashboard_icon = 'mk-theme-icon-dashboard2'; 
	}else{ 
		$dashboard_icon = $mk_settings['side-dashboard-icon']; 
	}

  $output .= '<div class="dashboard-trigger desktop-mode"><i class="'.$dashboard_icon.'"></i></div>';
endif; 

$output .= '</header>';

$output .= '<div class="responsive-nav-container"></div>';

$output .= '<div style="height:'.intval($header_height).'px;" class="secondary-header-space"></div>';

echo $output;
