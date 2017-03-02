// Load in the babel (es6) polyfill
import 'babel-polyfill';

import React from 'react';
import { render } from 'react-dom';

// Load the CSS
require( '../sass/style.scss' );

function renderApp() {
    render(
        (
            <Hello />
        ),
        document.getElementById( 'main' )
    );
}

class Hello extends React.Component {
    render() {
		return (
			<div className="placeholder">
				<p>This content is loaded through React.</p>
			</div>
        );
    }
}

document.addEventListener( 'DOMContentLoaded', function() {
	renderApp();
} );