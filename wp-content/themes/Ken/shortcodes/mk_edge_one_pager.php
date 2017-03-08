<?php

extract(shortcode_atts(array(
    'orderby' => 'date',
    'slides' => '',
    'order' => 'DESC',
    'navigation' => 'true',
    "el_class" => ''
), $atts));

$button2_txt_color = $button1_txt_color = $outline1_hover_color = $outline2_hover_color = $button2_bg_color = $button1_bg_color = $outline2_active_color = $color_mask_css = $outline1_active_color = '';

global $post, $mk_accent_color;

$query = array(
    'post_type' => 'edge',
    'suppress_filters' => false
);


if (!empty($slides)) {
    $query['post__in'] = explode(',', $slides);
}

if ($order) {
    $query['order'] = $order;
}
if ($orderby) {
    $query['orderby'] = $orderby;
}

$loop = new WP_Query($query);


$output = '<div id="fullpage" class="mk-edge-one-pager" data-navigation="'.$navigation.'">';
while ($loop->have_posts()):
    $loop->the_post();
    
    
    $type            = get_post_meta($post->ID, '_edge_type', true) ? get_post_meta($post->ID, '_edge_type', true) : 'image';
    $animation       = get_post_meta($post->ID, '_animation', true) ? get_post_meta($post->ID, '_animation', true) : 'slide_down';
    $mp4             = get_post_meta($post->ID, '_video_mp4', true);
    $webm            = get_post_meta($post->ID, '_video_webm', true);
    $video_preview   = get_post_meta($post->ID, '_video_preview', true);
    $pattern         = get_post_meta($post->ID, '_pattern', true);
    $overlay         = get_post_meta($post->ID, '_color_overlay', true);
    $overlay_opacity = get_post_meta($post->ID, '_overlay_opacity', true);
    $slide_image     = get_post_meta($post->ID, '_slide_image', true);
    $slide_bg_color  = get_post_meta($post->ID, '_bg_color', true);
    $cover_bg        = get_post_meta($post->ID, '_cover', true);
    
    $content_width = get_post_meta($post->ID, '_content_width', true) ? get_post_meta($post->ID, '_content_width', true) : 70;
    $title         = get_post_meta($post->ID, '_title', true);
    $description   = get_post_meta($post->ID, '_description', true);

    $title_size           = get_post_meta($post->ID, '_title_size', true) ? ('font-size : '.get_post_meta($post->ID, '_title_size', true).'px;') : '';
    $title_weight         = get_post_meta($post->ID, '_caption_title_weight', true) ? ('font-weight:'.get_post_meta($post->ID, '_caption_title_weight', true).';') : '';
    $caption_custom_color = get_post_meta($post->ID, '_custom_caption_color', true) ? ('color:'.get_post_meta($post->ID, '_custom_caption_color', true)) : '';
    
    $btn_1_txt = get_post_meta($post->ID, '_btn_1_txt', true);
    $btn_1_url = get_post_meta($post->ID, '_btn_1_url', true);
    $btn_2_txt = get_post_meta($post->ID, '_btn_2_txt', true);
    $btn_2_url = get_post_meta($post->ID, '_btn_2_url', true);
    
    $caption_skin = get_post_meta($post->ID, '_caption_skin', true);
    
    $btn_1_style = get_post_meta($post->ID, '_btn_1_style', true);
    $btn_2_style = get_post_meta($post->ID, '_btn_2_style', true);
    
    $btn_1_skin    = get_post_meta($post->ID, '_btn_1_skin', true);
    $btn_2_skin    = get_post_meta($post->ID, '_btn_2_skin', true);
    $caption_align = get_post_meta($post->ID, '_caption_align', true);
    
    $header_skin = get_post_meta($post->ID, '_edge_header_skin', true) ? get_post_meta($post->ID, '_edge_header_skin', true) : 'dark';
    
    
    
    if ($btn_1_style == 'flat') {
        if ($btn_1_skin == 'light') {
            $button1_bg_color  = '#ffffff';
            $button1_txt_color = '#252525';
            
        } else if ($btn_1_skin == 'dark') {
            $button1_bg_color  = '#252525';
            $button1_txt_color = '#fff';
            
        } else if ($btn_1_skin == 'skin') {
            $button1_bg_color  = $mk_accent_color;
            $button1_txt_color = '#fff';
        }
    }
    
    if ($btn_2_style == 'flat') {
        if ($btn_2_skin == 'light') {
            $button2_bg_color  = '#ffffff';
            $button2_txt_color = '#252525';
            
        } else if ($btn_2_skin == 'dark') {
            $button2_bg_color  = '#252525';
            $button2_txt_color = '#fff';
            
        } else if ($btn_2_skin == 'skin') {
            $button2_bg_color  = $mk_accent_color;
            $button2_txt_color = '#fff';
        }
    }
    
    
    if ($btn_1_style == 'outline') {
        if ($btn_1_skin == 'light') {
            $outline1_active_color = '#ffffff';
            $outline1_hover_color  = '#252525';
            
        } else if ($btn_1_skin == 'dark') {
            $outline1_active_color = '#252525';
            $outline1_hover_color  = '#ffffff';
            
        } else if ($btn_1_skin == 'skin') {
            $outline1_active_color = $mk_accent_color;
            $outline1_hover_color  = '#ffffff';
        }
    }
    
    if ($btn_2_style == 'outline') {
        if ($btn_2_skin == 'light') {
            $outline2_active_color = '#ffffff';
            $outline2_hover_color  = '#252525';
            
        } else if ($btn_2_skin == 'dark') {
            $outline2_active_color = '#252525';
            $outline2_hover_color  = '#ffffff';
            
        } else if ($btn_2_skin == 'skin') {
            $outline2_active_color = $mk_accent_color;
            $outline2_hover_color  = '#ffffff';
        }
    }
    
    
    
    
    $bg_image_css = ($type == 'image') ? ' style="background-image:url(' . $slide_image . '); background-color:' . $slide_bg_color . '" ' : '';
    
    $cover_bg = ($cover_bg != 'false') ? ' mk-background-stretch' : '';
    
    $output .= '<section id="edge-entry-'.get_the_id().'" class="section one-pager-slide ' . $caption_align . $cover_bg . '"' . $bg_image_css . ' data-title="'.str_replace(' ', '-', get_the_title()).'" data-header-skin="' . $header_skin . '">';
    
    
    if ($pattern == 'true') {
        $output .= '<div class="mk-section-mask"></div>';
    }
    

    if (!empty($overlay)) {
        $color_mask_css = ' style="background-color:' . $overlay . ';opacity:' . $overlay_opacity . ';"';
        $output .= '<div' . $color_mask_css . ' class="mk-section-color-mask"></div>';
    }
    
    
    if ($type == 'video') {

         if(!empty($video_preview)) {
            $output .= '<div style="background-image:url('.$video_preview.');" class="mk-video-section-touch"></div>';  
         }
        
        $output .= '<div class="mk-section-video"><video poster="' . $video_preview . '" muted="muted" preload="auto" loop="true" autoplay="true">';
        
        if (!empty($mp4)) {
            $output .= '<source type="video/mp4" src="' . $mp4 . '" />';
        }
        if (!empty($webm)) {
            $output .= '<source type="video/webm" src="' . $webm . '" />';
        }
        if (!empty($ogv)) {
            $output .= '<source type="video/ogg" src="' . $ogv . '" />';
        }
        
        $output .= '</video></div>';
    }
    
    
    $output .= '<div class="mk-grid">';
    
    $output .= '<div class="edge-slide-content edge-' . $animation . ' caption-' . $caption_skin . '" style="width:' . $content_width . '%">';
    $output .= (!empty($title)) ? '<div class="mk-edge-title" style="'.$title_size.$title_weight.$caption_custom_color.'">' . $title . '</div>' : '';
    $output .= (!empty($description)) ? '<p class="mk-edge-desc" style="'.$caption_custom_color.'">' . $description . '</p>' : '';
    
    if (!empty($btn_1_txt) || !empty($btn_2_txt)) {
        $output .= '<div class="edge-buttons">';
        $smooth_scroll_1 = (preg_match('/#/',$btn_1_url)) ? ' el_class="mk-smooth"' : '';
        $smooth_scroll_2 = (preg_match('/#/',$btn_2_url)) ? ' el_class="mk-smooth"' : '';
        $output .= (!empty($btn_1_txt)) ? do_shortcode('[mk_button style="' . $btn_1_style . '" size="large" bg_color="' . $button1_bg_color . '" txt_color="' . $button1_txt_color . '" outline_skin="' . $outline1_active_color . '" outline_hover_skin="' . $outline1_hover_color . '" url="' . $btn_1_url . '" target="_self" align="left" margin_top="0" margin_bottom="10"'.$smooth_scroll_1.']' . $btn_1_txt . '[/mk_button]') : '';
        $output .= (!empty($btn_2_txt)) ? do_shortcode('[mk_button style="' . $btn_2_style . '" size="large" bg_color="' . $button2_bg_color . '" txt_color="' . $button2_txt_color . '" outline_skin="' . $outline2_active_color . '" outline_hover_skin="' . $outline2_hover_color . '" url="' . $btn_2_url . '" target="_self" align="left" margin_top="0" margin_bottom="10"'.$smooth_scroll_2.']' . $btn_2_txt . '[/mk_button]') : '';
        $output .= '</div>';
    }
    
    $content = str_replace(']]>', ']]&gt;', apply_filters('the_content', get_the_content()));
    
    if (!empty($content)) {
        $output .= '<div class="mk-edge-custom-content">' . $content . '</div>';
    }
    
    $output .= '</div><!--/edge-slide-content-->';
    $output .= '</div><!--/mk-grid-->';
    $output .= '</section><!--/edge-slide-->' . "\n\n\n";

endwhile;
wp_reset_postdata();

$output .= '</div>';


echo $output;
