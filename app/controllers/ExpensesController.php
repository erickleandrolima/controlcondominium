<?php

class ExpensesController extends BaseController {

	/**
	 * Expense Repository
	 *
	 * @var Expense
	 */
	protected $expense;

	public function __construct(Expense $expense)
	{
		$this->beforeFilter('auth');
		$this->expense = $expense;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$expenses = DB::table(DB::Raw('expenses e LEFT JOIN months m ON m.id = e.month_id'))
									->select(DB::raw('e.*, m.month_name'))
									->orderBy('date_reference', 'desc')
									->where('e.user_id', '=', Auth::id())
							 		->simplePaginate(10);

		return View::make('expenses.index', compact('expenses'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$months = App::make('MonthsController')->getOpenMonths();

		$categories = App::make('CategoriesController')->getCategories();

		$statusList = $this->getStatusList();

		return View::make('expenses.create', compact('months', 'categories', 'statusList'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Expense::$rules);

		$month = DB::table('months')
 					->where('month_reference', $input['date_reference'])
					->get();
					
		$input['month_id'] = $month[0]->id;					

		if ($validation->passes())
		{
			$this->expense->create($input);

			return Redirect::route('expenses.index')
												->with('success', '<strong>Sucesso</strong> Registro inserido!');
		}

		return Redirect::route('expenses.create')
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$expense = $this->expense->findOrFail($id);

		return View::make('expenses.show', compact('expense'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$expense = $this->expense->find($id);

		$months = App::make('MonthsController')->getOpenMonths();

		$categories = App::make('CategoriesController')->getCategories();

		$month_id = App::make('MonthsController')->getMonthId($expense);

		$statusList = $this->getStatusList();

		$path = (!empty($expense->document)) ? $expense->document : null;

		if (is_null($expense))
		{
			return Redirect::route('expenses.index');
		}

		return View::make('expenses.edit', compact('expense', 'months', 'categories', 'month_id', 'statusList', 'path'));
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
		$validation = Validator::make($input, Expense::$rules);

		if ($validation->passes())
		{
			$expense = $this->expense->find($id);							    
			
			if(!is_null(Input::file('document'))):
				$upload = new Upload(Input::file('document'));
				$input['document'] = $upload->upload();
			else:
			    $input['document'] = $expense->document;
			endif;    

			$expense->update($input);
			
			App::make('MonthsController')->updateMonthId($input, $id);

			return Redirect::route('expenses.index')
											->with('success', '<strong>Sucesso</strong> Registro atualizado!');
		}

		return Redirect::route('expenses.edit', $id)
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->expense->find($id)->delete();

		return Redirect::route('expenses.index')
										->with('success', '<strong>Sucesso</strong> Registro excluído!');
	}

	public function getStatusList()
	{
		return [
			0 => 'Aguardando pagamento',
			1 => 'Pago'
		];
	}

}
