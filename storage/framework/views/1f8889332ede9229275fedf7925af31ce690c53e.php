<?php $__env->startSection('content-header'); ?>
	<section class="content-header">
    <h1>
      <i class="fa fa-newspaper-o"></i> Memos
    </h1>
    <ol class="breadcrumb">
      <li><a href="/memo">Memo</a></li>
      <li class="active">show</li>
    </ol>
  </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <?php /* <?php echo Form::model($memo, ['class'=>'form-horizontal','id'=>'formMemoprocess']); ?> */ ?>
  <form class="form-horizontal">
    <?php echo $__env->make('memo.inbox._form',['stat'=>'show'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="box-footer">
      <a href="<?php echo e(url()->previous()); ?>" class="btn btn-success">
        <i class="fa fa-reply" aria-hidden="true"></i> Back
      </a>
      
      <a href="<?php echo e(route('memo.report.print',$memo->token)); ?>" target="_blank" class="btn btn-success">
        <i class="fa fa-file-pdf-o" aria-hidden="true"></i> Print
      </a>
    </div>
  </form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
  <script type="text/javascript">
    getUpload();

    $('#formMemoprocess').on('keyup keypress', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) { 
        e.preventDefault();
        return false;
      }
    });

    function getUpload(){
      var token = '<?php echo e(csrf_token()); ?>';
      $.ajax({
        type: 'POST',
        url: '<?php echo e(route('memo.upload.get')); ?>',
        data: {
          no_memo: $('[name=memo_no').val(), 
          _token: token,
        },
        dataType: 'html',
          success: function(data){
          var datas = JSON.parse(data);

          $.each(datas, function( key, value ) {

            console.log(value);
            getFile(value);
          });
        }
      });
    }

    function approve(id=<?php echo e($memo->id); ?>) {
      $("#formMemoprocess").attr('action', '/memo/process/approve/' + id);
      $("#formMemoprocess").submit();
    }

    function reject(id=<?php echo e($memo->id); ?>) {
      $("#formMemoprocess").attr('action', '/memo/process/reject/' + id);
      $("#formMemoprocess").submit();
    }

    function revise(id = <?php echo e($memo->id); ?>) {
      $("#formMemoprocess").attr('action', '/memo/process/revise/' + id);
      $("#formMemoprocess").submit();
    }

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
    var markup =$('<li><a href="/memo/upload/show/'+value.file_name+'?branch='+value.branch_id+'" target="_blank">'+get_mime(value.file_type)+value.file_name+'</a><span class="pull-right"></span></li>');
    $("#UploadMemo ul").append(markup);
  }
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>