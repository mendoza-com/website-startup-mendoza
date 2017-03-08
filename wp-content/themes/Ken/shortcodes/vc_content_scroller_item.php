<?php
$output = '';
$output .= '<div class="swiper-slide">';
$output .= '<div class="mk-inner-grid">';
$output .= wpb_js_remove_wpautop($content);
$output .= '</div>';
$output .= '</div>';
echo $output;
