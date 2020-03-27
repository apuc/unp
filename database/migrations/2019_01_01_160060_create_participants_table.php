<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipantsTable extends Migration
{
	const TABLE_NAME = 'participants';

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

			$table->unsignedBigInteger('team_id');
			$table->unsignedBigInteger('match_id');

			$table->unsignedInteger('score')->nullable();
			$table->unsignedInteger('external_id')->nullable()->unique();
			$table->unsignedInteger('position')->nullable();

			// Уникальность
			$table->unique(['team_id', 'match_id'],		'uk_team_match');
			$table->unique(['match_id', 'position'],	'uk_position');

			// Связи
			$table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
			$table->foreign('match_id')->references('id')->on('matches')->onDelete('cascade');

			// Индексы
			$table->index('team_id');
			$table->index('match_id');
			$table->index('position');
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
			$table->dropForeign(['team_id']);
			$table->dropForeign(['match_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
