<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTournamenttypesTable extends Migration
{
	const TABLE_NAME = 'tournamenttypes';

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

			$table->string('name');

			// Уникальность
			$table->unique(['sport_id', 'name'], 'uk_sport_name');

			// Связи
			$table->foreign('sport_id')->references('id')->on('sports')->onDelete('cascade');

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
			$table->dropForeign(['sport_id']);
		});
	
		Schema::dropIfExists(self::TABLE_NAME);
	}
}
