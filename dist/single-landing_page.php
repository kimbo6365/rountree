<?php get_header(); ?>

	<main role="main" aria-label="Content">
	<!-- section -->
	<section class="container ">

	<?php if (have_posts()): while (have_posts()) : the_post(); ?>
        <div class="col-sm-10">
		    <!-- article -->
            <article id="post-<?php the_ID(); ?>" class="single-landing_page-post" <?php post_class(); ?>>
                <h1><?php the_title(); ?></h1>
                <div><?php the_content(); ?></div>
                <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
            </article>
            <!-- /article -->
            <div class="entry-spacer compact"></div>
            <?php echo do_shortcode('[ninja_form id=5]'); ?>
        </div>

	<?php endwhile; ?>
	<?php endif; ?>

	</section>
	<!-- /section -->
	</main>

<?php get_footer(); ?>
