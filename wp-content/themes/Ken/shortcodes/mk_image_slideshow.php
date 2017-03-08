<?php

extract(shortcode_atts(array(
    "images" => '',
    "image_width" => 770,
    "image_height" => 350,
    "effect" => 'fade',
    "animation_speed" => 700,
    "slideshow_speed" => 7000,
    "direction" => 'horizontal',
    "direction_nav" => "true",
    "pagination" => "false",
    "freeModeFluid" => "true",
    "freeMode" => "false",
    "margin_bottom" => 20,
    'loop' => 'true',
    'resposnive' => 'false',
    "mousewheelControl" => 'false',
    "slideshow_aligment" => 'none',
    "el_class" => ''
), $atts));


if ($images == '')
    return null;


$id     = uniqid();
$slides = $output = '';
$images = explode(',', $images);
$i      = -1;

foreach ($images as $attach_id) {
    $i++;
    $image_src_array = wp_get_attachment_image_src($attach_id, 'full', true);
    $image_src       = bfi_thumb($image_src_array[0], array(
        'width' => $image_width,
        'height' => $image_height,
        'crop' => true
    ));


    $slides .= '<div class="swiper-slide">';
    $slides .= '<a class="mk-lightbox" href="'.$image_src_array[0].'" rel="slideshow-'.$id.'"><img alt="" src="' . mk_thumbnail_image_gen($image_src, $image_width, $image_height) . '" /></a>';
    $slides .= '</div>' . "\n\n";

}

$container_width = ($resposnive != 'true') ? 'max-width:' . $image_width . 'px;' : '';

$output .= '<div class="mk-image-slideshow" style="' . $container_width . 'max-height:' . $image_height . 'px; margin-bottom:'.$margin_bottom.'px; float:'.$slideshow_aligment.';"><div id="mk-swiper-' . $id . '" data-loop="true" data-freeModeFluid="' . $freeModeFluid . '" data-slidesPerView="1" data-pagination="' . $pagination . '" data-freeMode="' . $freeMode . '" data-mousewheelControl="false" data-direction="' . $direction . '" data-slideshowSpeed="' . $slideshow_speed . '" data-animationSpeed="' . $animation_speed . '" data-directionNav="' . $direction_nav . '" class="swiper-container mk-swiper-slider ' . $el_class . '">';

$output .= '<div class="swiper-wrapper">' . $slides . '</div>';

if ($direction_nav == 'true') {
    $output .= '<a class="mk-swiper-prev slideshow-swiper-arrows"><i class="mk-theme-icon-prev-big"></i></a>';
    $output .= '<a class="mk-swiper-next slideshow-swiper-arrows"><i class="mk-theme-icon-next-big"></i></a>';
}

if ($pagination == 'true') {
    $output .= '<div class="swiper-pagination"></div>';
}

$output .= '</div></div>';

echo $output;
