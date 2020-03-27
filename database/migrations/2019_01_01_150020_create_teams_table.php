<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
	const TABLE_NAME = 'teams';

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
			$table->unsignedBigInteger('country_id');
			$table->unsignedBigInteger('gender_id');

			$table->string('name');
			$table->unsignedInteger('external_id')->nullable()->unique();
			$table->string('logo')->nullable();

			// Уникальность

			// Связи
			$table->foreign('sport_id')->references('id')->on('sports')->onDelete('cascade');
			$table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
			$table->foreign('gender_id')->references('id')->on('genders')->onDelete('cascade');

			// Индексы
			$table->index('gender_id');
			$table->index('sport_id');
			$table->index('country_id');
			$table->index('name');
			$table->index('logo');
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
			$table->dropForeign(['country_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
