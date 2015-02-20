<?php

class ReportsController extends BaseController {

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
		$Allmonths = DB::table('months')->select('*')->orderBy('month_reference', 'desc')->get();

		$select[0] = 'Selecione o mês de referência';

		foreach($Allmonths as $month) {
    		$select[$month->month_reference] = $month->month_name;
		}

		$action = 'muralFilter';
	
		return View::make('reports.filter', compact('select', 'action'));

	}

	public function up2()
	{
		$months = DB::table('months')->get();
		foreach ($months as $d):	
			$expense = App::make('ExpensesController')->sum($d->month_reference);

			// calc total and divider for total dwellers
			$total_by_dweller = $expense[0]->total / DB::table('dwellers')->count();

			// update status this month to released and updated cost value for this month
			App::make('MonthsController')->castMonth($d->month_reference, $total_by_dweller);

			foreach (Dweller::all() as $dweller):

				//throw expenses for each dweller
				DB::table('dweller_expenses')
					->where('id_dweller', $dweller->id)
					->where('date_expense', $d->month_reference)
					->update(
						array(
							'value' => ($dweller->situation == 1) ? $total_by_dweller : $total_by_dweller / 2,
						)
				);

				$extras = DB::table('expenses')
									->where('id_dweller', $dweller->id)
									->where('date_reference', $d->month_reference)
									->get();

				// if extras expenses not empty, throw extra expenses this dweller
				if (!empty($extras)) {

					foreach ($extras as $extra):

						DB::table('dweller_expenses')
						->where('id_dweller', $dweller->id)
						->update(
							array(
								'value' => $extra->value,
							)
						);

					endforeach;	

				}					

			endforeach;	
		endforeach;
		echo 'valores atualizados com sucesso';		
	}

	public function muralFilter()
	{
		
		$input = array_except(Input::all(), '__method');

		$expenses = DB::table('expenses')
					->select('*')
					->where('date_reference', $input['filter'])
					->where('id_dweller', 0)
					->get();
		
		$debtors = DB::table('dweller_expenses')
					->select('*')
					->join('dwellers', 'dweller_expenses.id_dweller', '=', 'dwellers.id')
					->where('type_expense', 0)
					->where('status_expense', 0)
					->orderBy('number_apartament')
					->orderBy('date_expense')
					->get();
	
		$month_reference = BaseController::getMonthNameExtension($input['filter'], 2);

		$informations = DB::table('months')
						->select(DB::raw('due_date, cost'))
						->where('month_reference', $input['filter'])
						->get();

		$due_date = BaseController::getMonthNameExtension($informations[0]->due_date);						

		$cost = $informations[0]->cost;

		$dwellers = Dweller::all();

		$html =  View::make('reports.mural', compact('expenses', 'debtors', 'month_reference', 'due_date', 'cost', 'dwellers'));

		$pdf = App::make('dompdf');
		$pdf->loadHtml($html);
		return $pdf->stream();
	}



}
