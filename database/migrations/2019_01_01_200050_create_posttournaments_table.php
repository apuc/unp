<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePosttournamentsTable extends Migration
{
	const TABLE_NAME = 'posttournaments';

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
			$table->unsignedBigInteger('tournament_id');

			// Уникальность
			$table->unique(['post_id', 'tournament_id'], 'uk_post_tournament');

			// Связи
			$table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
			$table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');

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
			$table->dropForeign(['tournament_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
