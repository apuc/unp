<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusectionsTable extends Migration
{
	const TABLE_NAME = 'menusections';

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

			$table->string('name')->unique();
			$table->string('url')->unique()->nullable();
			$table->boolean('is_enabled');
			$table->unsignedInteger('position')->unique();

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
