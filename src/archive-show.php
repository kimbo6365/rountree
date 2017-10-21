<?php
	$SHOWS_PAGE_ID = 6;
		// Fetch main Shows page, not any posts
		$shows_query = new WP_Query( array( 'p' => $SHOWS_PAGE_ID, 'post_type' => 'page' ) );
		if ($shows_query->have_posts()): while ($shows_query->have_posts()) : $shows_query->the_post();
	?>
	<?php /* Template Name: Shows */ get_header(); ?>
	<main role="main" aria-label="Content">
		<section class="container-fluid">
			<div class="row">
					<h1 class="col-sm-10 col-sm-offset-1 page-title"><?php the_title(); ?></h1>
			</div>
			<div class="row">
				<article id="post-<?php the_ID(); ?>" class="col-sm-10 col-sm-offset-1" <?php post_class();?>>
						<?php the_content(); ?>						
				</article>
			<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
			<?php endwhile; ?>
			<?php endif; ?>
			<div class="entry-spacer"></div>
		</div>
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>
				<?php if ($wp_query->post->post_parent == 0): ?>
					<div class="row">
						<article id="post-<?php the_ID(); ?>" class="z-layout-item" <?php post_class();  ?>>
							<?php get_template_part('_show_details_partial'); ?>
						</article>
						<?php if (($wp_query->current_post +1) < ($wp_query->post_count)): ?>
							<div class="entry-spacer"></div>
						<?php endif; ?>
					</div>
					<?php endif; ?>
				<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
			<?php endwhile; ?>
			<?php endif; ?>
			<?php 
					$alert_type = get_post_meta($SHOWS_PAGE_ID, 'alert_type')[0]; 
					$alert_text = get_post_meta($SHOWS_PAGE_ID, 'alert_text')[0];

					switch ($alert_type) {
						case 'Blue':
							$alert_style = 'info';
							break;
						case 'Yellow':
							$alert_style = 'warning';
							break;
						case 'Red':
							$alert_style = 'danger';
							break;
							case 'Green':
								$alert_style = 'success';
								break;
					}
				?>
			<div style="margin-top: 100px;" class="alert alert-<?php echo $alert_style; ?>"><?php echo $alert_text; ?></div>
		</section>
	</main>

<?php get_footer(); ?>
