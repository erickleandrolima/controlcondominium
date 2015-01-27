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
		$this->expense = $expense;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$expenses = Expense::orderBy('date_reference', 'desc')->get();

		return View::make('expenses.index', compact('expenses'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$Allmonths = DB::table('months')
					->select('*')
					->where('casted', 0)
					->orderBy('month_reference', 'desc')->get();

		$months[0] = 'Selecione o mês de referência';

		foreach($Allmonths as $month) {
    		$months[$month->month_reference] = $month->month_name;
		}

		$allCategories = DB::table('categories')->select('*')->get();

		$categories[0] = 'Selecione uma categoria';

		foreach($allCategories as $category) {
    		$categories[$category->id] = $category->name;
		}

		$allDwellers = DB::table('dwellers')->select('*')->get();

		$dwellers[0] = 'Selecione um morador';

		foreach($allDwellers as $dweller) {
    		$dwellers[$dweller->id] = $dweller->name;
		}

		return View::make('expenses.create', compact('months', 'categories', 'dwellers'));
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

		echo '<pre>';
		var_dump($input);
		exit();

		if ($validation->passes())
		{
			$this->expense->create($input);

			// check this expense is for a some dweller
			if (!empty($input['id_dweller'])) {
				DB::table('dwellers_expenses')
					->insert(
						array(
							'id_dweller' => $input['id_dweller'],
							'date_expense' => $input['date_expense'],
							'value' => $input['value'],
							'created_at' => 'NOW()',
							'type_expense' => 1
						)
				);
			}		

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

		$Allmonths = DB::table('months')->select('*')->get();

		$months[0] = 'Selecione o mês de referência';

		foreach($Allmonths as $month) {
    		$months[$month->month_reference] = $month->month_name;
		}

		$allCategories = DB::table('categories')->select('*')->get();

		$categories[0] = 'Selecione uma categoria';

		foreach($allCategories as $category) {
    		$categories[$category->id] = $category->name;
		}

		$allDwellers = DB::table('dwellers')->select('*')->get();

		$dwellers[0] = 'Selecione um morador';

		foreach($allDwellers as $dweller) {
    		$dwellers[$dweller->id] = $dweller->name;
		}

		if (is_null($expense))
		{
			return Redirect::route('expenses.index');
		}

		return View::make('expenses.edit', compact('expense', 'months', 'categories', 'dwellers'));
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
			$expense->update($input);

			return Redirect::route('expenses.show', $id)
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

	/**
	 * Sum expenses for month determine.
	 *
	 * @param  date  $date
	 * @return Response
	 */

	public function sum($date)
	{
		$total = DB::table('expenses')
				   ->select(DB::raw('SUM(value) AS total'))
				   ->whereRaw(DB::raw("date_reference BETWEEN DATE_FORMAT(  '{$date}',  '%Y-%m-01' ) AND LAST_DAY(  '{$date}' ) and id_dweller = 0"))
				   ->groupBy(DB::raw('YEAR(date_reference) , MONTH(date_reference)'))
				   ->get();
		
		return $total;				   
	}


	/**
	 * Pay expense for determine dweller.
	 *
	 * @param  int  $id
	 * @return Response
	 */

	public function pay($id, $date)
	{
		DB::table('dwellers_expenses')
		->where('id_dweller', $id)
		->where('date_expense', $date)
		->update(array('status_expense' => 1, 'updated_at' => DB::raw('NOW()')));

		return Redirect::route('dwellers.show', $id);
	}

	public function parcialPay($id, $date)
	{
		$input =  array_except(Input::all(), '_method');

		DB::table('dwellers_expenses')->insert(
			array(
				'id_dweller' => $id, 
				'date_expense' => $date, 
				'value' => $input['value'], 
				'type_expense' => 1, 
				'status_expense' => 1,
				'updated_at' => DB::raw('NOW()'),
			)
		);

		return Redirect::route('dwellers.show', $id);
	}

}
