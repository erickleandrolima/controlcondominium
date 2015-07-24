<?php

class MonthsController extends BaseController {

	/**
	 * Month Repository
	 *
	 * @var Month
	 */
	protected $month;

	public function __construct(Month $month)
	{
        $this->beforeFilter('auth');
		$this->month = $month;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$months = Month::orderBy('month_reference', 'desc')->where('user_id', '=', Auth::id())->simplePaginate(10);

		return View::make('months.index', compact('months'));
	}

	/**
	 * Cast expense for month
	 *
	 * @param  date  $date
	 * @return Response
	 */
	public function cast($date)
	{
		// Verify if exists due date for this month
		$haveDueDate = Month::where('month_reference', '=', $date)->where('due_date', '!=', '0000-00-00')->count();

		if ($haveDueDate > 0):
			
			// sum total expenses for this month
			$expense = App::make('ExpensesController')->sum($date);

			// calc total and divider for total dwellers
			$total_by_dweller = $expense[0]->total / DB::table('dwellers')->count();

			// update status this month to released and updated cost value for this month
			$this->castMonth($date, $total_by_dweller);

			foreach (Dweller::where('user_id', '=', Auth::id())->get() as $dweller):

				//throw expenses for each dweller
				DB::table('dweller_expenses')
					->insert(
						array(
							'id_dweller' => $dweller->id,
							'date_expense' => $date,
							// verify if apartament is occupied, when not divide this value for half
							'value' => ($dweller->situation == 1) ? $total_by_dweller : $total_by_dweller / 2,
							'user_id' => Auth::id(),
						)
				);

			endforeach;

			return Redirect::route('months.index')
											->with('success', '<strong>Sucesso</strong> Lançamento realizado!');
		
		endif;

		return Redirect::route('months.index')
										->with('message', 'Você precisa cadastrar a data de vencimento antes de lançar');
	}

	/**
	 * Check cast for determine month
	 *
	 * @param  date  $date
	 * @return Response
	 */

	public function castMonth($date, $value)
	{
		DB::table('months')->where('month_reference', $date)->update(array('casted' => 1, 'cost' => $value));

		return true;
	}

	/**
	 * rebase calc for determine month
	 *
	 * @param  date  $date
	 * @return Response
	 */

	public function rebaseCalc($date)
	{
		DB::table('dweller_expenses')
			->where('date_expense', $date)
			->where('user_id', Auth::id())
			->delete();

		DB::table('months')
			->where('month_reference', $date)
			->update(['casted' => 0, 'cost' => 0]);

		return Redirect::route('months.index')
						->with('success', '<strong>Sucesso</strong> Recalcule o mês escolhido!');
	}

	/**
	 * generate months for determine year
	 *
	 * @param  date  $year
	 * @return Response
	 */

	public function generateMonths()
	{
		$input =  array_except(Input::all(), '_method');
		$year = (int) $input['year'];
		if ($year > 1000 && $year < 3000):
			$start    = (new DateTime($year . '-01-01'))->modify('first day of this month');
			$end      = (new DateTime($year + 1 . '-01-01'))->modify('first day of this month');
			$interval = DateInterval::createFromDateString('1 month');
			$period   = new DatePeriod($start, $interval, $end);
			$monthNames = BaseController::$months_array;

			foreach ($period as $dt):

				$nextMonth = $dt->format('m') + 1;

				$find = DB::table('months')->where('month_reference', '=', $dt->format('Y-m-d'))->get();

				if (empty($find)):

					if ($nextMonth <= 9):
						$due_date = new DateTime($year . '-0' . $nextMonth . '-20');
						$due_date = $due_date->format('Y-m-d');
					elseif ($nextMonth > 12):
						$due_date = new DateTime($year + 1 . '-01-20');
						$due_date = $due_date->format('Y-m-d');
					else:
	                	$due_date = new DateTime($year . '-' . $nextMonth . '-20');
	                	$due_date = $due_date->format('Y-m-d');
					endif;					

					DB::table('months')->insert(array(
						'month_reference' => $dt->format('Y-m-d'),
						'month_name' => $monthNames[$dt->format('m')] . ' de ' . $year,
						'casted' => 0,
						'cost' => 0,
						'due_date' => $due_date,
						'user_id' => Auth::id(),
						'created_at' => DB::raw('NOW()'),
						'updated_at' => DB::raw('NOW()'),													                     	
					));
				endif;		
			endforeach;

			return Redirect::route('months.index')
			 				->with('success', '<strong>Sucesso</strong> Os meses de ' . $year . ' foram gerados!');
		else:
			return Redirect::route('months.index')
			 				->with('message', '<strong>Erro</strong> O ano digitado é inválido: ' . $year);
		endif;	 				
	}

	/**
	 * delete months for determine year
	 *
	 * @param  date  $year
	 * @return Response
	 */

	public function deleteMonths()
	{
		$input =  array_except(Input::all(), '_method');
		$year = (int) $input['year'];
		if ($year > 1000 && $year < 3000):
			$start    = (new DateTime($year . '-01-01'))->modify('first day of this month');
			$end      = (new DateTime($year + 1 . '-01-01'))->modify('first day of this month');
			$interval = DateInterval::createFromDateString('1 month');
			$period   = new DatePeriod($start, $interval, $end);
			$monthNames = BaseController::$months_array;

			foreach ($period as $dt):
				DB::table('months')
					->where('month_reference', '=', $dt->format('Y-m-d'))
					->where('user_id', '=', Auth::id())
					->delete();
			endforeach;

			return Redirect::route('months.index')
			 				->with('success', '<strong>Sucesso</strong> Os meses de ' . $year . ' foram deletados!');
		else:
			return Redirect::route('months.index')
			 				->with('message', '<strong>Erro</strong> O ano digitado é inválido: ' . $year);			 				
		endif;			 				
	}
}