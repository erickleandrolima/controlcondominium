<?php
 
class UsersController extends BaseController {
    
    protected $layout = "auth.login";

    public function __construct() {
        $this->beforeFilter('csrf', array('on'=>'post'));
    }

    public function getDashboard() {
        $this->layout->content = View::make('months.index');
    }

    public function getLogin() 
    {
        $this->layout->content = View::make('auth.login');
    }

    public function postSignin() 
    {
    	if (Auth::attempt(array('email'=>Input::get('email'), 'password'=>Input::get('password')))) {
    	    return Redirect::to('months')->with('success', 'Login realizado com sucesso!');
    	} else {
    	    return Redirect::to('users/login')
    	        ->with('message', 'Você digitou sua senha ou email incorretamente, tente novamente')
    	        ->withInput();
    	}             
    }

    public function getRegister() {
        $this->layout->content = View::make('auth.register');
    }

    public function postCreate() {
        
        $validator = Validator::make(Input::all(), User::$rules);
     
        if ($validator->passes()) {
        	$user = new User;
    	    $user->firstname = Input::get('firstname');
    	    $user->lastname = Input::get('lastname');
    	    $user->email = Input::get('email');
    	    $user->password = Hash::make(Input::get('password'));
    	    $user->save();
        	 
    	    return Redirect::to('users/login')->with('success', 'Thanks for registering!');

        } else {
        	return Redirect::to('users/register')
        					->withInput()
        					->withErrors($validator)
        					->with('message', 'Há erros em seu cadastro');
        }
    }

    public function getLogout() {
        Auth::logout();
        return Redirect::to('users/login')->with('success', 'Logout realizado!');
    }

}
