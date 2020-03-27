<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchesTable extends Migration
{
	const TABLE_NAME = 'matches';

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

			$table->unsignedBigInteger('matchstatus_id');
			$table->unsignedBigInteger('stage_id')->nullable();

            $table->string('name')->nullable();
            $table->unsignedInteger('external_id')->nullable()->unique();
			$table->timestamp('started_at')->useCurrent();

			$table->decimal('odds1_current', 12, 4)	->nullable();
			$table->decimal('odds1_old', 12, 4)		->nullable();
			$table->decimal('oddsx_current', 12, 4)	->nullable();
			$table->decimal('oddsx_old', 12, 4)		->nullable();
			$table->decimal('odds2_current', 12, 4)	->nullable();
			$table->decimal('odds2_old', 12, 4)		->nullable();

			$table->unsignedBigInteger('bookmaker1_id')->nullable();
			$table->unsignedBigInteger('bookmakerx_id')->nullable();
			$table->unsignedBigInteger('bookmaker2_id')->nullable();

			// Уникальность

			// Связи
			$table->foreign('matchstatus_id')->references('id')->on('matchstatuses')->onDelete('cascade');
			$table->foreign('stage_id')->references('id')->on('stages')->onDelete('cascade');

			$table->foreign('bookmaker1_id')->references('id')->on('bookmakers')->onDelete('cascade');
			$table->foreign('bookmakerx_id')->references('id')->on('bookmakers')->onDelete('cascade');
			$table->foreign('bookmaker2_id')->references('id')->on('bookmakers')->onDelete('cascade');

			// Индексы
			$table->index('matchstatus_id');
			$table->index('stage_id');
			$table->index('name');
			$table->index('started_at');

			$table->index('odds1_current');
			$table->index('odds1_old');
			$table->index('oddsx_current');
			$table->index('oddsx_old');
			$table->index('odds2_current');
			$table->index('odds2_old');
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
			$table->dropForeign(['matchstatus_id']);
			$table->dropForeign(['stage_id']);

			$table->dropForeign(['bookmaker1_id']);
			$table->dropForeign(['bookmakerx_id']);
			$table->dropForeign(['bookmaker2_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
