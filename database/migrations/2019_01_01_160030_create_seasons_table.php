<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeasonsTable extends Migration
{
	const TABLE_NAME = 'seasons';

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

			$table->unsignedBigInteger('tournament_id');

			$table->string('name');
			$table->unsignedInteger('external_id')->nullable()->unique();

			// Уникальность
			$table->unique(['tournament_id', 'name'], 'uk_tournament_name');

			// Связи
			$table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');

			// Индексы
			$table->index('tournament_id');
			$table->index('name');
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
			$table->dropForeign(['tournament_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
