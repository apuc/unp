<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBenefitsTable extends Migration
{
	const TABLE_NAME = 'benefits';

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
			$table->string('slug')->unique();
			$table->string('name')->unique();
			$table->string('icon')->nullable();
			$table->string('announce')->nullable();
			$table->string('url')->nullable()->unique();
			$table->unsignedInteger('position')->unique();

			// Уникальность
			// Связи
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
		Schema::dropIfExists(self::TABLE_NAME);
	}
}
