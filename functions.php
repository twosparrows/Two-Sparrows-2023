<?php

// All Kōkako by Two Sparrows functions are pluggable, and can be replaced. Add any site specific functions below


// Base Year - the year the website went active, ie. year zero for the website

if ( !defined( 'kokako_base_year' ) ) {
	define( 'kokako_base_year', 2023 );
}


// Set up words within emails (used to break email addresses at appropriate places)
global $emailsWordList;
$emailsWordList = array(); // Just add words to this array, and any email addresses that use the tsp_email() function will break on these words on smaller screens instead of overflowing the screen. Exmaple array: array( "imelda", "design", "web", "two", "sparrows" ) . The @ and . symbols will be automatically set to break after

?>