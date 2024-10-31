(function ($) {
	jQuery(window).on('elementor/frontend/init', function(){
		elementorFrontend.hooks.addAction( 'frontend/element_ready/postslider-widget.default', function( $scope ) {
		   const elem = $scope.find('.tc_blog_carousel');
		   const sClass = elem[0].id;
		   const data = elem.attr('slider_settings');
		   const str_data = data.replace(/'/g, '"')
		   const s_options = JSON.parse(str_data);
		   let s_autopaly;
		   let desk_space= parseInt(s_options.desktopSpace); let tab_space = parseInt(s_options.tabletSpace); let mobile_space = parseInt(s_options.mobileSpace)
		   let s_speed = parseInt(s_options.speed);
		   if(s_options.autoplay === 'yes'){
			s_autopaly = {
				 delay: s_options.autoplayDelay,
				 disableOnInteraction: false,
			 }
		   }else{
			s_autopaly = false
		  }
	
		   var swiper = new Swiper("#"+sClass, {
					slidesPerView: s_options.desktop,
					spaceBetween: desk_space,
					loopAdditionalSlides: 100,
					loop: true,
					autoplay: s_autopaly,
					speed: s_speed,
					navigation: {						
						nextEl: '.swiper-button-next',
						prevEl: '.swiper-button-prev',
					},
					pagination: {
						el: '.swiper-pagination',
						type: 'bullets',
						clickable: true,
					},
	
					// Responsive breakpoints
					breakpoints: {
						// when window width is >= 320px
						0: {
						slidesPerView: s_options.mobile,
						spaceBetween: mobile_space,
						},
						// when window width is >= 480px
						600: {
						slidesPerView: s_options.tablet,
						spaceBetween: tab_space,
						},
						// when window width is >= 640px
						1000: {
						slidesPerView: s_options.desktop,
						spaceBetween: desk_space,
						}
					}
	
					});
		  });
	
	});
})(jQuery);