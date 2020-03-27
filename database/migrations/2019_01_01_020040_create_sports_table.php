<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportsTable extends Migration
{
	const TABLE_NAME = 'sports';

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

			$table->boolean('is_enabled');

			$table->unsignedBigInteger('position')->nullable()->unique();
			$table->boolean('has_odds')->nullable();
			$table->string('icon')->nullable();

			$table->unsignedInteger('external_id')->nullable()->unique();
			$table->string('external_name')->nullable()->unique();

			// Уникальность
			// Связи
			// Индексы
			$table->index(['is_enabled'],	'index_is_enabled');
			$table->index(['has_odds'],		'index_has_odds');
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
