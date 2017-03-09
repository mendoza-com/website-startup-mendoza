<?php
    /*
    Template Name: Blog: Standard Whole Post
    */
?>
<?php get_header(); ?>
<?php cozy_edge_get_title(); ?>
<?php get_template_part('slider'); ?>
    <div class="edgtf-container">
        <?php do_action('cozy_edge_after_container_open'); ?>
        <div class="edgtf-container-inner">
            <?php cozy_edge_get_blog('standard-whole-post'); ?>
        </div>
        <?php do_action('cozy_edge_before_container_close'); ?>
    </div>
<?php do_action('cozy_edge_after_container_close'); ?>
<?php get_footer(); ?>