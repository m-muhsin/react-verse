import React from 'react';
import ContentMixin from '../../utils/content-mixin';

const ContactPage = React.createClass({
	mixins: [ ContentMixin ],

	render() {
		const post = this.props.post
		return (
			<div>
				<h1 dangerouslySetInnerHTML={ this.getTitle( post ) } />
				<div className="entry-content col-sm-6" dangerouslySetInnerHTML={ this.getContent( post ) } />
				<div className="col-sm-6">Map here</div>
			</div>
		);
	}
})

export default ContactPage;
