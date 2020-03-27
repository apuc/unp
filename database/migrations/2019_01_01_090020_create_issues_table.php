<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssuesTable extends Migration
{
	const TABLE_NAME = 'issues';

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

			$table->unsignedBigInteger('user_id')->nullable();
			$table->unsignedBigInteger('issuetype_id');
			$table->unsignedBigInteger('issuestatus_id');

			$table->string('author')->nullable();
			$table->string('email')->nullable();
			$table->text('message');
			$table->timestamp('posted_at')->useCurrent();

			// Уникальность
			// Связи
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('issuetype_id')->references('id')->on('issuetypes')->onDelete('cascade');
			$table->foreign('issuestatus_id')->references('id')->on('issuestatuses')->onDelete('cascade');

			// Индексы
			$table->index('user_id');
			$table->index('issuetype_id');
			$table->index('issuestatus_id');
			$table->index('author');
			$table->index('email');
			$table->index('posted_at');
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
			$table->dropForeign(['user_id']);
			$table->dropForeign(['issuetype_id']);
			$table->dropForeign(['issuestatus_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
