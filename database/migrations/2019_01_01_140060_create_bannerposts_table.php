<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannerpostsTable extends Migration
{
	const TABLE_NAME = 'bannerposts';

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

			$table->unsignedBigInteger('banner_id');
			$table->unsignedBigInteger('sitesection_id')->nullable();
			$table->unsignedBigInteger('bannerplace_id');

			$table->integer('margin')->nullable();

			$table->timestamp('started_at')->nullable();
			$table->timestamp('finished_at')->nullable();

			$table->unsignedInteger('view_limit')->nullable();
			$table->unsignedInteger('view_amount');
			$table->unsignedInteger('click_limit')->nullable();
			$table->unsignedInteger('click_amount');

			$table->boolean('is_enabled');
			$table->boolean('is_debug');

			// Уникальность
			// Связи
			$table->foreign('banner_id')->references('id')->on('banners')->onDelete('cascade');
			$table->foreign('sitesection_id')->references('id')->on('sitesections')->onDelete('cascade');
			$table->foreign('bannerplace_id')->references('id')->on('bannerplaces')->onDelete('cascade');

			// Индексы
			$table->index('margin');
			$table->index('started_at');
			$table->index('finished_at');
			$table->index('view_limit');
			$table->index('view_amount');
			$table->index('click_limit');
			$table->index('click_amount');
			$table->index('is_enabled');
			$table->index('is_debug');
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
			$table->dropForeign(['banner_id']);
			$table->dropForeign(['sitesection_id']);
			$table->dropForeign(['bannerplace_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
