<?php
	$SHOWS_PAGE_ID = 6;
	// Fetch main Shows page, not any posts
	$shows_query = new WP_Query( array( 'p' => $SHOWS_PAGE_ID, 'post_type' => 'page' ) );
	if ($shows_query->have_posts()): while ($shows_query->have_posts()) : $shows_query->the_post();
?>
<?php /* Template Name: Shows */ get_header(); ?>
<main role="main" aria-label="Content">
		<section class="container">
			<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
			<?php endwhile; ?>
		<?php endif; ?>	
		<div class="row">		
			<?php if (have_posts()): while (have_posts()) : the_post(); ?>
				<?php if ($wp_query->post->post_parent == 0): ?>
					<article id="post-<?php the_ID(); ?>" class="z-layout-item" <?php post_class();  ?>>
						<?php get_template_part('_show_details_partial'); ?>
						<?php if (($wp_query->current_post +1) < ($wp_query->post_count)): ?>
							<div class="entry-spacer"></div>
						<?php endif; ?>
					</article>
				<?php endif; ?>
				<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
			<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php get_footer(); ?>
