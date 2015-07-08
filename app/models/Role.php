<?php

class Role extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'role_description' => 'required',
		'role_rate' => 'required',
		'role_status' => 'required'
	);
}
