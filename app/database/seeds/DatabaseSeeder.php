<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// $this->call('UserTableSeeder');
		$this->call('DwellersTableSeeder');
		$this->call('ExpensesTableSeeder');
		$this->call('MonthsTableSeeder');
		$this->call('CategoriesTableSeeder');
	}

}
