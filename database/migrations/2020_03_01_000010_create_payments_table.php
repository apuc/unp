<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
	const TABLE_NAME = 'payments';

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
			$table->unsignedInteger('amount');
			$table->timestamp('paid_at')->useCurrent();
			$table->string('purpose')->nullable();

			// Уникальность
			// Связи
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

			// Индексы
			$table->index(['amount'], 'ix_amount');
			$table->index(['paid_at'], 'ix_paid_at');
			$table->index(['purpose'], 'ix_purpose');
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
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
