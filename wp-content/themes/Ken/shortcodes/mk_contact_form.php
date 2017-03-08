    <?php

    extract( shortcode_atts( array(
                'title' => '',
                'email' => get_bloginfo( 'admin_email' ),
                'style' => 'classic',
                'skin' => 'dark',
                'skin_color' => '',
                'btn_text_color' => '',
                'btn_hover_text_color' => '',
                'phone' => 'false',
                'captcha' => 'true',
                'el_class' => '',
            ), $atts ) );




    $id = uniqid();
    $tabindex_1 = $id;
    $tabindex_2 = $id + 1;
    $tabindex_3 = $id + 2;
    $tabindex_4 = $id + 3;
    $tabindex_5 = $id + 4;
    $name_str = __( 'FULL NAME ', 'mk_framework' );
    $email_str = __( 'EMAIL', 'mk_framework' );
    $submit_str = __( 'SUBMIT', 'mk_framework' );
    $content_str = __( 'SHORT MESSAGE', 'mk_framework' );
    $phone_str = __( 'YOUR PHONE NUMBER', 'mk_framework' );
    $enter_captcha = __( 'Enter Captcha', 'mk_framework' );
    $not_readable = __( 'Not readable?', 'mk_framework' );
    $change_text= __( 'Change text.', 'mk_framework' );

    $icon_user = $style == 'classic' ? '<i class="mk-icon-user"></i>' : '';
    $icon_email = $style == 'classic' ? '<i class="mk-icon-envelope-o"></i>' : '';
    $icon_phone = $style == 'classic' ? '<i class="mk-theme-icon-phone"></i>' : '';
    $icon_lock= $style == 'classic' ? '<i class="mk-li-lock"></i>' : '';

    $email = antispambot($email);
    $output = $style_css = $skin_style = "";

    $style_css .= '<style type="text/css">';

if ( $style == 'modern' ) {
    $style_css .= '
        #contact-form-'.$id.' .text-input,
        #contact-form-'.$id.' .mk-textarea,
        #contact-form-'.$id.' .mk-button{
            border-color:'.$skin_color.';
        }
        #contact-form-'.$id.' .text-input,
        #contact-form-'.$id.' .mk-textarea{
            color:'.$skin_color.';
        }
        #contact-form-'.$id.' .text-input::-webkit-input-placeholder,
        #contact-form-'.$id.' .mk-textarea::-webkit-input-placeholder,
        #contact-form-'.$id.' .text-input:-moz-placeholder,
        #contact-form-'.$id.' .mk-textarea:-moz-placeholder,
        #contact-form-'.$id.' .text-input::-moz-placeholder,
        #contact-form-'.$id.' .mk-textarea::-moz-placeholder,
        #contact-form-'.$id.' .text-input:-ms-input-placeholder,
        #contact-form-'.$id.' .mk-textarea:-ms-input-placeholder{
            color:'.$skin_color.';
        }
        #contact-form-'.$id.' .mk-button{
            color:'.$btn_text_color.' !important;
        }
        #contact-form-'.$id.' .mk-button:hover{
            background-color:'.$skin_color.';
            color:'.$btn_hover_text_color.' !important;
        }
        #contact-form-'.$id.' .captcha-change-image {
            color:'.$skin_color.';
        }
        ';
}

$style_css .= '</style>';

    $skin_style .= ($style == 'modern') ? '' : $skin.'-skin ';

    $output .= '<div id="contact-form-'.$id.'" class="mk-contact-form-wrapper '.$style.'-style '.$skin_style.$el_class.'">';
    $output .= '    <form class="mk-contact-form" method="post" novalidate="novalidate">';
    $output .= '        <div class="mk-form-row">
                            '.$icon_user.'
                            <input placeholder="'.$name_str.'" type="text" required="required" name="contact_name" class="text-input" value="" tabindex="'.$tabindex_1.'" />
                        </div>';
    $output .= '        <div class="mk-form-row">
                            '.$icon_email.'
                            <input placeholder="'.$email_str.'" type="email" required="required" name="contact_email" class="text-input" value="" tabindex="'.$tabindex_2.'" />
                            </div>';
    if($phone == 'true'){
    $output .= '        <div class="mk-form-row">
                            '.$icon_phone.'
                            <input placeholder="'.$phone_str.'" type="text" name="contact_phone" class="text-input" value="" tabindex="'.$tabindex_3.'" /></div>';
    }

    $output .= '        <textarea required="required" placeholder="'.$content_str.'" name="contact_content" class="mk-textarea" tabindex="'.$tabindex_4.'"></textarea>';
    
   
    // CAPTCHA 
    if($captcha == 'true') {
    $output .= '<div class="mk-form-row">
                    '.$icon_lock.'
                    <input placeholder="'.$enter_captcha.'" type="text" name="captcha" class="captcha-form text-input full" required="required" autocomplete="off" />
                        <img src="'.THEME_DIR_URI.'/captcha/captcha.php" class="captcha-image" alt="captcha txt"> 
                        <a href="#" class="captcha-change-image">'.$not_readable.' '.$change_text.'</a>
                </div>';
    }    

    $output .= '        <div class="button-row">
                            <button tabindex="'.$tabindex_5.'" class="mk-progress-button mk-button  outline-button medium" data-style="move-up">
                                <span class="mk-progress-button-content">'.$submit_str.'</span>
                                <span class="mk-progress">
                                    <span class="mk-progress-inner"></span>
                                </span>
                                <span class="state-success"><i class="mk-icon-check"></i></span>
                                <span class="state-error"><i class="mk-icon-times"></i></span>
                            </button>
                        </div>';
    $output .= '        <i class="mk-contact-loading mk-icon-refresh"></i>';
    $output .= '        <i class="mk-contact-success mk-theme-icon-tick"></i>';
    $output .= '        <input type="hidden" value="'.$email.'" name="contact_to"/>';
    $output .= '    </form>';
    $output .= '    <div class="clearboth"></div>';
    $output .= '</div>';
    $output .= $style_css;

    echo $output;
