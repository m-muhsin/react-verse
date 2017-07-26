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
import NotFound from '../not-found';

const Index = React.createClass( {
	getInitialState() {
		return {
			placeholderImage: {},
			posts: [],
			page: 1,
			fetchOnce: true,
			loading: false,
			initScroll: window.scrollY,
			initFetch: true
		}
	},

	componentDidMount() {

		customEndpoints.fetchCustomizerOptions('placeholder_image_url')
			.then(data => {
				this.setState( { placeholderImage: data } );
			});

		if ( window.scrollY == 0 || ReactVerseSettings.infiniteScroll.infinite_scroll == '0') {
			this.fetchPosts();
			this.setState( { initFetch: false } );
		}


		if (ReactVerseSettings.infiniteScroll.infinite_scroll == '1') {

			this.activateInfinityScroll()
		}

	},

	bottomVisible() {
		const scrollY = window.scrollY
		const visible = document.documentElement.clientHeight
		const pageHeight = document.documentElement.scrollHeight
		const bottomOfPage = visible + scrollY + 10 >= pageHeight
		return bottomOfPage || pageHeight < visible

	},

	activateInfinityScroll() {

		window.addEventListener('scroll', () => {
			if (this.bottomVisible() && this.state.fetchOnce) {

				this.fetchPosts();

			}

		})
	},

	fetchPosts() {

		this.setState({ fetchOnce: false })


		fetch(SiteSettings.endpoint + 'wp-json/wp/v2/posts?sticky=false&page=' + this.state.page + '&_embed=true')
			.then(response => {

				if (response.status === 400) return []

				return response.json()
			})
			.then(data => {

				if (data.length == 0) {

					this.setState({ fetchOnce: false });
					return;
				}


				let postArray = this.state.posts;

				data.forEach(function (item) {

					postArray.push(item);

				});

				this.setState({ posts: postArray });
				this.setState({ page: this.state.page + 1 });
				this.setState({ fetchOnce: true });
			});

	},

	renderPostList(type) {
		if (type == 'paged') {

			if ( this.props.posts.length == 0 ) {
				return <NotFound />
			}

			return (
				<div>
					<PostList loading={this.state.loading} posts={this.props.posts} placeholderImage={this.state.placeholderImage} />
					<Pagination
							path={this.props.path}
							current={this.props.page}
							isFirstPage={1 === this.props.page}
							isLastPage={this.props.totalPages === this.props.page}
							totalPages={this.props.totalPages} />
				</div>
			);
		}

		return (
			<div>
				<PostList posts={this.state.posts} placeholderImage={this.state.placeholderImage} />
				<div className='last'>{(Math.ceil(this.state.posts.length / 10) < this.props.totalPages) && <Placeholder type="posts" />}</div>
			</div>
		);

	},

	render() {

		if (!!this.props.previewId) {
			return (
				<PostPreview id={this.props.previewId} />
			);
		}


		const meta = {
			title: he.decode(ReactVerseSettings.meta.title),
			description: ReactVerseSettings.meta.description,
			canonical: ReactVerseSettings.URL.base,
		};


		return (
			<div className="site-content">
				<DocumentMeta { ...meta } />
				<BodyClass classes={['home', 'blog']} />
				<StickyPostsList />
				<QueryPosts query={this.props.query} />
				{this.state.posts.length === 0 ?
					<Placeholder type="posts" /> :

					ReactVerseSettings.infiniteScroll.infinite_scroll == "0" ?
						this.renderPostList('paged') :
						this.renderPostList('infinity')
				}
			</div>
		);
	}
});

export default connect((state, ownProps) => {
	let query = {};
	query.sticky = false;
	query.page = ownProps.params.paged || 1;

	let path = ReactVerseSettings.URL.path || '/';
	if (ReactVerseSettings.frontPage.page) {
		path += 'page/' + ReactVerseSettings.frontPage.blog + '/';
	}

	const posts = getPostsForQuery(state, query) || [];
	const requesting = isRequestingPostsForQuery(state, query);
	const previewId = ownProps.location.query.p || ownProps.location.query.page_id;

	return {
		previewId,
		path,
		page: parseInt(query.page),
		query,
		posts,
		requesting,
		loading: requesting && !posts.length,
		totalPages: getTotalPagesForQuery(state, query),
	};
})(Index);
