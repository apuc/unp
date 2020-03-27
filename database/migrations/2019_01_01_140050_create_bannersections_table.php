<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannersectionsTable extends Migration
{
	const TABLE_NAME = 'bannersections';

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

			$table->unsignedBigInteger('bannersection_id')->nullable();
			$table->unsignedBigInteger('bannerplace_id');
			$table->unsignedBigInteger('sitesection_id');

			// Уникальность
			$table->unique(['bannerplace_id', 'sitesection_id'], 'uk_bannerplace_sitesection');

			// Связи
			$table->foreign('bannersection_id')->references('id')->on('bannersections')->onDelete('cascade');
			$table->foreign('bannerplace_id')->references('id')->on('bannerplaces')->onDelete('cascade');
			$table->foreign('sitesection_id')->references('id')->on('sitesections')->onDelete('cascade');

			// Индексы
			$table->index('bannersection_id');
			$table->index('bannerplace_id');
			$table->index('sitesection_id');
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
			$table->dropForeign(['bannersection_id']);
			$table->dropForeign(['bannerplace_id']);
			$table->dropForeign(['sitesection_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
