<?php /* Template Name: Home */ get_header(); ?>
	<main role="main" aria-label="Content">
		<!-- section -->
		<section class="container home-page">
			<?php if (have_posts()): while (have_posts()) : the_post(); ?>

				<!-- article -->
				<article>
					<section class="media-tile">
						<div class="item-image">
							<img class="circle" src="<?php echo wp_get_attachment_image_src(72, 'medium')[0]; ?>" />
						</div>
						<div class="item-details">
							<h1>About Amanda</h1>
							<p><?php the_content(); ?></p>
						</div>
					</section>
					<?php $promo_banner_image = get_field('promo_banner_image') ?>
					<?php $promo_button_link = get_field('promo_button_link') ?>
					<?php $promo_button_text = get_field('promo_button_text') ?>
					<?php $promo_text = get_field('promo_text') ?>
					<div class="row">
						<div class="promo-banner" style="background-image: url('<?php echo wp_get_attachment_image_src($promo_banner_image, 'promo_banner')[0]; ?>');">
							<div class="promo-overlay">
								<h2><?php echo $promo_text; ?></h2>
								<a class="btn btn-primary btn-lg" href="<?php echo $promo_button_link; ?>"><?php echo $promo_button_text; ?></a>
							</div>
						</div>
					</div>
					<?php $linked_testimonials = get_field('linked_testimonials'); ?>
					<div id="testimonial-carousel" class="testimonials carousel slide row" data-ride="carousel">
						<h2 class="text-center">What people are saying:</h2>
						<div class="carousel-inner" role="listbox">
						<?php foreach( $linked_testimonials as $index=>$post): // variable must be called $post (IMPORTANT) ?>
								<?php setup_postdata($post); ?>
									<div class="item <?php if ($index == 0) echo 'active'; ?>">
										<div class="testimonial">
											<div class="testimonial-text">
												<?php the_content(); ?>
												<p class="testimonial-author">&mdash;<?php the_field('testimonial_author'); ?></p>
											</div>
										</div>
									</div>
								<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
							<?php endforeach; ?>
							<ol class="carousel-indicators">
							<?php for($i = 0; $i < count($linked_testimonials); $i++): ?>
									<li data-target="#testimonial-carousel" data-slide-to="<?php echo $i; ?>" <?php if ($i == 0)  echo 'class="active"'; ?>></li>
							<?php endfor; ?>
							</ol>
							</div>
					</div>
				</article>
				<!-- /article -->

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
