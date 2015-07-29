<?php

class Parameter extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'number_apartments' => 'required',
		'residential_name' => 'required',
		'day_due_date' => 'required',
	);
}
