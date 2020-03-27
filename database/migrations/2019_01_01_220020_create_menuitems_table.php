<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuitemsTable extends Migration
{
	const TABLE_NAME = 'menuitems';

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

			$table->unsignedBigInteger('menusection_id');

			$table->string('name');
			$table->string('url');
			$table->boolean('is_enabled');
			$table->unsignedBigInteger('position');

			// Уникальность
			$table->unique(['menusection_id', 'name'], 		'uk_menusection_name');
			$table->unique(['menusection_id', 'url'],		'uk_menusection_url');
			$table->unique(['menusection_id', 'position'],	'uk_menusection_position');

			// Связи
			$table->foreign('menusection_id')->references('id')->on('menusections')->onDelete('cascade');

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
		Schema::table(self::TABLE_NAME, function (Blueprint $table) {
			$table->dropForeign(['menusection_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
