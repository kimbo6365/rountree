	<?php
		$CLASSES_PAGE_ID = 2;
		// Fetch main Shows page, not any posts
		$shows_query = new WP_Query( array( 'p' => $CLASSES_PAGE_ID, 'post_type' => 'any' ) );
		if ($shows_query->have_posts()): while ($shows_query->have_posts()) : $shows_query->the_post();
	?>
	<?php /* Template Name: Shows */ get_header(); ?>
	<main role="main" aria-label="Content">
		<section class="container-fluid">
			<div class="row">
				<div class="filter-toolbar col-sm-11 text-right">
					<span>Filter by:&nbsp;</span>
					<div class="btn-group" data-toggle="buttons">
							<label id="btn-select-classes" class="btn btn-default">
								<input type="radio" name="category" id="2" autocomplete="off"> Classes
							</label>
							<label id="btn-select-workshops" class="btn btn-default">
								<input type="radio" name="options" id="3" autocomplete="off"> Workshops
							</label>
							<label id="btn-select-all" class="btn btn-default active">
								<input type="radio" name="options" id="*" autocomplete="off" checked> All
							</label>
					</div>
				</div>
			</div>
			<div class="row">
				<article id="post-<?php the_ID(); ?>" class="col-sm-10 col-sm-offset-1" <?php post_class();  ?>>
						<?php the_content(); ?>					
				</article>
			</div>
			<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
		<?php endwhile; ?>
	<?php endif; ?>
	<?php if (have_posts()): while (have_posts()) : the_post(); ?>
		<article class="class-listing" data-post-category="<?php echo get_the_category()[0]->cat_ID; ?>" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php get_template_part('_class_details_partial'); ?>
			<?php
				$linked_testimonials = get_field('linked_testimonials');
				if( $linked_testimonials ): ?>
				<ul class="testimonials">
					<?php $post = $linked_testimonials[0]; ?>
					<?php setup_postdata($post); ?>
					<li class="testimonial">
						<div class="testimonial-text">
							<?php the_content(); ?>
							<p class="testimonial-author">&mdash;<?php the_field('testimonial_author'); ?></p>
						</div>
					</li>
				</ul>
				<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
			<?php endif; ?>
			<?php if (($wp_query->current_post +1) < ($wp_query->post_count)): ?>
				<div class="entry-spacer"></div>
			<?php endif; ?>
		</article>
	<!-- /article -->
	<?php endwhile; ?>
	<?php endif; ?>
</section>
</main>
<?php get_footer(); ?>
