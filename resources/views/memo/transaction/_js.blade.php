<script type="text/javascript">
  $('#journal_id').on('change', function(){
    updateQueryStringParam('j', this.value);
  });

	$('#branch_id').on('change', function () {
    updateQueryStringParam('b', this.value);
  });
    
  $('#category_id').on('change', function(){
    updateQueryStringParam('c', this.value);
  });

  $('#department_id').on('change', function(){
    updateQueryStringParam('d', this.value);
  });

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