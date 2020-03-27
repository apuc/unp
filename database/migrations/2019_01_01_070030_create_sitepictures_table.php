<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitepicturesTable extends Migration
{
	const TABLE_NAME = 'sitepictures';

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

			$table->unsignedBigInteger('sitetext_id');

			$table->string('name')->nullable();
			$table->string('picture');

			// Уникальность
			$table->unique(['sitetext_id', 'picture'], 'uk_sitetext_picture');

			// Связи
			$table->foreign('sitetext_id')->references('id')->on('sitetexts')->onDelete('cascade');

			// Индексы
			$table->index('sitetext_id');
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
			$table->dropForeign(['sitetext_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
