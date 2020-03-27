<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrieftagsTable extends Migration
{
	const TABLE_NAME = 'brieftags';

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

			$table->unsignedBigInteger('brief_id');
			$table->unsignedBigInteger('tag_id');

			// Уникальность
			$table->unique(['brief_id', 'tag_id'], 'uk_brief_tag');

			// Связи
			$table->foreign('brief_id')->references('id')->on('briefs')->onDelete('cascade');
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
			$table->dropForeign(['brief_id']);
			$table->dropForeign(['tag_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
