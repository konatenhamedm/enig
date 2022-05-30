(function ($) {
 "use strict";
 
	$(document).ready(function(){
		$('#mobile-menu').slicknav();
		
		/* SPECIAL-PRODUCT-ALL ACTIVE JS*/
		$('.special-product-all').owlCarousel({
			//loop:true,
			margin:10,
			nav:true,
			autoplay:false,
			smartSpeed:3000,
			navText: ["<i class='fa fa-arrow-circle-o-left'></i>","<i class='fa fa-arrow-circle-o-right'></i>"],
			responsive:{
				0:{
					items:1
				},
				600:{
					items:2
				},
				768:{
					items:3
				},
				
				992:{
					items:1
				},
				1000:{
					items:1
				}
			}
		})	
		 
		 /* BESTSELER-PRODUCT-ALL ACTIVE JS*/
		 $('.best-product-all').owlCarousel({
			loop:true,
			margin:10,
			nav:true,
			autoplay:false,
			smartSpeed:3000,
			navText: ["<i class='fa fa-arrow-circle-o-left'></i>","<i class='fa fa-arrow-circle-o-right'></i>"],
			responsive:{
				0:{
					items:1
				},
				600:{
					items:1
				},
				768:{
					items:3
				},
				
				992:{
					items:1
				},
				1000:{
					items:1
				}
			}
		})
		
		/* FEATURED-PRODUCT-CORUSOL ACTIVE JS*/
		$('.featured-product-corusol').owlCarousel({
			loop:true,
			//margin:10,
			nav:true,
			autoplay:false,
			smartSpeed:3000,
			navText: ["<i class='fa fa-arrow-circle-o-left'></i>","<i class='fa fa-arrow-circle-o-right'></i>"],
			responsive:{
				0:{
					items:1
				},
				600:{
					items:1
				},
				768:{
					items:3
				},
				1000:{
					items:3
				}
			}
		})
		/* FEATURED-PRODUCT-CORUSOL-home-4 ACTIVE JS*/
		$('.featured-product-corusol-home-4').owlCarousel({
			loop:true,
			//margin:10,
			nav:true,
			autoplay:false,
			smartSpeed:3000,
			navText: ["<i class='fa fa-arrow-left'></i>","<i class='fa fa-arrow-right'></i>"],
			responsive:{
				0:{
					items:1
				},
				600:{
					items:1
				},
				768:{
					items:3
				},
				1000:{
					items:4
				}
			}
		})
		 
		 /* BLOAG-CORUSOL ACTIVE JS*/
		 $('.blog-corusol').owlCarousel({
			loop:true,
			//margin:10,
			nav:true,
			autoplay:false,
			smartSpeed:3000,
			navText: ["<i class='fa fa-arrow-circle-o-left'></i>","<i class='fa fa-arrow-circle-o-right'></i>"],
			responsive:{
				0:{
					items:1
				},
				600:{
					items:1
				},
				768:{
					items:2
				},
				1000:{
					items:2
				}
			}
		})
		/* BLOAG-CORUSOL Home 4 ACTIVE JS*/
		 $('.blog-corusol-4').owlCarousel({
			loop:true,
			//margin:10,
			nav:true,
			autoplay:false,
			smartSpeed:3000,
			navText: ["<i class='fa fa-arrow-circle-o-left'></i>","<i class='fa fa-arrow-circle-o-right'></i>"],
			responsive:{
				0:{
					items:1
				},
				600:{
					items:1
				},
				768:{
					items:1
				},
				1000:{
					items:1
				}
			}
		})
		/* LOGO-CORUSOL ACTIVE JS*/
		 $('.logo-area').owlCarousel({
			loop:false,
			//margin:10,
			nav:true,
			autoplay:false,
			smartSpeed:1500,
			navText: ["<i class='fa fa-arrow-circle-o-left'></i>","<i class='fa fa-arrow-circle-o-right'></i>"],
			responsive:{
				0:{
					items:1
				},
				600:{
					items:2
				},
				768:{
					items:3
				},
				1000:{
					items:5
				}
			}
		})
		
		/* LOGO-CORUSOL Home 4 ACTIVE JS*/
		 $('.logo-area-4').owlCarousel({
			loop:false,
			//margin:10,
			nav:true,
			autoplay:false,
			smartSpeed:3000,
			navText: ["<i class='fa fa-arrow-circle-o-left'></i>","<i class='fa fa-arrow-circle-o-right'></i>"],
			responsive:{
				0:{
					items:1
				},
				600:{
					items:3
				},
				1000:{
					items:4
				}
			}
		})
		/* TOP CETEGORY ACTIVE JS*/
		$('.top-category-menu').owlCarousel({
			loop:true,
			//margin:5,
			nav:true,
			autoplay:false,
			smartSpeed:3000,
			navText: ["<i class='fa fa-arrow-circle-o-left'></i>","<i class='fa fa-arrow-circle-o-right'></i>"],
			responsive:{
				0:{
					items:1
				},
				400:{
					items:2
				},
				600:{
					items:3
				},
				1000:{
					items:5
				}
			}
		})
		/* BLOG_TITLE_CAROSUL ACTIVE JS*/
		 $('.blog_title_carosul').owlCarousel({
			loop:true,
			//margin:10,
			nav:true,
			autoplay:false,
			smartSpeed:3000,
			navText: ["<i class='fa fa-arrow-left'></i>","<i class='fa fa-arrow-right'></i>"],
			responsive:{
				0:{
					items:1
				},
				600:{
					items:1
				},
				1000:{
					items:1
				}
			}
		})
		
	/*---------------------
	  scrollUp
	--------------------- */	
		$.scrollUp({
			scrollText: '<i class="fa fa-angle-up"></i>',
			easingType: 'linear',
			scrollSpeed: 900,
			animation: 'fade'
		});	
		
		
		
		
	});

	/* COUNTDOWN ACTIVE JS*/
	$(function () {
		var austDay = new Date();
		austDay = new Date(austDay.getFullYear() + 1, 1 - 1, 26);
		$('#defaultCountdown').countdown({until: austDay});
		$('#year').text(austDay.getFullYear());
		
		var austDay = new Date();
		austDay = new Date(austDay.getFullYear() + 1, 1 - 1, 26);
		$('#defaultCountdown2').countdown({until: austDay});
		$('#year').text(austDay.getFullYear());
		
		var austDay = new Date();
		austDay = new Date(austDay.getFullYear() + 1, 1 - 1, 26);
		$('#defaultCountdown3').countdown({until: austDay});
		$('#year').text(austDay.getFullYear());
	});

	/*  PRICE FILTER */
	$(function() {
		$( "#slider-range" ).slider({
		  range: true,
		  min: 0,
		  max: 1000,
		  values: [ 5, 800 ],
		  slide: function( event, ui ) {
			$( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
		  }
		});
		$( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
		  " - $" + $( "#slider-range" ).slider( "values", 1 ) );
	  });
	  
	 /*  CHECHOUT PAGE ACCORDION */
	  jQuery('.panel-heading a').on('click', function() {
		$('.panel-heading').removeClass('actives');
		$(this).parents('.panel-heading').addClass('actives');
	});
	
})(jQuery);