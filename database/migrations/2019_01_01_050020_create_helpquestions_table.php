<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHelpquestionsTable extends Migration
{
	const TABLE_NAME = 'helpquestions';

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

			$table->unsignedBigInteger('helpsection_id');

			$table->string('name');
			$table->text('answer');

			$table->boolean('is_enabled');

			// Уникальность
			$table->unique(['helpsection_id', 'name'], 'uk_helpsection_name');

			// Связи
			$table->foreign('helpsection_id')->references('id')->on('helpsections')->onDelete('cascade');

			// Индексы
			$table->index('helpsection_id');
			$table->index('name');
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
		Schema::table(self::TABLE_NAME, function (Blueprint $table) {
			$table->dropForeign(['helpsection_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
