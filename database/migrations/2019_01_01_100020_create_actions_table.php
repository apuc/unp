<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionsTable extends Migration
{
	const TABLE_NAME = 'actions';

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

			$table->unsignedBigInteger('actiongroup_id');

			$table->string('slug');
			$table->string('name');

			$table->text('description')->nullable();

			// Уникальность
			$table->unique(['actiongroup_id', 'slug'], 'uk_actiongroup_slug');
			$table->unique(['actiongroup_id', 'name'], 'uk_actiongroup_name');

			// Связи
			$table->foreign('actiongroup_id')->references('id')->on('actiongroups')->onDelete('cascade');

			// Индексы
			$table->index('actiongroup_id');
			$table->index('slug');
			$table->index('name');
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
			$table->dropForeign(['actiongroup_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
