// External dependencies
import React from 'react';
import { Link } from 'react-router';

let Pagination = React.createClass({
	render() {
		if (this.props.isFirstPage && this.props.isLastPage) {
			return null;
		}

		let next, prev;
		next = parseInt( this.props.current ) + 1;
		prev = parseInt( this.props.current ) - 1;

		var links = [];
		for (var i = 1; i <= this.props.totalPages; i++) {
			if (this.props.current === i) {
				links.push(<Link className="active" key={i} to={`${this.props.path}p/${i}`}>{i}</Link>);
			} else {
				links.push(<Link key={i} to={`${this.props.path}p/${i}`}>{i}</Link>);
			}
		}

		return (
			<nav className="navigation posts-navigation clear" role="navigation">
				<div className="nav-links">
					{!this.props.isFirstPage ?
						<div className="nav-previous">
							<Link to={`${this.props.path}p/${prev}`}>&larr;</Link>
						</div> :
						null
					}
					<div className="pagination-pages">
						{links}
					</div>
					{!this.props.isLastPage ?
						<div className="nav-next">
							<Link to={`${this.props.path}p/${next}`}>&rarr;</Link>
						</div> :
						null
					}
				</div>
			</nav>
		);
	}
} );

export default Pagination;
