<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswersTable extends Migration
{
	const TABLE_NAME = 'answers';

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

			$table->unsignedBigInteger('issue_id');
			$table->unsignedBigInteger('user_id');

			$table->timestamp('posted_at')->useCurrent();

			$table->text('message');

			// Уникальность
			// Связи
			$table->foreign('issue_id')->references('id')->on('issues')->onDelete('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
			$table->dropForeign(['issue_id']);
			$table->dropForeign(['user_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
