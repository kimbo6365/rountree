<?php
	$SHOWS_PAGE_ID = 6;
		// Fetch main Shows page, not any posts
		$shows_query = new WP_Query( array( 'p' => $SHOWS_PAGE_ID, 'post_type' => 'any' ) );
		if ($shows_query->have_posts()): while ($shows_query->have_posts()) : $shows_query->the_post();
	?>
	<?php /* Template Name: Shows */ get_header(); ?>
	<main role="main" aria-label="Content">
		<section class="container-fluid">
		<div class="row">
				<h1 class="col-sm-10 col-sm-offset-1 page-title"><?php the_title(); ?></h1>
		</div>
		<div class="row">
			<article id="post-<?php the_ID(); ?>" class="col-sm-10 col-sm-offset-1" <?php post_class();  ?>>
					<?php the_content(); ?>						
			</article>
		</div>
		<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
<?php endwhile; ?>
<?php endif; ?>
<div class="entry-spacer"></div>
<div class="row">
	<?php if (have_posts()): while (have_posts()) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" class="class-listing" <?php post_class();  ?>>
						<?php
							$cast = get_post_meta(get_the_ID(), 'cast', true);
							$director = get_post_meta(get_the_ID(), 'director', true);
							$dates = get_post_meta(get_the_ID(), 'dates', true);
							$cost = get_post_meta(get_the_ID(), 'cost', true);
						?>
						<section class="media-tile">
						<div class="class-image">
							<img class="circle" src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>" />
						</div>
						<div class="class-details">
							<h1><?php the_title(); ?></h1>
							<?php the_content(); ?>
							<dl class="detail-list">
								<?php
									if (!empty($dates))
									{
										echo '<dt>Dates</dt><dd>' . $dates . '</dd>';
									}
									if (!empty($cast))
									{
										echo '<dt>Cast</dt><dd>' . $cast . '</dd>';
									}
									if (!empty($director))
									{
										echo '<dt>Director</dt><dd>' . $director . '</dd>';
									}
									if (!empty($cost))
									{
										echo '<dt>Cost</dt><dd>' . $cost . '</dd>';
									}
								?>
							</dl>
						</div>
					</section>
				<?php if (($wp_query->current_post +1) < ($wp_query->post_count)): ?>
					<div class="entry-spacer"></div>
					<?php endif; ?>
				</article>
			<?php endwhile; ?>
			<?php endif; ?>
			</div>
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
			<div class="alert alert-<?php echo $alert_style; ?>"><?php echo $alert_text; ?></div>
		</section>
	</main>

<?php get_footer(); ?>
