<?php $__env->startSection('content'); ?>
	<div class="card-wrap account-forecasts-detail">
		<h2 class="title">Статья</h2>
		<form id="post-form" action="<?php echo e(route('account.post.update', ['post_id' => $post->id])); ?>" method="post" enctype="multipart/form-data" onsubmit="return false;">
			<input type="hidden" name="poststatus_id" value="">
			<?php echo e(csrf_field()); ?>

			<div class="form-group row">
				<label for="name" class="col-md-3 col-form-label">Заголовок <span class="red">*</span></label>
				<div class="col-md-9">
					<input type="text" class="form-control<?php echo e($errors->has('name') ? ' is-invalid' : ''); ?>" name="name" id="name" value="<?php echo e(old('name') ?? $post->name); ?>">
					<?php if($errors->has('name')): ?>
						<div class="invalid-feedback"><?php echo e($errors->first('name')); ?></div>
					<?php endif; ?>
				</div>
			</div>

			<div class="form-group row">
				<label class="col-md-3 col-form-label">Изображение <span class="red">*</span></label>
				<div class="ss-filebrowse col-md-9 d-flex">
					<img src="<?php echo e(asset('preview/80/80/storage/posts/' . $post->picture)); ?>" alt="<?php echo e($post->name); ?>">
					<div class="avatar-act">
						<label for="picture" class="btn btn-light">Загрузить изображение</label>
						<input class="form-control<?php echo e($errors->has('picture') ? ' is-invalid' : ''); ?>" type="file" hidden id="picture" name="picture">
						<?php if($errors->has('picture')): ?>
							<div class="invalid-feedback"><?php echo e($errors->first('picture')); ?></div>
						<?php endif; ?>
					</div>
				</div>
			</div>

			<div class="form-group row">
				<label for="author-img" class="col-md-3 col-form-label">Автор изображения</label>
				<div class="col-md-9">
					<input type="text" class="form-control<?php echo e($errors->has('picture_author') ? ' is-invalid' : ''); ?>" name="picture_author" id="author-img" value="<?php echo e(old('picture_author') ?? $post->picture_author); ?>">
					<?php if($errors->has('picture_author')): ?>
						<div class="invalid-feedback"><?php echo e($errors->first('picture_author')); ?></div>
					<?php endif; ?>
				</div>
			</div>

			<div class="form-group row">
				<label for="announce" class="col-md-3 col-form-label">Краткий анонс <span class="red">*</span></label>
				<div class="col-md-9">
					<textarea class="form-control<?php echo e($errors->has('announce') ? ' is-invalid' : ''); ?>" name="announce" id="announce" rows="5"><?php echo e(old('announce') ?? $post->announce); ?></textarea>
					<?php if($errors->has('announce')): ?>
						<div class="invalid-feedback"><?php echo e($errors->first('announce')); ?></div>
					<?php endif; ?>
				</div>
			</div>

			<div class="form-group">
				<label for="text">Текст <span class="red">*</span></label>
				<div>
					
					<textarea name="content" class="form-control<?php echo e($errors->has('content') ? ' is-invalid' : ''); ?>" id="text" rows="10"><?php echo e(old('content') ?? $post->content); ?></textarea>
					<?php if($errors->has('content')): ?>
						<div class="invalid-feedback"><?php echo e($errors->first('content')); ?></div>
					<?php endif; ?>
				</div>
			</div>

			<div class="form-group row">
				<label for="sport" class="col-md-3 col-form-label">Вид спорта <span class="red">*</span></label>
				<div class="col-md-9">
					<select name="sport_id" class="form-control<?php echo e($errors->has('sport_id') ? ' is-invalid' : ''); ?>" id="sport">
						<option valeu="">-- Выберите вид спорта</option>
						<?php $__currentLoopData = $sports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<option <?php echo ($sport->id == old('sport_id') || $sport->id == $post->sport_id) ? 'selected="selected"' : ''; ?> value="<?php echo e($sport->id); ?>"><?php echo e($sport->name); ?></option>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</select>
					<?php if($errors->has('sport_id')): ?>
						<div class="invalid-feedback"><?php echo e($errors->first('sport_id')); ?></div>
					<?php endif; ?>
				</div>
			</div>

			

			<div class="btn-account-row">
				<?php if($post->poststatus->slug == 'moderation' || $post->poststatus->slug == 'draft'): ?>
					<a href="javascript: void(0);" onclick="submitPost('<?php echo e($poststatusmoderation->id); ?>');" class="btn btn-primary">На проверку</a>
					<a href="javascript: void(0);" onclick="submitPost('<?php echo e($poststatusdraft->id); ?>');" class="btn btn-more">Сохранить черновик</a>
				<?php endif; ?>
				<span>Сохранено в <?php echo e($post->updated_at->format('H:i')); ?></span>
				
				<?php if($post->poststatus->slug == 'draft'): ?>
					<a href="javascript: void(0);" onclick="destroyPost('<?php echo e(route('account.post.destroy', ['post_id' => $post->id])); ?>');" class="btn btn-light mr-0 ml-md-auto"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
				<?php endif; ?>
			</div>
			<script>
				function submitPost(poststatus_id)
				{
					$('#post-form').find("input[name='poststatus_id']").val(poststatus_id);
					$('#post-form').attr('onsubmit', '');
					$('#post-form').submit();
				}

				function destroyPost(route, step)
				{

					if (step === undefined) {
						if (confirm("Вы уверены что хотите удалить эту публикацию?"))
							destroyPost(route, 1);
					}

					if (step === 1)
						$.post(route, {
							'_token': '<?php echo e(csrf_token()); ?>'
						}, function () {
							location.href = '<?php echo e(route('account.post.index')); ?>';
						});
				}
			</script>
		</form>
	</div>

	<section class="text-bottom">
		<p>Если нажать "НА ПРОВЕРКУ", статья сохранится и отправится для проверки модератором. В случае, если она удовлетворяет <a href="<?php echo e(route('site.legal.show', ['document' => 'rules'])); ?>">правилам сайта</a>, она будет опубликована.</p>
		<p>Если нажать "СОХРАНИТЬ ЧЕРНОВИК", статья сохранится и будет видна только Вам.</p>
	</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('partial.site.sidebar.account', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.site.grid.double', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/account/post/edit.blade.php ENDPATH**/ ?>