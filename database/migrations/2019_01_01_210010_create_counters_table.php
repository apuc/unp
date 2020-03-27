<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountersTable extends Migration
{
	const TABLE_NAME = 'counters';

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

			$table->string('name')->unique();
			$table->text('code_head')->nullable();
			$table->text('code_top')->nullable();
			$table->text('code_footer')->nullable();
			$table->text('code_script')->nullable();
			$table->boolean('is_enabled');

			// Уникальность
			// Связи
			// Индексы
			$table->index('is_enabled');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */

	public function down()
	{
		Schema::dropIfExists(self::TABLE_NAME);
	}
}
