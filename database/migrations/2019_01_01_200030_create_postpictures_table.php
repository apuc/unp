<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostpicturesTable extends Migration
{
	const TABLE_NAME = 'postpictures';

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

			$table->unsignedBigInteger('post_id');

			$table->string('name')->nullable();
			$table->string('picture');

			// Уникальность
			$table->unique(['post_id', 'picture'], 'uk_post_picture');

			// Связи
			$table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');

			// Индексы
			$table->index('post_id');
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
			$table->dropForeign(['post_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
