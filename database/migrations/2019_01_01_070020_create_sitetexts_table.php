<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitetextsTable extends Migration
{
	const TABLE_NAME = 'sitetexts';

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

			$table->unsignedBigInteger('sitesection_id');

			$table->string('slug');
			$table->string('name');

			$table->string('title')->nullable();
			$table->string('picture')->nullable();
			$table->text('announce')->nullable();

			$table->text('content');

			$table->boolean('is_enabled');

			$table->unsignedBigInteger('position');

			// Уникальность
			$table->unique(['sitesection_id', 'slug'], 		'uk_sitesection_slug');
			$table->unique(['sitesection_id', 'name'], 		'uk_sitesection_name');
			$table->unique(['sitesection_id', 'position'],	'uk_sitesection_position');

			// Связи
			$table->foreign('sitesection_id')->references('id')->on('sitesections')->onDelete('cascade');

			// Индексы
			$table->index('slug');
			$table->index('name');
			$table->index('title');
			$table->index('picture');
			$table->index('is_enabled');
			$table->index('position');
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
			$table->dropForeign(['sitesection_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
