<?php
	$CLASSES_PAGE_ID = 2;
	// Fetch main Classes page, not any posts
	$class_page_query = new WP_Query( 
		array( 
			'p' => $CLASSES_PAGE_ID, 
			'post_type' => 'page'
		) 
	);
	if ($class_page_query->have_posts()): while ($class_page_query->have_posts()) : $class_page_query->the_post();
?>
<?php get_header(); /* Template Name: Class Types */  ?>
	<main role="main" aria-label="Content">
		<section class="container">
			<div class="row">
				<article id="post-<?php the_ID(); ?>" class="col-sm-10 col-sm-offset-1" <?php post_class();  ?>>
						<?php the_content(); ?>					
				</article>
			</div>
			<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
		<?php endwhile; ?>
		<?php endif; ?>
			<div class="row">
				<?php
                    $class_types = get_terms( array(
                        'taxonomy' => 'class_type',
						'hide_empty' => true,
						'order' => 'ASC',
						'orderby' => 'term_group'
                    ) );
					if ($class_types): foreach ($class_types as $type):
				?>
				<?php if ($wp_query->post->post_parent == 0): ?>
					<article class="class-type" <?php post_class(); ?>>
                        <?php 
							$image_id = get_field('image', $type->taxonomy . '_' . $type->term_id); 
							$image_url = wp_get_attachment_image_src($image_id, 'medium');
                            $url = get_site_url() . "/" . $type->taxonomy . "/" . $type->slug;
                        ?>
                        <a href="<?php echo $url; ?>"><img src="<?php echo $image_url[0]; ?>" alt=""/></a>
                        <h1><a href="<?php echo $url; ?>"><?php echo $type->name; ?></a></h1>
                        <div>
							<p><?php echo $type->description; ?></p>
							<a class="btn btn-default" href="<?php echo $url; ?>">View <?php echo $type->name; ?> classes</a>
						</div>
                    </article>
				<?php endif; ?>
                <?php endforeach; ?>
                <article class="class-type all-classes" <?php post_class(); ?>>
                    <?php 
                        $url = get_site_url() . "/all-classes";
                    ?>
                    <a href="<?php echo $url; ?>"><img src="<?php the_post_thumbnail_url('medium')?>" alt=""/></a>
                    <h1><a href="<?php echo $url; ?>">All classes</a></h1>
                    <div>
						<a class="btn btn-default" href="<?php echo $url; ?>">View  all classes</a>
					</div>
                </article>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php get_footer(); ?>
