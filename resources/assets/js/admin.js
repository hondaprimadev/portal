$('#check_all').change(function(){
  if ($('#check_all').is(':checked')) {
    $('.checkin').prop('checked', true);
    $('#tableGrid tbody tr').addClass('selected');
  }
  else{
    $('.checkin').removeAttr('checked');
    $('#tableGrid tbody tr').removeClass('selected');
  }
});

$('.checkin').change(function(){
  if ($('.checkin').is(':checked')) {
    $(this).closest('tr').addClass('selected');
  }
  else{
    $(this).closest('tr').removeClass('selected');
  }
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