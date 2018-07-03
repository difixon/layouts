jQuery(document).ready(function ($) {
	var $grid = $('.isotope').isotope({
		layoutMode: 'fitRows'
	});

	var $win = $(window),
		$imgs = $("img");

	function loadVisible($els, trigger) {
		$els.filter(function () {
			var rect = this.getBoundingClientRect();
			return rect.top >= 0 && rect.top <= window.innerHeight;
		}).trigger(trigger);
	}

	$grid.isotope('on', 'layoutComplete', function () {
		loadVisible($imgs, 'lazylazy');
	});

	$win.on('scroll', function () {
		loadVisible($imgs, 'lazylazy');
	});

	$imgs.lazyload({
		effect: "fadeIn",
		failure_limit: Math.max($imgs.length - 1, 0),
		event: 'lazylazy'
	});
});