<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForecastsTable extends Migration
{
	const TABLE_NAME = 'forecasts';

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

			$table->unsignedBigInteger('sport_id');
			$table->unsignedBigInteger('outcome_id')->nullable();
			$table->unsignedBigInteger('bookmaker_id');
			$table->unsignedBigInteger('match_id');
			$table->unsignedBigInteger('user_id');
			$table->unsignedBigInteger('forecaststatus_id');

			$table->unsignedBigInteger('outcometype_id');
			$table->unsignedBigInteger('outcomescope_id');
			$table->unsignedBigInteger('outcomesubtype_id');
			$table->unsignedBigInteger('team_id')->nullable();

			$table->double('rate', 4, 2);
			$table->unsignedInteger('bet');
			$table->timestamp('posted_at')->useCurrent();
			$table->text('description')->nullable();

			// Уникальность
			$table->unique(['user_id', 'match_id', 'outcometype_id'], 'uk_match');

			// Связи
			$table->foreign('sport_id')->references('id')->on('sports')->onDelete('cascade');
			$table->foreign('outcome_id')->references('id')->on('outcomes')->onDelete('set null');
			$table->foreign('bookmaker_id')->references('id')->on('bookmakers')->onDelete('cascade');
			$table->foreign('match_id')->references('id')->on('matches')->onDelete('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('forecaststatus_id')->references('id')->on('forecaststatuses')->onDelete('cascade');

			$table->foreign('outcometype_id')->references('id')->on('outcometypes')->onDelete('cascade');
			$table->foreign('outcomescope_id')->references('id')->on('outcomescopes')->onDelete('cascade');
			$table->foreign('outcomesubtype_id')->references('id')->on('outcomesubtypes')->onDelete('cascade');
			$table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');

			// Индексы
			$table->index('sport_id');
			$table->index('outcome_id');
			$table->index('bookmaker_id');
			$table->index('match_id');
			$table->index('user_id');
			$table->index('forecaststatus_id');
			$table->index('rate');
			$table->index('bet');
			$table->index('posted_at');
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
			$table->dropForeign(['sport_id']);
			$table->dropForeign(['outcome_id']);
			$table->dropForeign(['bookmaker_id']);
			$table->dropForeign(['match_id']);
			$table->dropForeign(['user_id']);
			$table->dropForeign(['forecaststatus_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
