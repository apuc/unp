<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrieftournamentsTable extends Migration
{
	const TABLE_NAME = 'brieftournaments';

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

			$table->unsignedBigInteger('brief_id');
			$table->unsignedBigInteger('tournament_id');

			// Уникальность
			$table->unique(['brief_id', 'tournament_id'], 'uk_brief_tournament');

			// Связи
			$table->foreign('brief_id')->references('id')->on('briefs')->onDelete('cascade');
			$table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');

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
			$table->dropForeign(['brief_id']);
			$table->dropForeign(['tournament_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
