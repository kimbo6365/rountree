<?php get_header(); ?>

	<main role="main" aria-label="Content">
	<!-- section -->
	<section class="container-fluid">

	<?php if (have_posts()): while (have_posts()) : the_post(); ?>
		<!-- article -->
		<article id="post-<?php the_ID(); ?>" class="single-class-post" <?php post_class(); ?>>
		<?php get_template_part('_show_details_partial'); ?>
		<section class="show-description">
			<h2>About the show:</h2>
			<?php the_content(); ?>
			<ul class="info-block">
				<?php
					$cast = get_post_meta(get_the_ID(), 'cast', true);
					$director = get_post_meta(get_the_ID(), 'director', true);
				?>				
				<?php if (!empty($cast)) echo "<li><strong>Cast</strong><span>$cast</span></li>"; ?>
				<?php if (!empty($director)) echo "<li><strong>Director</strong><span>$director</span></li>"; ?>
			</ul>
		</section>			
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
