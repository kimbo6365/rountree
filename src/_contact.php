<?php /* Template Name: Contact */ get_header(); ?>

	<main role="main" aria-label="Content">
		<!-- section -->
		<section class="container contact-page">
			<div class="row">
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>
		<h1 class="col-sm-10 col-sm-offset-1 page-title"><?php the_title(); ?></h1>
		<!-- article -->
			<article id="post-<?php the_ID(); ?>" class="col-sm-10 col-sm-offset-1" <?php post_class(); ?>>

				<?php the_content(); ?>
				<?php echo do_shortcode("[ninja_form id=1]"); ?>

			</article>
			<!-- /article -->
		</div>

		<?php endwhile; ?>

		<?php else: ?>

			<!-- article -->
			<article>

				<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>

			</article>
			<!-- /article -->

		<?php endif; ?>

		</section>
		<!-- /section -->
	</main>

<?php get_footer(); ?>
