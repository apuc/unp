<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBriefsTable extends Migration
{
	const TABLE_NAME = 'briefs';

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
			$table->unsignedBigInteger('sport_id');
			$table->unsignedBigInteger('briefstatus_id');

			$table->string('name')->unique();

			$table->string('picture')->nullable();
			$table->string('picture_author')->nullable();

			$table->text('announce')->nullable();
			$table->text('content');
			$table->timestamp('posted_at')->useCurrent();

			$table->string('seo_title')->nullable();
			$table->text('seo_keywords')->nullable();
			$table->text('seo_description')->nullable();

			// Уникальность
			// Связи
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('sport_id')->references('id')->on('sports')->onDelete('cascade');
			$table->foreign('briefstatus_id')->references('id')->on('briefstatuses')->onDelete('cascade');

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
			$table->dropForeign(['user_id']);
			$table->dropForeign(['sport_id']);
			$table->dropForeign(['briefstatus_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
