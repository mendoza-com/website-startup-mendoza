<?php

extract( shortcode_atts( array(
			'el_class' => '',
			'color' => '',
			"size" => 14,
			'font_weight' => 'normal',
			'text_transform' => '',
			'margin_top' => '',
			'margin_bottom' => 20,
			"align" => 'left',
			"border_width" => 3,
			"border_color" => '',
			'animation' => '',
			"font_family" => '',
			'tag_name' => 'h3',
			"font_type" => '',
			'style'=> 'simple',
			'corner_style'=> '',
			'letter_spacing' => 0,
			'responsive_align' => 'center',
			'line_height' => 22
		), $atts ) );

$id = uniqid();


$output = $stroke_style_css = '';

$animation_css = ($animation != '') ? ' mk-animate-element ' . $animation . ' ' : '';

global $mk_accent_color, $mk_settings;

$color = ($color == $mk_settings['accent-color']) ? $mk_accent_color : $color;
$corner = $style == 'stroke' ? (!empty($corner_style)) ? $corner_style : 'pointed'  : 'pointed';

$output .= mk_get_fontfamily( "#fancy-title-", $id, $font_family, $font_type );

$line_height = ($line_height < $size) ? '100%' : ($line_height.'px');
$txt_transform = ($text_transform != '') ? ('text-transform:'.$text_transform.'; ') : '';

if($style == 'stroke') {
	$border_color = $border_color ? $border_color : $color;
	$stroke_style_css = 'style="border:'.$border_width.'px solid '.$border_color.';"';
}
$font_size_res = ($size > 36) ? ' fancy-title-responsive-title' : '';

$output .= '<'.$tag_name.' style="font-size: '.$size.'px;text-align:'.$align.';line-height:'.$line_height.';letter-spacing:'.$letter_spacing.'px;color: '.$color.';font-weight:'.$font_weight.';margin-bottom:'.$margin_bottom.'px; margin-top:'.$margin_top.'px; '.$txt_transform.'" id="fancy-title-'.$id.'" class="mk-fancy-title responsive-align-'.$responsive_align.$font_size_res.' '.$style.'-title '.$align.'-align '.$animation_css.' '.$el_class.'"><span class="fancy-title-span '.$corner.'" '.$stroke_style_css.'>' . wpb_js_remove_wpautop( $content ). '</span></'.$tag_name.'>';

if($style == 'alt') {
	$output .= '<style type="text/css">
                    #fancy-title-'.$id.':after{
                        background-color:'.mk_convert_rgba($color, 0.4).';
                        height:'.$border_width.'px !important;
                    }
                </style>';
}

if($style == 'avantgarde') {
	$output .= '<style type="text/css">
                    #fancy-title-'.$id.':after, #fancy-title-'.$id.':before {
                        background-color:'.mk_convert_rgba($color, 0.4).';
                        height:'.$border_width.'px !important;
                    }
                </style>';
}

if($style == 'standard') {
	$output .= '<style type="text/css">
					#fancy-title-'.$id.' span{border-color:'.$color.'; border-width:'.$border_width.'px !important;}
               #fancy-title-'.$id.':after, #fancy-title-'.$id.':before {background-color:'.$color.'; height:'.$border_width.'px !important;}
               </style>';
}
if($style == 'stroke') {
	$output .= '<style type="text/css">
					#fancy-title-'.$id.' span.rounded{border-radius:3px;}
					#fancy-title-'.$id.' span.full_rounded{border-radius:50px;}
               </style>';
}
if($style == 'underline') {
	$output .= '<style type="text/css">
                    #fancy-title-'.$id.' span:after{
                        background-color:'.$color.';
                        height:'.$border_width.'px !important;
                    }
                </style>';
}

$output .= '<style type="text/css">
					#fancy-title-'.$id.' a{
						color: '.$color.';
					}
               </style>';


echo $output;
