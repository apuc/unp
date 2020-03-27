<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHelpsectionsTable extends Migration
{
	const TABLE_NAME = 'helpsections';

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
			$table->string('icon')->nullable();

			$table->text('announce')->nullable();
			$table->text('text_header')->nullable();
			$table->text('text_footer')->nullable();

			$table->boolean('is_enabled');

			$table->string('seo_title')->nullable();
			$table->text('seo_keywords')->nullable();
			$table->text('seo_description')->nullable();

			// Уникальность
			// Связи
			// Индексы
			$table->index('is_enabled');
			$table->index('seo_title');
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
