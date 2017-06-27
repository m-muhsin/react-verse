// Load in the babel (es6) polyfill
// import 'babel-polyfill';

import React, { Component } from 'react';
import { render } from 'react-dom';
import { Provider } from 'react-redux';
import { Router, Route, browserHistory, applyRouterMiddleware } from 'react-router';
import { syncHistoryWithStore } from 'react-router-redux';
import { useScroll } from 'react-router-scroll';
import { createReduxStore } from './appState.js';

// Accessibility!
import { keyboardFocusReset, toggleFocus } from './utils/a11y';

//Load components
import Index from './components/posts';
import Navigation from './components/navigation';
import NotFound from './components/notfound';

// Load the CSS
require('../sass/style.scss');

// Redux store and history to manage state
const store = createReduxStore();
const history = syncHistoryWithStore(browserHistory, store);
const path = ReactVerseSettings.URL.path || '/';

function renderApp() {
    let siteURL = ReactVerseSettings.URL.path;
    // Add the event Jetpack listens for to initialize various JS features on posts.
    const emitJetpackEvent = () => {
        jQuery(document.body).trigger('post-load');
    }
    const routerMiddleware = applyRouterMiddleware(useScroll(shouldUpdateScroll), keyboardFocusReset('main'));

    render(
        (
            <Provider store={store}>
                <Router history={history} render={routerMiddleware} onUpdate={emitJetpackEvent}>
                    <Route path={siteURL} component={Index} />
                    <Route path="*" component={ NotFound } />
                </Router>
            </Provider>
        ),
        document.getElementById('main')
    );

    if (ReactVerseMenu.enabled) {
        alert('rv');
        render(
            (
                <Provider store={store}>
                    <Navigation />
                </Provider>
            ),
            document.getElementById('site-navigation')
        );
    } else {
        // Run this to initialize the focus JS for PHP-generated menus
        initNoApiMenuFocus();
    }
}

// Callback for `useScroll`, which skips the auto-scrolling on skiplinks
function shouldUpdateScroll(prevRouterProps, { location }) {
    if (location.hash) {
        return false;
    }
    return true;
}

// Initialize keyboard functionality with JS for non-react-build Menus (if the API doesn't exist)
function initNoApiMenuFocus() {
    const container = document.getElementById('site-navigation');
    if (!container) {
        return;
    }

    const menu = container.getElementsByTagName('div')[1];
    // No menu, no need to run the rest.
    if (!menu) {
        return;
    }

    const links = menu.getElementsByTagName('a');
    // Each time a menu link is focused or blurred, toggle focus.
    let i, len;
    for (i = 0, len = links.length; i < len; i++) {
        links[i].addEventListener('focus', toggleFocus, true);
        links[i].addEventListener('blur', toggleFocus, true);
    }

    const button = container.getElementsByTagName('button')[0];
    button.onclick = function () {
        if (-1 !== menu.className.indexOf('menu-open')) {
            menu.className = menu.className.replace(' menu-open', '');
            menu.setAttribute('aria-expanded', 'false');
            button.setAttribute('aria-expanded', 'false');
        } else {
            menu.className += ' menu-open';
            menu.setAttribute('aria-expanded', 'true');
            button.setAttribute('aria-expanded', 'true');
        }
    };
}

document.addEventListener('DOMContentLoaded', function () {
    renderApp();
});