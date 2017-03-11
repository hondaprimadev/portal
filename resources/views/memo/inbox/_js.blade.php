<script type="text/javascript">
	var department id = $('#department_id').val();
	alert(department_id);
	var tableUser = $("#tableInbox").DataTable({
      "sDom": 'rt',
      "scrollY":        "50vh",
      "scrollCollapse": true,
      "paging":         false
    });
	
	  $("#searchDtbox").keyup(function() {
        tableInbox.search($(this).val()).draw();
    });

    $('#budget').on('change', function () {
      // tableVs.columns(3).search( this.value ).draw();
      updateQueryStringParam('budget', this.value);
    });

    $('#branch_id').on('change', function () {
      // tableVs.columns(3).search( this.value ).draw();
      updateQueryStringParam('branch', this.value);
    });

    $('#tableInbox tbody').on('dblclick', 'tr', function () {
    	if ( $(this).hasClass('selected') ) {
    		$(this).removeClass('selected');
    	}
    	else {
    		tableInbox.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');
			var id = $(this).find('#idTableInbox').val();
			alert(id)l
    	}
    });


    // daterangepicker
    $('#reportrange').daterangepicker({
      buttonClasses: ['btn', 'btn-sm'],
      applyClass: 'btn-red',
      cancelClass: 'btn-default',
      startDate: '{{ $begin->format('m/d/y') }}',
      endDate: '{{ $end->format('m/d/y') }}',
      locale: {
        applyLabel: 'Submit',
        cancelLabel: 'Cancel',
        fromLabel: 'From',
        toLabel: 'To',
      },
      ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      }
    }, function(start, end, label){
      console.log(start.toISOString(), end.toISOString(), label);

      $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
      // window.location="{{  request()->url() }}?begin="+ start.format('Y-MM-DD') +"&end=" + end.format('Y-MM-DD');
      updateQueryStringParam('begin', start.format('Y-MM-DD'));
      updateQueryStringParam('end', end.format('Y-MM-DD'));

    });
</script>