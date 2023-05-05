<?php

// All Kōkako by Two Sparrows functions are pluggable, and can be replaced. Add any site specific functions below


// Base Year - the year the website went active, ie. year zero for the website

if ( !defined( 'kokako_base_year' ) ) {
	define( 'kokako_base_year', 2023 );
}


// Set up words within emails (used to break email addresses at appropriate places)
global $emailsWordList;
$emailsWordList = array( "imelda", "design", "web", "two", "sparrows" ); // Just add words to this array, and any email addresses that use the tsp_email() function will break on these words on smaller screens instead of overflowing the screen. Exmaple array: array( "imelda", "design", "web", "two", "sparrows" ) . The @ and . symbols will be automatically set to break after


// Section start hook
add_action( 'tsp_section_start', 'tsp_section_start_hook_child', 10, 1 );
if ( !function_exists( 'tsp_section_start_hook_child' ) ) {
	function tsp_section_start_hook_child( $data = array() ) {
		/* 
		global $section;

		// Kōkako theme hooks
		if ( ( array_key_exists( "heading", $section ) ) && ( array_key_exists( "display", $section["heading"] ) ) && ( "hide" != $section["heading"]["display"] ) ) {
			?><div class="motif-bar"></div><?php
		}
		*/
	}
}


// Section start hook
add_action( 'tsp_section_heading', 'tsp_section_heading_hook', 10, 1 );
function tsp_section_heading_hook( $data = array() ) {
	
	global $section;

	// Kōkako theme hooks
	if ( ( array_key_exists( "heading", $section ) ) && ( array_key_exists( "display", $section["heading"] ) ) && ( "hide" != $section["heading"]["display"] ) ) {
		?><div class="motif-bar-heading"></div><?php
	}

}


// Override display heading function to add tsp_section_heading hook
function tsp_display_heading( $argsPassed = array( "headingOverride" => "", "useH2" => false, "link" => "", "displayOverride" => "", "alignmentOverride" => "" ) ) { // If only one item in an array is passed, other associative items don't get added, hence defaults merge below. See https://stackoverflow.com/questions/30245573/php-pass-array-to-function-maintain-default-values-if-not-set . Display and Alignment overrides are for use outside of $section, eg. in footer for CTA section
		
	global $section, $h1Displayed;
	$argsDefaults = array( "headingOverride" => "", "useH2" => false, "link" => "", "displayOverride" => "", "alignmentOverride" => "" );
	$args = array_merge( $argsDefaults, $argsPassed );
	
	// Overrides
	if ( "" != $args["headingOverride"] )
		$section["heading"]["heading"] = $args["headingOverride"];
	if ( "" != $args["displayOverride"] )
		$section["heading"]["display"] = $args["displayOverride"];
	if ( "" != $args["alignmentOverride"] )
		$section["heading"]["alignment"] = $args["alignmentOverride"];
	
	// Select h1 or h2
	if ( ( array_key_exists( "index", $section ) ) && ( array_key_exists( "type", $section ) ) ) {
		if ( ( ( 1 == $section["index"] ) && ( false == $args["useH2"] ) ) || ( ( false == $h1Displayed ) && ( false == $args["useH2"] ) ) ) {
			$h = 1;
			$h1Displayed = true;
		} else {
			$h = 2;
		}
	} elseif ( false == $args["useH2"] ) {
		$h = 1;
	} else {
		$h = 2;
	}
	
	// Build link HTML (if required)
	if ($args["link"] != "") {
		$args["link"] = '<a href="' . $args["link"] . '"';
		if ( false === strpos( $section['ministryLink'], site_url() ) ) {
			$args["link"] .= ' target="_blank"';
		}
		$args["link"] .= '>';
	}

	// Output heading
	if ( "hide" != $section["heading"]["display"] ) {	
		do_action( 'tsp_section_heading' );
	} ?>
	<h<?= $h ?> class="<?= $section["heading"]["display"] ?><?php if ( ( "default" != $section["heading"]["alignment"] ) && ( "" != $section["heading"]["alignment"] ) ) { echo " " . $section["heading"]["alignment"]; } ?>"><?= $args["link"] ?><span><?= do_shortcode( $section["heading"]["heading"] ) // htmlentities() removed as it conflicts with shortcodes ?><?php if ( "" != $args["link"] ) { echo '</a>'; } ?></span></h<?= $h ?>><?php // h1 for first section only - more semantic for SEO. Note change of h1 to h2 for subsequent sections - more semantic for SEO
}

?>