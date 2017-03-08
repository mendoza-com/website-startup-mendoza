<?php

extract( shortcode_atts( array(
			'background_style' => '',
			'max_width' => '',
			'host' => '',
			'mp4' => '',
			'webm' => '',
			'ogv' => '',
			'poster_image' => '',
			'stream_host_website' => '',
			'stream_video_id' => '',
			'video_controls' => '',
			'autoplay' => '',
			'align' => '',
			'margin_bottom' => '',
			'el_class' => '',
			'visibility' => '',
			'animation' => ''
		), $atts ) );

$output = $video_output = $style_css = $option_control = $autoplay_option = '';

$animation_css = ($animation != '') ? (' mk-animate-element ' . $animation . ' ') : '';


/* control options */
/* -------------------------------------------------------------------- */

if($video_controls == 'true'){
	$option_control .= 1;
}else{
	$option_control .= 0;
}

/* autoplay options */
/* -------------------------------------------------------------------- */
($autoplay == 'true') ? $autoplay_option = ($host == 'self_hosted') ? 'autoplay' : 'autoplay=1&amp;' : '' ;


/* video output */
/* -------------------------------------------------------------------- */
if ($host == 'self_hosted'){
	$video_output .= '<div style="background-image:url('.$poster_image.');" class="mk-video-theatre-touch"></div>';
	$video_output .= '<div class="mk-video-theatre"><video poster="'.$poster_image.'" controls>';
	if ( !empty( $mp4 ) ) {
		$video_output .= '<source type="video/mp4" src="'.$mp4.'" />';
	}
	if ( !empty( $webm ) ) {
		$video_output .= '<source type="video/webm" src="'.$webm.'" />';
	}
	if ( !empty( $ogv ) ) {
		$video_output .= '<source type="video/ogg" src="'.$ogv.'" />';
	}
	$video_output .= '</video></div>';

	$stream_source = $host;

} else {
	if ($stream_host_website == 'youtube'){
		$stream_source = 'youtube';
		$video_output = '<iframe style="position: relative; height: 440px; width: 800px" src="https://www.youtube.com/embed/'.$stream_video_id.'?rel=0&amp;enablejsapi=1"></iframe>';
	} else if ($stream_host_website == 'vimeo'){
		$stream_source = 'vimeo';
		$video_output = '<iframe src="//player.vimeo.com/video/'.$stream_video_id.'?badge=0&amp;loop=0&amp;api=1" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
	}
}

/* content */
/* -------------------------------------------------------------------- */


$output .= '<div class="theatre-slider-container '.$visibility.' '.$animation_css.$align.'-align autoplay-'.$autoplay.'" data-source="'.$stream_source.'">';
if($background_style == 'desktop_style'){
	$output .= '<div class="computer-theatre-slider">';
	$output .= '	<img src="'.THEME_DIR_URI.'/images/theatre-desktop.png" />';
	$output .= '	<div class="player-container"><div class="player">'.$video_output.'</div></div>';
	$output .= '</div>';
	
	$style_css .= '<style type="text/css">';
	$style_css .= '
			.theatre-slider-container{
				margin-bottom: '.$margin_bottom.'px;
			}
	        .computer-theatre-slider {
	            max-width:'.$max_width.'px !important;
	        }
	        ';
	$style_css .= '</style>';
	$output .= $style_css;

}else if($background_style == 'laptop_style'){
	$output .= '<div class="laptop-theatre-slider">';
	$output .= '	<img src="'.THEME_DIR_URI.'/images/theatre-laptop.png" />';
	$output .= '	<div class="player-container"><div class="player">'.$video_output.'</div></div>';
	$output .= '</div>';
	
	$style_css .= '<style type="text/css">';
	$style_css .= '
			.theatre-slider-container{
				margin-bottom: '.$margin_bottom.'px;
			}
	        .laptop-theatre-slider {
	            max-width:'.$max_width.'px !important;
	        }
	        ';
	$style_css .= '</style>';

	$output .= $style_css;
}

$output .= '</div>';

echo $output;