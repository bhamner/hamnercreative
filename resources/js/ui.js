
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
  
   // Animated headline: size the rotating slot to the visible phrase so the
   // loading-bar underline matches the current text width
   const initAnimatedHeadline = async () => {
      const $selector = $('.header-wrapper .selector');
      if (! $selector.length) {
         return;
      }

      if (document.fonts?.ready) {
         await document.fonts.ready;
      }

      const sizeWordsWrapper = () => {
         const $wrapper = $selector.find('.ah-words-wrapper');
         if (! $wrapper.length) {
            return;
         }

         const $visible = $wrapper.find('b.is-visible').first();
         if (! $visible.length) {
            return;
         }

         const $probe = $visible.clone().css({
            position: 'absolute',
            visibility: 'hidden',
            display: 'inline-block',
            left: '-9999px',
            top: 0,
            width: 'auto',
            opacity: 1,
            transform: 'none',
            whiteSpace: 'nowrap',
         }).appendTo($wrapper);

         const width = Math.ceil($probe.outerWidth());
         $probe.remove();

         if (width > 0) {
            $wrapper.css('width', width);
         }
      };

      sizeWordsWrapper();
      $selector.animatedHeadline({ animationType: 'loading-bar' });
      sizeWordsWrapper();

      const wrapperEl = $selector.find('.ah-words-wrapper').get(0);
      if (wrapperEl) {
         new MutationObserver(sizeWordsWrapper).observe(wrapperEl, {
            attributes: true,
            attributeFilter: ['class'],
            subtree: true,
         });
      }

      let resizeTimer;
      $(window).on('resize', () => {
         clearTimeout(resizeTimer);
         resizeTimer = setTimeout(sizeWordsWrapper, 150);
      });
   };

   setTimeout(() => {
      initAnimatedHeadline();
   }, 1000);

   //tinyslider (optional sections)
   if (document.querySelector('.my-slider')) {
      tns({
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
   }

   //swiper
   if (document.querySelector('.swiper')) {
      new Swiper('.swiper', {
         autoplay: {
           delay: 4000,
         },
      });
   }
 
});// end docready
