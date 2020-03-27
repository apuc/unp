<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannersTable extends Migration
{
	const TABLE_NAME = 'banners';

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

			$table->unsignedBigInteger('bannerformat_id');
			$table->unsignedBigInteger('bannercampaign_id');

			$table->string('name');
			$table->string('picture')->nullable();
			$table->string('link');
			$table->text('html')->nullable();
			$table->string('alt')->nullable();

			// Уникальность
			$table->unique(['bannerformat_id', 'bannercampaign_id', 'name'], 'uk_banners');

			// Связи
			$table->foreign('bannerformat_id')->references('id')->on('bannerformats')->onDelete('cascade');
			$table->foreign('bannercampaign_id')->references('id')->on('bannercampaigns')->onDelete('cascade');

			// Индексы
			$table->index('bannerformat_id');
			$table->index('bannercampaign_id');
			$table->index('name');
			$table->index('picture');
			$table->index('link');
			$table->index('alt');
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
			$table->dropForeign(['bannerformat_id']);
			$table->dropForeign(['bannercampaign_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
