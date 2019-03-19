<?php
  $CHILDREN = get_children(array('post_type' => 'class', 'post_parent' => get_the_ID()));
?>

<section class="media-tile" >
  <a class="item-image" href="<?php the_permalink() ?>">
    <img class="circle" src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>" />
  </a>
  <div class="item-details">
    <?php if (is_single(get_the_ID())) : ?>
        <h1><?php the_title(); ?></h1>
    <?php else: ?>
      <h1><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>  
    <?php endif; ?>
    <?php // Show the excerpt when we're viewing a lists of posts. Show the content when we're viewing a single post. ?>
    <p><?php $wp_query->posts[0]->post_type == "page" ? the_excerpt() : the_content(); ?></p>
    <?php
      $class_name = get_the_title();
      $class_id = get_the_ID();
      $dates = get_post_meta(get_the_ID(), 'class_dates', true);
      $cost = get_post_meta(get_the_ID(), 'class_cost', true);
      $single_class_cost = get_post_meta(get_the_ID(), 'single_class_cost', true);
      $is_sold_out = get_field('is_sold_out');
      $location_name = get_post_meta(get_the_ID(), 'class_location_name', true);
      $location_address = get_post_meta(get_the_ID(), 'class_location_address', true);
      $prerequisites = get_post_meta(get_the_ID(), 'class_prerequisites', true);      
      $discount_end_date = get_post_meta(get_the_ID(), 'class_discount_end_date', true);
      $discount_amount = get_post_meta(get_the_ID(), 'class_discount_amount', true);
      $discount_label = get_post_meta(get_the_ID(), 'class_discount_label', true);
      if ($discount_end_date) {
        // The date is stored in ms and the PHP date functions expect s, so multiply by 1000
        $discount_end_date = strtotime($discount_end_date);
      }
      $cost_alert = '';

      // If the discount date has not passed, reduce the cost by the discount amount
      if ($discount_end_date >= strtotime('00:00')) { 
        $original_cost = $cost;
        $cost -= $discount_amount;
        $displayCost = '<em>(<strike>$' . $original_cost . '</strike>)</em>&nbsp;<strong>$' . $cost . '*</strong>';
        $cost_alert = "<div class=\"alert alert-warning\"><strong>$discount_label:</strong> Save $$discount_amount if you sign up before " . date('F j', $discount_end_date) . '</div>';
      } else {
        $displayCost = '$' . $cost;
      }
    ?>
    <div class="payment-block">
      <?php if ($is_sold_out === true): ?>
          echo '<a class="btn btn-danger btn-lg" disabled>Sold out!</a><a class="btn btn-lg btn-link js-join-waitlist" data-requested-class="' . get_the_title() . '">Get on the waiting list!</a>';
      <?php elseif (!empty($cost)): ?>
        <?php if (count($CHILDREN) > 0): ?>
          <?php $is_any_child_sold_out = false; ?>
          <div class="btn-group" role="group">
            <div class="btn-group js-multi-class-dropdown" role="group">
              <button id="child-class-list-<?php the_ID(); ?>" type="button" class="btn btn-default btn-lg dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Choose dates
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" aria-labelledby="child-class-list-<?php the_ID(); ?>">
                <?php foreach ($CHILDREN as $key => $post): ?>
                  <?php 
                    $is_sold_out = get_post_meta($post->ID, 'is_sold_out', true) === "true"; 
                    if ($is_sold_out) {
                      $is_any_child_sold_out = true;
                    }
                  ?>
                  <li class="form-group">
                    <a class="js-multi-class-item-toggle" href="#">
                      <label <?php echo $is_sold_out ? "class=\"disabled\"" : ""; ?>>
                        <input <?php echo $is_sold_out ? "disabled" : ""; ?> class="js-multi-class-item" data-class-date="<?php echo get_the_title($post->ID); ?>" data-item-id="<?php echo $class_id; ?>" data-single-class-id="<?php echo $post->ID; ?>" type="checkbox">
                        <?php echo get_the_title($post->ID); ?>
                        <?php echo $is_sold_out ? "<i>(Sold out)</i>" : ""; ?>
                      </label>
                    </a>
                  </li>
                <?php endforeach ?>
                <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly. ?>
                <li>
                  <button class="btn btn-primary btn-lg dropdown-button js-checkout-btn" data-item-name="<?php echo $class_name; ?>" data-item-cost="<?php echo $single_class_cost; ?>" data-item-type="class" data-item-id="<?php the_ID(); ?>" data-is-multi="true" type="button" data-item-date="">Sign up now!</button>
                </li>
              </ul>
            </div>
            <?php if (!$is_any_child_sold_out): ?>
              <button type="button" class="btn btn-primary btn-lg js-checkout-btn" data-item-name="<?php the_title(); ?>" data-item-cost="<?php echo $cost; ?>" data-item-type="class" data-item-id="<?php the_ID(); ?>">
                Sign up for all classes!
              </button>
            <?php else: ?>
              <button type="button" class="btn btn-warning btn-lg" disabled>
                Partially sold out!
              </button>
            <?php endif; ?>
          </div>
        <?php else: ?>
          <a class="btn btn-primary btn-lg js-checkout-btn" data-item-name="<?php the_title(); ?>" data-item-cost="<?php echo $cost; ?>" data-item-type="class" data-item-id="<?php the_ID(); ?>">Sign Up Now!</a>
        <?php endif ?>      
      <?php endif; ?>
      
    </div>    
    <ul class="info-block">      
      <?php      
        if (!empty($dates)) echo '<li><strong>Dates</strong><span>' . $dates . '</span></li>';
        if (!empty($cost)) echo '<li><strong>Cost</strong><span>' . $displayCost . $cost_alert . '</span></li>';
        if (!empty($location_name) && !empty($location_address)) {
          echo '<li><strong>Location</strong><span>' . $location_name . '&nbsp;&mdash;&nbsp;' . buildGoogleMapsLink($location_address) . '</span></li>';
        }
        if (!empty($prerequisites)) echo '<li><strong>Prerequisites</strong><span>' . $prerequisites . '</span></li>';							
        
        if (empty($cost)) {
          echo '<a class="btn btn-default btn-lg btn-info js-request-class" data-requested-class="' . get_the_title() . '">Request this class</a>';
        }
      ?>
    </ul>
  </div>
  </section>