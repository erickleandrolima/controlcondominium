<?php
 
class UsersController extends BaseController {
    
    protected $layout = "auth.login";
    protected $user;

    public function __construct(User $user) {
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->user = $user;
    }

    public function index()
    {
        $users = DB::table('users')
                        ->orderBy('firstname', 'ASC')
                        ->simplePaginate(10);

        return View::make('users.index', compact('users'));
    }

    public function edit($id)
    {
        $user = $this->user->find($id);

        if (is_null($user))
        {
            return Redirect::route('users.index');
        }

        $userRole = DB::table('roles')
                    ->leftJoin('assigned_roles','roles.id', '=', 'assigned_roles.user_id')
                    ->where('assigned_roles.user_id', '=', $id)
                    ->get();

        
        $Allroles = DB::table('roles')
                    ->get();                    
        
        $roles[0] = 'Selecione o mês de referência';

        foreach($Allroles as $role) {
            $roles[$role->id] = $role->name;
        }

        return View::make('users.edit', compact('user', 'roles', 'userRole'));
    }

    public function update($id)
    {
        $user = User::where('id', '=', $id)->first();
        $user->firstname = Input::get('firstname');
        $user->lastname = Input::get('lastname');
        $user->email = Input::get('email');
        $user->password = Hash::make(Input::get('password'));
        $user->situation = Input::get('situation');
        $user->save();

        DB::table('assigned_roles')
            ->where('user_id', '=', $id)
            ->update(array('role_id' => Input::get('role_id')));
                 
        return Redirect::route('users.index')->with('success', '<strong>Sucesso</strong> dados atualizados com sucesso!');
    }

    public function create() {
        return View::make('users.create');
    }

    public function store() {
        
        $validator = Validator::make(Input::all(), User::$rules);
     
        if ($validator->passes()) {
            $user = new User;
            $user->firstname = Input::get('firstname');
            $user->lastname = Input::get('lastname');
            $user->email = Input::get('email');
            $user->password = Hash::make(Input::get('password'));
            $user->save();
             
            return Redirect::route('users.index')->with('success', '<strong>Sucesso</strong> Usuário criado');

        } else {
            return Redirect::route('users.create')
                            ->withInput()
                            ->withErrors($validator)
                            ->with('message', 'Há erros em seu cadastro');
        }
    }

    public function destroy($id)
    {
        $this->user->find($id)->delete();

        return Redirect::route('users.index')
                                        ->with('success', '<strong>Sucesso</strong> Registro excluído!');
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

    public function getLogout() {
        Auth::logout();
        return Redirect::to('users/login')->with('success', 'Logout realizado!');
    }

}
