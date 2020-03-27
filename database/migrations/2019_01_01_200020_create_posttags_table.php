<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePosttagsTable extends Migration
{
	const TABLE_NAME = 'posttags';

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
			$table->unsignedBigInteger('tag_id');

			// Уникальность
			$table->unique(['post_id', 'tag_id'], 'uk_post_tag');

			// Связи
			$table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
			$table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');

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
		Schema::table(self::TABLE_NAME, function (Blueprint $table) {
			$table->dropForeign(['post_id']);
			$table->dropForeign(['tag_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
