/* global _, jQuery, wp */
( function( $, api ) {
	// Site title.
	api( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );

	/**
	 * Override the handler for clicking links in preview to allow history.pushState() to do its thing.
	 *
	 * @param {jQuery.Event} event Event.
	 */
	api.Preview.prototype.handleLinkClick = function handleLinkClick( event ) {
		var link, isInternalJumpLink;
		link = $( event.target );

		// No-op if the anchor is not a link.
		if ( _.isUndefined( link.attr( 'href' ) ) ) {
			return;
		}

		isInternalJumpLink = ( '#' === link.attr( 'href' ).substr( 0, 1 ) );

		// Allow internal jump links to behave normally without preventing default.
		if ( isInternalJumpLink ) {
			return;
		}

		// If the link is not previewable, prevent the browser from navigating to it.
		if ( ! api.isLinkPreviewable( link[0] ) ) {
			wp.a11y.speak( api.settings.l10n.linkUnpreviewable );
			event.preventDefault();
		}
	};

	// Heading Gradient
	api( 'heading_gradient_one', function( value ) {
		value.bind( function( newval ) {
			var gradientOne = 'linear-gradient(to right, ' + newval + ',' + ReactVerseSettings.headingGradientData.two + '  )';
			$( '.site-title, .entry-title a' ).css( 'background-image', gradientOne );
		} );
	} );

	api( 'heading_gradient_two', function( value2 ) {
		value2.bind( function( newVal2 ) {
			var gradientTwo = 'linear-gradient(to right, ' + ReactVerseSettings.headingGradientData.one + ', ' + newVal2 + ' )';
			$( '.site-title, .entry-title a' ).css( 'background-image', gradientTwo );
		} );
	} );

	api('heading_gradient_direction', function( direction ) {
		direction.bind(function ( dir ) {
			var gradientThree = 'linear-gradient(to ' + dir + ', ' + ReactVerseSettings.headingGradientData.one + ', ' + ReactVerseSettings.headingGradientData.two + ' )';
			$('.site-title, .entry-title a').css('background-image', gradientThree);
		});
	});

	// Body Gradient
	api( 'body_gradient_one', function( value ) {
		value.bind( function( newval ) {
			var gradientOne = 'linear-gradient(to right, ' + newval + ',' + ReactVerseSettings.bodyGradientData.two + '  )';
			$( '.site-title, .entry-title a' ).css( 'background-image', gradientOne );
		} );
	} );

	api( 'body_gradient_two', function( value2 ) {
		value2.bind( function( newVal2 ) {
			var gradientTwo = 'linear-gradient(to right, ' + ReactVerseSettings.bodyGradientData.one + ', ' + newVal2 + ' )';
			$( '.site-title, .entry-title a' ).css( 'background-image', gradientTwo );
		} );
	} );

	api('body_gradient_direction', function( direction ) {
		direction.bind(function ( dir ) {
			var gradientThree = 'linear-gradient(to ' + dir + ', ' + ReactVerseSettings.bodyGradientData.one + ', ' + ReactVerseSettings.headingGradientData.two + ' )';
			$('.site-title, .entry-title a').css('background-image', gradientThree);
		});
	});

})(jQuery, wp.customize);
