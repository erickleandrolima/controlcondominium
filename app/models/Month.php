<?php

class Month extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'month_reference' => 'required',
		'month_name' => 'required'
	);
}
