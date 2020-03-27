<?php $__env->startSection('content'); ?>
	<div class="card event-card matches-detail" id="description">
		<div class="card-header">
			<span class="name"><a href="<?php echo e(route('site.match.index')); ?>">Матчи</a> / <a href="<?php echo e(route('site.match.index', ['sport' => $match->stage->season->tournament->sport->slug])); ?>"><?php echo e($match->stage->season->tournament->sport->name); ?></a></span>
			
		</div>
		<div class="card-body text-center">
			<div class="matches-detail__participants">
				<div class="matches-detail__participant">
					<?php if(null !== $match->participants[0]->team->logo): ?>
						<div class="matches-detail__participant-img">
							<img src="<?php echo e(asset('preview/100/100/storage/teams/' . $match->participants[0]->team->logo)); ?>" alt="<?php echo e($match->participants[0]->team->name); ?>">
						</div>
					<?php endif; ?>
					<h3><?php echo e($match->participants[0]->team->name); ?></h3>
				</div>

				<div class="matches-detail__score">
					<?php if(in_array($match->matchstatus->slug, ['finished', 'inprogress'])): ?>
   						<div class="matches-detail__score-1"><?php echo e($match->participants[0]->score); ?></div>
   						<div class="matches-detail__score-2"><?php echo e($match->participants[1]->score); ?></div>
   					<?php endif; ?>
				</div>

				<div class="matches-detail__participant">
					<?php if(null !== $match->participants[1]->team->logo): ?>
						<div class="matches-detail__participant-img">
							<img src="<?php echo e(asset('preview/100/100/storage/teams/' . $match->participants[1]->team->logo)); ?>" alt="<?php echo e($match->participants[1]->team->name); ?>">
						</div>
					<?php endif; ?>
					<h3><?php echo e($match->participants[1]->team->name); ?></h3>
				</div>
			</div>
			<p class="text-uppercase">
				<span><?php echo e($match->stage->season->tournament->name); ?></span>
				&mdash;
				<span><?php echo e($match->stage->season->name); ?></span>
				<?php if(false === mb_strpos(mb_strtolower($match->stage->season->tournament->name), mb_strtolower($match->stage->name))): ?>
					&mdash;
					<span><?php echo e($match->stage->name); ?></span>
				<?php endif; ?>
			</p>
			<p>
				<?php echo e(Moment::asDate($match->started_at)); ?> в <?php echo e($match->started_at->format('H:i')); ?>

			</p>
		</div>
		<div class="card-footer">
			<div class="card-icons">
				
			</div>
			<div class="event-date">
				<div class="text-uppercase"><?php echo e($match->matchstatus->name); ?></div>
				
			</div>
		</div>
	</div>

	<div class="card-wrap">
		<h2 class="title">Коэффициенты</h2>

		<div class="bets-box">
			<div class="nav nav-tabs outcometype-tabs">
				<a class="nav-item nav-link active" id="outcometype-1-tab" data-toggle="tab" href="#outcometype-1" aria-controls="outcometype-1" aria-selected="true">1Х2</a>
				<a class="nav-item nav-link" id="outcometype-2-tab" data-toggle="tab" href="#outcometype-2" aria-controls="outcometype-2" aria-selected="false">1 или 2</a>
				
				<a class="nav-item nav-link" id="outcometype-6-tab" data-toggle="tab" href="#outcometype-6" aria-controls="outcometype-6" aria-selected="false">Двойной шанс</a>
				
				<a class="nav-item nav-link" id="outcometype-9-tab" data-toggle="tab" href="#outcometype-9" aria-controls="outcometype-9" aria-selected="false">Чет/Нечет</a>
				<a class="nav-item nav-link" id="outcometype-10-tab" data-toggle="tab" href="#outcometype-10" aria-controls="outcometype-10" aria-selected="false">Обе забьют?</a>
			</div>
			<div class="tab-content outcometype-content">
				<div class="tab-pane fade show active" id="outcometype-1" aria-labelledby="outcometype-1-tab">
					<div class="nav nav-tabs outcomescope-tabs">
						<a class="nav-item nav-link active" id="outcomescope-1-1-tab" data-toggle="tab" href="#outcomescope-1-1" aria-controls="outcomescope-1-1" aria-selected="true">Осн. время</a>
						<a class="nav-item nav-link" id="outcomescope-1-2-tab" data-toggle="tab" href="#outcomescope-1-2" aria-controls="outcomescope-1-2" aria-selected="false">1-й тайм</a>
						<a class="nav-item nav-link" id="outcomescope-1-3-tab" data-toggle="tab" href="#outcomescope-1-3" aria-controls="outcomescope-1-3" aria-selected="false">2-й тайм</a>
					</div>
					<div class="tab-content">
						<div class="tab-pane fade show active" id="outcomescope-1-1" aria-labelledby="outcomescope-1-1-tab">
							<p class="text-center pb-3 pt-3">Загрузка...</p>
						</div>
						<div class="tab-pane fade" id="outcomescope-1-2" aria-labelledby="outcomescope-1-2-tab">
							<p class="text-center pb-3 pt-3">Загрузка...</p>
						</div>
						<div class="tab-pane fade" id="outcomescope-1-3" aria-labelledby="outcomescope-1-3-tab">
							<p class="text-center pb-3 pt-3">Загрузка...</p>
						</div>
					</div>
				</div>

				<div class="tab-pane fade" id="outcometype-2" aria-labelledby="outcometype-2-tab">
					<div class="nav nav-tabs outcomescope-tabs">
						<a class="nav-item nav-link active" id="outcomescope-2-1-tab" data-toggle="tab" href="#outcomescope-2-1" aria-controls="outcomescope-2-1" aria-selected="true">Осн. время</a>
						<a class="nav-item nav-link" id="outcomescope-2-2-tab" data-toggle="tab" href="#outcomescope-2-2" aria-controls="outcomescope-2-2" aria-selected="false">1-й тайм</a>
						<a class="nav-item nav-link" id="outcomescope-2-3-tab" data-toggle="tab" href="#outcomescope-2-3" aria-controls="outcomescope-2-3" aria-selected="false">2-й тайм</a>
					</div>
					<div class="tab-content">
						<div class="tab-pane fade show active" id="outcomescope-2-1" aria-labelledby="outcomescope-2-1-tab">
							<p class="text-center pb-3 pt-3">Загрузка...</p>
						</div>
						<div class="tab-pane fade" id="outcomescope-2-2" aria-labelledby="outcomescope-2-2-tab">
							<p class="text-center pb-3 pt-3">Загрузка...</p>
						</div>
						<div class="tab-pane fade" id="outcomescope-2-3" aria-labelledby="outcomescope-2-3-tab">
							<p class="text-center pb-3 pt-3">Загрузка...</p>
						</div>
					</div>
				</div>

				<div class="tab-pane fade" id="outcometype-6" aria-labelledby="outcometype-6-tab">
					<div class="nav nav-tabs outcomescope-tabs">
						<a class="nav-item nav-link active" id="outcomescope-6-1-tab" data-toggle="tab" href="#outcomescope-6-1" aria-controls="outcomescope-6-1" aria-selected="true">Осн. время</a>
						<a class="nav-item nav-link" id="outcomescope-6-2-tab" data-toggle="tab" href="#outcomescope-6-2" aria-controls="outcomescope-6-2" aria-selected="false">1-й тайм</a>
						<a class="nav-item nav-link" id="outcomescope-6-3-tab" data-toggle="tab" href="#outcomescope-6-3" aria-controls="outcomescope-6-3" aria-selected="false">2-й тайм</a>
					</div>
					<div class="tab-content">
						<div class="tab-pane fade show active" id="outcomescope-6-1" aria-labelledby="outcomescope-6-1-tab">
							<p class="text-center pb-3 pt-3">Загрузка...</p>
						</div>
						<div class="tab-pane fade" id="outcomescope-6-2" aria-labelledby="outcomescope-6-2-tab">
							<p class="text-center pb-3 pt-3">Загрузка...</p>
						</div>
						<div class="tab-pane fade" id="outcomescope-6-3" aria-labelledby="outcomescope-6-3-tab">
							<p class="text-center pb-3 pt-3">Загрузка...</p>
						</div>
					</div>
				</div>

				<div class="tab-pane fade" id="outcometype-9" aria-labelledby="outcometype-9-tab">
					<div class="nav nav-tabs outcomescope-tabs">
						<a class="nav-item nav-link active" id="outcomescope-9-1-tab" data-toggle="tab" href="#outcomescope-9-1" aria-controls="outcomescope-9-1" aria-selected="true">Осн. время</a>
						<a class="nav-item nav-link" id="outcomescope-9-2-tab" data-toggle="tab" href="#outcomescope-9-2" aria-controls="outcomescope-9-2" aria-selected="false">1-й тайм</a>
						<a class="nav-item nav-link" id="outcomescope-9-3-tab" data-toggle="tab" href="#outcomescope-9-3" aria-controls="outcomescope-9-3" aria-selected="false">2-й тайм</a>
					</div>
					<div class="tab-content">
						<div class="tab-pane fade show active" id="outcomescope-9-1" aria-labelledby="outcomescope-9-1-tab">
							<p class="text-center pb-3 pt-3">Загрузка...</p>
						</div>
						<div class="tab-pane fade" id="outcomescope-9-2" aria-labelledby="outcomescope-9-2-tab">
							<p class="text-center pb-3 pt-3">Загрузка...</p>
						</div>
						<div class="tab-pane fade" id="outcomescope-9-3" aria-labelledby="outcomescope-9-3-tab">
							<p class="text-center pb-3 pt-3">Загрузка...</p>
						</div>
					</div>
				</div>

				<div class="tab-pane fade" id="outcometype-10" aria-labelledby="outcometype-10-tab">
					<div class="nav nav-tabs outcomescope-tabs">
						<a class="nav-item nav-link active" id="outcomescope-10-1-tab" data-toggle="tab" href="#outcomescope-10-1" aria-controls="outcomescope-10-1" aria-selected="true">Осн. время</a>
						<a class="nav-item nav-link" id="outcomescope-10-2-tab" data-toggle="tab" href="#outcomescope-10-2" aria-controls="outcomescope-10-2" aria-selected="false">1-й тайм</a>
						<a class="nav-item nav-link" id="outcomescope-10-3-tab" data-toggle="tab" href="#outcomescope-10-3" aria-controls="outcomescope-10-3" aria-selected="false">2-й тайм</a>
					</div>
					<div class="tab-content">
						<div class="tab-pane fade show active" id="outcomescope-10-1" aria-labelledby="outcomescope-10-1-tab">
							<p class="text-center pb-3 pt-3">Загрузка...</p>
						</div>
						<div class="tab-pane fade" id="outcomescope-10-2" aria-labelledby="outcomescope-10-2-tab">
							<p class="text-center pb-3 pt-3">Загрузка...</p>
						</div>
						<div class="tab-pane fade" id="outcomescope-10-3" aria-labelledby="outcomescope-10-3-tab">
							<p class="text-center pb-3 pt-3">Загрузка...</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(function () {
			$('[data-toggle="tooltip"]').tooltip()
		})

		$(document).ready(function () {
			ssOffers().setUrl('<?php echo e(route('site.match.show', ['match' => $match->id])); ?>');

			$("*[id^='outcomescope-']").bind('ss.offers.loaded', function (e, self, content) {
				if (/outcomescope\-[0-9]+\-[0-9]+$/.test($(this).attr('id'))) {
					// группируем контент
					content = $('<div>' + content + '<div>').find('#nav');

					/**
					 * подсвечиваем коэффициенты
					 *
					 */

					(function () {
						var o;
						var types = content.find('.bets-table tr').eq(0).find('.outcomesubtype').length;

						for (var i = 0; i < types; i++) {
							o = null;
							content.find('.bets-table tr').each(function () {
								if ($(this).find('.odds').length == 0)
									return;

								if ($(this).find('.odds span').length == 0)
									return;

								if (
										null === o
									||	parseFloat($(this).find('.odds').eq(i).find('span').text()) > parseFloat(o.find('span').text())
								)
									o = $(this).find('.odds').eq(i);
							});

							if (null !== o)
								o.addClass('odds-max');
						}
					})();

					// подгружаем контент
					$(this).html('<div data-ss-offers-content>' + content.html() + '<div>');
				}
			});

			// авто подгрузка при открытие страницы
			ssOffers('1x2', 'ord').load('#outcomescope-1-1');

			// подгрузка при клике 1х2 первый тайм
			$('#outcomescope-1-2-tab').bind('shown.bs.tab', function () {
				ssOffers('1x2', '1h').load('#outcomescope-1-2');
			});

			// подгрузка при клике 1х2 второй тайм
			$('#outcomescope-1-3-tab').bind('shown.bs.tab', function () {
				ssOffers('1x2', '2h').load('#outcomescope-1-3');
			});

			// подгрузка при клике на таб 1 или 2 (автоматом подгружаем основное время)
			$('#outcometype-2-tab').bind('shown.bs.tab', function () {
				ssOffers('12', 'ord').load('#outcomescope-2-1');
			});

			// подгрузка при клике 1 или 2 первый тайм
			$('#outcomescope-2-2-tab').bind('shown.bs.tab', function () {
				ssOffers('12', '1h').load('#outcomescope-2-2');
			});

			// подгрузка при клике 1 или 2 второй тайм
			$('#outcomescope-2-3-tab').bind('shown.bs.tab', function () {
				ssOffers('12', '2h').load('#outcomescope-2-3');
			});

			// подгрузка при клике на таб ди (автоматом подгружаем основное время)
			$('#outcometype-6-tab').bind('shown.bs.tab', function () {
				ssOffers('dc', 'ord').load('#outcomescope-6-1');
			});

			// подгрузка при клике ди первый тайм
			$('#outcomescope-6-2-tab').bind('shown.bs.tab', function () {
				ssOffers('dc', '1h').load('#outcomescope-6-2');
			});

			// подгрузка при клике ди второй тайм
			$('#outcomescope-6-3-tab').bind('shown.bs.tab', function () {
				ssOffers('dc', '2h').load('#outcomescope-6-3');
			});

			// подгрузка при клике на таб чн (автоматом подгружаем основное время)
			$('#outcometype-9-tab').bind('shown.bs.tab', function () {
				ssOffers('oe', 'ord').load('#outcomescope-9-1');
			});

			// подгрузка при клике чн первый тайм
			$('#outcomescope-9-2-tab').bind('shown.bs.tab', function () {
				ssOffers('oe', '1h').load('#outcomescope-9-2');
			});

			// подгрузка при клике чн второй тайм
			$('#outcomescope-9-3-tab').bind('shown.bs.tab', function () {
				ssOffers('oe', '2h').load('#outcomescope-9-3');
			});

			// подгрузка при клике на таб оз (автоматом подгружаем основное время)
			$('#outcometype-10-tab').bind('shown.bs.tab', function () {
				ssOffers('bts', 'ord').load('#outcomescope-10-1');
			});

			// подгрузка при клике оз первый тайм
			$('#outcomescope-10-2-tab').bind('shown.bs.tab', function () {
				ssOffers('bts', '1h').load('#outcomescope-10-2');
			});

			// подгрузка при клике оз второй тайм
			$('#outcomescope-10-3-tab').bind('shown.bs.tab', function () {
				ssOffers('bts', '2h').load('#outcomescope-10-3');
			});
		});
	</script>

	<?php if($forecasts->count()): ?>
		<div class="card-wrap" id="forecasts">
			<h2 class="title">Прогнозы на матч</h2>

			<?php $__currentLoopData = $forecasts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $forecast): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<div class="cards_list d-none d-md-block">
					<?php echo $__env->make('card.site.forecast.normal', [
						'forecast' => $forecast
					], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

			<!-- для мобилы -->
			<?php $__currentLoopData = $forecasts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $forecast): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<div class="cards_tile d-block d-md-none">
					<?php echo $__env->make('card.site.forecast.normal', [
						'forecast' => $forecast
					], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<!-- end для мобилы -->
		</div>
	<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('partial.site.sidebar.match', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layout.site.grid.double', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/site/match/show.blade.php ENDPATH**/ ?>