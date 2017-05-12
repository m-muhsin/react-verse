// Load in the babel (es6) polyfill
import 'babel-polyfill';

import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import { render } from 'react-dom';

//Load components
import {Hello} from './components/home';

// Load the CSS
require( '../sass/style.scss' );

function renderApp() {
    ReactDOM.render(
        (
            <Hello />
        ),
        document.getElementById( 'main' )
    );
}

document.addEventListener( 'DOMContentLoaded', function() {
	renderApp();
} );