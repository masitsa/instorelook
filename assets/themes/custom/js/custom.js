$(document).ready(function() 
{
	//check page width
	var document_width = parseInt($( document ).width());
	if(document_width <= 767)
	{
		$('#collapse-location').removeClass("in");
		$('#collapse-latest-sellers').removeClass("in");
		$('#collapse-brands').removeClass("in");
		$('#collapse-price-range').removeClass("in");
		$('#collapse-best-sellers').removeClass("in");
	}
	
	$('#owl-recent').owlCarousel({
		loop:true,
		margin:10,
		nav:true,
		responsive:{
			0:{
				items:1
			},
			600:{
				items:3
			},
			1000:{
				items:5
			}
		}
	})
	//Owl Carousel
	var owl = $("#owl-carousel");
 
	owl.owlCarousel({
		items : 10, //10 items above 1824px browser width
		itemsDesktop : [1823,4], //5 items between 1823px and 1024px
		itemsDesktopSmall : [1023,3], // betweem 1023px and 601px
		itemsTablet: [600,2], //2 items between 600 and 0
		itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
	});
	 
	// Custom Navigation Events
	$(".next").click(function(){
		owl.trigger('owl.next');
	})
	$(".prev").click(function(){
		owl.trigger('owl.prev');
	})
	
	//Owl Carousel
	var owl2 = $("#owl-carousel2");
 
	owl2.owlCarousel({
		items : 10, //10 items above 1824px browser width
		itemsDesktop : [1823,4], //5 items between 1823px and 1024px
		itemsDesktopSmall : [1023,3], // betweem 1023px and 601px
		itemsTablet: [600,2], //2 items between 600 and 0
		itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
	});
	 
	// Custom Navigation Events
	$(".next2").click(function(){
		owl2.trigger('owl.next');
	})
	$(".prev2").click(function(){
		owl2.trigger('owl.prev');
	})
});

$("input.alert-danger").change(function() {
	$(this).removeClass('alert-danger');
});

$("textarea.alert-danger").keyup(function() {
	$(this).removeClass('alert-danger');
});

