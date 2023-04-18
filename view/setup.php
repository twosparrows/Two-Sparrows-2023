<?php 

/*

THEME SETUP

Updated at 31/03/2023 12:22.48am UTC

Included via functions/site.php

*/


$GLOBALS['updatedTimeStamp'] = 1680222168;

// Development Modes
$GLOBALS['kokakoDevelopmentMode'] = false;
$GLOBALS['kokakoNoJavaScriptTestMode'] = false;

// Additional Body Classes
$GLOBALS['additionalBodyClasses'] = "header-fixed";

// Sections
$GLOBALS['availableSectionTypes'] = array( // NB: Text section is always available
     "call-to-action",
     "centred-images",
     "latest-posts",
     "multiple-columns",
     "multiple-rows",
     "page-banner",
     "page-heading",
     "testimonials",
     "text",
     "text-with-photo",
     "versions",
);

// JS Dependencies
$GLOBALS['jsDependencies'] = array(
     "jquery" => array(
          "source" => "//ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js",
          "dependencies" => "",
          "version" => "3.6.0",
          "in_footer" => "1",
          "user_logged_in" => "",
     ),
     "gsap" => array(
          "source" => "//cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js",
          "dependencies" => "",
          "version" => "3.9.1",
          "in_footer" => "1",
          "user_logged_in" => "",
     ),
     "scrollMagic" => array(
          "source" => "//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/ScrollMagic.min.js",
          "dependencies" => array("jquery", "gsap"),
          "version" => "2.0.7",
          "in_footer" => "1",
          "user_logged_in" => "",
     ),
     "scrollMagicJquery" => array(
          "source" => "//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/plugins/jquery.ScrollMagic.min.js",
          "dependencies" => array("jquery", "gsap", "scrollMagic"),
          "version" => "2.0.7",
          "in_footer" => "1",
          "user_logged_in" => "",
     ),
     "scrollMagicGsap" => array(
          "source" => "//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/plugins/animation.gsap.min.js",
          "dependencies" => array("jquery", "gsap", "scrollMagic", "scrollMagicJquery"),
          "version" => "2.0.7",
          "in_footer" => "1",
          "user_logged_in" => "",
     ),
);

// Widget areas
$GLOBALS['widgetAreas'] = array(
     "header-widget" => true,
     "number-of-footer-columns" => 4,
     "subfooter-widget" => false,
);

// Colour Schemes
$GLOBALS['colourSchemes'] = array(
     "colour-scheme-light" => array(
          "description" => "Light Colour Scheme (Light background, dark text)",
          "background"  => "#fff",
     ),
     "colour-scheme-dark" => array(
          "description" => "Dark Colour Scheme (Dark background, light text)",
          "background"  => "#000",
     ),
);

// Logos
$GLOBALS['headerLogoWidth'] = 185;
$GLOBALS['headerLogoWidthRetina'] = 370;
$GLOBALS['footerLogoWidth'] = 255;
$GLOBALS['footerLogoWidthRetina'] = 510;

// Functions

function tsp_updated_timeStamp() { // Can also be called as a function if required, although higher overhead than a variable
     return 1680222168;
}

?>