<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookmakerpicturesTable extends Migration
{
	const TABLE_NAME = 'bookmakerpictures';

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

			$table->unsignedBigInteger('bookmakertext_id');

			$table->string('name')->nullable();
			$table->string('picture');

			// Уникальность
			$table->unique(['bookmakertext_id', 'picture'], 'uk_bookmakertext_picture');

			// Связи
			$table->foreign('bookmakertext_id')->references('id')->on('bookmakers')->onDelete('cascade');

			// Индексы
			$table->index('bookmakertext_id');
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
			$table->dropForeign(['bookmakertext_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
