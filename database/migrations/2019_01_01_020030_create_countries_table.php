<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration
{
	const TABLE_NAME = 'countries';

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

			$table->string('slug')->unique();
			$table->string('name')->unique();
			$table->string('flag')->nullable();

			$table->boolean('is_enabled');

			$table->unsignedInteger('external_id')->nullable()->unique();
			$table->string('external_name')->nullable()->unique();

			// Уникальность
			// Связи

			// Индексы
			$table->index('is_enabled');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */

	public function down()
	{
		Schema::dropIfExists(self::TABLE_NAME);
	}
}
