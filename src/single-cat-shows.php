<?php get_header(); ?>

	<main role="main" aria-label="Content">
	<!-- section -->
	<section class="container-fluid ">

	<?php if (have_posts()): while (have_posts()) : the_post(); ?>
		<?php
			$cast = get_post_meta(get_the_ID(), 'cast', true);
			$location_name = get_post_meta(get_the_ID(), 'location_name', true);
			$location_address = get_post_meta(get_the_ID(), 'location_address', true);
			$director = get_post_meta(get_the_ID(), 'director', true);
			$dates = get_post_meta(get_the_ID(), 'dates', true);
			$cost = get_post_meta(get_the_ID(), 'cost', true);
			$ticket_link = get_post_meta(get_the_ID(), 'ticket_link', true);
		?>
		<!-- article -->
		<article id="post-<?php the_ID(); ?>" class="single-class-post" <?php post_class(); ?>>
		<section class="media-tile" >
			<a class="class-image" href="<?php the_permalink() ?>">
				<img class="circle" src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>" />
			</a>
			<div class="class-details">
				<h1><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>  
				<ul class="show-details">
					<?php
						if (!empty($dates)) echo '<li><strong>Dates</strong><span>' . $dates . '</span></li>';
						if (!empty($location_name) && !empty($location_address)) {
							echo '<li><strong>Location</strong><span>' . $location_name . '&nbsp;&mdash;&nbsp;<a class="maps-link" target="_blank" href="https://maps.google.com/?q=term' . urlencode($location_address) . '">' . $location_address . '</a></span></li>';
						}
						if (!empty($cost)) echo '<li><strong>Cost</strong><span>$' . $cost . '</span></li>';
						if (!empty($ticket_link)) echo '<li><a class="btn btn-lg btn-primary" href="' . $ticket_link . '">Buy tickets now!</a></li>';
					?>
				</ul>
				<?php // Show the excerpt when we're viewing a lists of posts. Show the content when we're viewing a single post. ?>
			</div>
		</section>
		<section class="show-description">
			<h2>About the show:</h2>
			<?php $wp_query->posts[0]->post_type == "page" ? the_excerpt() : the_content(); ?>
			<ul class="show-details">
				<?php
					if (!empty($cast)) echo '<li><strong>Cast</strong><span>' . $cast . '</span></li>';
					if (!empty($director)) echo '<li><strong>Director</strong><span>' . $director . '</span></li>';
				?>
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
