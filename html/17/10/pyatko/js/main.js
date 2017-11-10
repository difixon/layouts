$(document).ready(function() {
    var offset = 500;
    var duration = 500;
    $(window).scroll(function() {
        if ($(this).scrollTop() > offset) {
            $('.back-to-top').fadeIn(duration);
        } else {
            $('.back-to-top').fadeOut(duration);
        }
    });

    $('.back-to-top').click(function(event) {
        event.preventDefault();
        $('html, body').animate({scrollTop: 0}, duration);
        return false;
    })
    var mySwiper = new Swiper ('.swiper-container', {
     // Optional parameters
     nextButton: '.swiper-button-next',
     prevButton: '.swiper-button-prev',
     slidesPerView: 'auto',
     centeredSlides: true,
     paginationClickable: true,
     loop: true
   })
});
$(document).on('click', 'a[href^="#"]', function (event) {
    event.preventDefault();

    $('html, body').animate({
        scrollTop: $($.attr(this, 'href')).offset().top
    }, 500);
});
$(document).ready(function(){

    $(".hamburger-nav").on("click", function(){
        $(".menu").animate({
          height: 'toggle'
        });

    });

});
