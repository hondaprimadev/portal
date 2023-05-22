<?php /* Delete Modal */ ?>
<div class="modal fade" id="deleteCRMModal" tabindex="-1" role="dialog" aria-labelledby="Delete Supplier">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="CreateMerk">Please Confirm</h4>
			</div>
			<div class="modal-body">
				<p class="lead">
            	<i class="fa fa-question-circle fa-lg"></i>  
            		Are you sure you want to delete this Supplier?
          		</p>
			</div>
			<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            		<button type="submit" class="btn btn-danger" onclick=deleteCrm()><i class="fa fa-times-circle"></i> Yes
			</div>
		</div>
	</div>
</div>