<section class="media-tile" >
  <a class="item-image" href="<?php the_permalink() ?>">
    <img class="circle" src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>" />
  </a>
  <div class="item-details">
    <h1><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>  
    <div>
      <?php 
        if ($wp_query->post->post_parent == 0) {
          the_excerpt();
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
          $date = get_post_meta($post->ID, 'date', true);
          $time = get_post_meta($post->ID, 'time', true);
          $online_cost = get_post_meta($post->ID, 'online_cost', true);
          $cost_at_door = get_post_meta($post->ID, 'cost_at_door', true);
          $ticket_link = get_post_meta($post->ID, 'ticket_link', true);
          $cost_text = '';
          
          if ($online_cost && $cost_at_door) {
            $cost_text = '$'.$online_cost . '&nbsp; online | $' . $cost_at_door . '&nbsp;at door';
          } else if ($online_cost) {
            $cost_text = "\$$online_cost";
          } else if ($cost_at_door) {
            $cost_text = "\$$cost_at_door";
          }
          
          echo '<tr>';
          echo '<td class="show-date-time">' . date('D, m/d', strtotime($date)) . ' at ' . $time . '</td>';
          if (!empty($location_name) && !empty($location_address)) {
            echo '<td class="show-location">' . $location_name . '<br />' . buildGoogleMapsLink($location_address) . '</td>';
          }
          echo "<td class=\"show-ticket-info\">";
          if (!empty($ticket_link)) {
            echo '<p>' . $cost_text . '</p><a class="btn btn-primary" target="_blank" href="' . $ticket_link . '">Buy tickets now!</a>';
          } else if (!empty($cost_text)) {
            echo "<p>$cost_text</p>";
          }
          echo '</td></tr>';
        }
        wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly        
        echo '</tbody></table>';
      endif;
    ?>
  </div>
</div>