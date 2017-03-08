<?php 

extract( shortcode_atts( array(
      'item_txt' => '',
      'item_text_size' => '',
      'item_color' => '',
      'item_font_weight' => '',
      'item_text_align' => '',
      'el_class' => '',
    ), $atts ) );


$output = '';

$id = uniqid();


$output .= '<div id="mk-fade-txt-item-'.$id.'" class="swiper-slide">
        		  '.$item_txt.'
            </div>';


$output .= '<style type="text/css">
                #mk-fade-txt-item-'.$id.' { 
                  font-size:'.$item_text_size.'px;
                  color: '.$item_color.';
                  font-weight: '.$item_font_weight.';
                  text-align: '.$item_text_align.';
                }
        </style>';


echo $output;