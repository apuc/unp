<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutcomesTable extends Migration
{
	const TABLE_NAME = 'outcomes';

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

			$table->unsignedBigInteger('match_id');
			$table->unsignedBigInteger('outcometype_id');
			$table->unsignedBigInteger('outcomescope_id');
			$table->unsignedBigInteger('outcomesubtype_id');
			$table->unsignedBigInteger('team_id')->nullable();
			$table->unsignedInteger('external_id')->nullable();

			// Уникальность
			$table->unique('external_id');

			// Индексы
			$table->index(['match_id'],				'index_match');
			$table->index(['outcometype_id'],		'index_outcometype');
			$table->index(['outcomescope_id'],		'index_outcomescope');
			$table->index(['outcomesubtype_id'],	'index_outcomesubtype');
			$table->index(['team_id'],				'index_team');

			// Связи
			$table->foreign('match_id')			->references('id')->on('matches')			->onDelete('cascade');
			$table->foreign('outcometype_id')	->references('id')->on('outcometypes')		->onDelete('cascade');
			$table->foreign('outcomesubtype_id')->references('id')->on('outcomesubtypes')	->onDelete('cascade');
			$table->foreign('outcomescope_id')	->references('id')->on('outcomescopes')		->onDelete('cascade');
			$table->foreign('team_id')			->references('id')->on('teams')				->onDelete('cascade');
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
			$table->dropForeign(['outcometype_id']);
			$table->dropForeign(['outcomesubtype_id']);
			$table->dropForeign(['outcomescope_id']);
			$table->dropForeign(['team_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
