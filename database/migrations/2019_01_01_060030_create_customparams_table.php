<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomparamsTable extends Migration
{
	const TABLE_NAME = 'customparams';

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

			$table->unsignedBigInteger('customgroup_id');
			$table->unsignedBigInteger('customtype_id');

			$table->string('slug');
			$table->string('name');

			$table->string('value_string')->nullable();
			$table->integer('value_integer')->nullable();
			$table->text('value_text')->nullable();
			$table->float('value_float')->nullable();
			$table->boolean('value_boolean')->nullable();
			$table->date('value_date')->nullable();
			$table->dateTime('value_datetime')->nullable();

			// Уникальность
			$table->unique(['customgroup_id', 'slug'], 'uk_customgroup_slug');
			$table->unique(['customgroup_id', 'name'], 'uk_customgroup_name');

			// Связи
			$table->foreign('customgroup_id')->references('id')->on('customgroups')->onDelete('cascade');
			$table->foreign('customtype_id')->references('id')->on('customtypes')->onDelete('cascade');

			// Индексы
			$table->index('customgroup_id');
			$table->index('customtype_id');
			$table->index('slug');
			$table->index('name');
			$table->index('value_string');
			$table->index('value_integer');
			$table->index('value_float');
			$table->index('value_boolean');
			$table->index('value_date');
			$table->index('value_datetime');
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
			$table->dropForeign(['customgroup_id']);
			$table->dropForeign(['customtype_id']);
		});

		Schema::dropIfExists(self::TABLE_NAME);
	}
}
