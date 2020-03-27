<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegaldocumentsTable extends Migration
{
	const TABLE_NAME = 'legaldocuments';

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

			$table->unsignedInteger('position')->unique();
			$table->string('slug')->unique();
			$table->string('name')->unique();
			$table->text('announce')->nullable();

			$table->string('seo_title')->nullable();
			$table->text('seo_keywords')->nullable();
			$table->text('seo_description')->nullable();

			// Уникальность
			// Связи
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
		Schema::dropIfExists(self::TABLE_NAME);
	}
}
