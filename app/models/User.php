<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Zizaco\Entrust\HasRole;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;
	use HasRole;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public static $rules = [
		'create' => [
		    'firstname'=>'required|alpha|min:2',
		    'lastname'=>'required|alpha|min:2',
		    'email'=>'required|email|unique:users',
		    'password'=>'required|alpha_num|between:6,12|confirmed',
		    'password_confirmation'=>'required|alpha_num|between:6,12',
		    'role_id' => 'required',
		],
		'update' => [
			'firstname'=>'required|alpha|min:2',
			'lastname'=>'required|alpha|min:2',
			'role_id' => 'required',
		],
    ];

}
