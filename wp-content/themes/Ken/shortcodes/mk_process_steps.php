<?php
$title = $el_class = $output = $list_items = $style_css = '';

extract(shortcode_atts(array(
	'orientation' => '',
	'skin' => 'dark',
	'background_color' => '#fff',
	'border_color' => '',
	'icon_color' => '',
	'icon_hover_color' => '',
	'title_color' => '',
	'description_color' => '',
	'el_class' => '',
), $atts));

$id = uniqid();


/* style init */
/* -------------------------------------------------------------------- */
$style_css .= '<style type="text/css">';

if ( $skin == 'custom' ) {
    $style_css .= '
    	#mk-process-steps-'.$id.'.custom-skin .step-items:before{
    		border-color: '.$border_color.';
		}
        #mk-process-steps-'.$id.'.custom-skin .step-icon {
            border:2px solid '.$border_color.' !important;
            color:'.$icon_color.' !important;
            background-color:'.$background_color.' !important;
        }
        #mk-process-steps-'.$id.'.custom-skin .step-icon:hover {
            background-color:'.$icon_color.' !important;
            color:'.$icon_hover_color.' !important;
        }';
	if ($orientation == 'vertical'){
		$style_css .= '
			#mk-process-steps-'.$id.'.custom-skin .step-holder, #mk-process-steps-'.$id.'.custom-skin .step-holder:before {
	            border-color: '.$border_color.' !important;
	            background-color:'.$background_color.' !important; 
	        }
	    ';
	}
	$style_css .= '
        #mk-process-steps-'.$id.'.custom-skin .step-holder .step-title{
            color:'.$title_color.' !important;
        }
        #mk-process-steps-'.$id.'.custom-skin .step-holder .step-desc{
            color:'.$description_color.' !important;
        }
    ';
}

$style_css .= '</style>';

/* html output */
/* -------------------------------------------------------------------- */
$output .= '<div id="mk-process-steps-'.$id.'" class="mk-process-steps ' . $skin . '-skin ' . $orientation . ' ' . $el_class . '">';

if ($orientation == 'vertical') {

	$output .= '<div class="step-items">' . wpb_js_remove_wpautop($content) . '</div>';

} else {

	if (preg_match_all("/(.?)\[(mk_step)\b(.*?)(?:(\/))?\]/s", $content, $matches)) {
		for ($i = 0; $i < count($matches[0]);
			$i++) {
			$matches[3][$i] = shortcode_parse_atts($matches[3][$i]);
		}
		for ($i = 0; $i < count($matches[0]);
			$i++) {
			$icon = $matches[3][$i]['icon'] ? $matches[3][$i]['icon'] : '';

			if (!empty($icon)) {
				$icon = (strpos($icon, 'mk-') !== FALSE) ? ($icon) : ('mk-' . $icon);
			} else {
				$icon = '';
			}

			$list_items .= '<li><span data-id="' . $matches[3][$i]['tab_id'] . '"><i class="step-icon ' . $icon . '"></i></span></li>';
		}
	}

	$output .= '<div class="step-panes">' . wpb_js_remove_wpautop($content, true) . '</div>';

	$output .= '<ul class="step-items">' . $list_items . '</ul>';

}

$output .= '</div>';
$output .= $style_css;

echo $output;
