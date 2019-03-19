<?php
/**
 * Author: Todd Motto | @toddmotto
 * URL: html5blank.com | @html5blank
 * Custom functions, support, custom post types and more.
 */

require_once "modules/is-debug.php";/*------------------------------------*\
    External Modules/Files
\*------------------------------------*/

// Load any external files you have here

/*------------------------------------*\
    Theme Support
\*------------------------------------*/

if (!isset($content_width))
{
    $content_width = 900;
}

if (function_exists('add_theme_support'))
{

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    add_image_size('large', 1280, 400, true); // Large Thumbnail
    add_image_size('medium', 400, 400, true); // Medium Thumbnail
    add_image_size('small', 250, 250, true); // Small Thumbnail
    add_image_size('promo_banner', 1280, 400, true); // Small Thumbnail

    // Add Support for Custom Backgrounds - Uncomment below if you're going to use
    /*add_theme_support('custom-background', array(
    'default-color' => 'FFF',
    'default-image' => get_template_directory_uri() . '/img/bg.jpg'
    ));*/

    // Add Support for Custom Header - Uncomment below if you're going to use
    /*add_theme_support('custom-header', array(
    'default-image'          => get_template_directory_uri() . '/img/headers/default.jpg',
    'header-text'            => false,
    'default-text-color'     => '000',
    'width'                  => 1000,
    'height'                 => 198,
    'random-default'         => false,
    'wp-head-callback'       => $wphead_cb,
    'admin-head-callback'    => $adminhead_cb,
    'admin-preview-callback' => $adminpreview_cb
    ));*/

    // Enables post and comment RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Enable HTML5 support
    add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));

    // Localisation Support
    load_theme_textdomain('html5blank', get_template_directory() . '/languages');
}

/*------------------------------------*\
    Functions
\*------------------------------------*/

// HTML5 Blank navigation
function html5blank_nav()
{
    wp_nav_menu(
    array(
        'theme_location'  => 'header-menu',
        'menu'            => '',
        'container'       => 'div',
        'container_class' => '',
        'container_id'    => '',
        'menu_class'      => 'nav',
        'menu_id'         => '',
        'echo'            => true,
        'fallback_cb'     => 'wp_page_menu',
        'before'          => '',
        'after'           => '',
        'link_before'     => '',
        'link_after'      => '',
        'items_wrap'      => '<ul>%3$s</ul>',
        'depth'           => 0,
        'walker'          => ''
        )
    );
}

// Load HTML5 Blank scripts (header.php)
function html5blank_header_scripts()
{
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {
        if (HTML5_DEBUG) {
            // jQuery
            wp_deregister_script('jquery');
            wp_register_script('jquery', get_template_directory_uri() . '/bower_components/jquery/dist/jquery.js', array(), '1.11.1');

            // Conditionizr
            wp_register_script('conditionizr', get_template_directory_uri() . '/js/lib/conditionizr-4.3.0.min.js', array(), '4.3.0');

            // Modernizr
            wp_register_script('modernizr', get_template_directory_uri() . '/bower_components/modernizr/modernizr.js', array(), '2.8.3');

            // Modernizr
            wp_register_script('bootstrap', get_template_directory_uri() . '/js/lib/bootstrap.js', array(), '3.3.7');

            // Custom scripts
            wp_register_script(
                'html5blankscripts',
                get_template_directory_uri() . '/js/scripts.js',
                array(
                    'conditionizr',
                    'modernizr',
                    'jquery',
				'bootstrap'),
                '1.0.0');

            // Enqueue Scripts
            wp_enqueue_script('html5blankscripts');

        // If production
        } else {
            // Scripts minify
            wp_register_script('html5blankscripts-min', get_template_directory_uri() . '/js/scripts.min.js', array(), '1.0.0');
            // Enqueue Scripts
            wp_enqueue_script('html5blankscripts-min');
        }

        wp_enqueue_script( 'rountree_stripe_payment', get_template_directory_uri() . '/js/lib/rountree_stripe_payment.js', array( 'jquery' ), null, true );
        wp_localize_script('rountree_stripe_payment', 'stripePaymentSettings', array(
            'name' => get_bloginfo('name'),
            'rountree-stripe-nonce' => wp_create_nonce('rountree-stripe-nonce'),
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            'testApiKey' => get_option('stripe_test_public_key'),
            'liveApiKey' => get_option('stripe_live_public_key')
        ));
    }
}

// Load HTML5 Blank conditional scripts
function html5blank_conditional_scripts()
{
    if (is_page('pagenamehere')) {
        // Conditional script(s)
        wp_register_script('scriptname', get_template_directory_uri() . '/js/scriptname.js', array('jquery'), '1.0.0');
        wp_enqueue_script('scriptname');
    }
}

// Load HTML5 Blank styles
function html5blank_styles()
{
    if (HTML5_DEBUG) {
        // normalize-css
        wp_register_style('normalize', get_template_directory_uri() . '/bower_components/normalize.css/normalize.css', array(), '3.0.1');

        // Custom CSS
        wp_register_style('html5blank', get_template_directory_uri() . '/style.css', array('normalize'), '1.0');

        // Register CSS
        wp_enqueue_style('html5blank');
    } else {
        // Custom CSS
        wp_register_style('html5blankcssmin', get_template_directory_uri() . '/style.css', array(), '1.0');
        // Register CSS
        wp_enqueue_style('html5blankcssmin');
    }
}

// Register HTML5 Blank Navigation
function register_html5_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'html5blank'), // Main Navigation
    ));
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

// Remove the width and height attributes from inserted images
function remove_width_attribute( $html ) {
   $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
   return $html;
}


// If Dynamic Sidebar Exists
if (function_exists('register_sidebar'))
{
    // Define Sidebar Widget Area 1
    register_sidebar(array(
        'name' => __('Widget Area 1', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-1',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    // Define Sidebar Widget Area 2
    register_sidebar(array(
        'name' => __('Widget Area 2', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-2',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
    global $wp_widget_factory;

    if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
        remove_action('wp_head', array(
            $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
            'recent_comments_style'
        ));
    }
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function html5wp_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages,
        'type' => 'list'
    ));
}

// Custom Excerpts
function html5wp_index($length) // Create 20 Word Callback for Index page Excerpts, call using html5wp_excerpt('html5wp_index');
{
    return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using html5wp_excerpt('html5wp_custom_post');
function html5wp_custom_post($length)
{
    return 40;
}

// Create the Custom Excerpts callback
function html5wp_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}

// Custom View Article link to Post
function html5_blank_view_article($more)
{
    global $post;
    if ($post->type === 'post') {
        return '&#8230; <div class="read-more-wrapper"><a class="view-article btn btn-default" href="' . get_permalink($post->ID) . '">' . __('Read More &raquo;', 'html5blank') . '</a></div>';
    } else {
        return '&#8230;';
    }
}

// Remove Admin bar
function remove_admin_bar()
{
    return false;
}

// Remove 'text/css' from our enqueued stylesheet
function html5_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// Custom Gravatar in Settings > Discussion
function html5blankgravatar ($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}

// Threaded Comments
function enable_threaded_comments()
{
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}

// Custom Comments Callback
function html5blankcomments($comment, $args, $depth)
{
    $GLOBALS['comment'] = $comment;
    extract($args, EXTR_SKIP);

    if ( 'div' == $args['style'] ) {
        $tag = 'div';
        $add_below = 'comment';
    } else {
        $tag = 'li';
        $add_below = 'div-comment';
    }
?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
    <?php if ( 'div' != $args['style'] ) : ?>
    <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
    <?php endif; ?>
    <div class="comment-author vcard">
    <?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
    <?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
    </div>
<?php if ($comment->comment_approved == '0') : ?>
    <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
    <br />
<?php endif; ?>

    <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
        <?php
            printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' );
        ?>
    </div>

    <?php comment_text() ?>

    <div class="reply">
    <?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </div>
    <?php if ( 'div' != $args['style'] ) : ?>
    </div>
    <?php endif; ?>
<?php }

/*------------------------------------*\
    Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('init', 'html5blank_header_scripts'); // Add Custom Scripts to wp_head
add_action('wp_print_scripts', 'html5blank_conditional_scripts'); // Add Conditional Page Scripts
add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
add_action('wp_enqueue_scripts', 'html5blank_styles'); // Add Theme Stylesheet
add_action('init', 'register_html5_menu'); // Add HTML5 Blank Menu
add_action('init', 'create_post_type_testimonial'); // Add our Testimonial Post Type
add_action('init', 'create_post_type_class'); // Add our Class Post Type
add_action('init', 'create_post_type_show'); // Add our Show Post Type
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('init', 'html5wp_pagination'); // Add our HTML5 Pagination

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('avatar_defaults', 'html5blankgravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'html5_blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('style_loader_tag', 'html5_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('post_thumbnail_html', 'remove_width_attribute', 10 ); // Remove width and height dynamic attributes to post images
add_filter('image_send_to_editor', 'remove_width_attribute', 10 ); // Remove width and height dynamic attributes to post images
add_filter( 'postmeta_form_limit' , 'customfield_limit_increase' );
function customfield_limit_increase( $limit ) {
    $limit = 150;
    return $limit;
}

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

// Shortcodes
add_shortcode('rountree_discount_code', 'rountree_discount_code');
add_shortcode('rountree_button', 'rountree_button');

// Shortcodes above would be nested like this -
// [html5_shortcode_demo] [html5_shortcode_demo_2] Here's the page title! [/html5_shortcode_demo_2] [/html5_shortcode_demo]

add_action('wp_ajax_nopriv_rountree_stripe_payment_submit', 'rountree_stripe_payment_submit');
add_action('wp_ajax_rountree_stripe_payment_submit', 'rountree_stripe_payment_submit');
add_action('init', 'create_post_type_stripe_payment_log'); // Add our Stripe Payment Log post type

// Add new column to shows grids to show total sales
function set_custom_edit_show_columns($columns) {
    unset( $columns['date'] );
    $columns['sales'] = 'Sales';
    $columns['date'] = 'Date';

    return $columns;
}

function custom_show_column($column, $post_id) {
    switch ( $column ) {
        case 'sales' :
            $sales = 0;
            $stripe_payment_query = new WP_Query( array( 'post_type' => 'stripe_payment_log', 'meta_key' => 'linked_post_id', 'meta_value' => $post_id ) );
            if ($stripe_payment_query->have_posts()): while ($stripe_payment_query->have_posts()) : $stripe_payment_query->the_post();
                $sales += get_post_meta(get_the_ID(), 'quantity', true);
            endwhile;
            endif;
            wp_reset_postdata();
            echo $sales; 
            break;
    }
}


// Add new column to classes grids to show total spots remaining
function set_custom_edit_class_columns($columns) {
    unset( $columns['date'] );
    $columns['spots_available'] = 'Spots Available';
    $columns['date'] = 'Date';

    return $columns;
}

function custom_class_column($column, $post_id) {
    switch ( $column ) {
        case 'spots_available' :
            echo get_post_meta($post_id, 'spots_available', true); 
            break;
    }
}

function set_custom_edit_stripe_payment_log_columns($columns) {
    unset( $columns['title'] );
    unset( $columns['date'] );
    $columns['name'] = 'Name';
    $columns['quantity'] = 'Quantity';
    $columns['customer_id'] = 'Customer ID';
    $columns['charge_id'] = 'Charge ID';
    $columns['amount'] = 'Amount';
    $columns['is_subscribed'] = 'Is Subscribed';
    $columns['linked_post_id'] = 'Item Purchased';
    $columns['date'] = 'Date';

    return $columns;
}

function custom_stripe_payment_log_column($column, $post_id) {
    switch ( $column ) {
        case 'name' :
            echo get_post_meta( $post_id , 'name' , true ); 
            break;
        case 'quantity' :
            echo get_post_meta( $post_id , 'quantity' , true ); 
            break;
        case 'customer_id' :
            echo get_post_meta( $post_id , 'customer_id' , true ); 
            break;
        case 'charge_id' :
            echo get_post_meta( $post_id , 'charge_id' , true ); 
            break;
        case 'amount' :
            $amount = get_post_meta( $post_id , 'amount' , true ); 
            echo money_format('%i', $amount / 100);
            break;
        case 'is_subscribed' :
            echo get_post_meta( $post_id , 'is_subscribed' , true ); 
            break;
        case 'linked_post_id' :
            $linked_post_id = get_post_meta( $post_id , 'linked_post_id' , true );
            echo get_the_title($linked_post_id); 
            break;

    }
}
add_filter( 'manage_edit-stripe_payment_log_sortable_columns', 'sortable_stripe_payment_log_column' );
function sortable_stripe_payment_log_column( $columns ) {
    $columns['linked_post_id'] = 'Item Purchased';
    $columns['name'] = 'Name'; 
    return $columns;
}

add_action('add_meta_boxes', 'rountree_add_stripe_payment_log_meta_box');
// Add post meta box to show payment info for shows and classes
function rountree_add_stripe_payment_log_meta_box()
{
    $screens = ['show', 'class'];
    foreach ($screens as $screen) {
        add_meta_box(
            'rountree_stripe_payment_log_box', // Unique ID
            'Stripe Payments',  // Box title
            'rountree_stripe_payment_log_html',  // Content callback, must be of type callable
            $screen // Post type
        );
    }
}
function rountree_stripe_payment_log_html($post)
{
    ?>
    <table class="wp-list-table widefat fixed striped posts">
        <thead>
            <tr>
                <th class="manage-column column-title column-primary">
                    Name
                </th>
                <th class="manage-column">
                    Quantity
                </th>
                <th class="manage-column">
                    Amount Charged
                </th>
                <th class="manage-column">
                    Charge ID
                </th>
                <th class="manage-column">
                    Purchase Date
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $html = '';
            $stripe_payment_query = new WP_Query( array( 
                'post_type' => 'stripe_payment_log', 
                'meta_key' => 'linked_post_id', 
                'meta_value' => $post->ID,
                'orderby' => 'date',
                'order' => 'DESC'
                ) );
            if ($stripe_payment_query->have_posts()): while ($stripe_payment_query->have_posts()) : $stripe_payment_query->the_post();
            $html .= '<tr>';
                $html .= '<td>' . get_post_meta(get_the_ID(), 'name', true) . '</td>';
                $html .= '<td>' . get_post_meta(get_the_ID(), 'quantity', true) . '</td>';
                $html .= '<td>' . money_format('%i', (get_post_meta(get_the_ID(), 'amount', true) / 100)) . '</td>';
                $html .= '<td>' . get_post_meta(get_the_ID(), 'charge_id', true) . '</td>';
                $html .= '<td>' . get_the_date() . '</td>';
                $html .= '</tr>';
            endwhile;
            echo $html;
            wp_reset_postdata();
            endif;
            ?>
        </tbody>
    </table>
    <?php
}

function rountree_stripe_payment_submit() {
    $data = $_POST;
    $apiTestKey = get_option('stripe_test_secret_key');
    $apiLiveKey = get_option('stripe_live_secret_key');

    if( ! class_exists( 'Stripe\Stripe' ) ) {
       require_once(get_template_directory() . '/modules/stripe-php/init.php');
    }
    \Stripe\Stripe::setApiKey($apiLiveKey);
    // \Stripe\Stripe::setApiKey($apiTestKey);
    try {
        // Create Stripe Customer
        $customer = \Stripe\Customer::create([
            'email' => $data['emailAddress'],
            'source' => $data['token'],
            'metadata' => [
                'first_name' => $data['firstName'],
                'last_name' => $data['lastName'],
                'is_subscribed' => $data['emailSignUp'],
                'class' => $data['itemType'] == "class" ? $data['itemName'] : '',
                'show' => $data['itemType'] == "show" ? $data['itemName'] : '',
            ],
        ]);
        $chargeDescription = $data['itemName'];
        //Create Charge
        $charge = \Stripe\Charge::create([
            'customer' => $customer->id,
            'amount' => $data['amount'],
            'currency' => 'usd',
            'description' => $chargeDescription,
            'statement_descriptor' => 'Amanda Rountree',
            'metadata' => [
                'first_name' => $data['firstName'],
                'last_name' => $data['lastName'],
                'is_subscribed' => $data['emailSignUp'],
                'quantity' => $data['itemQuantity'],
                'item_name' => $data['itemName'],
                'item_type' => $data['itemType'],
                'item_id' => $data['itemId']
            ],
        ]);    

        // Decrement the remaining spots count for classes
        if ($data['itemType'] === 'class') {
            $postIds = explode(",", $data['paymentPostId']);
            $parentPostId;
            $children = get_children(array('post_type' => 'class', 'post_parent' => $postIds[0]));
            $class_quantity = count($postIds) . " " . _n( 'class date', 'class dates', $postIds );
            
            // If there's only one post ID selected, that means someone's signed up for a whole class.
            // If the class has children, we should decrememt the number of spots available in each class date.
            // We should also set the main class's remaining spots to a string like N/A, since that varies by class date.
            if (count($postIds) === 1) {
                $class_quantity = "All class dates";
                if (count($children) > 0) {
                    $parentPostId = $postId[0];
                    $postIds = [];
                    foreach($children as $key => $child_post) {
                        $postIds[] = $child_post->ID;
                    }
                }
            }
            foreach ($postIds as $key => $postId) {
                $spots_available = get_post_meta($postId, 'spots_available', true);
                $spots_available--;
                update_post_meta($postId, 'spots_available', $spots_available);

                // If this post has any children, change the parent post's spots available to N/A
                if (count($children) > 0) {
                    if ($key === 0) {
                        update_post_meta($parentPostId, 'spots_available', 'N/A');
                    }
                }

                // If there aren't any spots available, indicate that the class is sold out to hide the button
                if ($spots_available === 0) {
                    update_post_meta($postId, 'is_sold_out', 'true');
                }
                // Log stripe payment
                wp_insert_post(
                    array(
                        'post_title' 	=>  $data['token'],
                        'post_status' 	=>  'publish',
                        'post_type' 	=>  'stripe_payment_log',
                        'meta_input'   => array(
                            'name' => $data['firstName'] . ' ' . $data['lastName'],
                            'quantity' => $class_quantity,
                            'customer_id' => $customer->id,
                            'charge_id' => $charge->id,
                            'amount' => $data['amount'],
                            'is_subscribed' => $data['emailSignUp'],
                            'linked_post_id' => $postId
                        ),
                    )
                );
            }
            
        } else if ($data['itemType'] === 'show') {
            // Log stripe payment
            wp_insert_post(
                array(
                    'post_title' 	=>  $data['token'],
                    'post_status' 	=>  'publish',
                    'post_type' 	=>  'stripe_payment_log',
                    'meta_input'   => array(
                        'name' => $data['firstName'] . ' ' . $data['lastName'],
                        'quantity' => $data['itemQuantity'],
                        'customer_id' => $customer->id,
                        'charge_id' => $charge->id,
                        'amount' => $data['amount'],
                        'is_subscribed' => $data['emailSignUp'],
                        'linked_post_id' => $data['itemId']
                    ),
                )
            );
        }

        add_to_mailing_list([
            'email_address' => $data['emailAddress'], 
            'first_name' => $data['firstName'],
            'last_name' => $data['lastName'],
            'is_subscribed' => $data['emailSignUp']]);

        wp_send_json_success($charge);
    } catch (Exception $e) {
        $headers =  array('Content-Type: text/html; charset=UTF-8');
        $email_content = array($data, $customer, $charge, $e);
        // Send an email for tracking errors
        wp_mail( 'kimbo6365@gmail.com', 'AmandaRountree.com: Error processing payment' , $email_content, $headers );
        wp_send_json($e->getMessage());
    }
}
/*------------------------------------*\
    Custom Post Types
\*------------------------------------*/

// Testimonial custom post type
function create_post_type_testimonial()
{
    register_taxonomy_for_object_type('post_tag', 'testimonial');
    register_post_type('testimonial', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('Testimonials', 'rountree'), // Rename these to suit
            'singular_name' => __('Testimonial', 'rountree'),
            'add_new' => __('Add New', 'rountree'),
            'add_new_item' => __('Add New Testimonial', 'rountree'),
            'edit' => __('Edit', 'rountree'),
            'edit_item' => __('Edit Testimonial', 'rountree'),
            'new_item' => __('New Testimonial', 'rountree'),
            'view' => __('View Testimonial', 'rountree'),
            'view_item' => __('View Testimonial', 'rountree'),
            'search_items' => __('Search Testimonial', 'rountree'),
            'not_found' => __('No Testimonials found', 'rountree'),
            'not_found_in_trash' => __('No Testimonials found in Trash', 'rountree')
        ),
        'public' => true,
        'supports' => array(
            'title',
            'editor',
		    'custom-fields'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        'can_export' => true, // Allows export in Tools > Export
        'taxonomies' => array(
		    'category'
        ),
        'menu_icon' => 'dashicons-format-quote',
        'menu_position' => 20
    ));
}

add_filter( 'manage_class_posts_columns', 'set_custom_edit_class_columns' );
add_action( 'manage_class_posts_custom_column' , 'custom_class_column', 10, 2 );
// Class custom post type
function create_post_type_class()
{
    register_post_type('class', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('Classes', 'rountree'), // Rename these to suit
            'singular_name' => __('Class', 'rountree'),
            'add_new' => __('Add New', 'rountree'),
            'add_new_item' => __('Add New Class', 'rountree'),
            'edit' => __('Edit', 'rountree'),
            'edit_item' => __('Edit Class', 'rountree'),
            'new_item' => __('New Class', 'rountree'),
            'view' => __('View Class', 'rountree'),
            'view_item' => __('View Class', 'rountree'),
            'search_items' => __('Search Classes', 'rountree'),
            'not_found' => __('No Classes found', 'rountree'),
            'not_found_in_trash' => __('No Classes found in Trash', 'rountree')
        ),
        'public' => true,
        'has_archive' => true,
        'hierarchical' => true,
        'supports' => array(
            'excerpt',
            'title',
            'editor',
            'custom-fields',
            'revisions',
            'thumbnail',
            'post-formats',
            'page-attributes' 
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        'can_export' => true, // Allows export in Tools > Export
        'menu_icon' => 'dashicons-groups',
        'menu_position' => 5,
        'rewrite' => array( 'slug' => 'classes' )
    ));
}

add_filter( 'manage_stripe_payment_log_posts_columns', 'set_custom_edit_stripe_payment_log_columns' );
add_action( 'manage_stripe_payment_log_posts_custom_column' , 'custom_stripe_payment_log_column', 10, 2 );
// Stripe Payment Log custom post type
function create_post_type_stripe_payment_log() {
    register_post_type( 'stripe_payment_log', 
    array(
        'label' => 'Stripe Payments',
        'description' => 'Stripe Payment Logs',
        'labels' => array(
            'name' => 'Stripe Payments',
            'singular_name' => 'Stripe Payment',
            'all_items' => 'All Stripe Payments',
            'view_item' => 'Stripe Payment',
            'add_new_item' => 'Log new Stripe Payment',
            'add_new' => 'Log new Stripe Payment',
            'edit_item' => 'Edit Stripe Payment',
            'update_item' => 'Stripe Payment',
            'search_items' => 'Search Stripe Payments',
            'not_found' => 'Stripe Payment not found',
            'not_found_in_trash' => 'Stripe Payment not found in Trash'
        ),
        'hierarchical'        => false,
        'public'              => false,
        'show_ui'             => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => false,
        'map_meta_cap'        => true,
        'supports'            => array(),
        'taxonomies'          => array(),
        'has_archive'         => false,
        'show_in_rest'        => true,
        'menu_icon' => 'dashicons-store',
        'menu_position' => 100
    ));
}

add_filter( 'manage_show_posts_columns', 'set_custom_edit_show_columns' );
add_action( 'manage_show_posts_custom_column' , 'custom_show_column', 10, 2 );
// Show custom post type
function create_post_type_show()
{
    register_post_type('show', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('Shows', 'rountree'), // Rename these to suit
            'singular_name' => __('Show', 'rountree'),
            'add_new' => __('Add New', 'rountree'),
            'add_new_item' => __('Add New Show', 'rountree'),
            'edit' => __('Edit', 'rountree'),
            'edit_item' => __('Edit Show', 'rountree'),
            'new_item' => __('New Show', 'rountree'),
            'view' => __('View Show', 'rountree'),
            'view_item' => __('View Show', 'rountree'),
            'search_items' => __('Search Shows', 'rountree'),
            'not_found' => __('No Shows found', 'rountree'),
            'not_found_in_trash' => __('No Shows found in Trash', 'rountree')
        ),
        'public' => true,
        'hierarchical' => true,
        'has_archive' => true,
        'supports' => array(
            'excerpt',
            'title',
            'editor',
            'custom-fields',
            'revisions',
            'thumbnail',
            'post-formats',
            'page-attributes' 
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        'can_export' => true, // Allows export in Tools > Export
        'taxonomies' => array(
            'category',
        ),
        'menu_icon' => 'dashicons-tickets-alt',
        'menu_position' => 5,
        'rewrite' => array( 'slug' => 'shows' )
    ));
}

add_action('nav_menu_css_class', 'add_current_nav_class', 10, 2 );

function add_current_nav_class($classes, $item) {
    
    // Getting the current post details
    global $post;
    
    // Getting the post type of the current post
    $current_post_type = get_post_type_object(get_post_type($post->ID));
    $current_post_type_slug = $current_post_type->rewrite['slug'];
        
    // Getting the URL of the menu item
    $menu_slug = strtolower(trim($item->url));
    
    // If the menu item URL contains the current post types slug add the current-menu-item class
    if (strpos($menu_slug,$current_post_type_slug) !== false) {
       $classes[] = 'current-menu-item';
    }
    
    // Return the corrected set of classes to be added to the menu item
    return $classes;
}

/*------------------------------------*\
    ShortCode Functions
\*------------------------------------*/

// Render an inline message to display a discount
function rountree_discount_code($atts, $content = 'Ask how you can save up to 15% on classes.', $tag)
{

	$a = shortcode_atts( array(
        'headline' => 'Get a discount!'
    ), $atts );

	return '<p class="alert alert-warning"><strong>' . $a['headline'] . '</strong>:&nbsp;' . $content . '</p>';
}

// Render a link as a button
function rountree_button($atts, $content = 'Click here!', $tag)
{

	$a = shortcode_atts( array(
        'url' => '#'
    ), $atts );

	return '<a class="btn btn-default" href="' . $a['url'] . '" title="' . $content . '">' . $content . '</a>';
}

add_filter( 'sc_payment_details', 'rountree_sc_payment_details', 20, 2);

function rountree_sc_payment_details( $html, $charge_response ) {
    $html = '<div class="modal fade in" tabindex="-1" data-backdrop="true" role="dialog">' . "\n";
    $html .= '<div class="modal-dialog" role="document">' . "\n";    
    $html .= '<div class="modal-content">' . "\n";   
    $html .= '<div class="modal-header">' . "\n";
    $html .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> ' . "\n";    
    $html .= '<h4 class="modal-title">Thank you, ' . $charge_response->source->name . '!</h4>' . "\n";
    $html .= '</div>' . "\n";
    $html .= '<div class="modal-body">' . "\n"; 
    $html .= '<p>Your payment for ' . $charge_response->description . ' has been sent.</p>' . "\n";
    $html .= '<p>You should receive an email confirmation at ' . $charge_response->receipt_email . '. </p>' . "\n";
    $html .= '<div class="entry-spacer compact"></div>' . "\n";   
    $html .= '<h2>Payment Details</h2>' . "\n";         
    $html .= '<dl class="detail-list">' . "\n";
    $html .= '<dt>Class</dt><dd>' . $charge_response->description . '</dd>' . "\n";        
    $html .= '<dt>Total Paid</dt><dd>' . Stripe_Checkout_Misc::to_formatted_amount( $charge_response->amount, $charge_response->currency ) . ' ' . strtoupper( $charge_response->currency ) . '</dd>' . "\n";
    $html .= '<dt>Card</dt><dd>' . $charge_response->source->brand . ' *' . $charge_response->source->last4 . '</dd>' . "\n";            
    $html .= '<dt>Transaction ID</dt><dd>' . $charge_response->id . '</dd>' . "\n";    
    $html .= '</dl>' . "\n";
    $html .= '</div>' . "\n";
    $html .= '</div>' . "\n";
    $html .= '</div>' . "\n";
    $html .= '</div>' . "\n";
    return $html;
}

function buildGoogleMapsLink( $address ) {
    $html = '<a class="maps-link" target="_blank" href="https://maps.google.com/?q=' . urlencode($address) . '">';
    $html .= $address;
    $html .= '</a>';
    return $html;
}

add_filter( 'rountree_add_to_mailing_list', 'rountree_add_to_mailing_list_callback' );
function rountree_add_to_mailing_list_callback( $form_data ) {
    $first_name = '';
    $last_name = '';
    $email_address = '';
 
    foreach( $form_data[ 'fields' ] as $field ) { // Field settigns, including the field key and value.
   

        if ($field['admin_label'] === "first_name") {
            $first_name = $field['value']; 
        } else if ($field['admin_label'] === "last_name") {
            $last_name = $field['value'];
        } else if ($field['admin_label'] === "email_address") {
            $email_address = $field['value'];
        } else if( $field['admin_label'] === 'is_subscribed') {
            $is_subscribed = $field['value'] === 1;
        }
        add_to_mailing_list([
            'email_address' => $email_address, 
            'first_name' => $first_name, 
            'last_name' => $last_name, 
            'is_subscribed' => $is_subscribed]);
  }
}

function add_to_mailing_list($user_data) {
    $email_hash = md5($user_data['email_address']);
    $url = 'https://us17.api.mailchimp.com/3.0/lists/13d3d1014a/members/' . $email_hash;
    $data = array(
        'email_address' => $user_data['email_address'], 
        'merge_fields' => array('FNAME' => $user_data['first_name'], 'LNAME' => $user_data['last_name']),
        'status' => $user_data['is_subscribed'] === 1 ? 'subscribed' : 'unsubscribed'
    );
    $fields_string = json_encode($data);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($fields_string)));
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "wordpress:" . get_option('rountree_mailchimp_api_key'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    $result = curl_exec($ch);
}
 
 function rountree_mailchimp_settings_api_init() {
    add_settings_section(
       'rountree_mailchimp_setting_section',
       'Mailchimp settings',
       'rountree_mailchimp_setting_section_callback',
       'general'
   );
    
    add_settings_field(
       'rountree_mailchimp_api_key',
       'Mailchimp API Key',
       'rountree_mailchimp_api_key_callback',
       'general',
       'rountree_mailchimp_setting_section'
   );
    
    register_setting( 'general', 'rountree_mailchimp_api_key' );
} 

add_action( 'admin_init', 'rountree_mailchimp_settings_api_init' );
function rountree_mailchimp_setting_section_callback() {
    echo '<p>Enter the Mailchimp API key here.</p>';
}
function rountree_mailchimp_api_key_callback() {
    echo '<input name="rountree_mailchimp_api_key" id="rountree_mailchimp_api_key" type="text" class="code" value="'. get_option( 'rountree_mailchimp_api_key' ).'" />';
}

// Re-enable WP native custom fields after ACF plugin disabled them
add_filter('acf/settings/remove_wp_meta_box', '__return_false');