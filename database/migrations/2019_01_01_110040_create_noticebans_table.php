<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticebansTable extends Migration
{
	const TABLE_NAME = 'noticebans';

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

			$table->unsignedBigInteger('noticetype_id');
			$table->unsignedBigInteger('action_id');
			$table->unsignedBigInteger('user_id');

			// Уникальность
			$table->unique(['noticetype_id', 'action_id', 'user_id'], 'uk_noticetype_action_user');

			// Связи
			$table->foreign('noticetype_id')->references('id')->on('noticetypes')->onDelete('cascade');
			$table->foreign('action_id')->references('id')->on('actions')->onDelete('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

			// Индексы
			$table->index('noticetype_id');
			$table->index('action_id');
			$table->index('user_id');
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
			$table->dropForeign(['noticetype_id']);
			$table->dropForeign(['action_id']);
			$table->dropForeign(['user_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
