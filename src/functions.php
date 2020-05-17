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

            wp_enqueue_script( 'rountree_stripe_payment', get_template_directory_uri() . '/js/lib/rountree_stripe_payment.js', array( 'jquery' ), null, true );
            wp_localize_script('rountree_stripe_payment', 'stripePaymentSettings', array(
                'name' => get_bloginfo('name'),
                'rountree-stripe-nonce' => wp_create_nonce('rountree-stripe-nonce'),
                'ajaxUrl' => admin_url( 'admin-ajax.php' ),
                'testApiKey' => get_option('stripe_test_public_key'),
                'liveApiKey' => get_option('stripe_live_public_key')
            ));

        // If production
        } else {
            // Scripts minify
            wp_register_script('html5blankscripts-min', get_template_directory_uri() . '/js/scripts.min.js', array(), '1.0.0');
            // Enqueue Scripts
            wp_enqueue_script('html5blankscripts-min');
            wp_localize_script('html5blankscripts-min', 'stripePaymentSettings', array(
                'name' => get_bloginfo('name'),
                'rountree-stripe-nonce' => wp_create_nonce('rountree-stripe-nonce'),
                'ajaxUrl' => admin_url( 'admin-ajax.php' ),
                'testApiKey' => get_option('stripe_test_public_key'),
                'liveApiKey' => get_option('stripe_live_public_key')
            ));
        }        
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
        wp_register_style('html5blankcssmin', get_template_directory_uri() . '/style.css', array(), '1.0.2');
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

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

// Shortcodes
add_shortcode('rountree_discount_code', 'rountree_discount_code');
add_shortcode('rountree_button', 'rountree_button');

// Shortcodes above would be nested like this -
// [html5_shortcode_demo] [html5_shortcode_demo_2] Here's the page title! [/html5_shortcode_demo_2] [/html5_shortcode_demo]

add_action('nav_menu_css_class', 'add_current_nav_class', 10, 2 );
function add_current_nav_class($classes, $item) {
    
    // Getting the current post details
    global $post;
    
    // Getting the post type of the current post
    $current_post_type = get_post_type_object(get_post_type($item->ID));
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
 
function rountree_page_banner_settings_init() {
    add_settings_section(
       'rountree_page_banner_setting_section',
       'Page Banner settings',
       'rountree_page_banner_setting_section_callback',
       'general'
   );
    
   add_settings_field(
      'rountree_page_banner_bold_text',
      'Page Banner Bold Text',
      'rountree_page_banner_bold_text_callback',
      'general',
      'rountree_page_banner_setting_section'
  );
    
    add_settings_field(
       'rountree_page_banner_main_text',
       'Page Banner Main Text',
       'rountree_page_banner_main_text_callback',
       'general',
       'rountree_page_banner_setting_section'
   );

    
   add_settings_field(
        'rountree_page_banner_link_text',
        'Page Banner Link Text',
        'rountree_page_banner_link_text_callback',
        'general',
        'rountree_page_banner_setting_section'
    );

    add_settings_field(
        'rountree_page_banner_link_url',
        'Page Banner Link URL',
        'rountree_page_banner_link_url_callback',
        'general',
        'rountree_page_banner_setting_section'
    );
    
    register_setting( 'general', 'rountree_page_banner_bold_text' );
    register_setting( 'general', 'rountree_page_banner_main_text' );
    register_setting( 'general', 'rountree_page_banner_link_text' );
    register_setting( 'general', 'rountree_page_banner_link_url' );
} 

add_action( 'admin_init', 'rountree_page_banner_settings_init' );

function rountree_page_banner_setting_section_callback() {
    echo '<p>Enter the information to show in a site-wide page banner here.</p>';
}
function rountree_page_banner_bold_text_callback() {
    echo '<input name="rountree_page_banner_bold_text" id="rountree_page_banner_bold_text" type="text" class="code" value="'. get_option( 'rountree_page_banner_bold_text' ).'" />';
}
function rountree_page_banner_main_text_callback() {
    echo '<input name="rountree_page_banner_main_text" id="rountree_page_banner_main_text" type="text" class="code" value="'. get_option( 'rountree_page_banner_main_text' ).'" />';
}
function rountree_page_banner_link_text_callback() {
    echo '<input name="rountree_page_banner_link_text" id="rountree_page_banner_link_text" type="text" class="code" value="'. get_option( 'rountree_page_banner_link_text' ).'" />';
}
function rountree_page_banner_link_url_callback() {
    echo '<input name="rountree_page_banner_link_url" id="rountree_page_banner_link_url" type="text" class="code" value="'. get_option( 'rountree_page_banner_link_url' ).'" />';
}


// Make sure the new Rountree plugin is active
activate_plugin('rountree/rountree.php');