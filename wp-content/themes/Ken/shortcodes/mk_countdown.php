<?php

extract( shortcode_atts( array(
            'skin' => 'dark',
            'custom_color' => '',
            'date' => '12/24/2015 12:00:00',
            'offset' => '+10',
            'el_class' => '',
        ), $atts ) );


$style_id = uniqid();
$custom_style = '
	<style type="text/css">
		#countdown-'.$style_id.' ul li {
			border-color: '.mk_convert_rgba($custom_color, 0.2).';
		}
		#countdown-'.$style_id.' ul li::before {
			background-color: '.mk_convert_rgba($custom_color, 0.2).';
		}
		#countdown-'.$style_id.' ul li .countdown-timer {
			color: '.$custom_color.';
        }
        #countdown-'.$style_id.' ul li .countdown-text {
			color: '.mk_convert_rgba($custom_color, 0.6).';
        }
	</style>
';

$output  = '<div id="countdown-'.$style_id.'" class="'.$el_class.' '.$skin.'-skin mk-event-countdown" data-offset="'.$offset.'" data-date="'.$date.'">';
$output .= '<ul>';
$output .= '<li><span class="days countdown-timer">00</span><span class="countdown-text">'.__('Days', 'mk_framework').'</span></li>';
$output .= '<li><span class="hours countdown-timer">00</span><span class="countdown-text">'.__('Hours', 'mk_framework').'</span></li>';
$output .= '<li><span class="minutes countdown-timer">00</span><span class="countdown-text">'.__('Minutes', 'mk_framework').'</span></li>';
$output .= '<li><span class="seconds countdown-timer">00</span><span class="countdown-text">'.__('Seconds', 'mk_framework').'</span></li>';
$output .= '</ul>';
$output .= '</div>';
$output .= $custom_style;
echo $output;
