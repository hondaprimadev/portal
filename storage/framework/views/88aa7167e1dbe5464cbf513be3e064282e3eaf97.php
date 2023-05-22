<script type="text/javascript">
		var tableCategory = $("#tableCategory").DataTable({
			"sDom": 'rt',
      		"scrollY":        "50vh",
      		"scrollCollapse": true,
      		"paging":         false
		});	
		$("#searchDtbox").keyup(function() {
        	tableCategory.search($(this).val()).draw() ;
    	});
		$('#tableCategory tbody').on('dblclick', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			}
			else {
				tableCategory.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				var id = $(this).find('#idTableCat').val();
				var name = $(this).find('#nameTableCat').val();
				var dept = $(this).find('#departmentTableCat').val();
				var acc = $(this).find('#accountTableCat').val();
				EditCat(id,name, dept, acc);
			}
		});

		function AddCat() 
		{
			$('#createCatModal').modal("show");
		}
		function EditCat(id, name, dept, acc) 
		{
			$("#editCat").attr('action', '/memo/category/' + id);
			$('#idCat').val(id);
			$("#nameCat").val(name);
			$("#departmentCat").val(dept);
			$("#accountCat").val(acc);
			$("#editCatModal").modal("show");
		}
		function deleteCat() {
			if ($('.checkin').is(':checked')) 
			{
				$('#deleteCatModal').modal("show");
			}
			else
			{
				$('#deleteNoModal').modal("show");
			}
		}
		function DeleteCat()
		{
			$("#formCatDelete").submit();
		}

		$('#account_id').change(function(){
			tableCategory.columns(4).search( this.value ).draw();
		});

		$('#department_id').change(function(){
			tableCategory.columns(3).search( this.value ).draw();
		});
	</script>