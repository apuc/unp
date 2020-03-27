<?php $__env->startSection('content'); ?>
	<?php $__env->startComponent('control.office.screen.show'); ?>
		<?php $__env->slot('toolbar'); ?>
			<?php echo $__env->make('control.office.toolbar.back', [
				'url' => route('office.user.index')
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $user)): ?>
				<?php echo $__env->make('control.office.toolbar.edit', [
					'url' => route('office.user.edit', [
						'user' => $user->id
					])
				], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php endif; ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('form'); ?>
			<?php echo $__env->make('control.office.plate.show', [
				'dataset'	=> $user,
				'model'	=> \App\User::class,
				'groups'	=> [
					'properties' => [
						'login',
						'name',
						'role',
						'born_at',
						'email',
						'phone',
						'avatar',
						'about',
						'balance',
						'visited_at',
					],
					'statistics' => [
						'forecasts_count',
						'stat_profit',
						'stat_wins',
						'stat_losses',
						'stat_draws',
						'stat_offer',
						'stat_bet',
						'stat_luck',
						'posts_count',
						'postcomments_count',
						'briefs_count',
						'briefcomments_count',
						'forecastcomments_count',
						'issues_count',
						'answers_count',
						'usersocials_count',
						'notices_count',
						'events_count',
					]
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('tabs'); ?>
			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Forecast::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Post::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Postcomment::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Brief::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Briefcomment::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Forecastcomment::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Issue::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Answer::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Usersocial::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Notice::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Event::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('panels'); ?>
			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $forecasts,
				'model'		=> \App\Forecast::class,
				'fields'	=> [
					'sport',
					'outcome',
					'bookmaker',
					'match',
					'started_at',
					'forecaststatus',
					'rate',
					'bet',
					'posted_at',
					'description',
					'forecastcomments_count',
					'forecastpictures_count',
				],
				'values'  	=> [
					'user_id'			=> $user->id,
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $posts,
				'model'		=> \App\Post::class,
				'fields'	=> [
					'name',
					'sport',
					'poststatus',
					'picture',
					'posted_at',
					'postcomments_count',
					'postpictures_count',
				],
				'values'  	=> [
					'user_id'			=> $user->id,
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $postcomments,
				'model'		=> \App\Postcomment::class,
				'fields'	=> [
					'post',
					'commentstatus',
					'posted_at',
					'message',
				],
				'values'  	=> [
					'user_id'			=> $user->id,
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $briefs,
				'model'		=> \App\Brief::class,
				'fields'	=> [
					'name',
					'sport',
					'briefstatus',
					'picture',
					'posted_at',
					'briefcomments_count',
					'briefpictures_count',
				],
				'values'  	=> [
					'user_id'			=> $user->id,
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $briefcomments,
				'model'		=> \App\Briefcomment::class,
				'fields'	=> [
					'brief',
					'commentstatus',
					'posted_at',
					'message',
				],
				'values'  	=> [
					'user_id'			=> $user->id,
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $forecastcomments,
				'model'		=> \App\Forecastcomment::class,
				'fields'	=> [
					'forecast',
					'commentstatus',
					'posted_at',
					'message',
				],
				'values'  	=> [
					'user_id'			=> $user->id,
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $issues,
				'model'		=> \App\Issue::class,
				'fields'	=> [
					'id',
					'posted_at',
					'issuetype',
					'issuestatus',
					'author',
					'email',
					'message',
					'answers_count',
				],
				'values'  	=> [
					'user_id'			=> $user->id,
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $answers,
				'model'		=> \App\Answer::class,
				'fields'	=> [
					'id',
					'issue',
					'posted_at',
					'message',
				],
				'values'  	=> [
					'user_id'			=> $user->id,
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $usersocials,
				'model'		=> \App\Usersocial::class,
				'fields'	=> [
					'social',
					'account',
				],
				'values'  	=> [
					'user_id'			=> $user->id,
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $notices,
				'model'		=> \App\Notice::class,
				'fields'	=> [
					'posted_at',
					'event',
					'noticetype',
					'noticestatus',
					'message',
				],
				'values'  	=> [
					'user_id'			=> $user->id,
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $events,
				'model'		=> \App\Event::class,
				'fields'	=> [
					'happened_at',
					'action',
					'visitor',
					'params',
					'notices_count',
				],
				'values'  	=> [
					'user_id'			=> $user->id,
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>

	<?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.office.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/user/show.blade.php ENDPATH**/ ?>