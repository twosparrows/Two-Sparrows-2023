<?php
/*

PAGE BANNER SECTION

Do not update this file in the parent theme sections folder. To make changes, copy this file into the child theme sections folder, and update it there. The custom file will automatically be used instead.

*/ 


global $section;
	
tsp_get_section_content( array( "background_required", "text_basic", "display_cta_buttons" ) );

?><div class="banner-overlay"></div><?php

do_action( 'tsp_section_start' );

tsp_open_container();
		
	tsp_apply_motif();
		
	?>
	<div class="row">
		<div class="col col-xs-12 col-sm-12">
			<?php if ( is_array( $section["background_required"]["image"] ) ) {
				if ( $section["developer"]["page_banner_image"] == "backgroundImage" ) {
					if ( ( !array_key_exists( "page_banner_image_position", $section["developer"] ) ) || ( "" == $section["developer"]["page_banner_image_position"] ) ) {
						$section["developer"]["page_banner_image_position"] = "center center";
					} ?>
					<style type="text/css">								
						section.kokako.pageBanner.section<?= $section["index"] ?> {<?php
							if ( tsp_section_has_class( "banner-gradient-light" ) ) {
								?>background-image: url(<?= $section["background_required"]["image"]["sizes"]["page-banner-retina"] ?>), linear-gradient( 58deg, #FFFFFF 0%, #FFFFFF00 100% );background-size:cover, 100% 100%;background-blend-mode:soft-light;<?php
							} else {
								?>background-image: url(<?= $section["background_required"]["image"]["sizes"]["page-banner-retina"] ?>);background-size: cover;<?php
							}
							?>background-attachment: <?= $section["developer"]["background_image_scroll"] ?>;
							background-position: <?= $section["developer"]["page_banner_image_position"] ?>;
						}
						
						@media (min-width: 992px) {
							section.kokako.pageBanner.section<?= $section["index"] ?> {<?php
								if ( tsp_section_has_class( "banner-gradient-light" ) ) {
									?>background-image: url(<?= $section["background_required"]["image"]["url"] ?>), linear-gradient( 58deg, #FFFFFF 0%, #FFFFFF00 100% );background-size:cover, 100% 100%;background-blend-mode:soft-light;<?php
									/* ?>background-image: url(<?= $section["background_required"]["image"]["url"] ?>), linear-gradient(180deg, #6C40676A 0%, #2C4A9A 100%);
									background-size: cover, 100% 100%;
									background-attachment: scroll;
									background-position: center center;
									background-blend-mode: soft-light;
									background-repeat: no-repeat;<?php */
								} else {
									?>background-image: url(<?= $section["background_required"]["image"]["url"] ?>);background-size: cover;<?php
								}
								?>background-attachment: <?= $section["developer"]["background_image_scroll"] ?>;
								background-position: <?= $section["developer"]["page_banner_image_position"] ?>;
							}
						}
					</style>
				<?php } else { // Default to normal image ?>
					<img src="<?= $section["background_required"]["image"]["url"] ?>" srcset="<?= $section["background_required"]["image"]["sizes"]["page-banner"] ?> <?= $section["background_required"]["image"]["sizes"]["page-banner-width"] ?>w, <?= $section["background_required"]["image"]["sizes"]["page-banner-retina"] ?> <?= $section["background_required"]["image"]["sizes"]["page-banner-retina-width"] ?>w" width="<?= $section["background_required"]["image"]["width"] ?>" />
				<?php }
			}
				
			if ( ( $section["heading"]["display"] != "hide" ) || ( $section["text_basic"] != "" ) || ( ( is_array($section["display_cta_buttons"] ) ) && ( !empty( $section["display_cta_buttons"] ) ) && ( "display" == $section["display_cta_buttons"][0] ) ) ) { // Don't display text box if there's nothing to go in it
				if ( ( is_array( $section["background_required"]["overlay"] ) ) && ( !empty( $section["background_required"]["overlay"] ) ) ) { // If the array is empty, "overlay" is not selected ?>
					<div class="overlay">
				<?php } else { ?>
					<div class="text-box">
				<?php }
						
					tsp_display_heading();
					
					// Content
					echo $section["text_basic"];

					tsp_cta_buttons();
					
					?>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
<?php do_action( 'tsp_section_end' ); ?>