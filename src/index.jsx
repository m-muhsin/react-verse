// Load in the babel (es6) polyfill
import 'babel-polyfill';

import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import { render } from 'react-dom';
import { Router, Route, browserHistory, applyRouterMiddleware } from 'react-router';
import { syncHistoryWithStore } from 'react-router-redux';

import { createReduxStore } from './appState.js';

//Load components
import {Hello} from './components/home';

// Load the CSS
require( '../sass/style.scss' );

// Redux store and history to manage state
const store = createReduxStore();
const history = syncHistoryWithStore( browserHistory, store );

function renderApp() {
    let siteURL = ReactVerseSettings.URL.path;
    console.log(ReactVerseSettings);
    ReactDOM.render(
        (
            <Router history={ history }>
                <Route path={ siteURL } component={Hello} />
            </Router>
        ),
        document.getElementById( 'main' )
    );
}

document.addEventListener( 'DOMContentLoaded', function() {
	renderApp();
} );