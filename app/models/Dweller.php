<?php

class Dweller extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'name' => 'required',
		'situation' => 'required',
		'number_apartament' => 'required'
	);

}
