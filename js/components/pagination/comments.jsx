// External dependencies
import React from 'react';
const noop = () => {};

class Pagination extends React.Component {
	propTypes: {
		start: React.PropTypes.number,
		current: React.PropTypes.number,
		end: React.PropTypes.number,
		onNextPage: React.PropTypes.func,
		onPreviousPage: React.PropTypes.func,
	}

	static get defaultProps() {
			return {
			start: 1,
			current: 1,
			onNextPage: noop,
			onPreviousPage: noop
		};
	}

	render() {
		let next = this.props.current + 1;
		let prev = this.props.current - 1;

		return (
			<nav className="navigation comment-navigation clear" role="navigation">
				<div className="nav-links">
					{ ( prev > 0 ) ?
						<div className="nav-previous">
							<a href="#" onClick={ this.props.onPreviousPage }>Older Comments</a>
						</div> :
						null
					}
					{ ( next <= this.props.end ) ?
						<div className="nav-next">
							<a href="#" onClick={ this.props.onNextPage }>Newer Comments</a>
						</div> :
						null
					}
				</div>
			</nav>
		);
	}
}

export default Pagination;
