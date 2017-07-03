// External dependencies
import React from 'react';

let Placeholder = React.createClass( {
	render() {
		let placeholderContent;
		if ( 'comments' === this.props.type ) {
			placeholderContent = (
				<p className="placeholder-comment"><span  className="purple-gradient">Loading comments…</span></p>
			);
		} else if ( 'search' === this.props.type ) {
			placeholderContent = (
				<h1 className="entry-title placeholder-title"><span className="purple-gradient">Searching…</span></h1>
			);
		} else {
			placeholderContent = (
				<h1 className="entry-title placeholder-title"><span className="purple-gradient">Loading…</span></h1>
			);
		}

		return (
			<div className="placeholder">
				{ placeholderContent }
			</div>
		);
	}
} );

export default Placeholder;
