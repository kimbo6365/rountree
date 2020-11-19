<section class="media-tile" >
  <a class="item-image" href="<?php the_permalink() ?>">
    <img class="circle" src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>" />
  </a>
  <div class="item-details">
    <?php
      if (is_single(get_the_ID())) {
        echo '<h1>'. get_the_title() .'</h1>';
      } else {
        echo '<h1><a href="' . get_permalink() .'">'. get_the_title() .'</a></h1>';
      }
    ?>
      
    <div>
      <?php 
        if ($wp_query->post->post_parent == 0) {
          the_excerpt();
          if (!is_single(get_the_ID())) {
            echo '<a class="excerpt" href="' . get_permalink() . '">More info &raquo;</a>';
          }
        } else {
          the_content();
        }
      ?>
    </div>
  </div>  
</section>
<div class="showtime-container">
  <div class="showtime-listing">
    <?php
      $children = get_children(array('post_type'=>'show', 'post_parent'=>$wp_query->posts[$wp_query->current_post]->ID));
      if ($children): 
        echo '<h2>Showtimes:&nbsp</h2>';

        echo "<div>";
        echo "";
        echo "</div>";
        echo '<table class="table show-grid"><thead><tr><th class="show-date-time">Date / Time</th><th>Location</th><th class="show-ticket-info">Tickets</th></tr></thead><tbody>';
        foreach ($children as $key => $post) {
          $location_name = get_post_meta($post->ID, 'location_name', true);
          $location_address = get_post_meta($post->ID, 'location_address', true); 
          $detailed_directions_page = get_post_meta($post->ID, 'detailed_directions_page', true); 
          $date = get_post_meta($post->ID, 'date', true);
          $time = get_post_meta($post->ID, 'time', true);
          $online_cost = get_post_meta($post->ID, 'online_cost', true);
          $cost_at_door = get_post_meta($post->ID, 'cost_at_door', true);
          $ticket_link = get_post_meta($post->ID, 'ticket_link', true);
          $single_show_id = $post->ID;
          $should_show_free_rsvp = get_field('should_show_free_rsvp');
          $mailchimp_tag_name = get_post_meta($single_show_id, 'mailchimp_tag_name', true);
          $is_pay_what_you_can = get_post_meta($single_show_id, 'is_pay_what_you_can', true);

          $showtime = date('D, m/d', strtotime($date)) . ' at ' . $time;
          wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly. 

          echo '<tr>';
          echo '<td class="show-date-time">' . $showtime . '</td>';
          if (!empty($location_name)) {
            echo "<td class=\"show-location\">$location_name";
            if ($detailed_directions_page && !empty(get_the_title($detailed_directions_page))) {
              echo "<a class=\"btn btn-sm btn-default show-detailed-directions-link js-trigger-detailed-directions-modal\" data-detailed-directions-post-title=\"". get_the_title($detailed_directions_page). "\" data-detailed-directions-post-content=\"". esc_attr(get_post_field('post_content', $detailed_directions_page)) . "\">How to get there</a>";
            }
            if (!empty($location_address)) {
              echo '<br />' . buildGoogleMapsLink($location_address) . '</td>';
            }
          }
          echo "<td class=\"show-ticket-info\">";

          /**
           * If it's past noon on the day of the show, just show the cost at the door if available
           * Otherwise, if the online_cost field is populated, render the trigger for the Stripe payment modal
           * Otherwise, if there is a ticket link, render a link to buy tickets externally.
           */

          if (strtotime('now') >= strtotime($date." America/New_York") && !empty($cost_at_door)) {
            if ($should_show_free_rsvp) {
              echo "Free";
            } else {
              echo "<p>\$$cost_at_door at door</p>";
            }
          } else if ($should_show_free_rsvp) {
              echo '<span>Tickets are free!</span><br /><a class="btn btn-primary js-show-rsvp-btn" data-item-name="'. get_the_title() .'" data-mailchimp-tag-name="' . $mailchimp_tag_name . '" data-item-date="'. $date .'">RSVP</a>';
          } else if (!empty($online_cost)) {
              echo '<a class="btn btn-primary js-checkout-btn" data-item-name="'. get_the_title() .'" data-item-cost="'. $online_cost .'" data-item-type="show" data-item-date="'. $showtime .'" data-item-id="'. $single_show_id .'" data-is-pay-what-you-can="' . boolval($is_pay_what_you_can) . '">Buy tickets!</a>';
          } else if (!empty($ticket_link)) {
              echo '<a class="btn btn-primary" target="_blank" href="' . $ticket_link . '">Buy tickets!</a>';
          }
          echo '</td></tr>';
        }
        echo '</tbody></table>';
        ?>
      <?php endif; ?>
  </div>
</div>