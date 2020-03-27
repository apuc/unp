<?php $__env->startSection('content'); ?>
	<div class="card-wrap" id="last-activity">
		<h2 class="title">ИСТОРИЯ ПОСЛЕДНЕЙ АКТИВНОСТИ</h2>
		<p>История активности показывает информацию о том, с каких устройств и в какое время Вы входили на сайт. Если Вы подозреваете, что кто-то получил доступ к Вашему профилю, Вы можете в любой момент прекратить эту активность.</p>
		<div class="btn-account-row row-top">
			<a href="#" class="btn btn-primary pl-4 pr-4"><i class="fa fa-times" aria-hidden="true"></i> Завершить все сеансы</a>
		</div>

		<div class="card">
			<div class="table-responsive">
				<table class="table table-sm">
					<tr>
						<th>Дата</th>
						<th>ОС</th>
						<th>Браузер</th>
						<th>IP</th>
						<th>Статус</th>
					</tr>
					<tr>
						<td>10.02.2019 19:10</td>
						<td>Windows</td>
						<td>Chrome</td>
						<td>127.0.0.1</td>
						<td>Онлайн</td>
					</tr>
					<tr>
						<td>09.02.2019 14:30</td>
						<td>Windows</td>
						<td>Chrome</td>
						<td>555.1.34.13</td>
						<td>Завершен</td>
					</tr>
					<tr>
						<td>03.02.2019 11:10</td>
						<td>MAC</td>
						<td>Safari</td>
						<td>123.123.123.123</td>
						<td>Завершен</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('partial.site.sidebar.account', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.site.grid.double', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/account/event/index.blade.php ENDPATH**/ ?>