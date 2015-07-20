<?php

class Dweller extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'create' => array(
			'name' => 'required',
			'situation' => 'required',
			'number_apartament' => 'required'
		),
		'update' => array(
			'name' => 'required',
			'situation' => 'required',
			'number_apartament' => 'required|unique:dwellers,number_apartament,:number'
		),
	);

}
