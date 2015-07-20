<?php

class Apartment extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'number_apartment' => 'required',
		'status' => 'required'
	);
}
