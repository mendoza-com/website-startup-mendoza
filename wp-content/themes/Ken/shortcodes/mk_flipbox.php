<?php

extract( shortcode_atts( array(
      'flip_direction' => '',
      'front_background_color' => '',
      'back_background_color' => '',
      'front_opacity' => '',
      'back_opacity' => '',
      "min_height" => '',
      "max_width" => '',
      'front_title' => '',
      'front_title_size' => '',
      'front_title_font_weight' => '',
      'front_title_color' => '',
      'front_desc' => '',
      'front_desc_size' => '',
      'front_desc_color' => '',
      'back_title' => '',
      'back_title_size' => '',
      'back_title_color' => '',
      'back_title_font_weight' => '',
      'back_desc' => '',
      'back_desc_size' => '',
      'back_desc_color' => '',
      'button_text' => '',
      'button_url' => '',
      'button_size' => '',
      'button_corner_style' => '',
      'btn_skin_1' => '',
      'btn_skin_2' => '',
      'el_class' => ''
    ), $atts ) );

$output = $front = $flip = '';

/*Flipbox Front*/
$front .= '<div class="mk-flipbox-front " style="opacity:'.$front_opacity.'; '.($front_background_color ? ('background-color: '.$front_background_color.';') : '').'" >';
$front .= ' <div class="mk-flipbox-content">';
$front .= '       <div class="front-title" style="'.($front_title_font_weight ? ('font-weight:'.$front_title_font_weight.';') : '').' font-size:'.$front_title_size.'px; line-height:'.$front_title_size.'px; '.($front_title_color ? ('color:'.$front_title_color.';') : '').'">'.$front_title.'</div>';
$front .= '       <div class="front-desc" style="font-size:'.$front_desc_size.'px; '.($front_desc_color ? ('color:'.$front_desc_color.';') : '').'">'.$front_desc.'</div>';
$front .= ' </div>';
$front .= '</div>';

/*Flipbox Back*/
$flip .= '<div class="mk-flipbox-back" style="opacity:'.$front_opacity.'; '.($back_background_color ? ('background-color: '.$back_background_color.';') : '').'">';
$flip .= '  <div class="mk-flipbox-content">';
$flip .= '        <div class="back-title" style="font-weight:'.$back_title_font_weight.'; font-size:'.$back_title_size.'px; line-height:'.$back_title_size.'px; '.($back_title_color ? ('color:'.$back_title_color.';') : '').'">'.$back_title.'</div>';
$flip .= '        <div class="back-desc" style="font-size:'.$back_desc_size.'px; '.($back_desc_color ? ('color:'.$back_desc_color.';') : '').' ">'.$back_desc.'</div>';

$flip .= !empty( $button_url ) ? (do_shortcode( '[mk_button style="fill" corner_style="'.$button_corner_style.'" size="'.$button_size.'" align="center" bg_color="" btn_hover_bg="" text_color="" outline_skin="'.$btn_skin_1.'" outline_border_width="2" outline_hover_skin="'.$btn_skin_2.'" url="'.$button_url.'" el_class=" back-button"]'.$button_text.'[/mk_button]' )) : '' ;

$flip .= '  </div>';
$flip .= '</div>';

$output .= '<div class="mk-flipbox-container flip-'.$flip_direction.' '.$el_class.'" style="height:1px; min-height:'.$min_height.'px; max-width:'.$max_width.'px">';
$output .= '      <div class="mk-flipbox-flipper">';
$output .=              $front;
$output .=              $flip;
$output .= '            <div class="clearboth"></div>';
$output .= '      </div>';
$output .= '</div>';


echo $output;
