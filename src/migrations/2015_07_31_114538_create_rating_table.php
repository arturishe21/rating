<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if (!Schema::hasTable('ratings')) {
            Schema::create('ratings', function (Blueprint $table) {
                $table->engine = 'InnoDB';

                $table->increments('id');
                $table->integer('ratingspage_id');
                $table->string('ratingspage_type', 255);
                $table->string('ip', 50);
                $table->integer('rating');
                $table->integer('user_id');
                $table->timestamps();

                $table->index('ratingspage_id');
                $table->index('user_id');
            });
        }
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::dropIfExists('ratings');
	}

}
