/*global ReactVerseSettings */
// External dependencies
import React from 'react';
import classNames from 'classnames';
import { Link } from 'react-router';

// Internal dependencies
import ContentMixin from '../../utils/content-mixin';

// Components
import Media from '../post/image';

let Post = React.createClass( {
	mixins: [ ContentMixin ],

	render: function() {
		let post = this.props;

		if ( 'attachment' === post.type ) {
			return null;
		}

		let classes = classNames( {
			entry: true
		} );

		let path = post.link.replace( ReactVerseSettings.URL.base, ReactVerseSettings.URL.path );

		const featuredMedia = this.getFeaturedMedia( post );
		return (
			<article id={ `post-${post.id}` } className={ classes }>
				<div className="col-sm-3">
					{ featuredMedia ?
					<Media media={ featuredMedia } parentClass='entry-image' /> :
					null
				}
				</div>
				<div className="col-sm-9">
					<h2 className="entry-title">
						<Link className="purple-gradient" to={ path } rel="bookmark" dangerouslySetInnerHTML={ this.getTitle( post ) } />
					</h2>
					<div className="entry-meta">
						<div className="entry-meta-value">
							<a href={ post.link } rel="bookmark">
								<time className="entry-date published updated" dateTime={ post.date }>{ this.getDate( post ) }</time>
							</a>
						</div>
					</div>
					<div className="entry-content" dangerouslySetInnerHTML={ this.getExcerpt( post ) } />


				</div>
			</article>
		);
	}
} );

export default Post;
