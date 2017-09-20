<?php /* Template Name: Gallery */ get_header(); ?>

	<main role="main" aria-label="Content">
		<!-- section -->
		<section class="container-fluid">
			<div class="row" >
				<h1 class="page-title col-sm-10 col-sm-offset-1"><?php the_title(); ?></h1>
			</div>
			<?php if (have_posts()): while (have_posts()) : the_post(); ?>
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<?php the_content(); ?>
					</div>
				</div>
				<!-- IMAGES -->
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1 gallery-section">
						<div class="row">
							<?php $gallery_query = new WP_Query(array( 
									'post_type'      => 'attachment',
									'post_mime_type' => 'image',
									'post_status'    => 'inherit',
									'posts_per_page' => - 1,
									'meta_query' => array(
										array(
											'key'     => 'include_in_gallery',
											'value'   => 'a:1:{i:0;s:3:"Yes";}'
										),
									)  )); ?>
							<?php if ($gallery_query->have_posts()): while ($gallery_query->have_posts()) : $gallery_query->the_post(); ?>
								<article id="post-<?php the_ID(); ?>" class="col-sm-3 gallery-image" <?php post_class(); ?>>
									<?php the_content(); ?>
									<h3><a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a></h3>
									<p><?php the_excerpt(); ?></p>
								</article>
								<?php if (($gallery_query->current_post + 1) %4 == 0) echo "</div><div class=\"row\">"; ?>
							<?php endwhile; ?>
							<?php endif; ?>
							</div>
					</div>
					<?php wp_reset_query();	 // Restore global post data stomped by the_post(). ?>
				</div>
				<!-- VIDEOS -->
				<div class="row">
				<div class="col-sm-10 col-sm-offset-1 gallery-section">
						<div class="row">
							<?php $gallery_query = new WP_Query(array( 
									'post_type'      => 'attachment',
									'post_mime_type' => 'video',
									'post_status'    => 'inherit',
									'posts_per_page' => - 1,
									'meta_key' => 'include_in_gallery' )); ?>
							<?php if ($gallery_query->have_posts()): while ($gallery_query->have_posts()) : $gallery_query->the_post(); ?>
								<article id="post-<?php the_ID(); ?>" class="col-sm-3 gallery-image" <?php post_class(); ?>>
									<?php the_content(); ?>
									<h3><a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a></h3>
									<p><?php the_excerpt(); ?></p>
								</article>
								<?php if (($gallery_query->current_post + 1) %4 == 0) echo "</div><div class=\"row\">"; ?>
							<?php endwhile; ?>
							<?php endif; ?>
							</div>
					</div>
					<?php wp_reset_query();	 // Restore global post data stomped by the_post(). ?>
			</div>
			<?php endwhile; ?>
			<?php else: ?>
			<article>
				<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>
			</article>
		<?php endif; ?>
		</section>
	</main>

<?php get_footer(); ?>
