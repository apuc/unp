<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffersTable extends Migration
{
	const TABLE_NAME = 'offers';

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

			$table->unsignedBigInteger('outcome_id');
			$table->unsignedBigInteger('bookmaker_id');
			$table->decimal('odds_current', '12', '4');
			$table->decimal('odds_old', '12', '4');
			$table->string('coupon')->nullable();
			$table->unsignedBigInteger('external_id')->nullable()->unique();
			$table->boolean('has_offers')->nullable();

			// Уникальность
			$table->unique(['bookmaker_id', 'outcome_id'], 'uk_bookmaker_outcome');

			// Связи
			$table->foreign('bookmaker_id')	->references('id')->on('bookmakers')->onDelete('cascade');
			$table->foreign('outcome_id')	->references('id')->on('outcomes')	->onDelete('cascade');

			// Индексы
			$table->index('odds_current');
			$table->index('odds_old');
			$table->index('coupon');
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
			$table->dropForeign(['bookmaker_id']);
			$table->dropForeign(['outcome_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
