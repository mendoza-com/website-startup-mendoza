<?php

extract( shortcode_atts( array(
			"tablet_color" => 'black',
			"images" => '',
			"animation_speed" => 700,
			"slideshow_speed" => 7000,
			"pause_on_hover" => "false",
			"el_class" => '',
			'animation' => '',
		), $atts ) );

if ( $images == '' ) return null;

$animation_css = '';
if ( $animation != '' ) {
	$animation_css = ' mk-animate-element ' . $animation . ' ';
}


$output = '';
$images = explode( ',', $images );
$i = -1;

foreach ( $images as $attach_id ) {
	$i++;
	$image_src_array = wp_get_attachment_image_src( $attach_id, 'full', true );
	$image_src       = bfi_thumb($image_src_array[0], array(
        'width' => 435,
        'height' => 585,
        'crop' => true
    ));

	$output .= '<li>';
	$output .= '<img alt="" src="' . mk_thumbnail_image_gen($image_src, 435, 585) .'" />';
	$output .= '</li>'. "\n\n";

}

echo '<div data-animation="fade" data-easing="swing" data-direction="horizontal" data-smoothHeight="false" data-slideshowSpeed="'.$slideshow_speed.'" data-animationSpeed="'.$animation_speed.'" data-pauseOnHover="'.$pause_on_hover.'" data-controlNav="false" data-directionNav="true" data-isCarousel="false" style="max-height:740px;max-width:501px;" class="mk-tablet-slideshow mk-script-call '.$animation_css.' mk-flexslider '.$el_class.'"><img style="display:none" class="mk-tablet-image" src="'.THEME_IMAGES.'/tablet-'.$tablet_color.'.png" alt="" /><div class="slideshow-container"><ul class="mk-flex-slides" style="max-width:100%px;max-height:100%;">' . $output . '</ul></div></div>';



