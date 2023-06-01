<?php
/*

TEXT WITH PHOTO SECTION

Do not update this file in the parent theme sections folder. To make changes, copy this file into the child theme sections folder, and update it there. The custom file will automatically be used instead.

*/ 


global $section;
	
tsp_get_section_content( array( "text", "image", "display_cta_buttons" ) );

// Add class with photo direction to container element
if ( "right" == $section["image"]["position"] ) {
	$classes = "photo-on-right";
} else {
	$classes = "photo-on-left";
}


// CUSTOM: Get Image Column Width (for sizes XL and above)
if ( !array_key_exists( "image_column_width", $section["developer"] ) ) {
	$section["developer"]["image_column_width"] = 6;
}


// Output Section

tsp_open_section();

	do_action( 'tsp_section_start' );

	tsp_open_container( $classes );

		tsp_apply_motif();

		if ( "" != $section["image"] ) { 
			
			$backgroundSize = "background-size:cover;"; // Default
			if ( "contain" == $section["image"]["size"] ) {
				$backgroundSize = "background-size:contain;";
			}
			if ( array_key_exists( "size", $section["image"] ) ) {
				$backgroundSize .= "background-repeat:no-repeat;";
			}

			?><style type="text/css">								
				section.<?= $section["type"] ?>.section<?= $section["index"] ?> .col-xl-<?= $section["developer"]["image_column_width"] ?>.image<?php if ( tsp_section_has_class( "image-sticky" ) ) { echo " .sticky-image"; } ?>{
					background: url(<?= $section["image"]["image"]["sizes"]["background-retina"]; ?>);
					<?= $backgroundSize ?>
					background-position: <?= $section["image"]["alignment"]; ?>;
				}
				
				@media (max-width: 991px) {
					section.<?= $section["type"] ?>.section<?= $section["index"] ?> .col-xl-<?= $section["developer"]["image_column_width"] ?>.image<?php if ( tsp_section_has_class( "image-sticky" ) ) { echo " .sticky-image"; } ?>{
						background: url(<?= $section["image"]["image"]["sizes"]["background"]; ?>);
						<?= $backgroundSize ?>
						background-position: <?= $section["image"]["alignment"]; ?>;
					}
				}

				@media (max-width: 1199px) {
					section.<?= $section["type"] ?>.section<?= $section["index"] ?> .col-xl-<?= $section["developer"]["image_column_width"] ?>.image<?php if ( tsp_section_has_class( "image-sticky" ) ) { echo " .sticky-image"; } ?>{
						min-height: 400px;
					}
				}
			</style>
		<?php } ?>
		<div class="row<?php if ( "right" == $section["image"]["position"] ) { echo " flex-row-reverse"; } ?>">
			<div class="<?php // col ?>col-xs-12 col-sm-12 col-xl-<?= $section["developer"]["image_column_width"] ?> image"><?php // Image always first for mobile sizes, order reversed above if required 
				if ( tsp_section_has_class( "image-sticky" ) ) {
					echo '<div class="sticky-image"></div>';
				}
			?></div>
			<div class="<?php // col ?>col-xs-12 col-sm-12 col-xl-<?= 12 - $section["developer"]["image_column_width"] ?> text">
				<div class="internalWrap">
					<?php tsp_display_heading(); ?>
					<?= $section["text"] ?>
					<?php tsp_cta_buttons(); ?>
				</div>
			</div>
		</div>
	</div>
	<?php do_action( 'tsp_section_end' ); ?>
</section>