jQuery(function($){

	$('.menu_btn').click(function() {

		$(this).siblings('ul').slideToggle(400, function() {
			if (this.style.display === 'none') {
				$(this).removeAttr('style');
			}
		});

	});

	$('.header_inner .bookmark').click(function(e) {

		e.preventDefault();

		var bookmarkURL = window.location.href;
		var bookmarkTitle = document.title;

		if ('addToHomescreen' in window && window.addToHomescreen.isCompatible) {
			addToHomescreen({autostart: false, startDelay: 0}).show(true);
		} else if (window.sidebar && window.sidebar.addPanel) {
			window.sidebar.addPanel(bookmarkTitle, bookmarkURL, '');
		} else if ((window.sidebar && /Firefox/i.test(navigator.userAgent)) || (window.opera && window.print)) {
			$(this).attr({
				href: bookmarkURL, title: bookmarkTitle, rel: 'sidebar'
			}).off(e);
			return true;
		} else if (window.external && ('AddFavorite' in window.external)) {
			window.external.AddFavorite(bookmarkURL, bookmarkTitle);
		} else {
			alert('Нажмите ' + (/Mac/i.test(navigator.userAgent) ? 'CMD' : 'Ctrl') + ' + D для добавления сайта в закладки.');
		}

		return false;

	});

});