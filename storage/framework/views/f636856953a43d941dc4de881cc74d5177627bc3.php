<script type="text/javascript">
  // Datatables
  var tableUser = $("#tableUser").dataTable();
    $("#searchDtbox").keyup(function() {
      tableUser.fnFilter(this.value);
    });
	/*dropzone*/
	var myDropzone = new Dropzone(document.body, { 
		// Make the whole body a dropzone
    	url: "<?php echo e(route('hrd.employee.profile.post')); ?>",
    	paramName: "profile_picture",
    	createImageThumbnails: false,
    	previewTemplate : '<div style="display:none"></div>',
    	parallelUploads: 20,
    	clickable: ".fileinput-button",
    	// Define the element that should be used as click trigger to select files.
  	});

	myDropzone.on("sending", function(file, xhr, formData){

		console.log('token', $('[name=_token').val());
		console.log('upload started', file);

		$('.progress').show();
		formData.append("_token", $('[name=_token').val());
	});

  	myDropzone.on("totaluploadprogress", function(progress){
    	console.log("progress", progress);
    	$('.progress-bar').width(progress + '%');
    	$('#progress-val').text(progress + '%');
  	});

  	myDropzone.on("queuecomplete", function(progress){
    	$('.progress').hide();
  	});

  	myDropzone.on("success", function(file, response){
  		console.log('url', response.urltemp);
  		console.log('filename', response.filename);
    	$('#profile_img').attr('src', response.urltemp + '?' + new Date().getTime());
    	$('#profile_text').val(response.filename);
    	$( ".btn-upload-profile" ).hide();
  		$( ".btn-delete-profile" ).show();

  	});
  	/*End Dropzone*/

  	//Default variable
  	getNik();

  	// jquery function
  	$( "#nik_auto" ).change(function(){
		  getNik();
    });

    $('#tableUser tbody').on('dblclick', 'tr', function () {
      if ( $(this).hasClass('selected') ) {
        $(this).removeClass('selected');
      }
      else {
        tableUser.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
          
          var id = $(this).find('#idTableUser').val();
          alert(id);
      }
    });

  	function getNik() {
  		if ($('#nik_auto').is(':checked')) 
  		{
  			$.ajax({
  				url: '<?php echo e(route('hrd.employee.get.id')); ?>',
  				success: function(response){
  					$("#nik").val(response);
  					$("#nik").prop('disabled', true);
  				}
  			});
  		}
  		else{
  			$("#nik").val('');
  			$("#nik").prop('disabled', false);
  		}
  	}
	// picture method
	function deletePicture() {
		var name = $("#profile_text").val();
    
  		$.ajax({
  			url: "/hrd/employee/profile/delete/"+name,
  			type: 'DELETE',
  			data:{
  				'_token': $('[name=_token').val(),
  			},
  			success: function(response){
  				console.log('delete picture', response);
  				$( ".btn-upload-profile" ).show();
  				$( ".btn-delete-profile" ).hide();
  				$('#profile_img').attr('src', '');
  				$('#profile_text').val('');
  			}
  		});
	}
</script>