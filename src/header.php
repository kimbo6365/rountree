<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' : '; } ?><?php bloginfo('name'); ?></title>

		<link href="//www.google-analytics.com" rel="dns-prefetch">
		<link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_template_directory_uri(); ?>/img/favicon/apple-icon-57x57.png" rel="apple-touch-icon-precomposed">
		<link rel="apple-touch-icon" sizes="60x60" href="<?php echo get_template_directory_uri(); ?>/img/favicon/apple-icon-60x60.png" rel="apple-touch-icon-precomposed">
		<link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/img/favicon/apple-icon-72x72.png" rel="apple-touch-icon-precomposed">
		<link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_template_directory_uri(); ?>/img/favicon/apple-icon-76x76.png" rel="apple-touch-icon-precomposed">
		<link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/img/favicon/apple-icon-114x114.png" rel="apple-touch-icon-precomposed">
		<link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_template_directory_uri(); ?>/img/favicon/apple-icon-120x120.png" rel="apple-touch-icon-precomposed">
		<link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_template_directory_uri(); ?>/img/favicon/apple-icon-144x144.png" rel="apple-touch-icon-precomposed">
		<link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_template_directory_uri(); ?>/img/favicon/apple-icon-152x152.png" rel="apple-touch-icon-precomposed">
		<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/img/favicon/apple-icon-180x180.png" rel="apple-touch-icon-precomposed">
		<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo get_template_directory_uri(); ?>/img/favicon/android-icon-192x192.png" rel="shortcut icon apple-touch-icon-precomposed">
		<link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/img/favicon/favicon-32x32.png" rel="shortcut icon apple-touch-icon-precomposed">
		<link rel="icon" type="image/png" sizes="96x96" href="<?php echo get_template_directory_uri(); ?>/img/favicon/favicon-96x96.png" rel="shortcut icon">
		<link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/img/favicon/favicon-16x16.png" rel="shortcut icon">
		<link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/img/favicon/manifest.json">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/img/favicon/ms-icon-144x144.png rel="shortcut icon">
		<meta name="theme-color" content="#ffffff">
		<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?>" href="<?php bloginfo('rss2_url'); ?>" />

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?php bloginfo('description'); ?>">
		<link href="https://fonts.googleapis.com/css?family=Cabin|Cairo|Montserrat|Muli|Noto+Sans|Nunito|Open+Sans|Oxygen|Poppins|Poppins:700|Raleway|Roboto|Source+Sans+Pro|Ubuntu|Varela+Round|Zilla+Slab|Spirax|Lato|Lato:700" rel="stylesheet">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/all.css" integrity="sha384-G0fIWCsCzJIMAVNQPfjH08cyYaUtMwjJwqiRKxxE/rx96Uroj1BtIQ6MLJuheaO9" crossorigin="anonymous">

		<?php wp_head(); ?>
		<script>
        // conditionizr.com
        // configure environment tests
        conditionizr.config({
            assets: '<?php echo get_template_directory_uri(); ?>',
            tests: {}
        });
        </script>

	</head>
	<body class="rountree" <?php body_class(); ?>>

		<!-- wrapper -->
		<div class="wrapper">

			<!-- header -->
			<header class="header clear" role="banner">
					<?php global $post; ?>
					<?php 
						if (is_home()) {
							// Hard-code the ID of the blog page
							$image = get_the_post_thumbnail_url(15, 'large');
						} else if (!empty(get_post_type())) {
							$image = get_the_post_thumbnail_url($post->ID, 'large');							
						}
					?>
					<div class="banner-image-container" style="background-image: url('<?php if (isset($image)) echo $image; ?>'); <?php if (isset($post) && $post->ID === 6) echo 'background-position-x: left;' ?>">
						<div class="page-title-wrapper">
							<div class="title-text">
								<h1>
									<?php
										if (is_front_page()) {
											echo 'Amanda Rountree';
										} else if (is_home()) {
											echo 'Amanda\'s Blog';
										} else if (!empty(get_post_type())) {
											echo get_the_title($post->ID);
										}
									?></h1>
								<h2><?php the_field('subtitle'); ?></h2>
							</div>
						</div>
					</div>
					<!-- nav -->
					<nav class="nav" role="navigation">
						<?php html5blank_nav(); ?>
					</nav>
					<!-- /nav -->

			</header>
			<!-- /header -->
