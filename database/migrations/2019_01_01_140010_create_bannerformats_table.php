<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannerformatsTable extends Migration
{
	const TABLE_NAME = 'bannerformats';

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

			$table->unsignedInteger('width');
			$table->unsignedInteger('height');

			// Уникальность
			$table->unique(['width', 'height'], 'uk_resolution');

			// Связи
			// Индексы
			$table->index('width');
			$table->index('height');
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
