jQuery(document).ready(function ($) {
	var qsRegex;
	var filters = [];
	var $grid = $('.isotope').isotope({
		layoutMode: 'fitRows'
	});
	var filterFns = {
		nameFilter: function() {
			return qsRegex ? $(this).find('.shopName').text().match( qsRegex ) : true;
		}
	};
	var lastCatVal;
	var lastRateTypeVal;
	var iso = $grid.data('isotope');
	var $filterCount = $('#filterCount');

	$('#catFilter').on( 'change', function() {
		var filterValue = this.value;
		if ( lastCatVal ) {
			removeFilter( lastCatVal );
			addFilter( filterValue );
		} else {
			addFilter( filterValue );
		}
		lastCatVal = filterValue;
		$grid.isotope({ filter: filters.join('') });
		updateFilterCount();
	});

	$('#rateTypeFilter').on( 'change', function() {
		var filterValue = this.value;

		if ( lastRateTypeVal ) {
			removeFilter( lastRateTypeVal );
			addFilter( filterValue );
		} else {
			addFilter( filterValue );
		}

		lastRateTypeVal = filterValue;
		$grid.isotope({ filter: filters.join('') });
		updateFilterCount();
	});

	var $nameFilter = $('#nameFilter').keyup( debounce( function() {
		var filterValue = 'nameFilter';
		filterValue = filterFns[ filterValue ];
		qsRegex = new RegExp( $('#nameFilter').val(), 'gi' );
		$grid.isotope({ filter: filterValue });
	}, 200 ) );

	function debounce( fn, threshold ) {
	  var timeout;
	  return function debounced() {
		if ( timeout ) {
		  clearTimeout( timeout );
		}
		function delayed() {
		  fn();
		  timeout = null;
		}
		timeout = setTimeout( delayed, threshold || 100 );
	  }
	}

	function addFilter( filter ) {
	  if ( filters.indexOf( filter ) == -1 ) {
		filters.push( filter );
	  }
	}

	function removeFilter( filter ) {
	  var index = filters.indexOf( filter);
	  if ( index != -1 ) {
		filters.splice( index, 1 );
	  }
	}

	function updateFilterCount() {
		$filterCount.html( '(<b>' + iso.filteredItems.length + '</b>)' );
	}
});