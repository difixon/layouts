$(document).ready(function ($) {

  $('#fullpage').fullpage({
    anchors: ['slide-0', 'slide-2', 'slide-3', 'slide-4', 'slide-5', 'slide-6'],
    menu: '#menu, #menu-2',
	responsiveWidth: 959,
	responsiveHeight: 300,
	responsiveSlides: true,
    onLeave: function (index, nextIndex, direction) {
      if (nextIndex > 1) {
        $('.mouse').addClass('click');
        setTimeout(function () {
          $('.header').removeClass('first-slide');
          $('.bottom').removeClass('first-slide');
        }, 700)
      } else {
        $('.header').addClass('first-slide');
        $('.bottom').addClass('first-slide');
        $('.mouse').removeClass('click');

      }
    }
  });

  $('.header .number')
    .textillate({
      loop: true,
      initialDelay: 1000,
      in: {effect: 'pulse'},
      out:{effect: 'pulse'}
    });

  //btn-menu
  $('.btn-menu').on('click', function (e) {
    e.preventDefault();
    $(this).toggleClass('active');
    $('#menu-2').toggleClass('active');
  });

  $('.btn-subslide').on('click', function (e) {
    e.preventDefault();
    var subslide = $(this).data('subslide');
    $('#menu, .header, .bottom').hide();
    $('#' + subslide).addClass('active');
    $.fn.fullpage.setAllowScrolling(false);
  });

  $('.btn-close-subslide').on('click', function (e) {
    e.preventDefault();
    $(this).parents('.subslide').removeClass('active');
    $.fn.fullpage.setAllowScrolling(true);
    $('.header, #menu, .bottom').show();
  });

  $('.accordion').on('click', '.item-title', function (e) {
    e.preventDefault();
    var other = $(this).parents('.item').siblings();
    other.find('.item-body').slideUp();
    other.find('.item-title').removeClass('active');
    $(this).next().slideToggle();
    $(this).toggleClass('active');

  });

  $('#contact-form').find('input, textarea').on('blur', function () {
    if ($(this).val() !== '') {
      $(this).addClass('active');
    } else {
      $(this).removeClass('active');
    }
  });

  $('.link-file').on('click', function (e) {
    e.preventDefault();
    $(this).parents().find(':file').click();
  });

  $('.file :file').on('change', function () {
    $('.link-file').text($(this).val());
  });

  $('.btn-contact').on('click', function (e) {
    e.preventDefault();
    $('#contact-form').addClass('active');
    $.fn.fullpage.setAllowScrolling(false);
  });

  $('.btn-close').on('click', function (e) {
    e.preventDefault();
    $('#contact-form').removeClass('active');
    $.fn.fullpage.setAllowScrolling(true);
  });


  $('.btn-circle-click').on('click', function (e) {
    var that = this;
    $(this).addClass('active');
    setTimeout(function () {
      $(that).removeClass('active');
    }, 300);
  });


});
