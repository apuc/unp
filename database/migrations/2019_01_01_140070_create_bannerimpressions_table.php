<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannerimpressionsTable extends Migration
{
	const TABLE_NAME = 'bannerimpressions';

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

			$table->unsignedBigInteger('bannerpost_id');
			$table->unsignedBigInteger('user_id')->nullable();

			$table->timestamp('impressed_at')->useCurrent();

			$table->ipAddress('ip')->nullable();

			// Уникальность
			// Связи
			$table->foreign('bannerpost_id')->references('id')->on('bannerposts')->onDelete('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

			// Индексы
			$table->index('bannerpost_id');
			$table->index('user_id');
			$table->index('impressed_at');
			$table->index('ip');
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
			$table->dropForeign(['bannerpost_id']);
			$table->dropForeign(['user_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
