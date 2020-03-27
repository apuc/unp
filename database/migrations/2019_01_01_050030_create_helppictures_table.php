<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHelppicturesTable extends Migration
{
	const TABLE_NAME = 'helppictures';

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

			$table->unsignedBigInteger('helpquestion_id');

			$table->string('name')->nullable();
			$table->string('picture');

			// Уникальность
			$table->unique(['helpquestion_id', 'picture'], 'uk_helpquestion_picture');

			// Связи
			$table->foreign('helpquestion_id')->references('id')->on('helpquestions')->onDelete('cascade');

			// Индексы
			$table->index('helpquestion_id');
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
			$table->dropForeign(['helpquestion_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
