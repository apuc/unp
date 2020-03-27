<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticetemplatesTable extends Migration
{
	const TABLE_NAME = 'noticetemplates';

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
			$table->unsignedBigInteger('noticetype_id');
			$table->unsignedBigInteger('role_id');

			$table->text('message');

			// Уникальность
			$table->unique(['action_id', 'noticetype_id', 'role_id'], 'uk_action_noticetype_role');

			// Связи
			$table->foreign('action_id')->references('id')->on('actions')->onDelete('cascade');
			$table->foreign('noticetype_id')->references('id')->on('noticetypes')->onDelete('cascade');
			$table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

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
			$table->dropForeign(['action_id']);
			$table->dropForeign(['noticetype_id']);
			$table->dropForeign(['role_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
