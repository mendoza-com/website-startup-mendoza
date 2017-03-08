<?php

/*
 *
 * Contains all the dynamic css rules generated based on theme settings.
 *
 */

function mk_dynamic_css() {

	wp_enqueue_style('mk-style', get_stylesheet_uri(), false, false, 'all');

	global $mk_settings;

	$output = $typekit_fonts_1 = $attach = '';

/* Get skin color from global $_GET for skin switcher panel */
	if (isset($_GET['skin'])) {
		$accent_color = '#' . $_GET['skin'];
		$mk_settings['footer-link-color']['hover'] = '#' . $_GET['skin'];
		$mk_settings['dashboard-link-color']['hover'] = '#' . $_GET['skin'];
		$mk_settings['sidebar-link-color']['hover'] = '#' . $_GET['skin'];
		$mk_settings['link-color']['hover'] = '#' . $_GET['skin'];
		$mk_settings['footer-social-color']['hover'] = '#' . $_GET['skin'];
		$mk_settings['main-nav-top-color']['hover'] = '#' . $_GET['skin'];
		$mk_settings['main-nav-sub-color']['bg-hover'] = '#' . $_GET['skin'];

	} else {
		$accent_color = $mk_settings['accent-color'];
	}

/**
 * Typekit fonts
 * */

	$typekit_id = isset($mk_settings['typekit-id']) ? $mk_settings['typekit-id'] : '';
	$typekit_elements_list_1 = isset($mk_settings['typekit-element-names']) ? $mk_settings['typekit-element-names'] : '';
	$typekit_font_family_1 = isset($mk_settings['typekit-font-family']) ? $mk_settings['typekit-font-family'] : '';

	if ($typekit_id != '' && $typekit_elements_list_1 != '' && $typekit_font_family_1 != '') {
		if (is_array($typekit_elements_list_1)) {
			$typekit_elements_list_1 = implode(', ', $typekit_elements_list_1);
		} else {
			$typekit_elements_list_1 = $typekit_elements_list_1;
		}
		$typekit_fonts_1 = $typekit_elements_list_1 . ' {font-family: "' . $typekit_font_family_1 . '"}';

	}

###########################################
# Structure
###########################################

// Sidebar Width deducted from content width percentage
	$sidebar_width = 100 - $mk_settings['content-width'];

	$boxed_layout_width = $mk_settings['grid-width']+60;


	$output .= "
.mk-grid,
.mk-inner-grid
{
	max-width: {$mk_settings['grid-width']}px;
}

.theme-page-wrapper.right-layout .theme-content, .theme-page-wrapper.left-layout .theme-content
{
	width: {$mk_settings['content-width']}%;
}

.theme-page-wrapper #mk-sidebar.mk-builtin
{
	width: {$sidebar_width}%;
}



.mk-boxed-enabled,
.mk-boxed-enabled #mk-header.sticky-header,
.mk-boxed-enabled #mk-header.transparent-header-sticky,
.mk-boxed-enabled .mk-secondary-header
{
	max-width: {$boxed_layout_width}px;

}

@media handheld, only screen and (max-width: {$mk_settings['grid-width']}px)
{

#sub-footer .item-holder
{
	margin:0 20px;
}

}

";

###########################################
	# Backgrounds
	###########################################

/**
 * Body background
 */
	$body_bg = $mk_settings['body-bg']['color'] ? 'background-color:' . $mk_settings['body-bg']['color'] . ';' : '';
	$body_bg .= $mk_settings['body-bg']['url'] ? 'background-image:url(' . $mk_settings['body-bg']['url'] . ');' : ' ';
	$body_bg .= $mk_settings['body-bg']['position'] ? 'background-position:' . $mk_settings['body-bg']['position'] . ';' : '';
	$body_bg .= $mk_settings['body-bg']['attachment'] ? 'background-attachment:' . $mk_settings['body-bg']['attachment'] . ';' : '';
	$body_bg .= $mk_settings['body-bg']['repeat'] ? 'background-repeat:' . $mk_settings['body-bg']['repeat'] . ';' : '';
	$body_bg .= (isset($mk_settings['body-bg']['cover']) && $mk_settings['body-bg']['cover'] == 1) ? 'background-size: cover;background-repeat: no-repeat;-moz-background-size: cover;-webkit-background-size: cover;-o-background-size: cover;' : '';

/**
 * Header background
 */
	$header_bg_color = $mk_settings['header-bg']['color'] ? 'background-color:' . $mk_settings['header-bg']['color'] . ';' : '';
	$header_bg = $mk_settings['header-bg']['color'] ? 'background-color:' . $mk_settings['header-bg']['color'] . ';' : '';
	$header_bg .= $mk_settings['header-bg']['url'] ? 'background-image:url(' . $mk_settings['header-bg']['url'] . ');' : ' ';
	$header_bg .= $mk_settings['header-bg']['position'] ? 'background-position:' . $mk_settings['header-bg']['position'] . ';' : '';
	$header_bg .= $mk_settings['header-bg']['attachment'] ? 'background-attachment:' . $mk_settings['header-bg']['attachment'] . ';' : '';
	$header_bg .= $mk_settings['header-bg']['repeat'] ? 'background-repeat:' . $mk_settings['header-bg']['repeat'] . ';' : '';
	$header_bg .= (isset($mk_settings['header-bg']['cover']) && $mk_settings['header-bg']['cover'] == 1) ? 'background-size: cover;background-repeat: no-repeat;-moz-background-size: cover;-webkit-background-size: cover;-o-background-size: cover;' : '';

/**
 * Page Title background
 */
	$page_title_bg = $mk_settings['page-title-bg']['color'] ? 'background-color:' . $mk_settings['page-title-bg']['color'] . ';' : '';
	$page_title_bg .= $mk_settings['page-title-bg']['url'] ? 'background-image:url(' . $mk_settings['page-title-bg']['url'] . ');' : ' ';
	$page_title_bg .= $mk_settings['page-title-bg']['position'] ? 'background-position:' . $mk_settings['page-title-bg']['position'] . ';' : '';
	$page_title_bg .= $mk_settings['page-title-bg']['attachment'] ? 'background-attachment:' . $mk_settings['page-title-bg']['attachment'] . ';' : '';
	$page_title_bg .= $mk_settings['page-title-bg']['repeat'] ? 'background-repeat:' . $mk_settings['page-title-bg']['repeat'] . ';' : '';
	$page_title_bg .= (isset($mk_settings['page-title-bg']['cover']) && $mk_settings['page-title-bg']['cover'] == 1) ? 'background-size: cover;background-repeat: no-repeat;-moz-background-size: cover;-webkit-background-size: cover;-o-background-size: cover;' : '';
	$page_title_bg .= $mk_settings['page-title-bg']['border'] ? 'border-bottom:1px solid ' . $mk_settings['page-title-bg']['border'] . ';' : '';

/**
 * Page background
 */
	$page_bg = $mk_settings['page-bg']['color'] ? 'background-color:' . $mk_settings['page-bg']['color'] . ';' : '';
	$page_bg .= $mk_settings['page-bg']['url'] ? 'background-image:url(' . $mk_settings['page-bg']['url'] . ');' : ' ';
	$page_bg .= $mk_settings['page-bg']['position'] ? 'background-position:' . $mk_settings['page-bg']['position'] . ';' : '';
	$page_bg .= $mk_settings['page-bg']['attachment'] ? 'background-attachment:' . $mk_settings['page-bg']['attachment'] . ';' : '';
	$page_bg .= $mk_settings['page-bg']['repeat'] ? 'background-repeat:' . $mk_settings['page-bg']['repeat'] . ';' : '';
	$page_bg .= (isset($mk_settings['page-bg']['cover']) && $mk_settings['page-bg']['cover'] == 1) ? 'background-size: cover;background-repeat: no-repeat;-moz-background-size: cover;-webkit-background-size: cover;-o-background-size: cover;' : '';

/**
 * Footer background
 */
	$footer_bg = $mk_settings['footer-bg']['color'] ? 'background-color:' . $mk_settings['footer-bg']['color'] . ';' : '';
	$footer_bg .= $mk_settings['footer-bg']['url'] ? 'background-image:url(' . $mk_settings['footer-bg']['url'] . ');' : ' ';
	$footer_bg .= $mk_settings['footer-bg']['position'] ? 'background-position:' . $mk_settings['footer-bg']['position'] . ';' : '';
	$footer_bg .= $mk_settings['footer-bg']['attachment'] ? 'background-attachment:' . $mk_settings['footer-bg']['attachment'] . ';' : '';
	$footer_bg .= $mk_settings['footer-bg']['repeat'] ? 'background-repeat:' . $mk_settings['footer-bg']['repeat'] . ';' : '';
	$footer_bg .= (isset($mk_settings['footer-bg']['cover']) && $mk_settings['footer-bg']['cover'] == 1) ? 'background-size: cover;background-repeat: no-repeat;-moz-background-size: cover;-webkit-background-size: cover;-o-background-size: cover;' : '';

	$page_title_color = $mk_settings['page-title-color'];
	$page_title_size = $mk_settings['page-title-size'];
	$page_title_padding = 40;
	$page_title_weight = '';
	$page_title_letter_spacing = '';

	if (global_get_post_id()) {


		$post_id = global_get_post_id();

		$intro = get_post_meta($post_id, '_page_title_intro', true);

		
		if($intro != 'none') {
			$attach = 'background-attachment: scroll;';
		}

		$enable = get_post_meta($post_id, '_custom_bg', true);

		if ($enable == 'true') {
			$body_bg = get_post_meta($post_id, 'body_color', true) ? 'background-color: ' . get_post_meta($post_id, 'body_color', true) . ';' : '';
			$body_bg .= get_post_meta($post_id, 'body_image', true) ? 'background-image:url(' . get_post_meta($post_id, 'body_image', true) . ');' : '';
			$body_bg .= get_post_meta($post_id, 'body_repeat', true) ? 'background-repeat:' . get_post_meta($post_id, 'body_repeat', true) . ';' : '';
			$body_bg .= get_post_meta($post_id, 'body_position', true) ? 'background-position:' . get_post_meta($post_id, 'body_position', true) . ';' : '';
			$body_bg .= get_post_meta($post_id, 'body_attachment', true) ? 'background-attachment:' . get_post_meta($post_id, 'body_attachment', true) . ';' : '';
			$body_bg .= (get_post_meta($post_id, 'body_cover', true) == 'true') ? 'background-size: cover;background-repeat: no-repeat;-moz-background-size: cover;-webkit-background-size: cover;-o-background-size: cover;' : '';

			$header_bg = get_post_meta($post_id, 'header_color', true) ? 'background-color: ' . get_post_meta($post_id, 'header_color', true) . ';' : '';
			$header_bg_color = get_post_meta($post_id, 'header_color', true) ? 'background-color: ' . get_post_meta($post_id, 'header_color', true) . ';' : '';
			$header_bg .= get_post_meta($post_id, 'header_image', true) ? 'background-image:url(' . get_post_meta($post_id, 'header_image', true) . ');' : '';
			$header_bg .= get_post_meta($post_id, 'header_repeat', true) ? 'background-repeat:' . get_post_meta($post_id, 'header_repeat', true) . ';' : '';
			$header_bg .= get_post_meta($post_id, 'header_position', true) ? 'background-position:' . get_post_meta($post_id, 'header_position', true) . ';' : '';
			$header_bg .= get_post_meta($post_id, 'header_attachment', true) ? 'background-attachment:' . get_post_meta($post_id, 'header_attachment', true) . ';' : '';
			$header_bg .= (get_post_meta($post_id, 'header_cover', true) == 'true') ? 'background-size: cover;background-repeat: no-repeat;-moz-background-size: cover;-webkit-background-size: cover;-o-background-size: cover;' : '';

			$page_title_bg = get_post_meta($post_id, 'banner_color', true) ? 'background-color: ' . get_post_meta($post_id, 'banner_color', true) . ';' : '';
			$page_title_bg .= get_post_meta($post_id, 'banner_image', true) ? 'background-image:url(' . get_post_meta($post_id, 'banner_image', true) . ');' : '';
			$page_title_bg .= get_post_meta($post_id, 'banner_repeat', true) ? 'background-repeat:' . get_post_meta($post_id, 'banner_repeat', true) . ';' : '';
			$page_title_bg .= get_post_meta($post_id, 'banner_position', true) ? 'background-position:' . get_post_meta($post_id, 'banner_position', true) . ';' : '';
			$page_title_bg .= get_post_meta($post_id, 'banner_attachment', true) ? 'background-attachment:' . get_post_meta($post_id, 'banner_attachment', true) . ';' : '';
			$page_title_bg .= (get_post_meta($post_id, 'banner_cover', true) == 'true') ? 'background-size: cover;background-repeat: no-repeat;-moz-background-size: cover;-webkit-background-size: cover;-o-background-size: cover;' : '';

			$page_bg = get_post_meta($post_id, 'page_color', true) ? 'background-color: ' . get_post_meta($post_id, 'page_color', true) . ' !important;' : '';
			$page_bg .= get_post_meta($post_id, 'page_image', true) ? 'background-image:url(' . get_post_meta($post_id, 'page_image', true) . ') !important;' : '';
			$page_bg .= get_post_meta($post_id, 'page_repeat', true) ? 'background-repeat:' . get_post_meta($post_id, 'page_repeat', true) . ' !important;' : '';
			$page_bg .= get_post_meta($post_id, 'page_position', true) ? 'background-position:' . get_post_meta($post_id, 'page_position', true) . ' !important;' : '';
			$page_bg .= get_post_meta($post_id, 'page_attachment', true) ? 'background-attachment:' . get_post_meta($post_id, 'page_attachment', true) . ' !important;' : '';
			$page_bg .= (get_post_meta($post_id, 'page_cover', true) == 'true') ? 'background-size: cover;background-repeat: no-repeat;-moz-background-size: cover;-webkit-background-size: cover;-o-background-size: cover;' : '';

			$footer_bg = get_post_meta($post_id, 'footer_color', true) ? 'background-color: ' . get_post_meta($post_id, 'footer_color', true) . ';' : '';
			$footer_bg .= get_post_meta($post_id, 'footer_image', true) ? 'background-image:url(' . get_post_meta($post_id, 'footer_image', true) . ');' : '';
			$footer_bg .= get_post_meta($post_id, 'footer_repeat', true) ? 'background-repeat:' . get_post_meta($post_id, 'footer_repeat', true) . ';' : '';
			$footer_bg .= get_post_meta($post_id, 'footer_position', true) ? 'background-position:' . get_post_meta($post_id, 'footer_position', true) . ';' : '';
			$footer_bg .= get_post_meta($post_id, 'footer_attachment', true) ? 'background-attachment:' . get_post_meta($post_id, 'footer_attachment', true) . ';' : '';
			$footer_bg .= (get_post_meta($post_id, 'footer_cover', true) == 'true') ? 'background-size: cover;background-repeat: no-repeat;-moz-background-size: cover;-webkit-background-size: cover;-o-background-size: cover;' : '';

			$page_title_color = get_post_meta($post_id, '_page_title_color', true) ? get_post_meta($post_id, '_page_title_color', true) : $mk_settings['page-title-color'];
			$page_title_weight = get_post_meta($post_id, '_page_title_weight', true) ? ('font-weight:' . get_post_meta($post_id, '_page_title_weight', true)) : '';
			$page_title_letter_spacing = get_post_meta($post_id, '_page_title_letter_spacing', true) ? ('letter-spacing:' . get_post_meta($post_id, '_page_title_letter_spacing', true) . 'px;') : '';

			$page_title_size = get_post_meta($post_id, '_page_title_size', true) ? get_post_meta($post_id, '_page_title_size', true) : $mk_settings['page-title-size'];
			$page_title_padding = get_post_meta($post_id, '_page_title_padding', true) ? get_post_meta($post_id, '_page_title_padding', true) : 40;
		}

	}

	$header_bottom_border = (isset($mk_settings['header-bottom-border']) && !empty($mk_settings['header-bottom-border'])) ? ('border-bottom:1px solid' . $mk_settings['header-bottom-border'] . ';') : '';

	$output .= "body,
.theme-main-wrapper
{
{$body_bg}
}

.mk-side-dashboard {
	background-color:{$mk_settings['dashboard-bg']};
}";

if (isset($mk_settings['header-border-top']) && ($mk_settings['header-border-top'] == 1)) {
		$output .= "
		.theme-main-wrapper:not(.vertical-header) #mk-header,
		.theme-main-wrapper:not(.vertical-header) .mk-secondary-header
		{
			border-top:1px solid {$accent_color};
		}";
}

$output .= "#mk-header,
.mk-secondary-header
{
{$header_bg};
}

.sticky-header-padding {
	{$header_bg_color}
}

#mk-header.transparent-header-sticky,
#mk-header.sticky-header {
{$header_bottom_border}}


.transparent-header.light-header-skin,
.transparent-header.dark-header-skin
 {
  border-top: none !important;
  background: none !important;
}

#mk-page-title .mk-page-title-bg {
{$page_title_bg};
{$attach}
}

#theme-page
{
{$page_bg}}

#mk-footer
{
{$footer_bg}
}
#sub-footer
{
	background-color: {$mk_settings['sub-footer-bg']};
}

#mk-page-title
{
	padding:{$page_title_padding}px 0;
}

#mk-page-title .mk-page-heading{
	font-size:{$page_title_size}px;
	color:{$page_title_color};
{$page_title_weight};
{$page_title_letter_spacing};
}
#mk-breadcrumbs {
	line-height:{$page_title_size}px;
}

";

###########################################
	# Widgets
	###########################################

	$widget_font_family = (isset($mk_settings['widget-title']['font-family']) && !empty($mk_settings['widget-title']['font-family'])) ? ('font-family:' . $mk_settings['widget-title']['font-family'] . ';') : '';
	$widget_font_size = (isset($mk_settings['widget-title']['font-size']) && !empty($mk_settings['widget-title']['font-size'])) ? ('font-size:' . $mk_settings['widget-title']['font-size'] . ';') : '';
	$widget_font_weight = (isset($mk_settings['widget-title']['font-weight']) && !empty($mk_settings['widget-title']['font-weight'])) ? ('font-weight:' . $mk_settings['widget-title']['font-weight'] . ';') : '';
	$widget_title_divider = (isset($mk_settings['widget-title-divider']) && $mk_settings['widget-title-divider'] == 1) ? '' : 'display: none;'; 

	$output .= ".widgettitle
{
{$widget_font_family}
{$widget_font_size}
{$widget_font_weight}
}

.widgettitle:after{
	{$widget_title_divider}
}

.mk-side-dashboard .widgettitle,
.mk-side-dashboard .widgettitle a
{
	color: {$mk_settings['dashboard-title-color']};
}


.mk-side-dashboard,
.mk-side-dashboard p
{
	color: {$mk_settings['dashboard-txt-color']};
}

.mk-side-dashboard a
{
	color: {$mk_settings['dashboard-link-color']['regular']};
}

.mk-side-dashboard a:hover
{
	color: {$mk_settings['dashboard-link-color']['hover']};
}";
if($mk_settings['header-structure'] == 'margin'){
	$output .= "
	.mk-side-dashboard 
	{
		width: 270px !important;
		right: 20px !important;
	}
	";
}


$output .= "#mk-sidebar .widgettitle,
#mk-sidebar .widgettitle  a
{
	color: {$mk_settings['sidebar-title-color']};
}


#mk-sidebar,
#mk-sidebar p
{
	color: {$mk_settings['sidebar-txt-color']};
}

#mk-sidebar a
{
	color: {$mk_settings['sidebar-link-color']['regular']};
}

#mk-sidebar a:hover
{
	color: {$mk_settings['sidebar-link-color']['hover']};
}


#mk-footer .widgettitle,
#mk-footer .widgettitle a
{
	color: {$mk_settings['footer-title-color']};
}

#mk-footer,
#mk-footer p
{
	color: {$mk_settings['footer-txt-color']};
}

#mk-footer a
{
	color: {$mk_settings['footer-link-color']['regular']};
}

#mk-footer a:hover
{
	color: {$mk_settings['footer-link-color']['hover']};
}

.mk-footer-copyright,
.mk-footer-copyright a {
	color: {$mk_settings['footer-socket-color']} !important;
}

.mk-footer-social a {
	color: {$mk_settings['footer-social-color']['regular']} !important;
}

.mk-footer-social a:hover {
	color: {$mk_settings['footer-social-color']['hover']}!important;
}

";

###########################################
	# Typography & Coloring
	###########################################

	$body_font_backup = (isset($mk_settings['body-font']['font-backup']) && !empty($mk_settings['body-font']['font-backup'])) ? ('font-family:' . $mk_settings['body-font']['font-backup'] . ';') : '';
	$body_font_family = (isset($mk_settings['body-font']['font-family']) && !empty($mk_settings['body-font']['font-family'])) ? ('font-family:' . $mk_settings['body-font']['font-family'] . ';') : '';
	$heading_font_family = (isset($mk_settings['heading-font']['font-family']) && !empty($mk_settings['heading-font']['font-family'])) ? ('font-family:' . $mk_settings['heading-font']['font-family'] . ';') : '';
	$p_font_size = (isset($mk_settings['p-text-size']) && !empty($mk_settings['p-text-size'])) ? $mk_settings['p-text-size'] : $mk_settings['body-font']['font-size'];
	

	$output .= "body
{
	line-height: 20px;
{$body_font_backup}
{$body_font_family}
	font-size:{$mk_settings['body-font']['font-size']};
	color:{$mk_settings['body-txt-color']};
}

{$typekit_fonts_1}

p {
	font-size:{$p_font_size}px;
	color:{$mk_settings['body-txt-color']};
	line-height:{$mk_settings['p-line-height']}px;
}

a {
	color:{$mk_settings['link-color']['regular']};
}

a:hover {
	color:{$mk_settings['link-color']['hover']};
}


#theme-page h1,
#theme-page h2,
#theme-page h3,
#theme-page h4,
#theme-page h5,
#theme-page h6
{
	font-weight:{$mk_settings['heading-font']['font-weight']};
	color:{$mk_settings['heading-color']};
}
h1, h2, h3, h4, h5, h6
{
{$heading_font_family}}


input,
button,
textarea {
{$body_font_family}}

";

###########################################
# Main Navigation
###########################################

	$nav_text_align = (isset($mk_settings['nav-alignment']) && !empty($mk_settings['nav-alignment'])) ? ('text-align:' . $mk_settings['nav-alignment'] . ';') : ('text-align:left;');

	$main_nav_font_family = (isset($mk_settings['main-nav-font']['font-family']) && !empty($mk_settings['main-nav-font']['font-family'])) ? ('font-family:' . $mk_settings['main-nav-font']['font-family'] . ';') : '';

	if($mk_settings['header-structure'] == 'vertical'){
		$main_nav_top_level_space = (isset($mk_settings['main-nav-item-space']) && !empty($mk_settings['main-nav-item-space']) && isset($mk_settings['vertical-nav-item-space']) && !empty($mk_settings['vertical-nav-item-space'])) ? ('padding:'. $mk_settings['vertical-nav-item-space'] . 'px ' . $mk_settings['main-nav-item-space'] . 'px;') : ('padding: 9px 15px;');
		$plus_for_submenu = $mk_settings['main-nav-item-space'] + 10;
		$main_nav_top_level_space_lr = (isset($mk_settings['main-nav-item-space'])) && !empty($mk_settings['main-nav-item-space']) ? ('padding: 0 '.$plus_for_submenu .'px ;') : ('padding: 0 15px;');

		$main_nav_top_level_space_bt = isset($mk_settings['vertical-nav-item-space']) && !empty($mk_settings['vertical-nav-item-space']) ? ('padding:'. $mk_settings['vertical-nav-item-space'] . 'px 0;') : ('padding: 9px 0;');

		
	}else{
		$main_nav_top_level_space = (isset($mk_settings['main-nav-item-space'])) && !empty($mk_settings['main-nav-item-space']) ? ('padding: 0 ' . $mk_settings['main-nav-item-space'] . 'px;') : ('padding: auto 17px;');
	}
	

	$main_nav_top_level_font_size = 'font-size:' . $mk_settings['main-nav-font']['font-size'] . ';';

	$main_nav_top_level_font_transform = (isset($mk_settings['main-nav-top-transform']) && !empty($mk_settings['main-nav-top-transform'])) ? ('text-transform: ' . $mk_settings['main-nav-top-transform'] . ';') : ('text-transform: uppercase;');

	$main_nav_top_level_font_weight = 'font-weight:' . $mk_settings['main-nav-font']['font-weight'] . ';';

	$main_nav_sub_level_font_size = (isset($mk_settings['sub-nav-top-size']) && !empty($mk_settings['sub-nav-top-size'])) ? ('font-size:' . $mk_settings['sub-nav-top-size'] . 'px;') : ('font-size:' . $mk_settings['main-nav-font']['font-size'] . 'px;');

	$main_nav_sub_level_font_transform = (isset($mk_settings['sub-nav-top-transform']) && !empty($mk_settings['sub-nav-top-transform'])) ? ('text-transform: ' . $mk_settings['sub-nav-top-transform'] . ';') : ('text-transform: uppercase;');
	
	$main_nav_sub_level_font_weight = (isset($mk_settings['sub-nav-top-weight']) && !empty($mk_settings['sub-nav-top-weight'])) ? ('font-weight:' . $mk_settings['sub-nav-top-weight'] . ';') : ('font-weight:' . $mk_settings['main-nav-font']['font-weight'] . ';');

	$logo_height = (!empty($mk_settings['logo']['height'])) ? $mk_settings['logo']['height'] : 50;
	$header_height = $logo_height+($mk_settings['header-padding'] * 2);
	if (isset($mk_settings['squeeze-sticky-header']) && ($mk_settings['squeeze-sticky-header'])) {
		$sticky_logo_height = round($logo_height / 1.5);
		$sticky_header_padding = round($mk_settings['header-padding'] / 2.8);
		$header_sticky_height = round($logo_height / 1.5+(($mk_settings['header-padding'] / 2.4) * 2));
	} else {
		$sticky_logo_height = $logo_height;
		$sticky_header_padding = $mk_settings['header-padding'];
		$header_sticky_height = round($logo_height+(($mk_settings['header-padding']) * 2));
	}

	$header_vertical_width = (isset($mk_settings['header-vertical-width']) && !empty($mk_settings['header-vertical-width'])) ? $mk_settings['header-vertical-width'] : ('280');
	$header_vertical_padding = (isset($mk_settings['header-padding-vertical']) && !empty($mk_settings['header-padding-vertical'])) ? $mk_settings['header-padding-vertical'] : ('30'); 

	$vertical_nav_width = $header_vertical_width - ($header_vertical_padding * 2);

	$output .= "


.header-searchform-input input[type=text]{
	background-color:{$mk_settings['header-bg']['color']};
}

.theme-main-wrapper:not(.vertical-header) .sticky-header.sticky-header-padding {
	padding-top:{$header_height}px;
}

.bottom-header-padding.none-sticky-header {
	padding-top:{$header_height}px;	
}

.bottom-header-padding.none-sticky-header {
	padding-top:{$header_height}px;	
}

.bottom-header-padding.sticky-header {
	padding-top:{$header_sticky_height}px;	
}


#mk-header:not(.header-structure-vertical) #mk-main-navigation > ul > li.menu-item,
#mk-header:not(.header-structure-vertical) #mk-main-navigation > ul > li.menu-item > a,
#mk-header:not(.header-structure-vertical) .mk-header-search,
#mk-header:not(.header-structure-vertical) .mk-header-search a,
#mk-header:not(.header-structure-vertical) .mk-header-wpml-ls,
#mk-header:not(.header-structure-vertical) .mk-header-wpml-ls a,
#mk-header:not(.header-structure-vertical) .mk-cart-link,
#mk-header:not(.header-structure-vertical) .dashboard-trigger,
#mk-header:not(.header-structure-vertical) .responsive-nav-link,
#mk-header:not(.header-structure-vertical) .mk-header-social a,
#mk-header:not(.header-structure-vertical) .mk-margin-header-burger
{
	height:{$header_height}px;
	line-height:{$header_height}px;
}

#mk-header:not(.header-structure-vertical).sticky-trigger-header #mk-main-navigation > ul > li.menu-item,
#mk-header:not(.header-structure-vertical).sticky-trigger-header #mk-main-navigation > ul > li.menu-item > a,
#mk-header:not(.header-structure-vertical).sticky-trigger-header .mk-header-search,
#mk-header:not(.header-structure-vertical).sticky-trigger-header .mk-header-search a,
#mk-header:not(.header-structure-vertical).sticky-trigger-header .mk-cart-link,
#mk-header:not(.header-structure-vertical).sticky-trigger-header .dashboard-trigger,
#mk-header:not(.header-structure-vertical).sticky-trigger-header .responsive-nav-link,
#mk-header:not(.header-structure-vertical).sticky-trigger-header .mk-header-social a,
#mk-header:not(.header-structure-vertical).sticky-trigger-header .mk-margin-header-burger,
#mk-header:not(.header-structure-vertical).sticky-trigger-header .mk-header-wpml-ls,
#mk-header:not(.header-structure-vertical).sticky-trigger-header .mk-header-wpml-ls a
{
	height:{$header_sticky_height}px;
	line-height:{$header_sticky_height}px;
}";

	if (isset($mk_settings['squeeze-sticky-header']) && ($mk_settings['squeeze-sticky-header'])) {
		$output .= "
	#mk-header:not(.header-structure-vertical).sticky-trigger-header #mk-main-navigation > ul > li.menu-item > a {
		padding-left:15px;
		padding-right:15px;
	}
	";
	}

	$output .= ".mk-header-logo,
.mk-header-logo a{
	height:{$logo_height}px;
	line-height:{$logo_height}px;
}

#mk-header:not(.header-structure-vertical).sticky-trigger-header .mk-header-logo,
#mk-header:not(.header-structure-vertical).sticky-trigger-header .mk-header-logo a{
	height:{$sticky_logo_height}px;
	line-height:{$sticky_logo_height}px;
}

.vertical-expanded-state #mk-header.header-structure-vertical,
.vertical-condensed-state  #mk-header.header-structure-vertical:hover{
	width: {$header_vertical_width}px !important;
}

#mk-header.header-structure-vertical{
	padding-left: {$header_vertical_padding}px !important;
	padding-right: {$header_vertical_padding}px !important;
}

.vertical-condensed-state .mk-vertical-menu {
  width:{$vertical_nav_width}px;
}


.theme-main-wrapper.vertical-expanded-state #theme-page > .mk-main-wrapper-holder,
.theme-main-wrapper.vertical-expanded-state #theme-page > .mk-page-section,
.theme-main-wrapper.vertical-expanded-state #theme-page > .wpb_row,
.theme-main-wrapper.vertical-expanded-state #mk-page-title,
.theme-main-wrapper.vertical-expanded-state #mk-footer {
	padding-left: {$header_vertical_width}px;
}

.theme-main-wrapper.vertical-header #mk-page-title,
.theme-main-wrapper.vertical-header #mk-footer,
.theme-main-wrapper.vertical-header #mk-header,
.theme-main-wrapper.vertical-header #mk-header.header-structure-vertical .mk-vertical-menu{
	box-sizing: border-box;
}

.vertical-condensed-state #mk-header.header-structure-vertical:hover ~ #theme-page > .mk-main-wrapper-holder,
.vertical-condensed-state #mk-header.header-structure-vertical:hover ~ #theme-page > .mk-page-section,
.vertical-condensed-state #mk-header.header-structure-vertical:hover ~ #theme-page > .wpb_row,
.vertical-condensed-state #mk-header.header-structure-vertical:hover ~ #mk-page-title,
.vertical-condensed-state #mk-header.header-structure-vertical:hover ~ #mk-footer {
	padding-left: {$header_vertical_width}px ;
}

.mk-header-logo,
.mk-header-logo a
 {
	margin-top: {$mk_settings['header-padding']}px;
	margin-bottom: {$mk_settings['header-padding']}px;
}


#mk-header:not(.header-structure-vertical).sticky-trigger-header .mk-header-logo,
#mk-header:not(.header-structure-vertical).sticky-trigger-header .mk-header-logo a
{
	margin-top:{$sticky_header_padding}px;
	margin-bottom: {$sticky_header_padding}px;
}


#mk-main-navigation > ul > li.menu-item > a {
	{$main_nav_top_level_space}
	{$main_nav_font_family}
	{$main_nav_top_level_font_size}
	{$main_nav_top_level_font_transform}
	{$main_nav_top_level_font_weight}
}

.mk-header-logo.mk-header-logo-center {
	{$main_nav_top_level_space}
}

.mk-vertical-menu > li.menu-item > a {
	{$main_nav_top_level_space}
	{$main_nav_font_family}
	{$main_nav_top_level_font_size}
	{$main_nav_top_level_font_transform}
	{$main_nav_top_level_font_weight}
}
";

	if ($mk_settings['header-structure'] == 'vertical') {
		$output .= "
	.header-structure-vertical .mk-vertical-menu > .menu-item > .sub-menu {
		{$main_nav_top_level_space_lr}
	}
	";
	}

	$output .= "


.mk-vertical-menu li.menu-item > a,
.mk-vertical-menu .mk-header-logo {
	{$nav_text_align} 
}

.main-navigation-ul > li ul.sub-menu li.menu-item a.menu-item-link{
	{$main_nav_sub_level_font_size}
	{$main_nav_sub_level_font_transform}
	{$main_nav_sub_level_font_weight}
}

.mk-vertical-menu > li ul.sub-menu li.menu-item a{
	{$main_nav_sub_level_font_size}
	{$main_nav_sub_level_font_transform}
	{$main_nav_sub_level_font_weight}
}

#mk-main-navigation > ul > li.menu-item > a,
.mk-vertical-menu li.menu-item > a
{
	color:{$mk_settings['main-nav-top-color']['regular']};
	background-color:{$mk_settings['main-nav-top-color']['bg']};
}

#mk-main-navigation > ul > li.current-menu-item > a,
#mk-main-navigation > ul > li.current-menu-ancestor > a,
#mk-main-navigation > ul > li.menu-item:hover > a
{
	color:{$mk_settings['main-nav-top-color']['hover']};
	background-color:{$mk_settings['main-nav-top-color']['bg-hover']};
}

.mk-vertical-menu > li.current-menu-item > a,
.mk-vertical-menu > li.current-menu-ancestor > a,
.mk-vertical-menu > li.menu-item:hover > a,
.mk-vertical-menu ul li.menu-item:hover > a {
	color:{$mk_settings['main-nav-top-color']['hover']};
}



#mk-main-navigation > ul > li.menu-item > a:hover
{
	color:{$mk_settings['main-nav-top-color']['hover']};
	background-color:{$mk_settings['main-nav-top-color']['bg-hover']};
}

.dashboard-trigger,
.res-nav-active,
.mk-header-social a {
	color:{$mk_settings['main-nav-top-color']['regular']};
}

.dashboard-trigger:hover,
.res-nav-active:hover {
	color:{$mk_settings['main-nav-top-color']['hover']};
}";

if (isset($mk_settings['navigation-border-top']) && ($mk_settings['navigation-border-top'] == 1)) {
		$output .= "
		#mk-main-navigation ul li.no-mega-menu > ul,
		#mk-main-navigation ul li.has-mega-menu > ul,
		#mk-main-navigation ul li.mk-header-wpml-ls > ul{
			border-top:1px solid {$accent_color};
		}";
}


$output .= "#mk-main-navigation ul li.no-mega-menu ul,
#mk-main-navigation > ul > li.has-mega-menu > ul,
.header-searchform-input .ui-autocomplete,
.mk-shopping-box,
.shopping-box-header > span,
#mk-main-navigation ul li.mk-header-wpml-ls > ul {
	background-color:{$mk_settings['main-nav-sub-bg']};
}

#mk-main-navigation ul ul.sub-menu a.menu-item-link,
#mk-main-navigation ul li.mk-header-wpml-ls > ul li a
{
	color:{$mk_settings['main-nav-sub-color']['regular']};
}

#mk-main-navigation ul ul li.current-menu-item > a.menu-item-link,
#mk-main-navigation ul ul li.current-menu-ancestor > a.menu-item-link {
	color:{$mk_settings['main-nav-sub-color']['hover']};
	background-color:{$mk_settings['main-nav-sub-color']['bg-hover']} !important;
}


.header-searchform-input .ui-autocomplete .search-title,
.header-searchform-input .ui-autocomplete .search-date,
.header-searchform-input .ui-autocomplete i
{
	color:{$mk_settings['main-nav-sub-color']['regular']};
}
.header-searchform-input .ui-autocomplete i,
.header-searchform-input .ui-autocomplete img
{
	border-color:{$mk_settings['main-nav-sub-color']['regular']};
}

.header-searchform-input .ui-autocomplete li:hover  i,
.header-searchform-input .ui-autocomplete li:hover img
{
	border-color:{$mk_settings['main-nav-sub-color']['hover']};
}


#mk-main-navigation .megamenu-title,
.mk-mega-icon {
	color:{$mk_settings['main-nav-sub-color']['regular']};
}

#mk-main-navigation ul ul.sub-menu a.menu-item-link:hover,
.header-searchform-input .ui-autocomplete li:hover,
#mk-main-navigation ul li.mk-header-wpml-ls > ul li a:hover
{
	color:{$mk_settings['main-nav-sub-color']['hover']};
	background-color:{$mk_settings['main-nav-sub-color']['bg-hover']} !important;
}

.header-searchform-input .ui-autocomplete li:hover .search-title,
.header-searchform-input .ui-autocomplete li:hover .search-date,
.header-searchform-input .ui-autocomplete li:hover i,
#mk-main-navigation ul ul.sub-menu a.menu-item-link:hover i
{
	color:{$mk_settings['main-nav-sub-color']['hover']};
}


.header-searchform-input input[type=text],
.dashboard-trigger,
.header-search-icon,
.header-search-close,
.header-wpml-icon
{
	color:{$mk_settings['main-nav-top-color']['regular']};
}";

$header_search_icon_color = (isset($mk_settings['header-search-icon-color']) && !empty($mk_settings['header-search-icon-color'])) ? $mk_settings['header-search-icon-color'] : $mk_settings['main-nav-top-color']['regular'];

$output .="
.header-search-icon {
	color:{$header_search_icon_color};	
}

.mk-burger-icon div {
      background-color:{$mk_settings['main-nav-top-color']['regular']};
 }



.header-search-icon:hover
{
	color: {$mk_settings['main-nav-top-color']['regular']};
}


.responsive-nav-container
{
	background-color:{$mk_settings['main-nav-sub-bg']};
}

.mk-responsive-nav a,
.mk-responsive-nav .has-mega-menu .megamenu-title
{
	color:{$mk_settings['main-nav-sub-color']['regular']};
	background-color:{$mk_settings['main-nav-sub-color']['bg']};
}

.mk-responsive-nav li a:hover
{
	color:{$mk_settings['main-nav-sub-color']['hover']};
	background-color:{$mk_settings['main-nav-sub-color']['bg-hover']};
}

";

###########################################
	# Responsive Mode
	###########################################

	$grid_width_100 = $mk_settings['grid-width']+100;

	$output .= "

@media handheld, only screen and (max-width: {$grid_width_100}px)
{

.dashboard-trigger.res-mode {
	display:block !important;
}

.dashboard-trigger.desktop-mode {
	display:none !important;
}

}



@media handheld, only screen and (max-width: {$mk_settings['res-nav-width']}px)
{

#mk-header.sticky-header,
.mk-secondary-header,
.transparent-header-sticky {
	position: relative !important;
	left:auto !important;
    right:auto!important;
    top:auto !important;
}

#mk-header:not(.header-structure-vertical).put-header-bottom,
#mk-header:not(.header-structure-vertical).put-header-bottom.sticky-trigger-header,
#mk-header:not(.header-structure-vertical).put-header-bottom.header-offset-passed,
.admin-bar #mk-header:not(.header-structure-vertical).put-header-bottom.sticky-trigger-header {
	position:relative;
	bottom:auto;
}

.mk-margin-header-burger {
	display:none;
}

.main-navigation-ul li.menu-item,
.mk-vertical-menu li.menu-item,
.main-navigation-ul li.sub-menu,
.sticky-header-padding,
.secondary-header-space
{
	display:none !important;
}

.vertical-expanded-state #mk-header.header-structure-vertical, .vertical-condensed-state #mk-header.header-structure-vertical{
	width: 100% !important;
	height: auto !important;
}
.vertical-condensed-state  #mk-header.header-structure-vertical:hover {
	width: 100% !important;
}
.header-structure-vertical .mk-vertical-menu{
	position:relative;
	padding:0;
	width: 100%;
}
.header-structure-vertical .mk-header-social.inside-grid{
	position:relative;
	padding:0;
	width: auto;
	bottom: inherit !important;
	height:{$header_height}px;
	line-height:{$header_height}px;
	float:right !important;
	top: 0 !important;
}


.vertical-condensed-state .header-structure-vertical .mk-vertical-menu>li.mk-header-logo {
	-webkit-transform: translate(0,0);
	-moz-transform: translate(0,0);
	-ms-transform: translate(0,0);
	-o-transform: translate(0,0);
	opacity: 1!important;
	position: relative!important;
	left: 0!important;
}
.vertical-condensed-state .header-structure-vertical .mk-vertical-header-burger{
	opacity:0 !important;
}


.mk-header-logo {
	padding:0 !important;
}

.mk-vertical-menu .responsive-nav-link{
	float:left !important;
	height:{$header_height}px;
}
.mk-vertical-menu .responsive-nav-link i{
	height:{$header_height}px;
	line-height:{$header_height}px;
}
.mk-vertical-menu .mk-header-logo {
	float:left !important
}


.header-search-icon i,
.mk-cart-link i
{
	padding:0 !important;
	margin:0 !important;
	border:none !important;
}

.header-search-icon,
.mk-cart-link
{
	margin:0 8px !important;
	padding:0 !important;
}


.mk-header-logo
{

	margin-left:20px !important;
	display:inline-block !important;
}

.main-navigation-ul
{
	text-align:center !important;
}

.responsive-nav-link {
	display:inline-block !important;
}

.mk-shopping-box {
	display:none !important;
}

}


#mk-header.transparent-header {
  position: absolute;
  left: 0;
}

.transparent-header {
  transition: all 0.3s ease-in-out;
  -webkit-transition: all 0.3s ease-in-out;
  -moz-transition: all 0.3s ease-in-out;
  -ms-transition: all 0.3s ease-in-out;
  -o-transition: all 0.3s ease-in-out;
}

.transparent-header.transparent-header-sticky {
  opacity: 1;
  left: auto !important;
}
.transparent-header #mk-main-navigation ul li .sub {
  border-top: none;
}
.transparent-header .mk-cart-link:hover,
.transparent-header .dashboard-trigger:hover,
.transparent-header .res-nav-active:hover,
.transparent-header .header-search-icon:hover {
  opacity: 0.7;
}
.transparent-header .header-searchform-input input[type=text] {
  background-color: transparent;
}
.transparent-header.light-header-skin .dashboard-trigger,
.transparent-header.light-header-skin .dashboard-trigger:hover,
.transparent-header.light-header-skin .res-nav-active,
.transparent-header.light-header-skin #mk-main-navigation > ul > li.menu-item > a,
.transparent-header.light-header-skin #mk-main-navigation > ul > li.current-menu-item > a,
.transparent-header.light-header-skin #mk-main-navigation > ul > li.current-menu-ancestor > a,
.transparent-header.light-header-skin #mk-main-navigation > ul > li.menu-item:hover > a,
.transparent-header.light-header-skin #mk-main-navigation > ul > li.menu-item > a:hover,
.transparent-header.light-header-skin .res-nav-active:hover,
.transparent-header.light-header-skin .header-searchform-input input[type=text],
.transparent-header.light-header-skin .header-search-icon,
.transparent-header.light-header-skin .header-search-close,
.transparent-header.light-header-skin .header-search-icon:hover,
.transparent-header.light-header-skin .mk-cart-link,
.transparent-header.light-header-skin .mk-header-social a,
.transparent-header.light-header-skin .mk-header-wpml-ls a{
  color: #fff !important;
}
.transparent-header.light-header-skin .mk-burger-icon div {
  background-color: #fff;
}
.transparent-header.light-header-skin .mk-light-logo {
  display: inline-block !important;
}
.transparent-header.light-header-skin .mk-dark-logo {
  display: none !important;
}
.transparent-header.light-header-skin.transparent-header-sticky .mk-light-logo {
  display: none !important;
}
.transparent-header.light-header-skin.transparent-header-sticky .mk-dark-logo {
  display: inline-block !important;
}
.transparent-header.dark-header-skin .dashboard-trigger,
.transparent-header.dark-header-skin .dashboard-trigger:hover,
.transparent-header.dark-header-skin .res-nav-active,
.transparent-header.dark-header-skin #mk-main-navigation > ul > li.menu-item > a,
.transparent-header.dark-header-skin #mk-main-navigation > ul > li.current-menu-item > a,
.transparent-header.dark-header-skin #mk-main-navigation > ul > li.current-menu-ancestor > a,
.transparent-header.dark-header-skin #mk-main-navigation > ul > li.menu-item:hover > a,
.transparent-header.dark-header-skin #mk-main-navigation > ul > li.menu-item > a:hover,
.transparent-header.dark-header-skin .res-nav-active:hover,
.transparent-header.dark-header-skin .header-searchform-input input[type=text],
.transparent-header.dark-header-skin .header-search-icon,
.transparent-header.dark-header-skin .header-search-close,
.transparent-header.dark-header-skin .header-search-icon:hover,
.transparent-header.dark-header-skin .mk-cart-link,
.transparent-header.dark-header-skin .mk-header-social a,
.transparent-header.dark-header-skin .mk-header-wpml-ls a {
  color: #444 !important;
}
.transparent-header.dark-header-skin .mk-burger-icon div {
  background-color: #444;
}



";

###########################################
	# Accent Color
	###########################################

	$overlay_color = isset($mk_settings['hover-overlay-color']) ? $mk_settings['hover-overlay-color'] : $accent_color;

	if (isset($mk_settings['hover-overlay-color']) && !empty($mk_settings['hover-overlay-color'])) {
		$overlay_color = $mk_settings['hover-overlay-color'];
	} else {
		$overlay_color = $accent_color;
	}

	$output .= "
.mk-skin-color,
.blog-categories a,
.blog-categories,
.rating-star .rated,
.widget_testimonials .testimonial-position,
.testimonial-company,
.portfolio-similar-meta .cats,
.entry-meta .cats a,
.search-meta span a,
.search-meta span,
.single-share-trigger:hover,
.single-share-trigger.mk-toggle-active,
.project_content_section .project_cats a,
.mk-love-holder i:hover,
.blog-comments i:hover,
.comment-count i:hover,
.widget_posts_lists li .cats a,
.mk-employeee-networks li a:hover,
.mk-tweet-shortcode span a,
.classic-hover .portfolio-permalink:hover i,
.mk-pricing-table .mk-icon-star,
.mk-process-steps.dark-skin .step-icon,
.mk-edge-next,
.mk-edge-prev,
.prev-item-caption,
.next-item-caption,
.mk-employees.column_rounded-style .team-member-position, 
.mk-employees.column-style .team-member-position,
.mk-event-countdown.accent-skin .countdown-timer,
.mk-event-countdown.accent-skin .countdown-text,
.mk-box-text:hover i,
.mk-process-steps.light-skin .mk-step:hover .step-icon,
.mk-process-steps.light-skin .active-step-item .step-icon,
.blog-modern-entry .blog-categories,
.woocommerce-thanks-text
{
	color: {$accent_color};
}

.mk-love-holder .item-loved i,
.widget_posts_lists .cats a,
#mk-breadcrumbs a:hover,
.widget_social_networks a.light,
.widget_posts_tabs .cats a {
	color: {$accent_color} !important;
}

a:hover,
.mk-tweet-shortcode span a:hover {
	color:{$mk_settings['link-color']['hover']};
}



/* Main Skin Color : Background-color Property */
#wp-calendar td#today,
div.jp-play-bar,
.mk-header-button:hover,
.next-prev-top .go-to-top:hover,
.wide-eye-portfolio-item .portfolio-meta .the-title,
.mk-portfolio-carousel .portfolio-meta:before,
.meta-image.frame-grid-portfolio-item .portfolio-meta .the-title,
.masonry-border,
.author-social li a:hover,
.slideshow-swiper-arrows:hover,
.mk-clients-shortcode .clients-info,
.mk-contact-form-wrapper .mk-form-row i.input-focused,
.mk-login-form .form-row i.input-focused,
.comment-form-row i.input-focused,
.widget_social_networks a:hover,
.mk-social-network a:hover,
.blog-masonry-entry .post-type-icon:hover,
.list-posttype-col .post-type-icon:hover,
.single-type-icon,
.demo_store,
.add_to_cart_button:hover,
.mk-process-steps.dark-skin .mk-step:hover .step-icon,
.mk-process-steps.dark-skin .active-step-item .step-icon,
.mk-process-steps.light-skin .step-icon,
.mk-social-network a.light:hover,
.widget_tag_cloud a:hover,
.widget_categories a:hover,
.edge-nav-bg,
.gform_wrapper .button:hover,
.mk-event-countdown.accent-skin li:before,
.masonry-border,
.mk-gallery.thumb-style .gallery-thumb-lightbox:hover,
.fancybox-close:hover,
.fancybox-nav span:hover,
.blog-scroller-arrows:hover,
ul.user-login li a i,
.mk-isotop-filter ul li a.current,
.mk-isotop-filter ul li a:hover
{
	background-color: {$accent_color};
}



.hover-overlay {
	Background-color:{$overlay_color};
}


::-webkit-selection
{
	background-color: {$accent_color};
	color:#fff;
}

::-moz-selection
{
	background-color: {$accent_color};
	color:#fff;
}

::selection
{
	background-color: {$accent_color};
	color:#fff;
}

.next-prev-top .go-to-top,
.mk-contact-form-wrapper .text-input:focus, .mk-contact-form-wrapper .mk-textarea:focus,
.widget .mk-contact-form-wrapper .text-input:focus, .widget .mk-contact-form-wrapper .mk-textarea:focus,
.mk-contact-form-wrapper .mk-form-row i.input-focused,
.comment-form-row .text-input:focus, .comment-textarea textarea:focus,
.comment-form-row i.input-focused,
.mk-login-form .form-row i.input-focused,
.mk-login-form .form-row input:focus,
#sub-footer,
.mk-event-countdown.accent-skin li
{
	border-color: {$accent_color}!important;
}

";

###########################################
	# MISC
	###########################################

	$output .= "

.mk-divider .divider-inner i
{
	background-color: {$mk_settings['page-bg']['color']};
}

.mk-loader
{
	border: 2px solid {$accent_color};
}

.alt-title span,
.single-post-fancy-title span,
.portfolio-social-share,
.woocommerce-share ul
{
	background-color: {$mk_settings['page-bg']['color']};
}

";

###########################################
	# WOOCOMMERCE DYNAMIC STYLES
	###########################################
	if (class_exists('woocommerce')) {

		$accent_color_90 = mk_convert_rgba($accent_color, 0.9);

		$output .= "

.woocommerce-page ul.products li.product .add_to_cart_button i,
.woocommerce-page .entry-summary .star-rating,
.woocommerce-page .quantity .plus,
.woocommerce-page .quantity .minus,
.product_meta a,
.sku_wrapper span,
.order-total,
ul.cart_list .star-rating,
ul.product_list_widget .star-rating,
.mini-cart-remove,
.add_to_cart_button .mk-icon-plus,
.add_to_cart_button .mk-theme-icon-magnifier
{
	color: {$accent_color};
}

.mk-checkout-payement h3,
.woocommerce-message .button:hover,
.woocommerce-error .button:hover,
.woocommerce-info .button:hover,
.woocommerce.widget_shopping_cart .amount,
.widget_product_categories .current-cat,
.widget_product_categories li a:hover
 {
	color: {$accent_color} !important;
}

.button-icon-holder i,
.mini-cart-button i,
.single_add_to_cart_button i,
.add_to_cart_button:hover,
.woocommerce-page ul.products li.product .add_to_cart_button:hover,
.widget_price_filter .ui-slider .ui-slider-range,
.mini-cart-remove:hover,
.mini-cart-button:hover,
.widget_product_tag_cloud a:hover,
.product-single-lightbox:hover,
span.onsale
{
	background-color: {$accent_color} !important;
}

.product-loading-icon {
	background-color:{$accent_color_90};
}

.mk-cart-link {
	color:{$mk_settings['main-nav-top-color']['regular']};
}
.mk-cart-link:hover {
	color:{$mk_settings['main-nav-top-color']['hover']};
}

.mini-cart-remove,
.mini-cart-button {
	border-color: {$accent_color};
}

";

	}

	$output .= $mk_settings['custom-css'];

	$output = preg_replace('/\r|\n|\t/', '', $output);


	wp_enqueue_style('theme-dynamic-styles', get_template_directory_uri() . '/custom.css');

	wp_add_inline_style('theme-dynamic-styles', $output);

}
add_action('wp_enqueue_scripts', 'mk_dynamic_css', 10);
