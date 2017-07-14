// External dependencies
import React from 'react';

// Internal dependencies
import Post from './single';

const PostList = React.createClass( {
	propTypes: {
		posts: React.PropTypes.array.isRequired,
		shouldShowEmpty: React.PropTypes.bool,
		error: React.PropTypes.string,
		placeholderImage: React.PropTypes.object
	},

	getInitialState() {
	    return {
	      p: [],
	      page: 2,
	      fetchOnce: true,
	      loading: false,
	      infinityScroll: true
	    };
	  },

	getDefaultProps() {
		return {
			shouldShowEmpty: true,
			error: 'It seems we can’t find what you’re looking for. Perhaps searching can help.',
		};
	},

	componentDidMount() {
		let that = this;
		if( this.state.infinityScroll ) {

			document.body.onscroll = function() {
				// console.log(document.querySelector('.last').getBoundingClientRect().top + window.pageYOffset, window.pageYOffset)
				let z = (document.querySelector('.last').getBoundingClientRect().top + window.pageYOffset) - 600
				if( z ) {
					// console.log('scrolling', window.pageYOffset, 'el', z.getBoundingClientRect());
					
					if( z <= window.pageYOffset ) {
						console.log('inside load scrolling', window.pageYOffset, 'el', z);
						if( that.state.fetchOnce ) {
							document.querySelector('.last').innerHTML = 'Loading...';
							fetch(SiteSettings.endpoint + 'wp-json/wp/v2/posts?page=' + that.state.page )
								.then(r => {
									console.log('r', r)
									if(r.status === 400) {
										that.setState({fetchOnce: false})
										return []
									}
									return r.json()
								})
								.then(d => {
									if(!d) return 
									let a = that.state.p;
									console.log(a)
									d.forEach(function(i){
										a.push(i)
									})
									that.setState({p:a})
									that.setState({page: that.state.page + 1})
									document.querySelector('.last').innerHTML = '';
								})
							that.setState({fetchOnce: false})
						}
						
					} else {
						that.setState({fetchOnce: true})
					}
				}
			}	
		}
		
		
		this.setState({p: this.props.posts})

	},

	renderPosts() {

		return this.state.p.map( ( post, i ) => {
			return <Post key={ 'post-' + i } { ...post } placeholderImage={this.props.placeholderImage}/>
		} );
	},

	renderEmpty() {
		if ( ! this.props.shouldShowEmpty ) {
			return null;
		}

		return (
			<article className="entry">
				<h2 className="entry-title"><span>Nothing Found</span></h2>

				<div className="featured-image col-sm-4"></div>

				<div className="entry-content col-sm-8">
					<p>{ this.props.error }</p>
				</div>

				<div className="entry-meta"></div>
			</article>
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
				{
					this.props.posts.length ?
					<div className='last'></div> :
					null	
				}
				
			</div>
		);
	}
} );

export default PostList;
