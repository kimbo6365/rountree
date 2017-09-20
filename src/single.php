<?php get_header(); ?>

	<main role="main" aria-label="Content">
	<section class="container-fluid">
		<div class="row">
	<?php if (have_posts()): while (have_posts()) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="col-sm-10 col-sm-offset-1">
					<h1 class="page-title">
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
					</h1>
				</div>
				<div class="col-sm-10 col-sm-offset-1">
					<?php the_content(); // Dynamic Content ?>
				</div>
				<div class="col-sm-10 col-sm-offset-1">
					<?php
						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
					?>
				</div>
				</section>
			</article>
			</div>
	<?php endwhile; ?>

	<?php else: ?>

		<!-- article -->
		<article>

			<h1 class="page-title"><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h1>

		</article>
		<!-- /article -->

	<?php endif; ?>

	</section>
	<!-- /section -->
	</main>

<?php get_footer(); ?>
