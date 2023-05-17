<?php

// Get setup variables
global $logo;
global $socialMediaAccounts, $contactDetails; // Declared globally in header
$shieldedSite = tsp_booleanise( get_field( "shielded_site", "option" ), "add" );

// Footer Logo
$footerLogo = get_field( "footer_logo", "option" );
if ( "" == $footerLogo )
	$footerLogo = $logo;

	
// Contact Footer
$footerCtaOverride = get_field( "footer_cta_section" );

if ( $footerCtaOverride != "hide" ) { // Show defaults

	$footerCta = get_field( "footer_cta_section_defaults", "option" );
	if ( empty( $footerCta["heading"]["heading_display"] ) ) {
		$footerCta["heading"]["display"] = "display";
	} else {
		$footerCta["heading"]["display"] = $footerCta["heading"]["heading_display"][0];
	}
		
	if ( ( !empty( $footerCta["always_display"] ) ) || ( "show" == $footerCtaOverride ) ) { // Then "Always Display" is checked ?>

		<a name="callToAction" id="callToAction"></a>
		<section class="kokako callToAction contact<?php if ( $footerCta["colour_scheme"] != "default" ) { echo " colour-scheme " . $footerCta["colour_scheme"]; } ?>">

			<?php 
			global $section;
			$section["type"] = "callToAction"; // Hack for now. To be fixed when footer.php calls sections/call-to-action.php
			do_action( 'tsp_section_start' ); ?>

			<div class="container">
				<?php 
					
				// Apply Background
				
				if ( ( !array_key_exists( "display_background", $footerCta ) ) || ( ( array_key_exists( "display_background", $footerCta ) ) && ( !empty( $footerCta["display_background"] ) && ( ( $footerCta["display_background"][0] == "Display Background Image") ) ) ) ) { // Proceed to show background if there is no "Display Background" option for the section (must be set) or if "Display Background" is checked
					if ( ( is_array( $footerCta["background"] ) ) && ( $footerCta["background"]["image"] != "" ) ) { ?>
						<style type="text/css">
							section.kokako.callToAction {
								<?php if ( $footerCta["background"]["position"] != "repeat" ) { ?>
									background: url(<?= $footerCta["background"]["image"]["url"] ?>) center center no-repeat;
									background-size: cover;
									background-attachment: <?= $footerCta["background"]["position"] ?>;
								<?php } else { ?>
									background: url(<?= $footerCta["background"]["image"]["url"] ?>) repeat;
								<?php } ?>
							}
						</style>
					<?php }
				} ?>

				<div class="row">
					<div class="col-xs-12 col-md-12">
						<?php
							
						tsp_display_heading( array(
								"headingOverride" => $footerCta["heading"]["heading"],
								"useH2" => true,
								"displayOverride" => $footerCta["heading"]["display"],
								"alignmentOverride" => $footerCta["heading"]["alignment"],
							)
						);
						
						echo apply_filters( 'the_content', $footerCta["content"] ); // Performs shortcodes etc
						
						?>
					</div>
				</div>
			</div>

			<?php do_action( 'tsp_section_end' ); ?>

		</section>
	
	<?php }
}



?>
</main>

<footer id="footer" class="container-fluid" tabindex="-1"><?php // #footer required for skip to footer accessibility link at top of header ?>
	<div class="container">
		<div class="row">
			<?php
			
			// Set up Footer columns
			$footerLgColumnWidth = 12 / $GLOBALS['widgetAreas']['number-of-footer-columns']; // 12, 6, 4 or 3 (as there is a maximum of 4 footer columns)
			
			for ( $c=1; $c<=$GLOBALS['widgetAreas']['number-of-footer-columns']; $c++ ) { ?>

				<div class="col-xs-12 col-sm-12 col-lg-<?= $footerLgColumnWidth ?> footer-col-<?= $c ?><?php if ( 1 == $c ) { echo ' footer-logo'; } ?>">
					
					<?php
					
					 // First column only: Add Logo
					if ( 1 == $c ) {
						if ( ( is_array( $footerLogo ) ) && ( !empty( $footerLogo ) ) ) { ?>
							<a class="footer-logo-a" href="<?= get_option('home'); ?>">
								<img class="alignnone" src="<?= $footerLogo['url'] ?>" alt="<?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?>"<?php if ( 2 < $footerLogo['width'] ) { ?> width="<?= $footerLogo['width'] / 2 ?>"<?php } if ( 2 < $footerLogo['height'] ) { ?> height="<?= $footerLogo['height'] / 2 ?>"<?php } ?> />
							</a>
						<?php } else { ?>
							<h4><a href="<?= get_option('home'); ?>"><?= bloginfo('name'); ?></a></h4>
						<?php }
					}

					?><p>Copyright &copy; <?php tsp_copyright_line( kokako_base_year ); ?><br /><a href="<?= get_option( 'home' ); ?>"><?php bloginfo() ?></a></p><?php
					/* <p>Website created for <span class="non-breaking-spaces"><?php bloginfo() ?></span> by <?php tsp_website_link_line(); ?></p> */

					// All columns: Add Widget
					if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( "Footer Column " . $c ) ) :
					endif;
					
					// Final Column only: Add Copyright line
					// if ( $c == $GLOBALS['widgetAreas']['number-of-footer-columns'] ) {
					// if ( false == $GLOBALS['widgetAreas']['subfooter-widget'] ) { // Display the copyright line here if no Subfooter (otherwise displayed in Subfooter ?>

					</div>
				</div>

				<div class="row two-sparrows-supports">
					<div class="col-xs-12 col-sm-6 trees-that-count">
						<a href="//www.treesthatcount.co.nz/" class="no-underline" target="_blank"><img class="alignright" src="<?php bloginfo('stylesheet_directory'); ?>/img/TreesThatCount_supporter_whitebubble_withgreen.png" srcset="<?php bloginfo('stylesheet_directory'); ?>/img/TreesThatCount_supporter_whitebubble_withgreen@2x.png 354w" alt="Trees That Count - Te Rahi o Tāne - Native tree supporter" title="Trees That Count - Te Rahi o Tāne - Native tree supporter" width="177" height="177" /></a>
					</div>
					<div class="col-xs-12 col-sm-6 shielded">
						<?php if ( true == $shieldedSite ) {
							include( TEMPLATEPATH . '/template-parts/shielded_site.php' );
						}
					?></div>
					
				</div>

			<?php } ?>
				
		</div>		
	</div>
	
	<?php 
	
	// Subfooter
	if ( true == $GLOBALS['widgetAreas']['subfooter-widget'] ) { ?>
		<div id="subfooter" class="container">
			<?php if ( is_active_sidebar( "subfooter-widget" ) ) { // NB: Must use ID (not name) for function to work properly - see notes at https://developer.wordpress.org/reference/functions/is_active_sidebar/ ?>
				<div class="row">
					<div class="col-xs-12 col-sm-12 aligncentre">
						<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( "Subfooter" ) ) :
						endif;?>
					</div>
				</div>
			<?php } ?>
			<div class="row">
				<div class="col-xs-12 col-sm-12 aligncentre">
					<?php /* <p>Copyright &copy; <?php tsp_copyright_line( kokako_base_year ); ?> <a href="<?= get_option( 'home' ); ?>"><?php bloginfo() ?></a> <span class="footer-copyright-separator">|</span> Website created for <span class="non-breaking-spaces"><?php bloginfo() ?></span> by <?php tsp_website_link_line(); ?></p> */?>
					<?php if ( true == $shieldedSite ) {
						include( TEMPLATEPATH . '/template-parts/shielded_site.php' );
					} ?>
				</div>
			</div>
		</div>
	<?php } ?>
	
</footer>

<?php 

// Display Bootstrap screen size	
if ( tsp() ) {
	$bootstrap = get_field( 'display_screen_size_for_testing', 'option' );
	if ( ( is_array( $bootstrap ) ) && ( "bootstrap_test" == $bootstrap[0] ) ) { ?>
		<div id="bootstrap-test" class="container-fluid clearfix">
				<div class="d-none d-xl-block">
					<p>XL</p>
				</div>
				<div class="d-none d-lg-block d-xl-none">
					<p>LG</p>
				</div>
				<div class="d-none d-md-block d-lg-none d-xl-none">
					<p>MD</p>
				</div>
				<div class="d-none d-sm-block d-md-none d-lg-none d-xl-none">
					<p>SM</p>
				</div>
				<div class="d-sm-none">
					<p>XS</p>
				</div>
			</div>
	<?php }
}


wp_footer();

include( TEMPLATEPATH . '/template-parts/check_js_loaded_min.php' );

?>
</body>
</html>