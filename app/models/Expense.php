<?php

class Expense extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'date_expense' => 'required',
		'description' => 'required',
		'value' => 'required'
	);
}
