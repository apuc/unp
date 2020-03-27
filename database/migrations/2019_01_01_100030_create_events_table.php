<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
	const TABLE_NAME = 'events';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */

	public function up()
	{
		Schema::create(self::TABLE_NAME, function (Blueprint $table) {
			// Поля
			$table->bigIncrements('id');
			$table->timestamps();

			$table->unsignedBigInteger('action_id');
			$table->unsignedBigInteger('user_id');

			$table->timestamp('happened_at')->useCurrent();
			$table->ipAddress('visitor');
			$table->json('params')->nullable();

			// Уникальность
			// Связи
			$table->foreign('action_id')->references('id')->on('actions')->onDelete('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

			// Индексы
			$table->index('action_id');
			$table->index('user_id');
			$table->index('happened_at');
			$table->index('visitor');
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
			$table->dropForeign(['action_id']);
			$table->dropForeign(['user_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
