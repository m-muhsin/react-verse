// External dependencies
import React, {Component} from 'react';
import { connect } from 'react-redux';
import DocumentMeta from 'react-document-meta';
import BodyClass from 'react-body-class';
import he from 'he';

// Components
import Placeholder from '../placeholder';

class Index extends Component {
    render() {
		return (
			<div className="placeholder">
				<Placeholder type="posts" />
			</div>
        );
    }
}

export default Index;