<?php
 
class UsersController extends BaseController {
    
    protected $user;

    public function __construct(User $user) {
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->user = $user;
    }

    public function index()
    {
        $users = DB::table('users')
                        ->orderBy('firstname', 'ASC')
                        ->where('user_id', '=', Auth::id())
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
                    ->leftJoin('assigned_roles','roles.id', '=', 'assigned_roles.role_id')
                    ->where('assigned_roles.user_id', '=', $id)
                    ->get();

        if (empty($userRole)):
            $roleDummy = new stdClass();
            $roleDummy->role_id = 0;
            $userRole[0] = $roleDummy;
        endif;                   

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
        if (!empty(Input::get('password'))):
            $user->password = Hash::make(Input::get('password'));
        endif;
        $user->situation = Input::get('situation');
        $user->save();

        $findUserRole = DB::table('assigned_roles')->where('user_id', '=', $id)->get();

        if (empty($findUserRole)):
            DB::table('assigned_roles')
            ->insert(array(
                'role_id' => Input::get('role_id'),
                'user_id' => $id
            ));
        else:    

            DB::table('assigned_roles')
                ->where('user_id', '=', $id)
                ->update(array('role_id' => Input::get('role_id')));

        endif;        
                 
        return Redirect::route('users.index')->with('success', '<strong>Sucesso</strong> dados atualizados com sucesso!');
    }

    public function create() {
        return View::make('users.create');
    }

    public function store() {
        
        $validator = Validator::make(Input::all(), User::$rules);
     
        if ($validator->passes()) {

            // set numbers days after today expire access
            $expire_date = strtotime('+30 days', strtotime(date('Y-m-d'))) ;
            $expire_date = date('Y-m-d', $expire_date);

            $user = new User;
            $user->firstname = Input::get('firstname');
            $user->lastname = Input::get('lastname');
            $user->email = Input::get('email');
            $user->password = Hash::make(Input::get('password'));
            $user->expire_access = $expire_date;
            $user->situation = 1;
            $user->user_id = (!empty(Input::get('user_id'))) ? Input::get('user_id') : 0;
            $user->save();
            if (!Auth::check()):    
                return Redirect::to('users/login')->with('success', '<strong>Sucesso</strong> Faça o login com o novo usuário');
            else:
                return Redirect::route('users.index')->with('success', '<strong>Sucesso</strong> Usuário criado');
            endif;

        } else {
            return Redirect::route('users.create')
                            ->withInput()
                            ->withErrors($validator)
                            ->with('message', 'Há erros em seu cadastro');
        }
    }

    // Logout....I dont know why
    
    public function show()
    {
        Auth::logout();
        return View::make('users.login')->with('success', 'Logout realizado!');
    }

    public function destroy($id)
    {
        $this->user->find($id)->delete();

        return Redirect::route('users.index')
                        ->with('success', '<strong>Sucesso</strong> Registro excluído!');
    }

    public function getDashboard() {
        View::make('months.index');
    }

    public function signin() 
    {
        $user = User::where('email', '=', Input::get('email'))->first();

        if (!is_null($user)):

            if ($user->expire_access == date('Y-m-d') || $user->situation == 0):
                return Redirect::to('users/login')
                    ->with('message', 'O tempo de acesso para o seu usuário expirou ou sua conta está inativa, entre em contato com o suporte: suporte@wwebcondominio.com')
                    ->withInput();
            else:    
            	if (Auth::attempt(array('email'=>Input::get('email'), 'password'=>Input::get('password')))) {
            	    return Redirect::to('months')->with('success', 'Login realizado com sucesso!');
            	} else {
            	    return Redirect::to('users/login')
            	        ->with('message', 'Você digitou sua senha ou email incorretamente, tente novamente')
            	        ->withInput();
            	}

            endif;
        else:
            return Redirect::to('users/login')
                ->with('message', 'Seu usuário não existe em nosso sistema, <a href="users/create">clique aqui e crie uma conta</a>')
                ->withInput();
        endif;                     
    }
}
