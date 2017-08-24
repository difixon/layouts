$(document).ready(function() {

	$('.click-whiteseo').click(function() {
	   $('.drop-whiteseo').slideToggle();
	   $(this).toggleClass('active');

	   return false;
	});

	$("#slides").not('.slick-initialized').slick({
		lazyLoad:'ondemand',
		arrows:true,
		autoplay:false,
		dots:true,
		speed:400,
		infinite:false,
		nextArrow:'<a class="slick-next"></a>',
		prevArrow:'<a class="slick-prev"></a>'
	});

	$(".reviews .feedbacks-list").not('.slick-initialized').slick({
		lazyLoad:'ondemand',
		arrows:true,
		autoplay:false,
		dots:false,
		speed:400,
		slidesToShow:3,
        adaptiveHeight: true,
		infinite:true,
		nextArrow:'<a class="slick-next"></a>',
		prevArrow:'<a class="slick-prev"></a>',
		responsive: [
			{
				breakpoint: 1100,
				settings: {
					centerMode: false,
					slidesToShow: 2
				}
			},
			{
				breakpoint: 740,
				settings: {
					centerMode: false,
					slidesToShow: 1
				}
			}
		]
	});

	$('.list .type').click(function() {
	    $.magnificPopup.close();
		$('.type').removeClass('active');
		$(this).addClass('active');
		$('#mycity').html($(this).data('city')); return false;
	});

	$("#clients").not('.slick-initialized').slick({
		autoplay:true,
		autoplaySpeed:4000,
		dots:false,
		speed:500,
		infinite:true,
		slidesToShow:3,
		slidesToScroll:3,
		nextArrow:'<a class="slick-next"></a>',
		prevArrow:'<a class="slick-prev"></a>',
		responsive: [
			{
				breakpoint:1100,
				settings:{
					centerMode:false,
					slidesToShow:2,
					slidesToScroll:2
				}
			},
			{
				breakpoint:740,
				settings:{
					centerMode:false,
					slidesToShow:1,
					slidesToScroll:1
				}
			}
		]
	});

	$("#fullinfo").not('.slick-initialized').slick({
		autoplay:false,
		dots:true,
		speed:500,
		infinite:true,
		slidesToShow:1,
		nextArrow:'<a class="slick-next"></a>',
		prevArrow:'<a class="slick-prev"></a>'
	});


	$("#cases").not('.slick-initialized').slick({
		arrows:true,
		autoplay:false,
		dots:false,
		speed:400,
		infinite:true,
		nextArrow:'<a class="slick-next"></a>',
		prevArrow:'<a class="slick-prev"></a>',
		adaptiveHeight:true
	});

	$('.menu-xs li a').on('click', function() {
		var n = $(this).data('td');
		var table = $(this).parents('table');
		table.find('td').hide().removeClass('tdselect');
		table.find('td:nth-child(1)').show();
		table.find('td:nth-child(' + n + ')').show().addClass('tdselect');
		$(this).parents('ul').find('li').removeClass('active');
		$(this).parent('li').addClass('active');
		return false;
	});

	$('.count').click(function () {
        $('.step').removeClass('active');
        $(this).closest('.step').addClass('active');
        return false;
    });

	$('.title-step').click(function () {
        $('.step').removeClass('active');
        $(this).closest('.step').addClass('active');

        $('html, body').animate({
            scrollTop: $(this).closest('.step').offset().top
        }, 1000);
        return false;
    });

	$('.step .count').click(function() {
	    $('.step .str').hide();
	});

	$('.first-step .count').click(function() {
	    $('.step .str').show();
	});

	$('.types').click(function() {
	   $('.city-block').show();
	   var id = $(this).attr('id');
	   if (id == 'type1') {
			$('.city-block .type').show();
	   }
	   else {
			$('.city-block .type').hide();
			$('.city-block .city-' + id).show();
	   }
	   $('.types').removeClass('active');
	   $(this).addClass('active');
	   return false;
	});

	$('ul.region-tab-list li a').on('click',function(){
       $('ul.region-tab-list li.active').removeClass('active');
       $(this).parent('li').addClass('active');

       var index = $('ul.region-tab-list li a').index(this);

       $('.region-tab-content.active').removeClass('active');
       $('.region-tab-content').eq(index).addClass('active');

       return false;
    });

	$("#redesignform").validate({
		rules: {
			phone: "required"
		},
		messages: {
			phone: "Укажите свой телефон или email"
		}
	});

	$(".formmodal").magnificPopup({
		type:'inline'
	});


    $("#regseoform").validate({
		rules: {
			email: "required"
		},
		messages: {
			email: "Укажите свой телефон или email"
		},
		submitHandler: function(form) {
			$.post('/forms/regseo.php', $(form).serialize(), function(data) {
				if(data) {
					$.magnificPopup.close();
					$.magnificPopup.open({
						items: {
							src: '<div class="modal modal-result">' + data + '</div>',
							type: 'inline'
						}
					});
					yaCounter36235.reachGoal('Hochu_v_top3');
					$(form).trigger('reset');
				}
			});
		}
	});

});
