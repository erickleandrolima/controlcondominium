<?php

class UpdateAdminPermissions extends Seeder {

	public function run()
	{
		$admin = Role::where('name','=','admin')->first();
		
		$months = Permission::where('name','=','months')->first();
		$expenses = Permission::where('name','=','expenses')->first();
		$dwellers = Permission::where('name','=','dwellers')->first();
		$categories = Permission::where('name','=','categories')->first();
		$reports = Permission::where('name','=','reports')->first();
		
		$admin->perms()->sync(array($months->id, $expenses->id, $dwellers->id, $categories->id, $reports->id));
	}

}
