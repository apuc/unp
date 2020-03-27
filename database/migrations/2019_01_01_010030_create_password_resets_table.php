<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasswordResetsTable extends Migration
{
	const TABLE_NAME = 'password_resets';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
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
