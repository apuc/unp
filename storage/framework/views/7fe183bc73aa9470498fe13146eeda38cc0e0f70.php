<!-- Modal -->
<div class="modal fade" id="ss-crud-<?php echo e($action); ?>-modal">
	<div class="modal-dialog modal-lg" style="transform: none;">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">...</h4>
				<button onclick="ssCRUD().close();" type="button" class="close"><span>&times;</span></button>
			</div>
			<div class="modal-body">
				...
			</div>
			<div class="modal-footer">
				<button onclick="ssCRUD().save();" type="button" class="btn btn-primary"><?php echo app('translator')->get('button.office.' . ($action == 'tpl' ? 'create' : $action)); ?></button>
				<button type="button" onclick="" class="btn btn-primary btn-inverse">Сбросить</button>
			</div>
		</div>
	</div>
</div><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/partial/office/shell/modal-editor.blade.php ENDPATH**/ ?>