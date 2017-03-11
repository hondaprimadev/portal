<script type="text/javascript">
		var tableAccount = $("#tableAccount").DataTable({
			"sDom": 'rt',
      		"scrollY":        "50vh",
      		"scrollCollapse": true,
      		"paging":         false
		});	
		$("#searchJournalbox").keyup(function() {
        	tableAccount.search($(this).val()).draw() ;
    	});
		$('#tableAccount tbody').on('dblclick', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			}
			else {
				tableAccount.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				var id = $(this).find('#idTableAccount').val();
				var name = $(this).find('#nameTableAccount').val();
				EditAccount(id,name);
			}
		});

		function AddAccount() 
		{
			$('#createAccountModal').modal("show");
		}
		function EditAccount (id, name) 
		{
			$("#editAccount").attr('action', '/memo/account/' + id);
			$('#idAccount').val(id);
			$("#nameAccount").val(name);

			$("#editAccountModal").modal("show");
		}
		function deleteAccount() {
			if ($('.checkin').is(':checked')) 
			{
				$('#deleteAccountModal').modal("show");
			}
			else
			{
				$('#deleteNoModal').modal("show");
			}
		}
		function DeleteAccount(id)
		{
			$("#formAccountDelete").submit();
		}

		$('#account_id').change(function(){
			tableCategory.columns(4).search( this.value ).draw();
		});

		$('#department_id').change(function(){
			tableCategory.columns(3).search( this.value ).draw();
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

			  if( typeof value == 'undefined' || value == null || value == '' ) { 
			  	// Remove param if value is empty
			    params = urlQueryString.replace(removeRegex, "$1");
			    params = params.replace( /[&;]$/, "" );

			  } else if (urlQueryString.match(updateRegex) !== null) { 
				// If param exists already, update it
			    params = urlQueryString.replace(updateRegex, "$1" + newParam);
			  } else { 
			  	// Otherwise, add it to end of query string
				params = urlQueryString + '&' + newParam;
			  }
			}
			var iurl = window.history.replaceState({}, "", baseUrl + params);
			window.location = baseUrl + params;
    };
	</script>