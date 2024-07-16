
DocReady( () => {
 
    //preloader div
    $(".preloader-wrap").delay(1500).fadeOut('slow');

    //scrollto
    $(() => $('a[href*="#"]:not([href="#"])').on('click', function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') 
        && location.hostname == this.hostname) {
          let target = $(this.hash);
          target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
          if (target.length) {
            $('html, body').animate({ scrollTop: target.offset().top }, 1000);
            return false;
          }
        }
    }));

   //navbar 
    $(window).scroll(function() {
      ($(window).scrollTop() >= 200) ? $('.navbar').addClass('inbody') : $('.navbar').removeClass('inbody');
    }); 
  
   //animated headline
   setTimeout(() => {
      $( () => $('.selector').animatedHeadline({ animationType: 'loading-bar' })  );
    }, "1000");
 

   //tinyslider
   let slider = tns({
      container: '.my-slider',
      items: 1,
      slideBy: 'page',
      autoHeight: true,
      controls: false,
      nav: false,
      autoplayButtonOutput: false,
      autoplayTimeout: 5000,
      autoplay: true
     });

   //swiper
    let mySwiper = new Swiper('.swiper', {
       autoplay: {
         delay: 4000,
       },
    });
 
});// end docready
