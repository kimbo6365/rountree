<?php get_header(); ?>

	<main role="main" aria-label="Content">
	<!-- section -->
	<section class="container ">

	<?php if (have_posts()): while (have_posts()) : the_post(); ?>

		<!-- article -->
		<article id="post-<?php the_ID(); ?>" class="single-class-post" <?php post_class(); ?>>
			<?php get_template_part('_class_details_partial'); ?>
			<?php
				$linked_testimonials = get_field('linked_testimonials');
				if( $linked_testimonials ): ?>
				<h2 class="testimonial-header">What People Are Saying:</h2>
				<div class="entry-spacer class-testimonials"></div>
				<ul class="testimonials row">
					<?php foreach( $linked_testimonials as $post): // variable must be called $post (IMPORTANT) ?>
						<?php setup_postdata($post); ?>
						<li class="testimonial">
							<div class="testimonial-text">
								<?php echo get_the_content(); ?>
								<p class="testimonial-author">&mdash;<?php the_field('testimonial_author'); ?></p>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
				<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
			<?php endif; ?>
		</article>
		<!-- /article -->

	<?php endwhile; ?>

	<?php else: ?>

		<!-- article -->
		<article>

			<h1><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h1>

		</article>
		<!-- /article -->

	<?php endif; ?>

	</section>
	<!-- /section -->
	</main>

<?php get_footer(); ?>
