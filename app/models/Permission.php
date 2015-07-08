<?php

class Permission extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'permission_description' => 'required',
		'permission_rate' => 'required',
		'permission_status' => 'required'
	);
}
