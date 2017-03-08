<?php
global $mk_settings;
$el_class = $output = $style_css = '';

extract( shortcode_atts( array(
            'container_bg_color' => '',
            'style' => 'simple',
            'el_class' => ''
		), $atts ) );


$id = uniqid();
$el_class = $this->getExtraClass( $el_class );

$style_css .= '<style type="text/css">';

if ( $style == 'simple' ) {
    $style_css .= '
        #accordion-'.$id.' .mk-accordion-single.current-item .mk-accordion-tab{
            color:'.$mk_settings['accent-color'].';
        }
        ';
}
$style_css .= '</style>';

$output .= '<div id="accordion-'.$id.'" class="mk-accordion '.$style.'-style '.$el_class.'">';
$output .= wpb_js_remove_wpautop($content);
$output .= '</div>';
$output .= $style_css;
$output .= '<style>#accordion-'.$id.' .mk-accordion-pane .inner-box{background-color: '.$container_bg_color.';}</style>';


echo $output;
