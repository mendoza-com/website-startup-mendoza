<?php
$output = $el_class = '';
extract(shortcode_atts(array(
	'fullwidth' => 'false',
	'id' => '',
	'padding' =>0,
	'attached' => 'false',
	'visibility' => '',
    'el_class' => '',
), $atts));

$fullwidth_start = $output = $fullwidth_end = '';

$padding_css = ($attached == 'true') ? ' add-padding-'.$padding : '';

$css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_row vc_row '.get_row_css_class().$el_class, $this->settings['base']);

$id = $id ? (' id="'.$id.'" ') : '';

if($fullwidth == 'true') {
	global $post;
	$page_layout = get_post_meta( $post->ID, '_layout', true );
	$fullwidth_start = '</div></div></div>';
	if(is_singular('post')) {
		$fullwidth_start .= '</div>';
	}
	$fullwidth_end = '<div class="mk-main-wrapper-holder"><div class="theme-page-wrapper '.$page_layout.'-layout mk-grid vc_row-fluid no-padding"><div class="theme-content no-padding">';
	if(is_singular('post')) {
		$fullwidth_end .= '<div class="single-content">';
	}
}

$output .= $fullwidth_start . '<div'.$id.' class="'.$css_class.' '.$visibility.' mk-fullwidth-'.$fullwidth.$padding_css .' attched-'.$attached.'">';
$output .= wpb_js_remove_wpautop($content);
$output .= '</div>'.$fullwidth_end . $this->endBlockComment('row');
echo $output;