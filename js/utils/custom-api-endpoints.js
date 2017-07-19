export default {
	fetchCustomizerOptions(key = '') {
		if( !key ) {
			return null;
		}


		return fetch(SiteSettings.endpoint + 'wp-json/reactverse/v1/theme_mod/' + key)
			.then(r => {
				if(r.status === 404) {
					return {}
				}
				return r.json()
			})
			.then(data => {
				return data;
			})
	}
}
