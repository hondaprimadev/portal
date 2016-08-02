<script type="text/javascript">
  /*dropzone*/
  var myDropzone = new Dropzone(document.body, { 
    // Make the whole body a dropzone
      url: "{{ route('hrd.employee.profile.post') }}",
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
    // picture method
  function deletePicture() {
    var name = $("#profile_text").val();
    $.ajax({
      url: "/profile/delete/"+name,
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