<?php get_header(); ?>

	<main role="main" aria-label="Content">
		<!-- section -->
		<section class="container">

			<h1 class="page-title col-sm-10 col-sm-offset-1"><?php _e( 'Latest Posts', 'html5blank' ); ?></h1>

			<?php get_template_part('loop'); ?>

			<?php get_template_part('pagination'); ?>

		</section>
		<!-- /section -->
	</main>

<?php get_footer(); ?>
