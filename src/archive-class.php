<?php
	$CLASSES_PAGE_ID = 2;
	// Fetch main Classes page, not any posts
	$class_page_query = new WP_Query( 
		array( 
			'p' => $CLASSES_PAGE_ID, 
			'post_type' => 'any'
		) 
	);
	if ($class_page_query->have_posts()): while ($class_page_query->have_posts()) : $class_page_query->the_post();
?>
<?php /* Template Name: Shows */ get_header(); ?>
	<main role="main" aria-label="Content">
		<section class="container">
			<div class="row">
				<!-- <div class="filter-toolbar col-sm-11 text-right">
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
				</div> -->
			</div>
			<div class="row">
				<article id="post-<?php the_ID(); ?>" class="col-sm-10 col-sm-offset-1" <?php post_class();  ?>>
						<?php the_content(); ?>					
				</article>
			</div>
			<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
		<?php endwhile; ?>
		<?php endif; ?>
			<div class="row">
				<?php
					$classes_query = new WP_Query( 
						array(
							'post_type' => 'class', 
							'posts_per_page' => -1
						)
					);
					if ($classes_query->have_posts()): while ($classes_query->have_posts()) : $classes_query->the_post();
				?>
				<article class="z-layout-item" data-post-type="<?php echo $post->post_type; ?>" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
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
					<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php get_footer(); ?>
