<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMonthsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('months', function(Blueprint $table) {
			$table->increments('id');
			$table->date('month_reference');
			$table->string('month_name');
			$table->integer('casted')->default('0');
			$table->decimal('cost', 5, 2)->default('0');
			$table->date('due_date');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('months');
	}

}
