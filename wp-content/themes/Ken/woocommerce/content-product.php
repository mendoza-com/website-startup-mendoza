<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 *
 * @package This template is overrided by theme
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop, $mk_settings, $post;


// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;



$grid_width = $mk_settings['grid-width'];
$content_width = $mk_settings['content-width'];
$height = $mk_settings['woo-loop-thumb-height'];
$quality = $mk_settings['woo-image-quality'] ? $mk_settings['woo-image-quality'] : 1;

// Sets the shop loop columns from theme options.
if(is_archive()) {
	$layout = $mk_settings['woo-shop-layout'];
	if($layout == 'full') {
		$classes[] = 'four-column';
		$width = round($grid_width/4) - 36;
		$column_width = round($grid_width/4);
	} else {
		$classes[] = 'three-column';
		$width = round((($content_width / 100) * $grid_width)/3) - 36;
		$column_width = round($grid_width/3);
	}
} else {
	switch ($woocommerce_loop['columns']) {

	case 4:
			$classes[] = 'four-column';
			$width = round($grid_width/4) - 38;
			$column_width = round($grid_width/4);
		break;
	case 3:
			$classes[] = 'three-column';
			$width = round($grid_width/3) - 41;
			$column_width = round($grid_width/3);
		break;
	case 2:
			$classes[] = 'two-column';
			$width = round($grid_width/2) - 49;
			$column_width = round($grid_width/2);
		break;
	case 1:
			$classes[] = 'one-column';
			$width = $grid_width - 66;
			$column_width = $grid_width;
		break;

	default:
			$classes[] = 'four-column';
			$width = round($grid_width/4) - 36;
			$column_width = round($grid_width/4);
		break;
}

}


/*
* Product add to card & out of stock badge
*/
$out_of_stock_badge = '';
if ( ! $product->is_in_stock() ) {

	$mk_add_to_cart = '<a href="'. apply_filters( 'out_of_stock_add_to_cart_url', get_permalink( $product->id ) ).'" alt="'. apply_filters( 'out_of_stock_add_to_cart_text', __( 'READ MORE', 'mk_framework' ) ).'" class="add_to_cart_button"><i class="mk-theme-icon-magnifier"></i></a>';

	$out_of_stock_badge = '<span class="out-of-stock">'.__( 'OUT OF STOCK', 'mk_framework' ).'</span>';
}
else { ?>

	<?php

	switch ( $product->product_type ) {
	case "variable" :
		$link  = apply_filters( 'variable_add_to_cart_url', get_permalink( $product->id ) );
		$label  = apply_filters( 'variable_add_to_cart_text', __( 'Select options', 'mk_framework' ) );
		$icon_class = 'mk-theme-icon-plus';
		break;
	case "grouped" :
		$link  = apply_filters( 'grouped_add_to_cart_url', get_permalink( $product->id ) );
		$label  = apply_filters( 'grouped_add_to_cart_text', __( 'View options', 'mk_framework' ) );
		$icon_class = 'mk-theme-icon-plus';
		break;
	case "external" :
		$link  = apply_filters( 'external_add_to_cart_url', get_permalink( $product->id ) );
		$label  = apply_filters( 'external_add_to_cart_text', __( 'Read More', 'mk_framework' ) );
		$icon_class = 'mk-theme-icon-magnifier';
		break;
	default :
		$link  = apply_filters( 'add_to_cart_url', esc_url( $product->add_to_cart_url() ) );
		$label  = apply_filters( 'add_to_cart_text', __( 'ADD TO CART', 'mk_framework' ) );
		$icon_class = 'mk-theme-icon-cart2';
		break;
	}

	if ( $product->product_type != 'external' ) {
		$mk_add_to_cart = '<a href="'. $link .'" rel="nofollow" data-product_id="'.$product->id.'" title="'.$label.'" class="add_to_cart_button product_type_'.$product->product_type.'"><i class="'.$icon_class.'"></i></a>';
	}
	else {
		$mk_add_to_cart = '';
	}
}





?>
<li <?php post_class( $classes ); ?> style="max-width:<?php echo $column_width; ?>px">
	<div class="item-holder">

	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

		<span class="product-loading-icon"></span>

		<?php

			echo $out_of_stock_badge;

			if ($product->is_on_sale()) :
			 echo apply_filters('woocommerce_sale_flash', '<span class="onsale">'.__( 'SALE', 'mk_framework' ).'</span>', $post, $product);
			endif;

			$loop_image_size = isset($mk_settings['woo_loop_image_size']) ? $mk_settings['woo_loop_image_size'] : 'crop';

		/* Porduct loop thumbnail */
		if ( has_post_thumbnail() ) {
			switch ($loop_image_size) {
		        case 'full':
		            $image_src_array = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full', true);
		            $image_output_src = $image_src_array[0];
		            break;
		        case 'crop':
		            $image_src_array = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full', true);
		            $image_output_src = bfi_thumb($image_src_array[0], array(
		                'width' => $width*$quality,
		                'height' => $height*$quality
		            ));
		            break;            
		        case 'large':
		            $image_src_array = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large', true);
		            $image_output_src = $image_src_array[0];
		            break;
		        case 'medium':
		            $image_src_array = wp_get_attachment_image_src(get_post_thumbnail_id(), 'medium', true);
		            $image_output_src = $image_src_array[0];
		            break;        
		        default:
		            $image_src_array = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full', true);
		            $image_output_src = bfi_thumb($image_src_array[0], array(
		                'width' => $width*$quality,
		                'height' => $height*$quality
		            ));
		            break;
		    }

			echo '<a href="'. get_permalink().'" class="product-loop-thumb">';

			echo '<img src="'.mk_thumbnail_image_gen($image_output_src, $width, $height).'" class="product-loop-image" alt="'.get_the_title().'" title="'.get_the_title().'" itemprop="image">';

			$product_gallery = get_post_meta( $post->ID, '_product_image_gallery', true );

			if ( !empty( $product_gallery ) ) {

				$gallery = explode( ',', $product_gallery );
				$hover_image_id  = $gallery[0];

				$image_src_hover_array = wp_get_attachment_image_src($hover_image_id, 'full', true );
				
				switch ($loop_image_size) {
		        case 'full':
		            $image_src_hover_array = wp_get_attachment_image_src($hover_image_id, 'full', true);
		            $image_hover_src = $image_src_hover_array[0];
		            break;
		        case 'crop':
		            $image_src_hover_array = wp_get_attachment_image_src($hover_image_id, 'full', true);
		            $image_hover_src = bfi_thumb($image_src_hover_array[0], array(
		                'width' => $width*$quality,
		                'height' => $height*$quality
		            ));
		            break;            
		        case 'large':
		            $image_src_hover_array = wp_get_attachment_image_src($hover_image_id, 'large', true);
		            $image_hover_src = $image_src_hover_array[0];
		            break;
		        case 'medium':
		            $image_src_hover_array = wp_get_attachment_image_src($hover_image_id, 'medium', true);
		            $image_hover_src = $image_src_hover_array[0];
		            break;        
		        default:
		            $image_src_hover_array = wp_get_attachment_image_src($hover_image_id, 'full', true);
		            $image_hover_src = bfi_thumb($image_src_hover_array[0], array(
		                'width' => $width*$quality,
		                'height' => $height*$quality
		            ));
		            break;
		    }

				echo '<img src="'.mk_thumbnail_image_gen($image_hover_src, $width, $height).'" alt="'.get_the_title().'" class="product-hover-image" title="'.get_the_title().'" >';
			}


		} else {

			echo '<img src="'. woocommerce_placeholder_img_src() .'" alt="Placeholder" width="'.$width*$quality.'" height="'.$height*$quality.'" />';

		}


		echo '<span class="product-hover-items">';
			 if ( $rating_html = $product->get_rating_html() ) :
					echo '<span class="product-item-rating">'.$rating_html.'</span>';
			endif;

			if( function_exists('mk_love_this') ) {
				echo mk_love_this();
			}

		echo '</span>';

		echo '</a>';

		?>




		<div class="product-item-details">

			<h3><a href="<?php echo get_permalink();?>"><?php the_title(); ?></a></h3>

			<?php do_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 ); ?>

			<?php echo $mk_add_to_cart; ?>
		</div>



	<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
</div>
</li>


