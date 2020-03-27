<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTournamentsTable extends Migration
{
	const TABLE_NAME = 'tournaments';

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
			$table->unsignedBigInteger('gender_id')->nullable();
			$table->unsignedBigInteger('tournamenttype_id')->nullable();

			$table->string('name');
			$table->unsignedInteger('external_id')->nullable()->unique();
			$table->boolean('is_top')->nullable();
			$table->string('logo')->nullable();
			$table->unsignedBigInteger('position')->nullable()->unique();

			// Уникальность
			$table->unique(['sport_id', 'gender_id', 'name'], 'uk_sport_gender_name');

			// Связи
			$table->foreign('sport_id')->references('id')->on('sports')->onDelete('cascade');
			$table->foreign('gender_id')->references('id')->on('genders')->onDelete('cascade');
			$table->foreign('tournamenttype_id')->references('id')->on('tournamenttypes')->onDelete('cascade');

			// Индексы
			$table->index(['is_top'], 'index_is_top');
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
			$table->dropForeign(['gender_id']);
			$table->dropForeign(['tournamenttype_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
