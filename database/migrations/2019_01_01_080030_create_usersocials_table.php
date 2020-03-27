<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersocialsTable extends Migration
{
	const TABLE_NAME = 'usersocials';

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

			$table->unsignedBigInteger('user_id');
			$table->unsignedBigInteger('social_id');

			$table->string('account');

			// Уникальность
			$table->unique(['user_id', 'social_id'], 'uk_user_social');

			// Связи
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('social_id')->references('id')->on('socials')->onDelete('cascade');

			// Индексы
			$table->index('user_id');
			$table->index('social_id');
			$table->index('account');
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
			$table->dropForeign(['social_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
