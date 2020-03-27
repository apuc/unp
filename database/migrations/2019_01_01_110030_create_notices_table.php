<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticesTable extends Migration
{
	const TABLE_NAME = 'notices';

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

			$table->unsignedBigInteger('event_id');
			$table->unsignedBigInteger('noticetype_id');
			$table->unsignedBigInteger('noticestatus_id');
			$table->unsignedBigInteger('user_id');

			$table->text('message');

			$table->timestamp('posted_at')->useCurrent();

			// Уникальность
			// Связи
			$table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
			$table->foreign('noticetype_id')->references('id')->on('noticetypes')->onDelete('cascade');
			$table->foreign('noticestatus_id')->references('id')->on('noticestatuses')->onDelete('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

			// Индексы
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
			$table->dropForeign(['event_id']);
			$table->dropForeign(['noticetype_id']);
			$table->dropForeign(['noticestatus_id']);
			$table->dropForeign(['user_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
