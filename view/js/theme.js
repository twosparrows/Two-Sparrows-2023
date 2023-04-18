/* 

THEME JS

DO NOT UPDATE THIS FILE. It is for reference only. All JS updates should be made in the WP Dashboard (which automatically minifies and forces a JS update).

*/



// VARIABLES

// Testimonials section

var testimonialTimer;



// FUNCTIONS

// Theme

function tspSetHeadingTopMargin() {
	var headingTopMargin = (jQuery(window).height() * 0.75) - jQuery('section.section1.fullScreen .container').height();
  	if (headingTopMargin > jQuery('header').height()) {
  		jQuery('section.section1.fullScreen .container').css("margin-top", headingTopMargin + "px");
  	} else {
  		jQuery('section.section1.fullScreen .container').css("margin-top", jQuery('header').height() + "px");
  	}
}

// Testimonials section

function setTestimonialTimer() {
	testimonialTimer = window.setInterval(function(){ 
		var childIndex = jQuery('section.testimonials p.testimonial-links a.current').attr("href").replace(/[^0-9]/g,'');
		childIndex++;
		if (jQuery('section.testimonials p.testimonial-links a.testimonial-link' + childIndex).length == 0) {
		  childIndex = 0;
		}
		jQuery('section.testimonials p.testimonial-links a.testimonial-link' + childIndex).trigger("click");
	}, 5000 ); 
}

function setTestimonialSectionHeight() { // NB: If more than one Testimonial section is used on the page, all will be set to the minimum height
	var maxHeight = 0;
	jQuery('section.testimonials div.testimonial').each(function(){
		if (jQuery(this).height() > maxHeight) {
			maxHeight = jQuery(this).height();
		}
	});
	maxHeight = Math.ceil(maxHeight) + 10;
	jQuery('section.testimonials .internalWrap').height(maxHeight);
}



// DOCUMENT READY

jQuery(document).ready(function($){

    // Theme
    
    // Confirm JS loaded
        $('#js-loaded').text("true"); // This will prevent "No JS" file from being loaded in footer.php (which is a fallback in case JS doesn't execute)
        
    // Animations
        let heading1 = document.querySelector('section.kokako h1');
        let heading2s = document.querySelectorAll('section.kokako h2');
        let textWithPhotoImages = document.querySelectorAll('section.textWithPhoto .image');
        let multipleColumns = document.querySelectorAll('section.multipleColumns .multiple-columns-col');
        let multipleRows = document.querySelectorAll('section.multipleRows .multiple-rows-row');
        let latestPosts = document.querySelectorAll('section.kokako.latestPosts .blog-grid.post');
        
    /* heading2s.forEach(
    	(item) => ( item.style.animationDelay = (Math.random() * 0.5) + 's' )
        ); */
        
    function inViewPort(el) {
    	if ( el ) {
    		let rect = el.getBoundingClientRect();
    		if ( rect ) {
    			return (
    				(rect.top <= 0 && rect.bottom >= 0) ||
    				(rect.bottom >= window.innerHeight && rect.top <= window.innerHeight) ||
    				(rect.top >= 0 && rect.bottom <= window.innerHeight)
    			);
    		} else {
    			return false;
    		}
    	} else {
    		return false;
    	}
    }
        
    function animateOnScroll() {
        
    	// let windowScroll = jQuery(window).scrollTop(); // Maybe should be .pageYOffset() these days? See chapter "Parallax scrolling with JS"
    	// let windowHeight = jQuery(window).height();
    	// let windowViewable = windowScroll + windowHeight;
    	let animationDelayInitial = 0.2;
    	let animationDelayIncrease = 0.2;
    	let parentSection = "";
    	let previousParentSection = "";
        
    	// Heading 1
    	if ( inViewPort(heading1) ) {
    		heading1.classList.add('appear');
    	}
        
    	// Heading 2s
    	if ( 0 == jQuery('.woocommerce').length ) { // Don't fade in h2's on Woocommerce pages
    		let animationDelay = animationDelayInitial; // Will add animationDelayInitial (in seconds) in case h1 and first h2 are in view together
    		heading2s.forEach(function(heading2) {
    			if ( inViewPort(heading2) ) {
    				if ( performance.now() < 4000) { // If page has recently loaded, add a variation, so that headings in view don't display all at the same time
    					heading2.style.animationDelay = animationDelay + 's'; // Animation delay doesn't need to be removed, as this code is only executing when a heading is in view with 4 seconds of the page loading, and the animation is never being re-triggered
    					animationDelay += animationDelayIncrease;
    				}			
    				if ( !heading2. classList.contains('hide') ) {
    					heading2.classList.add('appear');
    				}
    			}
    		});
    	}
        
    	// Text with Photo images
    	animationDelay = animationDelayInitial; // Will add 300ms in case h1 and first h2 are in view together, to match headings
    	textWithPhotoImages.forEach(function(textWithPhotoImage) {
    		if ( inViewPort(textWithPhotoImage) ) {
    			if ( performance.now() < 4000) { // If page has recently loaded, add a variation, so that headings in view don't display all at the same time
    				textWithPhotoImage.style.animationDelay = animationDelay + 's'; // Animation delay doesn't need to be removed, as this code is only executing when a heading is in view with 4 seconds of the page loading, and the animation is never being re-triggered
    				animationDelay += animationDelayIncrease;
    			}			
    			textWithPhotoImage.classList.add('appear');
    		}
    	});
        
    	// Multiple Columns columns
    	animationDelay = animationDelayInitial;
    	parentSection = "";
    	previousParentSection = "";
    	multipleColumns.forEach(function(multipleColumnsCol) {
    		if ( inViewPort(multipleColumnsCol) ) {
    			if ( jQuery(window).outerWidth() > 767 ) {
    				parentSection = jQuery(multipleColumnsCol).parent().parent().parent("section").attr("class");
    				if ( ( "" == previousParentSection) || ( parentSection == previousParentSection ) ) {
    					multipleColumnsCol.style.animationDelay = animationDelay + 's'; // Animation delay doesn't need to be removed, as this code is only executing when a heading is in view with 4 seconds of the page loading, and the animation is never being re-triggered
    					animationDelay += animationDelayIncrease;
    				} else {
    					animationDelay = animationDelayInitial;
    					multipleColumnsCol.style.animationDelay = animationDelay + 's'; // Animation delay doesn't need to be removed, as this code is only executing when a heading is in view with 4 seconds of the page loading, and the animation is never being re-triggered
    					animationDelay += animationDelayIncrease;
    				}
    				previousParentSection = parentSection;
    			}
    			multipleColumnsCol.classList.add('appear');
    		}
    	});
        
    	// Multiple Rows rows
    	animationDelay = animationDelayInitial;
    	multipleRows.forEach(function(multipleRowsRow) {
    		if ( inViewPort(multipleRowsRow) ) {
    			if ( jQuery(window).outerWidth() > 767 ) {
    				multipleRowsRow.style.animationDelay = animationDelay + 's'; // Animation delay doesn't need to be removed, as this code is only executing when a heading is in view with 4 seconds of the page loading, and the animation is never being re-triggered
    				animationDelay += animationDelayIncrease;
    			}
    			multipleRowsRow.classList.add('appear');
    		}
    	});
        
    	// Latest Posts columns
    	animationDelay = animationDelayInitial;
    	latestPosts.forEach(function(latestPostsPost) {
    		if ( inViewPort(latestPostsPost) ) {
    			if ( jQuery(window).outerWidth() > 767 ) {
    				latestPostsPost.style.animationDelay = animationDelay + 's'; // Animation delay doesn't need to be removed, as this code is only executing when a heading is in view with 4 seconds of the page loading, and the animation is never being re-triggered
    				animationDelay += animationDelayIncrease;
    			}
    			latestPostsPost.classList.add('appear');
    		}
    	});
        
    	window.requestAnimationFrame(animateOnScroll);
    }
        window.requestAnimationFrame(animateOnScroll);
        
        
    // Custom Animations
    /* let scrollMagicController = new ScrollMagic.Controller();
        
    if ( jQuery('section.kokako.textWithCircularPhoto').length ) {
        
    	let textWithCircularPhotoMotifTween = TweenMax.from('section.kokako.textWithCircularPhoto .background-motif', {
    		x: 25, // 25
    		y: 25, // 50
    		ease: Sine.easeInOut, // See https://greensock.com/docs/v2/Easing
    	});
    	let textWithCircularPhotoImageTween = TweenMax.from('section.kokako.textWithCircularPhoto .image', {
    		x: -25, // -50
    		y: -25,
    		ease: Sine.easeInOut,
    	});
        
    	new ScrollMagic.Scene({
    		triggerElement: 'section.kokako.textWithCircularPhoto',
    		duration: ( jQuery(window).height() * 1.5),
    		triggerHook: 0.5,
    		offset: ( jQuery(window).height() / -2 ),
    	})
    		.setTween(textWithCircularPhotoMotifTween)
    		.addTo(scrollMagicController);
        
    	new ScrollMagic.Scene({
    		triggerElement: 'section.kokako.textWithCircularPhoto',
    		duration: ( jQuery(window).height() * 1.5),
    		triggerHook: 0.5,
    		offset: ( jQuery(window).height() / -2 ),
    	})
    		.setTween(textWithCircularPhotoImageTween)
    		.addTo(scrollMagicController);
    }
        
    if ( jQuery('section.kokako.contact-footer').length ) {
        
    	let contactFooterMotifTween = TweenMax.from('section.kokako.contact-footer .foreground-motif', {
    		x: -25,
    		y: 50,
    		ease: Sine.easeInOut,
    	});
        
    	let contactFooterImageTween = TweenMax.from('section.kokako.contact-footer img', {
    		x: 0,
    		y: -50,
    		ease: Sine.easeInOut,
    	});
        
    	new ScrollMagic.Scene({
    		triggerElement: 'section.kokako.contact-footer',
    		duration: ( jQuery(window).height() * 1.5),
    		triggerHook: 0.5,
    		offset: ( jQuery(window).height() / -2 ),	
    	})
    		.setTween(contactFooterMotifTween)
    		.addTo(scrollMagicController);
        
    	new ScrollMagic.Scene({
    		triggerElement: 'section.kokako.contact-footer',
    		duration: ( jQuery(window).height() * 1.5),
    		triggerHook: 0.5,
    		offset: ( jQuery(window).height() / -2 ),
    	})
    		.setTween(contactFooterImageTween)
    		.addTo(scrollMagicController);
    } */
        
        
    // Adjust fixed Header size on scroll
    if (($(document).scrollTop() > 50) && ($(window).outerWidth() > 575)) {
    	jQuery('header').addClass("scrolled");			
    	// jQuery('section.section1').addClass("scrolled"); // No longer required
    } else {
    	jQuery('header').removeClass("scrolled");			
    	// jQuery('section.section1').removeClass("scrolled"); // No longer required
    }
    $(window).scroll(function(){
    	if (($(document).scrollTop() > 50) && ($(window).outerWidth() > 575)) {
    		jQuery('header').addClass("scrolled");			
    		// jQuery('section.section1').addClass("scrolled"); // No longer required
    	} else {
    		jQuery('header').removeClass("scrolled");			
    		// jQuery('section.section1').removeClass("scrolled"); // No longer required
    	}
    });
    
});



// WINDOW LOAD

jQuery(window).on('load', function(){

    // Theme
    
    // Set top margin of heading in top Section
    if (jQuery('section.section1.fullScreen').length) {
    	tspSetHeadingTopMargin();
    	jQuery(window).resize(function(){
    		tspSetHeadingTopMargin();
    	});
    	jQuery('section.section1.fullScreen').stellar();
    }
        
    // Accordion functionality
    jQuery('h4.accordion-toggle').click(function(){
    	jQuery(this).find('i.icon-plus').toggleClass('open');	
    	jQuery(this).next('div.accordion-content').slideToggle(400);	
    });
        
    /*
    // CODE REMOVED AT THIS STAGE AS NEEDS TO BE UPDATED TO INCLUDE ON SCROLL EVENT THAT CAN ALSO REMOVE THE BOTTOM-ALIGN CLASS
    // Position footer to bottom of window on shorter pages
    if ((jQuery(window).height() == jQuery(document).height()) || ((jQuery(window).height() > jQuery(document).height() - 50) && (jQuery('#wpadminbar').is(':visible')))) { // See https://stackoverflow.com/questions/14035819/window-height-vs-document-height - doc height is set to window height when it is less than he window height
    	jQuery('footer').addClass('bottom-align');
    }
        */
    
    // Testimonials section
    
    // Testimonials animation
    if (jQuery('section.testimonials').length) {
        
    	// Set Testimonials Height
    	setTestimonialSectionHeight();
    	jQuery(window).resize(function(){
    		setTestimonialSectionHeight();
    	});
        
    	// Set Testimonials Animation
    	if ( jQuery('section.testimonials div.testimonial').length > 1 ) { // Don't start timer if only one testimonial
        
    		jQuery('section.testimonials p.testimonial-links a').click(function(){
    			if (!jQuery(this).hasClass("current")) {
        
    				// Remove all "current" classes
    				jQuery('section.testimonials div.testimonial').removeClass("current");
    				jQuery('section.testimonials p.testimonial-links a').removeClass("current");
        
    				// Add an appropriate "current" class
    				var childIndex = jQuery(this).attr("href").replace(/[^0-9]/g,'');
    				jQuery('section.testimonials div.testimonial' + childIndex).addClass("current");
    				jQuery('section.testimonials p.testimonial-links a.testimonial-link' + childIndex).addClass("current");
    		  	}
    			return false;
    		});
        
    		// Set timer (and clear on hover)
    		setTestimonialTimer();
    		jQuery("section.testimonials div.col-xs-12").hover(function() {
    			window.clearInterval(testimonialTimer);
    		}, function() {
    			setTestimonialTimer();
    		});
    		jQuery("section.testimonials p.testimonial-links a").hover(function() {
    			window.clearInterval(testimonialTimer);
    		});
        
    	}
    }
    
});