<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealsTable extends Migration
{
	const TABLE_NAME = 'deals';

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

			$table->unsignedBigInteger('dealtype_id');
			$table->unsignedBigInteger('bookmaker_id');

			$table->string('name');
			$table->string('cover')->nullable();

			$table->string('url')->unique();

			$table->text('description');
			$table->timestamp('started_at')->nullable();
			$table->timestamp('finished_at')->useCurrent();

			$table->string('seo_title')->nullable();
			$table->text('seo_keywords')->nullable();
			$table->text('seo_description')->nullable();

			// Уникальность
			$table->unique(['bookmaker_id', 'name'], 	'uk_bookmaker_name');

			// Связи
			$table->foreign('dealtype_id')->references('id')->on('dealtypes')->onDelete('cascade');
			$table->foreign('bookmaker_id')->references('id')->on('bookmakers')->onDelete('cascade');

			// Индексы
			$table->index('dealtype_id');
			$table->index('bookmaker_id');
			$table->index('name');
			$table->index('cover');
			$table->index('started_at');
			$table->index('finished_at');
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
			$table->dropForeign(['dealtype_id']);
			$table->dropForeign(['bookmaker_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
