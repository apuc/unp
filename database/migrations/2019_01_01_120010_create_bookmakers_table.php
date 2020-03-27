<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookmakersTable extends Migration
{
	const TABLE_NAME = 'bookmakers';

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
			$table->unsignedInteger('external_id')->nullable()->unique();

			$table->string('logo')->nullable();
			$table->string('cover')->nullable();

			$table->unsignedInteger('bonus')->nullable();

			$table->text('announce')->nullable();
			$table->text('description')->nullable();

			$table->string('site')->nullable()->unique();
			$table->string('phone')->nullable()->unique();
			$table->string('email')->nullable()->unique();
			$table->string('address')->nullable()->unique();

			$table->boolean('is_enabled')->nullable();

			$table->string('seo_title')->nullable();
			$table->text('seo_keywords')->nullable();
			$table->text('seo_description')->nullable();

			$table->unsignedInteger('position')->unique();

			// Уникальность
			// Связи
			// Индексы
			$table->index('logo');
			$table->index('cover');
			$table->index('bonus');
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
		Schema::dropIfExists(self::TABLE_NAME);
	}
}
