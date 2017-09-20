<?php // Exclude posts from Class-Series, Workshops, and Shows categories ?>
<?php $query = new WP_Query( "cat=-2,-3,-4&paged=$paged" ); ?>
<?php if ($query->have_posts()): while ($query->have_posts()) : $query->the_post(); ?>
	<div class="row">
		<!-- article -->
		<article id="post-<?php the_ID(); ?>" class="blog-post col-sm-12" <?php post_class(); ?>>

			<div class="col-sm-10 col-sm-offset-1">
					<h2>
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
					</h2>
					<span class="post-meta-information">
						Posted on
						<time datetime="<?php the_time('Y-m-d'); ?> <?php the_time('H:i'); ?>">
							<?php the_date(); ?> <?php the_time(); ?>
						</time>
					</span>
					<div class="blog-excerpt">
						<p><?php the_excerpt(); ?></p>
					</div>
				</div>
		</article>
		<!-- /article -->
	</div>
	<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
<?php endwhile; ?>
<?php else: ?>

	<!-- article -->
	<article>
		<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>
	</article>
	<!-- /article -->

<?php endif; ?>
