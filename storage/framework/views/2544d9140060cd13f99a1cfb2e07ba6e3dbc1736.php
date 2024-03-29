<script type="text/javascript">
		var tableUser = $("#tableUser").DataTable({
      "sDom": 'rt',
      "scrollY":        "50vh",
      "scrollCollapse": true,
      "paging":         false
    });
		$("#searchDtbox").keyup(function() {
        tableUser.search($(this).val()).draw();
    });
    $('#budget').on('change', function () {
      updateQueryStringParam('budget', this.value);
    });
    $('#branch_id').on('change', function () {
      updateQueryStringParam('branch', this.value);
    });

    $('#tableUser tbody').on('dblclick', 'tr', function () {
    		if ( $(this).hasClass('selected') ) {
    			$(this).removeClass('selected');
    		}
    		else {
    			tableUser.$('tr.selected').removeClass('selected');
          $(this).addClass('selected');
          var id = $(this).find('#idTableApproval').val();
          var category = $(this).find('#categoryTableApproval').val();
          var path = $(this).find('#pathTableApproval').val();
          var branch = $(this).find('#branchTableApproval').val();
          var user = $(this).find('#userTableApproval').val();
          var budget = $(this).find('#budgetTableApproval').val();
          var budget_total = $(this).find('#budgetTotalTableApproval').val();
          var prepayment = $(this).find('#prepaymentTableApproval').val();
          var date1 = $(this).find('#date1TableApproval').val();
          var date2 = $(this).find('#date2TableApproval').val();
          console.log('get: '+id+category+path+branch+user+budget+budget_total+prepayment+date1+date2);
          editSetting(id, category, path, branch, user, budget, budget_total, prepayment, date1, date2);
    		}
    });

    $("#addBudget").on('click', function(){
          $(this).addClass('selected');
          var id = $(this).find('#idTableApproval').val();
          alert(id);
          return false;
          var category = $(this).find('#categoryTableApproval').val();
          var path = $(this).find('#pathTableApproval').val();
          var branch = $(this).find('#branchTableApproval').val();
          var user = $(this).find('#userTableApproval').val();
          var budget = $(this).find('#budgetTableApproval').val();
          var budget_total = $(this).find('#budgetTotalTableApproval').val();
          var prepayment = $(this).find('#prepaymentTableApproval').val();
          var date1 = $(this).find('#date1TableApproval').val();
          var date2 = $(this).find('#date2TableApproval').val();
    });

    // daterangepicker
    $('#reportrange').daterangepicker({
      buttonClasses: ['btn', 'btn-sm'],
      applyClass: 'btn-red',
      cancelClass: 'btn-default',
      startDate: '<?php echo e($begin->format('m/d/y')); ?>',
      endDate: '<?php echo e($end->format('m/d/y')); ?>',
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
      // window.location="<?php echo e(request()->url()); ?>?begin="+ start.format('Y-MM-DD') +"&end=" + end.format('Y-MM-DD');
      updateQueryStringParam('begin', start.format('Y-MM-DD'));
      updateQueryStringParam('end', end.format('Y-MM-DD'));

    });

    function addSetting() {
      $("#createSettingModal").modal("show");
    }

    function editSetting(id, category, path, branch, user, budget, budget_total, prepayment, date1, date2) {
      $("#editApproval").attr('action', '/memo/approval/' + id);
      $("#idApproval").val(id);
      $("#categoryApproval").val(category);
      $("#pathApproval").val(path);
      $("#branchApproval").val(branch);
      $("#userApproval").val(user);
      $("#budget_totalApproval").val(budget_total);
      $("#prepaymentApproval").val(prepayment);
      $("#date1Approval").val(date1);
      $("#date2Approval").val(date2);

      $("#editApprovalModal").modal("show");
    }

    function deleteApproval() {
      if ($('.checkin').is(':checked')) 
      {
        $('#deleteApprovalModal').modal("show");
      }
      else
      {
        $('#deleteNoModal').modal("show");
      }
    }
    function DeleteApproval()
    {
      $("#formApprovalDelete").submit();
    }
</script>