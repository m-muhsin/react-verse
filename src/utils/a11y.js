// Accessibility helpers

import React from 'react';

/**
 * Toggle a `focus` class on navigation items as they're tabbed through.
 *
 * @param  {FocusEvent}  event  The blur or focus event on each link item.
 */
export function toggleFocus( event ) {
	var self = event.target;

	// Move up through the ancestors of the current link until we hit .main-navigation.
	while ( -1 === self.className.indexOf( 'main-navigation' ) ) {
		// On li elements toggle the class .focus.
		if ( 'li' === self.tagName.toLowerCase() ) {
			if ( -1 !== self.className.indexOf( 'focus' ) ) {
				self.className = self.className.replace( ' focus', '' );
			} else {
				self.className += ' focus';
			}
		}

		self = self.parentElement;
	}
}