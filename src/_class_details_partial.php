<section class="media-tile" >
  <a class="item-image" href="<?php the_permalink() ?>">
    <img class="circle" src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>" />
  </a>
  <div class="item-details">
    <h1><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>  
    <?php // Show the excerpt when we're viewing a lists of posts. Show the content when we're viewing a single post. ?>
    <p><?php $wp_query->posts[0]->post_type == "page" ? the_excerpt() : the_content(); ?></p>
    <?php
      $dates = get_post_meta(get_the_ID(), 'class_dates', true);
      $cost = get_post_meta(get_the_ID(), 'class_cost', true);
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
    <ul class="info-block">
      <?php 
      if (!empty($cost)) {
        echo '<a class="btn btn-primary btn-lg js-checkout-btn" data-item-name="'. get_the_title() .'" data-item-cost="'. $cost .'" data-item-type="class" data-item-id="'. get_the_ID() .'">Sign Up Now!</a>';
      }
        if (!empty($dates)) echo '<li><strong>Dates</strong><span>' . $dates . '</span></li>';
        if (!empty($cost)) echo '<li><strong>Cost</strong><span>' . $displayCost . $cost_alert . '</span></li>';
        if (!empty($location_name) && !empty($location_address)) {
          echo '<li><strong>Location</strong><span>' . $location_name . '&nbsp;&mdash;&nbsp;' . buildGoogleMapsLink($location_address) . '</span></li>';
        }
        // Only show the  prerequisites fields on single page.
        if (is_single()) {
          
          if (!empty($prerequisites)) echo '<li><strong>Prerequisites</strong><span>' . $prerequisites . '</span></li>';							
        }
        if (empty($cost)) {
          echo '<a class="btn btn-default btn-lg btn-info js-request-class" data-requested-class="' . get_the_title() . '">Request this class</a>';
        }
      ?>
    </ul>
  </div>
  </section>