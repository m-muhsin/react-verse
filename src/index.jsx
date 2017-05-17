// Load in the babel (es6) polyfill
import 'babel-polyfill';

import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import { render } from 'react-dom';
// import { Router, Route, Switch } from 'react-router'

//Load components
import {Hello} from './components/home/index';

// Load the CSS
require( '../sass/style.scss' );

function renderApp() {
    ReactDOM.render(
        (
            <Router>
                <Route path="/" component={Hello} />
            </Router>
        ),
        document.getElementById( 'main' )
    );
}

document.addEventListener( 'DOMContentLoaded', function() {
	renderApp();
} );