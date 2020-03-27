<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostcommentsTable extends Migration
{
	const TABLE_NAME = 'postcomments';

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
			$table->unsignedBigInteger('user_id');
			$table->unsignedBigInteger('commentstatus_id');

			$table->timestamp('posted_at')->useCurrent();

			$table->text('message');		

			// Уникальность
			$table->unique(['user_id', 'posted_at'], 'uk_user_posted');

			// Связи
			$table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('commentstatus_id')->references('id')->on('commentstatuses')->onDelete('cascade');

			// Индексы
			$table->index('post_id');
			$table->index('user_id');
			$table->index('commentstatus_id');
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
			$table->dropForeign(['post_id']);
			$table->dropForeign(['user_id']);
			$table->dropForeign(['commentstatus_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
