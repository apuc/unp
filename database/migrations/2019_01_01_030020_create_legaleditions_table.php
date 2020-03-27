<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegaleditionsTable extends Migration
{
	const TABLE_NAME = 'legaleditions';

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

			$table->unsignedBigInteger('legaldocument_id');

			$table->date('issued_at');
			$table->text('content');

			// Уникальность
			$table->unique(['legaldocument_id', 'issued_at'], 'uk_legaldocument_issued');

			// Связи
			$table->foreign('legaldocument_id')->references('id')->on('legaldocuments')->onDelete('cascade');

			// Индексы
			$table->index('issued_at');
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
			$table->dropForeign(['legaldocument_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
