// External dependencies
import React from 'react';

// Internal dependencies
import Post from './single';
import Placeholder from '../placeholder';

const PostList = React.createClass( {
	propTypes: {
		posts: React.PropTypes.array.isRequired,
		shouldShowEmpty: React.PropTypes.bool,
		error: React.PropTypes.string,
		placeholderImage: React.PropTypes.object
	},


	getDefaultProps() {
		return {
			shouldShowEmpty: true,
			error: 'It seems we can’t find what you’re looking for. Perhaps searching can help.',
		};
	},

	componentDidMount() {

	},

	renderPosts() {

		return this.props.posts.map( ( post, i ) => {
			return <Post key={ 'post-' + i } { ...post } placeholderImage={this.props.placeholderImage}/>
		} );
	},

	renderEmpty() {
		if ( ! this.props.shouldShowEmpty ) {
			return null;
		}

		return (
			<Placeholder type="posts" />
		)
	},

	render() {
		if ( ! this.props.posts ) {
			return null;
		}


		return (
			<div className="site-main">
				{ this.props.posts.length ?
					this.renderPosts() :
					this.renderEmpty()
				}

			</div>
		);
	}
} );

export default PostList;
