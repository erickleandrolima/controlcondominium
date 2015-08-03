<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsEmptyApartmentToDwellersExpenses extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('dweller_expenses', function (Blueprint $table) {
			$table->integer('apartmentEmpty')->nullable()->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('dweller_expenses', function (Blueprint $table) {
			$table->dropColumn('apartmentEmpty');
		});
	}

}
