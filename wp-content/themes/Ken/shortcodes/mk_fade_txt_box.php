<?php 

extract( shortcode_atts( array(
            "animation_speed" => 700,
            "slideshow_speed" => 7000,
            'padding' => 0,
			'el_class' => '',
		), $atts ) );


$output = '';

$id = uniqid();

$output .= '<div id="mk-fade-txt-box-' . $id . '" data-loop="true" data-autoplayStop="false" data-slidesPerView="1" data-direction="horizontal" data-mousewheelControl="false" data-freeModeFluid="true" data-slideshowSpeed="' . $slideshow_speed . '" data-animationSpeed="' . $animation_speed . '" data-animation="fade" class="mk-fade-txt-box swiper-container mk-swiper-slider ' . $el_class . '">';
$output .= '	<div class="swiper-wrapper">';
$output .= "		\n\t\t\t".wpb_js_remove_wpautop( $content, true );
$output .= '	</div>';
$output .= '</div>';

$output .= '<style type="text/css">
				#mk-fade-txt-box-' . $id . ' .swiper-slide { 
                  padding: '.$padding.'px 0;
                }
        </style>';

echo $output;