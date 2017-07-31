import React from 'react';
import ContentMixin from '../../utils/content-mixin';

const FrontPage = React.createClass({
	mixins: [ ContentMixin ],

	render() {
		const post = this.props.post
		return (
			<div>
				<h1 dangerouslySetInnerHTML={ this.getTitle( post ) } />
				<div className="entry-content" dangerouslySetInnerHTML={ this.getContent( post ) } />
			</div>
		);
	}
})

export default FrontPage;
