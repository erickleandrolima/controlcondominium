<?php

class DwellersController extends BaseController {

	/**
	 * Dweller Repository
	 *
	 * @var Dweller
	 */
	protected $dweller;

	public function __construct(Dweller $dweller)
	{
		$this->beforeFilter('auth');
		$this->dweller = $dweller;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$dwellers = DB::table('dwellers')
						->orderBy('number_apartament', 'ASC')
						->where('user_id', '=', Auth::id())
						->simplePaginate(10);

		return View::make('dwellers.index', compact('dwellers'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$apartments = App::make('ApartmentsController')->getApartments();;

		return View::make('dwellers.create', compact('apartments'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();

		$validation = Validator::make($input, Dweller::$rules, BaseController::getCustomErrorMessages());


		if ($validation->passes())
		{
			$this->dweller->create($input);
			App::make('ApartmentsController')->setAssigned($input['number_apartament']);

			return Redirect::route('dwellers.index')
											->with('success', '<strong>Sucesso</strong> Registro inserido!');
		}

		return Redirect::route('dwellers.create')
			->withInput()
			->withErrors($validation)
			->with('message', 'Erro ao inserir os dados.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$dweller = $this->dweller->findOrFail($id);

		$increase = DB::table('dweller_expenses')
							->select(DB::raw('sum(value) as total'))
							->where('id_dweller', $id)
							->where('status_expense', 0)
							->where('type_expense', 0)
							->where('user_id', '=', Auth::id())
							->get();

		$decrease = DB::table('dweller_expenses')
							->select(DB::raw('sum(credit) as total'))
							->where('id_dweller', $id)
							->where('user_id', '=', Auth::id())
							->get();					

		$balance = ceil($increase[0]->total - $decrease[0]->total);

		$sum = DB::table('dweller_expenses')
				 ->select(DB::raw('sum(value) as total'))
			  	 ->where('id_dweller', $id)
		 		 ->where('type_expense', 0)
			 	 ->where('user_id', '=', Auth::id())
		 		 ->get();

		$expenses = DB::table('dweller_expenses')
					  ->select(DB::raw('*, sum(value) as total'))
		  			  ->where('id_dweller', $id)
					  ->where('user_id', '=', Auth::id())
					  ->groupBy('date_expense')
					  ->orderBy('date_expense', 'desc')
		  			  ->get();

		return View::make('dwellers.show', compact('dweller', 'expenses', 'balance', 'sum'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$dweller = $this->dweller->find($id);

		if (is_null($dweller))
		{
			return Redirect::route('dwellers.index');
		}

		$apartments = App::make('ApartmentsController')->getApartments($assigned = false);

		return View::make('dwellers.edit', compact('dweller', 'apartments'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = array_except(Input::all(), '_method');
		
		$validation = Validator::make($input, Dweller::$rules, BaseController::getCustomErrorMessages());

		if ($validation->passes())
		{
			$dweller = Dweller::find($id);

			if ($dweller->number_apartament == $input['number_apartament']):

				$dweller->update($input);
				App::make('ApartmentsController')->setAssigned($input['number_apartament']);

				return Redirect::route('dwellers.index')
												->with('success', '<strong>Sucesso</strong> Registro atualizado!');
			else:

				$check = Dweller::where('number_apartament', $input['number_apartament'])
								->where('user_id', Auth::id())
							    ->first();
				
				if (!is_null($check)):

					return Redirect::route('dwellers.edit', $id)
													->with('message', '<strong>Erro</strong> Esse número de apartamento já pertence a outro morador!');
				else:							  

					$dweller->update($input);
					App::make('ApartmentsController')->setAssigned($input['number_apartament']);

					return Redirect::route('dwellers.index')
								   ->with('success', '<strong>Sucesso</strong> Registro atualizado!');

				endif;

			endif;

		}

		return Redirect::route('dwellers.edit', $id)
			->withInput()
			->withErrors($validation)
			->with('message', 'Erro ao atualizar os dados.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->dweller->find($id)->delete();

		return Redirect::route('dwellers.index')
										->with('success', '<strong>Sucesso</strong> Registro excluído!');
	}

	public function getDwellersForDebtsReport()
	{
		return 	DB::table('dwellers')
				  ->select('*')
				  ->orderBy('number_apartament', 'asc')
				  ->simplePaginate(10);
	}
}
