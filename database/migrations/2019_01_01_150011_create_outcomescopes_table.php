<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutcomescopesTable extends Migration
{
	const TABLE_NAME = 'outcomescopes';

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

			$table->string('slug');
			$table->string('name');

			$table->integer('position');

			$table->text('description')->nullable();

			$table->boolean('is_enabled');

			$table->unsignedInteger('external_id')->nullable();
			$table->string('external_name')->nullable();
			$table->string('external_description')->nullable();

			// Уникальность
			$table->unique(['slug'], 					'uk_slug');
			$table->unique(['name'], 					'uk_name');
			$table->unique(['position'], 				'uk_position');
			$table->unique(['external_id'], 			'uk_external_id');
			$table->unique(['external_description'],	'uk_external_description');
			$table->unique(['external_name'],			'uk_external_name');

			// Индексы
			$table->index(['is_enabled'], 'index_is_enabled');

			// Связи
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
