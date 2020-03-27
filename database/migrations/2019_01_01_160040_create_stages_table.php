<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStagesTable extends Migration
{
	const TABLE_NAME = 'stages';

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

			$table->unsignedBigInteger('season_id');
			$table->unsignedBigInteger('gender_id');
			$table->unsignedBigInteger('country_id');

			$table->string('name');
			$table->unsignedInteger('external_id')->nullable()->unique();

			// Уникальность
			$table->unique(['country_id', 'season_id', 'gender_id', 'name'], 'uk_stage');

			// Связи
			$table->foreign('season_id')	->references('id')->on('seasons')	->onDelete('cascade');
			$table->foreign('gender_id')	->references('id')->on('genders')	->onDelete('cascade');
			$table->foreign('country_id')	->references('id')->on('countries')	->onDelete('cascade');

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
			$table->dropForeign(['season_id']);
			$table->dropForeign(['gender_id']);
			$table->dropForeign(['country_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
