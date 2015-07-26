<?php

class ReportsController extends BaseController {

	public function __construct()
	{
		$this->beforeFilter('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return View::make('reports.index');
	}

	public function mural()
	{
		$select = App::make('ExpensesController')->getMonths();

		return View::make('reports.muralFilter', compact('select'));
	}

	public function muralFilter()
	{
		
		$input = array_except(Input::all(), '__method');

		$expenses = DB::table('expenses')
					->select('*')
					->where('date_reference', $input['filter'])
					->where('user_id', Auth::id())
					->get();

		$debtors = DB::table('dweller_expenses')
					->select('*')
					->leftJoin('dwellers', 'dweller_expenses.id_dweller', '=', 'dwellers.id')
					->where('type_expense', 0)
					->where('status_expense', 0)
					->where('dweller_expenses.user_id', Auth::id())
					->orderBy('date_expense')
					->get();

		$month_reference = BaseController::getMonthNameExtension($input['filter'], 2);

		$informations = DB::table('months')
						->select(DB::raw('due_date, cost'))
						->where('month_reference', $input['filter'])
						->where('user_id', Auth::id())
						->get();
		
		$due_date = BaseController::getMonthNameExtension($informations[0]->due_date);						

		$cost = $informations[0]->cost;

		$dwellers = Dweller::where('user_id', '=', Auth::id())->get();

		$html =  View::make('reports.mural', compact('expenses', 'debtors', 'month_reference', 'due_date', 'cost', 'dwellers'));

		$pdf = App::make('dompdf');
		$pdf->loadHtml($html);
		return $pdf->stream();
	}

	public function debtsDwellers()
	{
		$allDwellers = DB::table('dwellers')->select('*')->orderBy('number_apartament', 'asc')->get();

		$select[0] = 'Selecione o morador';

		foreach($allDwellers as $dweller) {
    		$select[$dweller->id] = $dweller->number_apartament;
		}

		return View::make('reports.debtsDwellersFilter', compact('select'));

	}

	public function debtsDwellersFilter() 
	{
		$input = array_except(Input::all(), '__method');

		$expenses = DB::table('dweller_expenses')
						->select('*')
						->join('months', 'months.month_reference', '=', 'dweller_expenses.date_expense')
						->join('dwellers', 'dwellers.id', '=', 'dweller_expenses.id_dweller')
						->where('id_dweller', $input['filter'])
						->where('dweller_expenses.user_id', Auth::id())
						->where('status_expense', '0')
						->get();

		$total = DB::table('dweller_expenses')
						->select(DB::raw('sum(cost) as debt'))
						->join('months', 'months.month_reference', '=', 'dweller_expenses.date_expense')
						->join('dwellers', 'dwellers.id', '=', 'dweller_expenses.id_dweller')
						->where('id_dweller', $input['filter'])
						->where('dweller_expenses.user_id', Auth::id())
						->where('status_expense', '0')
						->get();					

		$html = View::make('reports.debtsDwellers', compact('expenses', 'total'));				
		$pdf = App::make('dompdf');
		$pdf->loadHtml($html);
		return $pdf->stream();
	}

	public function openExpenses()
	{
		$select = App::make('ExpensesController')->getMonthsForExpensesReport();

		return View::make('reports.openExpensesFilter', compact('select'));
	}

	public function openExpensesFilter()
	{
		$input = array_except(Input::all(), '__method');

		if (!empty($input['filter'])):
				$expenses = DB::table('expenses')
								->join('months', 'months.month_reference', '=', 'expenses.date_reference')
								->where('date_reference', $input['filter'])
								->where('expenses.user_id', Auth::id())
								->where('status', 0)
								->get();

				$total = DB::table('expenses')
							->select(DB::raw('sum(value) as debt'))
							->join('months', 'months.month_reference', '=', 'expenses.date_reference')
							->where('date_reference', $input['filter'])
							->where('expenses.user_id', Auth::id())
							->where('status', 0)
							->get();

			$all = false;				

		else:

			$all = true;
			
			$expenses = DB::table('expenses')
							->join('months', 'months.month_reference', '=', 'expenses.date_reference')
							->where('expenses.user_id', Auth::id())
							->where('status', 0)
							->get();

			$total = DB::table('expenses')
						->select(DB::raw('sum(value) as debt'))
						->join('months', 'months.month_reference', '=', 'expenses.date_reference')
						->where('expenses.user_id', Auth::id())
						->where('status', 0)
						->get();
		endif;

		$html = View::make('reports.openExpenses', compact('expenses', 'total', 'all'));				
		$pdf = App::make('dompdf');
		$pdf->loadHtml($html);
		return $pdf->stream();	
	}

}
