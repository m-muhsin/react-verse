import moment from 'moment';

export default {
	getTitle: function( data ) {
		return { __html: data.title.rendered };
	},

	// <a href=${ data.link } class="read-more">Read More <span class="screen-reader-text">${ data.title.rendered }</span></a>
	getExcerpt: function( data ) {
		if ( ! data.excerpt.protected ) {
			if ( 'image' === data.format && ! data.excerpt.rendered ) {
				return { __html: data.content.rendered };
			}
			return { __html: data.excerpt.rendered };
		}

		return { __html: '<p>This content is password-protected.</p>' };
	},

	getContent: function( data ) {
		if ( ! data.content.protected ) {
			return { __html: data.content.rendered };
		}

		return { __html: '<p>This content is password-protected.</p>' };
	},
    
	getDate: function( data ) {
		let date = moment( data.date );
		return date.format( 'MMMM Do YYYY' );
	},
};