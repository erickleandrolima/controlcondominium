<?php

class Residential extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'residential_name' => 'required',
		'residential_status' => 'required'
	);
}
