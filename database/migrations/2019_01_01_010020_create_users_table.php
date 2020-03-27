<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
	const TABLE_NAME = 'users';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(self::TABLE_NAME, function (Blueprint $table) {
			$table->bigIncrements('id');

			$table->timestamps();

			$table->unsignedBigInteger('role_id');

			$table->string('name')->nullable();
			$table->string('login')->unique();

			$table->string('email')->unique();
			$table->timestamp('email_verified_at')->nullable();

			$table->string('phone')->nullable()->unique();
			$table->timestamp('phone_verified_at')->nullable();

			$table->string('password');
			$table->rememberToken();

			$table->date('born_at')->nullable();
			$table->string('avatar')->nullable();
			$table->integer('balance')->default(0);
			$table->timestamp('visited_at')->useCurrent();

			$table->decimal('stat_profit', 12, 4)->default(0);
			$table->decimal('stat_roi', 12, 4)->default(0);
			$table->unsignedInteger('stat_forecasts')->default(0);
			$table->unsignedInteger('stat_briefs')->default(0);
			$table->unsignedInteger('stat_posts')->default(0);
			$table->unsignedInteger('stat_wins')->default(0);
			$table->unsignedInteger('stat_losses')->default(0);
			$table->unsignedInteger('stat_draws')->default(0);
			$table->decimal('stat_offer', 12, 4)->default(0);
			$table->unsignedInteger('stat_bet')->default(0);
			$table->unsignedInteger('stat_luck')->default(0);
			$table->unsignedInteger('stat_comments')->default(0);

			$table->text('about')->nullable();

			// Уникальность
			// Индексы
			$table->index('role_id');
			$table->index('name');
			$table->index('email_verified_at');
			$table->index('born_at');
			$table->index('avatar');
			$table->index('balance');
			$table->index('visited_at');

			$table->index('stat_profit');
			$table->index('stat_roi');
			$table->index('stat_forecasts');
			$table->index('stat_briefs');
			$table->index('stat_posts');
			$table->index('stat_wins');
			$table->index('stat_losses');
			$table->index('stat_draws');
			$table->index('stat_offer');
			$table->index('stat_bet');
			$table->index('stat_luck');
			$table->index('stat_comments');

			// Связи
			$table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table(self::TABLE_NAME, function (Blueprint $table) {
			$table->dropForeign(['role_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
