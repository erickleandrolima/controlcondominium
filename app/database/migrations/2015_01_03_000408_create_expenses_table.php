<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExpensesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('expenses', function(Blueprint $table) {
			$table->increments('id');
			$table->date('date_expense');
			$table->text('description');
			$table->decimal('value', 5,2);
			$table->date('date_reference');
			$table->integer('id_category')->default('0');
			$table->integer('id_dweller')->default('0');
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
		Schema::drop('expenses');
	}

}
