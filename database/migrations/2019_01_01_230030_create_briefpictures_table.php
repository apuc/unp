<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBriefpicturesTable extends Migration
{
	const TABLE_NAME = 'briefpictures';

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

			$table->string('name')->nullable();
			$table->string('picture');

			// Уникальность
			$table->unique(['brief_id', 'picture'], 'uk_brief_picture');

			// Связи
			$table->foreign('brief_id')->references('id')->on('briefs')->onDelete('cascade');

			// Индексы
			$table->index('brief_id');
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
			$table->dropForeign(['brief_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
