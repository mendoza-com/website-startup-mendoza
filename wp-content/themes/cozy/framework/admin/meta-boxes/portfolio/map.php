<?php

if(!function_exists('cozy_edge_map_portfolio')) {
    function cozy_edge_map_portfolio()
    {
        global $cozy_edge_Framework;

        $edgt_pages = array();
        $pages = get_pages();
        foreach ($pages as $page) {
            $edgt_pages[$page->ID] = $page->post_title;
        }

        global $cozy_edge_IconCollections;

//Portfolio Images

        $edgtPortfolioImages = new CozyEdgeMetaBox("portfolio-item", "Portfolio Images (multiple upload)", '', '', 'portfolio_images');
        $cozy_edge_Framework->edgtMetaBoxes->addMetaBox("portfolio_images", $edgtPortfolioImages);

        $edgt_portfolio_image_gallery = new CozyEdgeMultipleImages("edgt_portfolio-image-gallery", "Portfolio Images", "Choose your portfolio images");
        $edgtPortfolioImages->addChild("edgt_portfolio-image-gallery", $edgt_portfolio_image_gallery);

//Portfolio Images/Videos 2

        $edgtPortfolioImagesVideos2 = new CozyEdgeMetaBox("portfolio-item", "Portfolio Images/Videos (single upload)");
        $cozy_edge_Framework->edgtMetaBoxes->addMetaBox("portfolio_images_videos2", $edgtPortfolioImagesVideos2);

        $edgt_portfolio_images_videos2 = new CozyEdgeImagesVideosFramework("Portfolio Images/Videos 2", "ThisIsDescription");
        $edgtPortfolioImagesVideos2->addChild("edgt_portfolio_images_videos2", $edgt_portfolio_images_videos2);

//Portfolio Additional Sidebar Items

//$edgtAdditionalSidebarItems = new CozyEdgeMetaBox("portfolio-item", "Additional Portfolio Sidebar Items");
//$cozy_edge_Framework->edgtMetaBoxes->addMetaBox("portfolio_properties",$edgtAdditionalSidebarItems);
        $edgtAdditionalSidebarItems = cozy_edge_add_meta_box(
            array(
                'scope' => array('portfolio-item'),
                'title' => esc_html__('Additional Portfolio Sidebar Items', 'cozy'),
                'name' => 'portfolio_properties'
            )
        );

        $edgt_portfolio_properties = cozy_edge_add_options_framework(
            array(
                'label' => esc_html__('Portfolio Properties', 'cozy'),
                'name' => 'edgt_portfolio_properties',
                'parent' => $edgtAdditionalSidebarItems
            )
        );

        //$edgt_portfolio_properties = new CozyEdgeOptionsFramework("Portfolio Properties","ThisIsDescription");
        //$edgtAdditionalSidebarItems->addChild("edgt_portfolio_properties",$edgt_portfolio_properties);

        if (!function_exists('cozy_edge_add_attachment_custom_field')) {
            function cozy_edge_add_attachment_custom_field($form_fields, $post = null)
            {
                if (wp_attachment_is_image($post->ID)) {
                    $field_value = get_post_meta($post->ID, '_ptf_single_masonry_image_size', true);

                    $form_fields['ptf_single_masonry_image_size'] = array(
                        'input' => 'html',
                        'label' => esc_html__('Image Size', 'cozy'),
                        'helps' => esc_html__('Choose image size for masonry single', 'cozy')
                    );

                    $form_fields['ptf_single_masonry_image_size']['html'] = "<select name='attachments[{$post->ID}][ptf_single_masonry_image_size]'>";
                    $form_fields['ptf_single_masonry_image_size']['html'] .= '<option ' . selected($field_value, 'edgtf-default-masonry-item', false) . ' value="edgtf-default-masonry-item">' . esc_html__('Default Size', 'cozy') . '</option>';
                    $form_fields['ptf_single_masonry_image_size']['html'] .= '<option ' . selected($field_value, 'edgtf-large-height-masonry-item', false) . ' value="edgtf-large-height-masonry-item">' . esc_html__('Large Height', 'cozy') . '</option>';
                    $form_fields['ptf_single_masonry_image_size']['html'] .= '<option ' . selected($field_value, 'edgtf-large-width-masonry-item', false) . ' value="edgtf-large-width-masonry-item">' . esc_html__('Large Width', 'cozy') . '</option>';
                    $form_fields['ptf_single_masonry_image_size']['html'] .= '<option ' . selected($field_value, 'edgtf-large-width-height-masonry-item', false) . ' value="edgtf-large-width-height-masonry-item">' . esc_html__('Large Width/Height', 'cozy') . '</option>';
                    $form_fields['ptf_single_masonry_image_size']['html'] .= '</select>';

                }
                return $form_fields;
            }

            add_filter('attachment_fields_to_edit', 'cozy_edge_add_attachment_custom_field', 10, 2);
        }

        if (!function_exists('cozy_edge_image_attachment_fields_to_save')) {
            /**
             * @param array $post
             * @param array $attachment
             * @return array
             */
            function cozy_edge_image_attachment_fields_to_save($post, $attachment)
            {

                if (isset($attachment['ptf_single_masonry_image_size'])) {
                    update_post_meta($post['ID'], '_ptf_single_masonry_image_size', $attachment['ptf_single_masonry_image_size']);
                }

                return $post;
            }

            add_filter('attachment_fields_to_save', 'cozy_edge_image_attachment_fields_to_save', 10, 2);
        }
    }
    add_action('cozy_edge_meta_boxes_map', 'cozy_edge_map_portfolio');
}