<?php

class DefaultRolesAndPermissionsSeeder extends Seeder {

	public function run()
	{
		$ApartmentManager = new Role;
		$ApartmentManager->name = 'ApartmentManager';
		$ApartmentManager->save();

		$admin = new Role;
		$admin->name = 'Admin';
		$admin->save();

		$user = User::where('firstname','=','erick')->first();

		/* role attach alias */
		$user->attachRole($admin); // Parameter can be an Role object, array or id.

		$months = new Permission;
		$months->name = 'months';
		$months->display_name = 'Access Months';
		$months->save();

		$expenses = new Permission;
		$expenses->name = 'expenses';
		$expenses->display_name = 'Access expenses';
		$expenses->save();

		$dwellers = new Permission;
		$dwellers->name = 'dwellers';
		$dwellers->display_name = 'Access dwellers';
		$dwellers->save();

		$categories = new Permission;
		$categories->name = 'categories';
		$categories->display_name = 'Access categories';
		$categories->save();

		$reports = new Permission;
		$reports->name = 'reports';
		$reports->display_name = 'Access reports';
		$reports->save();

		$ApartmentManager->perms()->sync(array($months->id, $expenses->id, $dwellers->id, $categories->id, $reports->id));
		
		$admin->perms()->sync(array($months->id, $expenses->id, $dwellers->id, $categories->id, $reports->id));


		// $role = Role::findOrFail(1); // Pull back a given role

		// // Regular Delete
		// $role->delete(); // This will work no matter what

		// // Force Delete
		// $role->users()->sync([]); // Delete relationship data
		// $role->perms()->sync([]); // Delete relationship data

		// $role->forceDelete(); 

	}

}
