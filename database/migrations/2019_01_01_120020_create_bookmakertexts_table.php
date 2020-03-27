<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookmakertextsTable extends Migration
{
	const TABLE_NAME = 'bookmakertexts';

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

			$table->unsignedBigInteger('bookmaker_id');

			$table->string('slug');
			$table->string('name');

			$table->string('picture')->nullable();
			$table->text('announce')->nullable();

			$table->text('content');

			$table->boolean('is_enabled');

			$table->string('seo_title')->nullable();
			$table->text('seo_keywords')->nullable();
			$table->text('seo_description')->nullable();

			// Уникальность
			$table->unique(['bookmaker_id', 'slug'], 'uk_bookmaker_slug');
			$table->unique(['bookmaker_id', 'name'], 'uk_bookmaker_name');

			// Связи
			$table->foreign('bookmaker_id')->references('id')->on('bookmakers')->onDelete('cascade');

			// Индексы
			$table->index('slug');
			$table->index('name');
			$table->index('picture');
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
		Schema::table(self::TABLE_NAME, function (Blueprint $table) {
			$table->dropForeign(['bookmaker_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
