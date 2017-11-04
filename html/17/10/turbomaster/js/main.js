jQuery(document).ready(function() {
    var offset = 220;
    var duration = 500;
    jQuery(window).scroll(function() {
        if (jQuery(this).scrollTop() > offset) {
            jQuery('.back-to-top').fadeIn(duration);
        } else {
            jQuery('.back-to-top').fadeOut(duration);
        }
    });

    jQuery('.back-to-top').click(function(event) {
        event.preventDefault();
        jQuery('html, body').animate({scrollTop: 0}, duration);
        return false;
    })
    var mySwiper = new Swiper ('.slider-container', {
     // Optional parameters
     nextButton: '.swiper-button-next',
     prevButton: '.swiper-button-prev',
     slidesPerView: 'auto',
     centeredSlides: true,
     paginationClickable: true,
     loop: true
   })
   var mySwiper = new Swiper ('.feed-container', {
    // Optional parameters
    nextButton: '.swiper-button-next',
    prevButton: '.swiper-button-prev',
    slidesPerView: 'auto',
    centeredSlides: true,
    paginationClickable: true,
    loop: true
  })
  var mySwiper = new Swiper ('.proms-container', {
   // Optional parameters
   nextButton: '.swiper-button-next',
   prevButton: '.swiper-button-prev',
   slidesPerView: '2',
   centeredSlides: false,
   paginationClickable: true,
   loop: true
 })
});
function myFunction() {
    var x = document.getElementById("top_nav");
    if (x.className === "collapse navbar-collapse") {
        x.className += " responsive";
    } else {
        x.className = "collapse navbar-collapse";
    }
}
