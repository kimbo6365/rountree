<section class="media-tile" >
  <a class="class-image" href="<?php the_permalink() ?>">
    <img class="circle" src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>" />
  </a>
  <div class="class-details">
    <h1><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>  
    <?php // Show the excerpt when we're viewing a lists of posts. Show the content when we're viewing a single post. ?>
    <p><?php $wp_query->posts[0]->post_type == "page" ? the_excerpt() : the_content(); ?></p>
    <?php
      $class_discount = get_post_meta($post->ID, 'discount', true);
      if (!empty($class_discount))
      {
        echo do_shortcode($class_discount);
      }
    ?>
    <dl class="detail-list">
      <?php
        $postID = get_the_ID();
        $class_dates = get_post_meta($post->ID, 'dates', true);
        if (!empty($class_dates))
        {
          echo '<dt>Dates</dt><dd>' . $class_dates . '</dd>';
        }
        $class_cost = get_post_meta($post->ID, 'cost', true);
        if (!empty($class_cost))
        {
          echo '<dt>Cost</dt><dd>$' . $class_cost . '</dd>';
        }
      ?>
    </dl>
    <?php if ($class_cost > 0): ?>
      <?php echo do_shortcode("[stripe verify_zip=\"true\" billing=\"true\" amount=\"" . $class_cost . "00\" description=\"" . get_the_title() . "\"]"); ?>
    <?php else: ?>
      <div class="btn btn-default btn-lg btn-info">
        Request this class
      </div>
    <?php endif; ?>
  </div>
</section>