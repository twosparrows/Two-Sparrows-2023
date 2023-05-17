<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="<?php bloginfo('charset'); ?>" />
	<?php if ( is_search() ) { ?>
	   <meta name="robots" content="noindex, nofollow" /> 
	<?php }
	
	// Analytics - Head
	$analyticsHead = trim( get_field("analytics_code_head", "option") );
	if ( "" != $analyticsHead )
		echo $analyticsHead;
		
	?>
	
	<?php // <link rel="shortcut icon" href="/favicon.ico"> ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>

	<meta name="author" content="Developed by Two Sparrows Ltd www.twosparrows.co.nz">

	<?php wp_head(); ?>
	
	<?php // Load "No JS" CSS file if JS not enabled ?>
	<noscript>
		<link rel="stylesheet" type="text/css" href="<?= get_stylesheet_directory_uri() ?>/view/other/no-js.min.css" />
	</noscript>
	
</head>

<?php

// Add an interior-page class to the body tag if not home page
$bodyClass = trim( 'site ' . $GLOBALS['additionalBodyClasses'] );
if ( !is_front_page() ) {
	$bodyClass .= ' interior-page';
} ?>
	
<body<?php echo tsp_create_element_id(); echo body_class( trim( $bodyClass ) ); ?>><?php

	// Analytics - Body
	$analyticsBody = get_field( "analytics_code_body", "option") ;
	if ( "" != $analyticsBody )
		echo $analyticsBody;

	?>
	
	<header id="masthead" class="container-fluid">
		
		<div class="skip-link">
			<a href='#main'>Skip to content</a> or <a href="#footer">skip to footer</a>
		</div>

		<div class="container">
			
			<?php
			
			// Get setup variables
			$logoPosition = get_field( "header_logo_position", "option" ); // Left (or "") is the default
			
			// Navbar expand
			$navbarExpand = get_field( "navbar_expand", "option" );
			$navbarExpandClass = "navbar-expand";
			switch( $navbarExpand ) {
				case "never": $navbarExpandClass = ""; break;
				case "always": break;
				default: $navbarExpandClass .= $navbarExpand;
			}
			
			// Header Logo
			global $logo;
			$logo = get_field( "header_logo", "option" );
				// tsp( "headerLogo:" ); tsp( $headerLogo );
			
			
			// For Bootstrap see example https://getbootstrap.com/docs/4.1/examples/navbar-fixed/ from https://getbootstrap.com/docs/4.1/examples/ ?>
			
			<nav class="navbar <?= $navbarExpandClass; ?><?php if ( "right" == $logoPosition ) { echo " d-flex flex-row-reverse"; } ?>"><?php // navbar-expand-* class sets the break point at which the mobile menu becomes the main menu, eg. navbar-expand-lg expands to the full menu at LG size ?>
				
				<div class="logo">
					<a class="navbar-brand" href="<?= site_url(); ?>/">
						<?php if ( ( is_array( $logo ) ) && (!empty( $logo ) ) ) { ?>
							<img src="<?= $logo["sizes"]["logo"]; ?>" <?php if ( strpos( $logo["sizes"]["logo"], '.svg', -4 ) === false ) { // There is no need for srcset, width or height specified for SVGs ?>srcset="<?= $logo["sizes"]["logo-retina"]; ?> <?= $logo["sizes"]["logo-retina-width"]; ?>w" width="<?= $logo["sizes"]["logo-width"]; ?>" height="<?= $logo["sizes"]["logo-height"]; ?>"<?php } ?> alt="<?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?>" />
						<?php } else { // No logo
							bloginfo( 'name' );
						} ?>
					</a>
				</div>
				
				<?php
					
				// Header Widget
				if ( true == $GLOBALS['widgetAreas']['header-widget'] ) { ?> 
					<div class="header-widget<?php if ( "right" == $logoPosition ) { echo " header-widget-row-reverse"; } ?>">
						<?php
						if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( "Header" ) ) :
						endif;
						?>
					</div>
				<?php } ?>

				
				<button class="menu-toggler" type="button" aria-expanded="false" aria-label="Toggle menu"><span class="sr-only">Open </span>Menu</button><?php // .sr-only is for screen readers ?>
				
		    </nav>
		
		</div>
	</header>

	<nav id="website-navigation"<?php /* class="collapse navbar-collapse d-flex<?php if ( "right" != $logoPosition ) { echo " flex-row-reverse"; } ?>" id="navbarCollapse" */ ?>><?php // d-flex and flex-row-reverse classes align the menu to the right. See https://getbootstrap.com/docs/4.1/utilities/flex/ . Note that these classes may require overrides to collapse the menu at mobile sizes as they set the display to flex (instead of none) */ ?>

		<?php
		wp_nav_menu( array(
				'menu'              => 'main-menu',
				'theme_location'    => 'main-menu',
				'depth'             => 2,
				'container'         => 'div',
				'container_class'   => '',
				'container_id'      => 'main-nav',
				'menu_class'        => 'nav',
				'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
				'walker'            => new WP_Bootstrap_Navwalker()
			)
		);
					
		// Social Media Accounts, contactdetails
		global $socialMediaAccounts, $contactDetails; // Declared globally as used in footer also
		$socialMediaAccounts = get_field( 'social_media_accounts', 'option' );
		$contactDetails = array(
			"email" => get_field( 'email', 'option' ),
			"phone" => get_field( 'phone', 'option' ),
		);

		/*if ( ( $socialMediaAccounts != "" ) && ( !empty( $socialMediaAccounts) ) ) {
			?><p><span class="connect">Connect: </span><?php
			foreach( $socialMediaAccounts as $sm ) {
				?><a class="sm-link" href="<?= $sm["url"] ?>" target="_blank"><i class="fab fa-<?= $sm["account"] ?>"></i></a><?php
			} ?></p><?php
		} */ ?>		     
	</nav>

	<div class="header-background"></div><?php // This section is the background of the header, so that there never appears to be a gap between section 1 and the header when header is sliding up and down. Works better than section 1 border top method as allows for gradients on header background better ?>

	<main id="main" tabindex="-1"><?php // Don't allow focus via tab key - see comments at https://css-tricks.com/how-to-create-a-skip-to-content-link/ ?>