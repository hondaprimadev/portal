<script type="text/javascript">
	all_total();

	var params = '';
	var branch_id = $('#branch_id :selected').val();
	// Dropzone create
	var dzfilename ='tes';
	var myDropzone = new Dropzone("div#UploadMemo", { 
		// Make the whole body a dropzone
    	url: "{{ route('memo.upload.post') }}",
    	paramName: "upload_memo",
    	uploadMultiple: false,
	    parallelUploads: 100,
	    maxFilesize: 8,
	    previewTemplate : '<div style="display:none"></div>',
	    autoDiscover: false,
	    clickable: ".upload-button",
    	
    	init:function(){
    		var myDropzones = this;
    		
    		$.ajax({
                type: 'POST',
                url: '{{ route('memo.upload.get') }}',
                data: {
                	no_memo: $('[name=memo_no').val(), 
                	_token: $('[name=_token').val()
                },
                dataType: 'html',
                success: function(data){
                	var datas = JSON.parse(data);
                	$.each(datas, function( key, value ) {
                		getFile(value);
  						console.log(value.file_name);
					});
                    // console.log(datas);
                }
            });
    	}
  	});
	
  	myDropzone.on("sending", function(file, xhr, formData){
  		console.log(file);
		console.log('token', $('[name=_token').val());
		console.log('upload started', file);

		formData.append("_token", $('[name=_token').val());
		formData.append("branch_id", $('#branch_id :selected').val());
		formData.append("no_memo",$('[name=memo_no').val());
		$('.dial').knob();
		$('.dial').show();
		$('.upload-button').hide();
	});

  	myDropzone.on("totaluploadprogress", function(progress){
    	$('.dial').val(progress);
  	});

  	myDropzone.on("queuecomplete", function(progress){
    	$('.dial').closest('div').remove();
    	$('.dial').hide();
    	$('.upload-button').show();
  	});

  	myDropzone.on("success", function(file, response){
	    getFile(response);
	    $('.upload-button').show();
	    $('.dial').hide();
  	})
	myDropzone.on("error", function(file, response){
		if (response.error == true) {
			$('.alert-upload').show();
			$("#message-upload").append(response.message);
			return false;
		}
  	});

	$('#supplier_id').select2();
	// get url custom
	$('#company_id').change(function(){
		updateQueryStringParam("branch", "");
		updateQueryStringParam("dept", "");
		updateQueryStringParam("company", $('#company_id :selected').val());
		// window.location = myUrl;
		// console.log(myUrl);
	});

	$('#branch_id').change(function() {
  		updateQueryStringParam("branch", $('#branch_id :selected').val());
		// window.location = myUrl;
		// console.log(myUrl);
	});

	$('#department_id_approval').change(function(){
		updateQueryStringParam("category",null);
		updateQueryStringParam("dept", $('#department_id_approval :selected').val());
		// window.location = myUrl;
		// console.log(myUrl);
	});

	$('#category_id').change(function(){
		updateQueryStringParam("category", $('#category_id :selected').val());
	});

	$('#supplier_type').change(function(){
		getSupplier(this.value, branch_id);
	});

	$('#supplier_id').change(function(){
		var s_id =  this.value;
		var t_id = $('#supplier_type').val();
		getSupplierId(s_id, t_id);
	});

	$(".del_rinc").click(function(){
		var rowCount = $('#tableDetail tr').length;
		var trFam = $(this).closest("tr");

	    if(rowCount > 2)
	    {
			trFam.remove();
			return false;
	    }
	    else{
	    	return false;
	    }
	});

	$(".del_fin").click(function(){
		var rowCount = $('#tableFinance tr').length;
		var trFam = $(this).closest("tr");

	    if(rowCount > 2)
	    {
			trFam.remove();
			return false;
	    }
	    else{
	    	return false;
	    }
	});

	$(".del_rinc_edit").click(function(){
		var rowCount = $('#tableDetail tr').length;
		alert(rowCount);
		var tokenId = $('input[name=_token]').val();
		var id = $(this).closest("tr").find('.id_fam').val();
		var trFam = $(this).closest("tr");
		
	    if (rowCount !=2 && id!='') 
	    {
	    	/*$(this).closest("tr").remove();*/
	    	// $.ajax({
	    	// 	url: '/hrm/hrm/deletefamily/' + id,
	    	// 	type: 'POST',
	    	// 	data:{
	    	// 		'_token': tokenId,
	    	// 		'method': 'DELETE',
	    	// 	},
	    	// 	success: function(response){
	    	// 		trFam.remove();
	    	// 		return false;
	    	// 	}
	    	// });
	    }
	    else if(rowCount!=2 && id=='')
	    {
	    	
			trFam.remove();
			return false;
	    }
	    else
	    {
			return false;
	    }
	});

	// on submit form
	$('#formMemo').submit(function(e){

		if ($("input[name='budget']").val()) {
			var budget = parseFloat($("input[name='budget']").val().replace(/[^0-9-.]/g, ''));
			var amount = parseFloat($("#all_total_detail").val().replace(/[^0-9-.]/g, ''));
			if (amount > budget ) {
				alert('Your budget get to the limit');
				return false;
			}else{
				$(".form-control").prop('disabled',false);
			}
		}else{
			$(".form-control").prop('disabled',false);
		}


	});

	$('.delete-upload').click(function(){
		$(this).closest('li').remove();
		return false;
	});

	function deleteUpload(value, id) {
		$.ajax({
            type: 'DELETE',
            url: '/memo/upload/'+id+'?branch='+$('#branch_id :selected').val(),
            data: {_token: $('[name=_token').val()},
            dataType: 'html',
            success: function(data){
                $(value).closest('li').remove();
            },
            error: function(message){
            	console.log(message);
            	return false;
            }
        });
	}

	function getSupplier(name, branch, edit=''){
		var tokenId = $('input[name=_token]').val();
		if (name) {
			$.ajax({
				url: '{{ route('memo.supplier.all') }}?s='+name+'&b='+branch,
				type: 'GET',
				data:{
					'_token': tokenId,
				},
				success: function(response){
					$('#supplier_id').find('option').remove();
					var s_id = edit;
					$.each(response, function(key, value) {   
     					$('#supplier_id').append($("<option></option>").attr("value",key).text(value)); 
					});
					
					if (edit) {
     					$('#supplier_id').val(edit);
     				}
     				getSupplierId($('#supplier_id').val(), name);
				}
			});
		}
	}
	function getSupplierId(s_id, t_id) {
		var tokenId = $('input[name=_token]').val();
		if(s_id > 0){
			$.ajax({
				url: '{{ route('memo.supplier.get') }}?id='+s_id+'&type='+t_id,
				type: 'GET',
				data: {
					'_token': tokenId,
				},
				success: function(response){
					if (response.type == 'employee') {
						$('#get_supp').html('<table class="table"><tr><td><b>Name</b></td><td>'+response.name+'</td></tr><tr><td><b>Account No.</b></td><td>'+response.bank_account+'</td></tr><tr><td><b>Bank</b></td><td>'+response.bank_name+'</td></tr><tr><td><b>Branch</b></td><td>'+response.bank_branch+'</td></tr></table>');
					}else{
						$('#get_supp').html('<table class="table"><tr><td><b>Name</b></td><td>'+response.account_name+'</td></tr><tr><td><b>Account No.</b></td><td>'+response.account_number+'</td></tr><tr><td><b>Bank</b></td><td>'+response.bank.name+'</td></tr><tr><td><b>Branch</b></td><td>'+response.bank_branch+'</td></tr></table>');
					}
				}
			});
		}
	}

	function addrow()
	{
    	var thisTableId = $(this).parents("table").attr("id");
    	var lastRow = $('#'+'tableDetail' + " tr:last");
    	var newRow = lastRow.clone(true);

	    //append row to this table
	    $('#tableDetail').append(newRow);

	    // clear input
	    $("#tableDetail tr:last .detail-table").val('');

	    var this_id = $("#tableDetail tr:last  .deskrip_detail").attr('id');
	    var this_id1 = $("#tableDetail tr:last .qty_detail").attr('id');
	    var this_id2 = $("#tableDetail tr:last  .amount_detail").attr('id');
	    var this_id3 = $("#tableDetail tr:last  .total_detail").attr('id');

	    $("#tableDetail tr:last td .deskrip_detail").attr('id', this_id + 1);
	    $("#tableDetail tr:last td .qty_detail").attr('id', this_id1 + 1);
	    $("#tableDetail tr:last td .amount_detail").attr('id', this_id2 + 1);
	    $("#tableDetail tr:last td .total_detail").attr('id', this_id3 + 1);
	}

	function addRowFinance()
	{
    	var thisTableId = $(this).parents("table").attr("id");
    	var lastRow = $('#'+'tableFinance' + " tr:last");
    	var newRow = lastRow.clone(true);

	    //append row to this table
	    $('#tableFinance').append(newRow);

	    // clear input
	    $("#tableFinance tr:last .detail-table").val('');

	    var this_id = $("#tableFinance tr:last  .leasing_detail").attr('id');
	    var this_id1 = $("#tableFinance tr:last .total_finance_detail").attr('id');
	    var this_id2 = $("#tableFinance tr:last  .notes_detail").attr('id');

	    $("#tableFinance tr:last td .leasing_detail").attr('id', this_id + 1);
	    $("#tableFinance tr:last td .total_finance_detail").attr('id', this_id1 + 1);
	    $("#tableFinance tr:last td .notes_detail").attr('id', this_id2 + 1);
	}

	function numberFinance(this_id) {
		formatNumber(this_id);

		var thisTableId = $(this_id).parents("table").attr("id");
		var id = $(this_id).closest('tr').find('.total_finance_detail').attr('id');
		
		var id_val = $("#"+id).val();
		var id_num = parseFloat(id_val.replace(/[^0-9-.]/g, ''));

		var sum = 0;
		$('#tableFinance').find('.total_finance_detail').each(function(){
		    var value = $(this).val();
		    var value_num = parseFloat(value.replace(/[^0-9-.]/g, ''));
		    if (!isNaN(value_num)) sum += value_num;
		});
		var num = sum.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1,').split('').reverse().join('').replace(/^[\,]/,'');
		var total = $('#all_total_finance').val(num);

	}

	function number(this_id) {
		formatNumber(this_id);

		var thisTableId = $(this_id).parents("table").attr("id");
		var id = $(this_id).closest('tr').find('.amount_detail').attr('id');
		var id2 = $(this_id).closest('tr').find('.qty_detail').attr('id');
		var id3 = $(this_id).closest('tr').find('.total_detail').attr('id');
		
		var id_val = $("#"+id).val();
		var id_num = parseFloat(id_val.replace(/[^0-9-.]/g, ''));

		var id_val2 = $("#"+id2).val();
		var id_num2 = parseFloat(id_val2.replace(/[^0-9-.]/g, ''));

		var cont = id_num * id_num2;
		var num = cont.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1,').split('').reverse().join('').replace(/^[\,]/,'');
		
		$("#"+id3).val(num);
		all_total();
		
    }

    function formatNumber(input)
	{
        var num = input.value.replace(/\,/g,'');
        if(!isNaN(num))
        {
            if(num.indexOf('.') > -1)
            {
                num = num.split('.');
                num[0] = num[0].toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1,').split('').reverse().join('').replace(/^[\,]/,'');
                if(num[1].length > 2)
                {
                    alert('You may only enter two decimals!');
                    num[1] = num[1].substring(0,num[1].length-1);
                }
                input.value = num[0]+'.'+num[1];
            }
            else
            {
                input.value = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1,').split('').reverse().join('').replace(/^[\,]/,'');
            }
        }
        else
        {
            alert('You may only enter decimals!');
            input.value = input.value.substring(0,input.value.length-1);
        }
    }

    function all_total() {
		var sum = 0;
		$('#tableDetail').find('.total_detail').each(function(){
		    var value = $(this).val();
		    var value_num = parseFloat(value.replace(/[^0-9-.]/g, ''));
		    if (!isNaN(value_num)) sum += value_num;
		});
		var num = sum.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1,').split('').reverse().join('').replace(/^[\,]/,'');
		var total = $('#all_total_detail').val(num);
    }

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

	function get_mime(file) {
		switch(file) {
    	case 'image/jpeg':
        	return '<i class="fa fa-file-image-o fa-blue" aria-hidden="true"></i>';
        	break;
        case ' image/png':
        	return '<i class="fa fa-file-image-o fa-blue" aria-hidden="true"></i>';
        	break;
    	case 'application/octet-stream':
        	return '<i class="fa fa-file-excel-o fa-green" aria-hidden="true"></i>';
        	break;
        case 'application/CDFV2-corrupt':
        	return '<i class="fa fa-file-excel-o fa-green" aria-hidden="true"></i>';
        	break;
        case 'application/pdf':
        	return '<i class="fa fa-file-pdf-o fa-red" aria-hidden="true"></i>'

        case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
        	return '<i class="fa fa-file-word-o fa-blue" aria-hidden="true"></i>';
        	break;
        case 'application/vnd.ms-excel':
        	return '<i class="fa fa-file-word-o fa-blue" aria-hidden="true"></i>';
        	break;
    	default:
        	return '<i class="fa fa-file-o" aria-hidden="true"></i>';
		}
	}
	function getFile(value) {
		var markup =$('<li><a href="/memo/upload/show/'+value.file_name+'?branch='+value.branch_id+'" target="_blank">'+get_mime(value.file_type)+value.file_name+'</a><span class="pull-right"><a onclick="deleteUpload(this, '+value.id+')"><i class="fa fa-times fa-red" aria-hidden="true"></i></a></span></li>');
		$("#UploadMemo ul").append(markup);
	}
</script>