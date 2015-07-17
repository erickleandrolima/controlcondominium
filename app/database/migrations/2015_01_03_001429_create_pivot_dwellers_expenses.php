<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePivotDwellersExpenses extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dweller_expenses', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('id_dweller');
			$table->date('date_expense');
			$table->decimal('value', 5,2);
			$table->integer('type_expense')->default('0');
			$table->integer('status_expense')->default('0');
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
		Schema::drop('dweller_expenses');
	}

}
