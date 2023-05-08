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
		?><div class="motif-bar-heading"><div class="bar"></div></div><?php
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


// Button overrides (to add icon within button)
function tsp_button( $atts ) {

	// Example: [[button text="Button Text Here" link="URL here" target="blank (not necessary - external links default to a new window)" class="alt (alternate colour if required)"]

	// Set Attribute defaults
	extract( shortcode_atts( array(
		'text' => '',
		'link' => "",
		'class' => "",
		'target' => "",
		'align' => "",
		'onclick' => "",
		), $atts )
	);
	
	// Target
	$link = str_replace( "SITE", site_url(), $link );
	if ( "" == $target ) {
		if ( ( strpos( $link, site_url() ) === false ) && ( substr( $link, 0, 1 ) !== "/" ) && ( substr( $link, 0, 1 ) !== "#" ) ) {
			$target = 'blank';
		}
	}

	// Set up Return
	if ( ( "" != $text ) && ( "" != $link ) ) {

		// Alignment
		if ( ( "centre" == $align ) || ( "center" == $align ) ) {
			$return = '<p class="text-align-centre ">';
		} elseif ( "right" == $align ) {
			$return = '<p class="text-align-right">';
		} elseif ( "left" == $align ) {
			$return = '<p class="text-align-left">';
		} elseif ( "none" == $align ) {
			$return = '';
		} else {
			$return = '';
		}

		// Anchor
		$return .= '<a href="' . $link . '" class="button';
		if ( "" != $class )
			$return .= ' ' . $class;
		$return .= '"';
		if ( "" != $onclick ) {
			$return .= ' onclick="' . $onclick . '"';
		}
		if ( "" != $target ) {
			$return .= ' target="_' . $target . '"';
			if ( "blank" == $target )
				$return .= ' rel="noopener noreferrer"';
		}
		$return .= '>' . $text . '<i class="icon-right"></i></a>';
		if ( ( "centre" == $align ) || ( "center" == $align ) || ( "right" == $align ) || ( "left" == $align ) ) {
			$return .= '</p>';
		}
		return $return;
	}
}
function tsp_cta_buttons( $addWrapper = false ) { // To override the buttons, just manually set the array keys "cta_buttons", "cta_buttons_alignment", and "display_cta_buttons" in the $section array before calling this function. Example values are below

	/*
	
	Example values:

	$section["display_cta_buttons"] = array( "display" );
	$section["cta_buttons"] = array(
		array(
			["button_text"]		=> "This is the button text",
			["button_link"]		=> "#",
			["button_class"]	=> "",
			["button_target"]	=> "default",
		)
	);
	$section["cta_buttons_alignment"] = "default";

	*/

	global $section;

	if ( ( array_key_exists( "display_cta_buttons", $section ) ) && ( is_array( $section["display_cta_buttons"] ) ) && ( !empty( $section["display_cta_buttons"] ) ) && ( "display" == $section["display_cta_buttons"][0] ) ) {
		
		// Set up
		if ( ( !array_key_exists( "cta_buttons", $section ) ) || ( !array_key_exists( "cta_buttons_alignment", $section ) ) ) {
			tsp_get_section_content( array("cta_buttons", "cta_buttons_alignment") );
		}
		
		if ( !empty( $section["cta_buttons"] ) ) {
		
			// Start Wrapper
			if ( true == $addWrapper ) {
				?><div class="row cta-buttons-wrapper<?= tsp_extra_row_classes() ?>">
					<div class="col col-xs-12 col-md-12"><?php
			}
			
			// CTA Buttons section
			?><div class="cta-buttons<?php 
				
				// Buttons Alignment
				if ( "default" != $section["cta_buttons_alignment"])
					echo " buttons-align-" . $section["cta_buttons_alignment"];
					
				?>"><?php
					
				// Add Buttons
				foreach ( $section["cta_buttons"] as $cta ) {

					// Set up link
					$link = str_replace("SITE", site_url(), $cta["button_link"]); // "SITE" keyword can be used to create site URL
					if ( "" == $cta["button_target"] ) {
						if ( (strpos($link, site_url() ) === false) && ( substr($link, 0, 1) !== "/" ) && (substr($link, 0, 1) !== "#" ) ) {
							$target = '_blank';
						}
					}

					// Start output
					echo '<a href="' . $link . '"';
								
					// Set up classes
					$classes = "";
					if ( false === strpos($cta["button_class"], "no-button") )
						$classes .= "button";
					if ( "" != $cta["button_class"] )
						$classes .= ' ' . $cta["button_class"];
					if ( "" != $classes )
						echo ' class="' . trim($classes) . '"';
					
					// Complete anchor
					if ( "default" != $cta["button_target"] ) {
						echo ' target="' . $cta["button_target"] . '"';
						if ( "_blank" == $cta["button_target"] )
							echo ' rel="noopener noreferrer"';
					}
					echo '>' . $cta["button_text"] . '<i class="icon-right"></i></a>';
				}
				
			?></div><?php
			
			// End Wrapper
			if ( true == $addWrapper ) {
					?></div>
				</div><?php
			}
		
		}
	}
}


?>