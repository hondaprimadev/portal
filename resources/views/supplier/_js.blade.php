<script type="text/javascript">
	$('#branch_id').change(function() {
  		updateQueryStringParam("b", $('#branch_id :selected').val());
		// window.location = myUrl;
		// console.log(myUrl);
	});
	function updateQueryStringParam(key, value) {
    	var baseUrl = [location.protocol, '//', location.host, location.pathname].join(''),
        urlQueryString = document.location.search,
        newParam = key + '=' + value,
        params = '?' + newParam;

	    // If the "search" string exists, then build params from it
	    if (urlQueryString) {

	        updateRegex = new RegExp('([\?&])' + key + '[^&]*');
	        removeRegex = new RegExp('([\?&])' + key + '=[^&;]+[&;]?');

	        if( typeof value == 'undefined' || value == null || value == '' ) { // Remove param if value is empty

	            params = urlQueryString.replace(removeRegex, "$1");
	            params = params.replace( /[&;]$/, "" );

	        } else if (urlQueryString.match(updateRegex) !== null) { 
	        	// If param exists already, update it
	            params = urlQueryString.replace(updateRegex, "$1" + newParam);
	        } else { // Otherwise, add it to end of query string

	            params = urlQueryString + '&' + newParam;
	        }
	    }
    	var iurl = window.history.replaceState({}, "", baseUrl + params);
    	window.location = baseUrl + params;
	};

</script>