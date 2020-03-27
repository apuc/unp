<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForecastpicturesTable extends Migration
{
	const TABLE_NAME = 'forecastpictures';

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

			$table->unsignedBigInteger('forecast_id');

			$table->string('name')->nullable();
			$table->string('picture');

			// Уникальность
			$table->unique(['forecast_id', 'picture'], 'uk_forecast_picture');

			// Связи
			$table->foreign('forecast_id')->references('id')->on('forecasts')->onDelete('cascade');

			// Индексы
			$table->index('forecast_id');
			$table->index('name');
			$table->index('picture');
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
			$table->dropForeign(['forecast_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
