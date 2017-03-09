<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="edgtf-post-content">
		<div class="edgtf-post-image">
			<?php cozy_edge_get_module_template_part('templates/parts/video', 'blog'); ?>
		</div>
		<div class="edgtf-post-text">
			<div class="edgtf-post-text-inner">
				<?php cozy_edge_get_module_template_part('templates/lists/parts/title', 'blog'); ?>
				<div class="edgtf-post-info">
					<?php cozy_edge_post_info(array('author' => 'yes', 'category' => 'yes', 'date' => 'yes')) ?>
				</div>
				<?php
				if($type == 'standard-whole-post') {
					the_content();
				} else {
					cozy_edge_excerpt($excerpt_length);
				}
				?>
				<?php cozy_edge_get_module_template_part('templates/lists/parts/pages-navigation', 'blog');  ?>
				<?php if((has_tag() || cozy_edge_get_social_share_html() != '') && ($type == 'standard' || $type == 'standard-whole-post')) : ?>
					<div class="edgtf-post-info-bottom">
						<div class="edgtf-post-info-bottom-left">
							<?php has_tag() ? the_tags('', ', ', '') : ''; ?>
						</div>
						<div class="edgtf-post-info-bottom-right">
							<?php cozy_edge_post_info(array('share' => 'yes')) ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</article>