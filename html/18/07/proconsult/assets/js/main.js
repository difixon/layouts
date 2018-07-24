(function() {
    [].slice.call( document.querySelectorAll( 'select.cs-select' ) ).forEach( function(el) {
      new SelectFx(el);
    } );
  })();
  $(document).ready(function () {
     //initialize swiper when document ready
     var mySwiper = new Swiper ('.swiper-container', {
       // Optional parameters
       nextButton: '.carousel-control-next',
       prevButton: '.carousel-control-prev',
       slidesPerView: 'auto',
       paginationClickable: true,
       loop: true
     })
     var mySwiper1 = new Swiper ('.swiper-container1', {
       // Optional parameters
       nextButton: '.carousel-control-next1',
       prevButton: '.carousel-control-prev1',
       slidesPerView: 'auto',
       paginationClickable: true,
       loop: true
     })
   });
