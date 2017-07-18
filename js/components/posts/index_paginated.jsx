/*global ReactVerseSettings */
// External dependencies
import React from 'react';
import { connect } from 'react-redux';
import DocumentMeta from 'react-document-meta';
import BodyClass from 'react-body-class';
import he from 'he';

// Internal dependencies
import QueryPosts from 'wordpress-query-posts';
import { isRequestingPostsForQuery, getPostsForQuery, getTotalPagesForQuery } from 'wordpress-query-posts/lib/selectors';
import * as customEndpoints from '../../utils/custom-api-endpoints';

// Components
import PostList from './list';
import StickyPostsList from './sticky';
import PostPreview from '../post/preview';
import Pagination from '../pagination/archive';
import Placeholder from '../placeholder';

const Index = React.createClass( {
	getInitialState() {
		return {
			placeholderImage: {}
		}
	},

	componentDidMount() {
		customEndpoints.fetchCustomizerOptions('placeholder_image_url')
		.then(data => {
			this.setState({placeholderImage: data});
		});
	},

	render() {
		if ( !! this.props.previewId ) {
			return (
				<PostPreview id={ this.props.previewId } />
			);
		}

		const posts = this.props.posts;
		const meta = {
			title: he.decode( ReactVerseSettings.meta.title ),
			description: ReactVerseSettings.meta.description,
			canonical: ReactVerseSettings.URL.base,
		};


		return (
			<div className="site-content">
				<DocumentMeta { ...meta } />
				<BodyClass classes={ [ 'home', 'blog' ] } />
				<StickyPostsList />
				<QueryPosts query={ this.props.query } />
				{ this.props.loading ?
					<Placeholder type="posts" /> :
					<PostList posts={ posts } placeholderImage={this.state.placeholderImage}/>
				}
				<Pagination
					path={ this.props.path }
					current={ this.props.page }
					isFirstPage={ 1 === this.props.page }
					isLastPage={ this.props.totalPages === this.props.page } />
			</div>
		);
	}
} );

export default connect( ( state, ownProps ) => {
	let query = {};
	query.sticky = false;
	query.page = ownProps.params.paged || 1;

	let path = ReactVerseSettings.URL.path || '/';
	if ( ReactVerseSettings.frontPage.page ) {
		path += 'page/' + ReactVerseSettings.frontPage.blog + '/';
	}

	const posts = getPostsForQuery( state, query ) || [];
	const requesting = isRequestingPostsForQuery( state, query );
	const previewId = ownProps.location.query.p || ownProps.location.query.page_id;

	return {
		previewId,
		path,
		page: parseInt( query.page ),
		query,
		posts,
		requesting,
		loading: requesting && ! posts.length,
		totalPages: getTotalPagesForQuery( state, query ),
	};
} )( Index );
