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
		$months = Month::orderBy('month_reference', 'asc')->where('user_id', '=', Auth::id())->simplePaginate(10);

		return View::make('months.index', compact('months'));
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
			$userId = Auth::id();
			$start    = (new DateTime($year . '-01-01'))->modify('first day of this month');
			$end      = (new DateTime($year + 1 . '-01-01'))->modify('first day of this month');
			$interval = DateInterval::createFromDateString('1 month');
			$period   = new DatePeriod($start, $interval, $end);
			$monthNames = BaseController::$months_array;
			$parameters = Parameter::where('user_id', $userId)->first();

			foreach ($period as $dt):

				$nextMonth = $dt->format('m') + 1;

				$find = DB::table('months')
							->where('month_reference', '=', $dt->format('Y-m-d'))
							->where('user_id', $userId)
							->get();

				if (empty($find)):

					if ($nextMonth <= 9):
						$due_date = new DateTime($year . '-0' . $nextMonth . '-' . $parameters->day_due_date);
						$due_date = $due_date->format('Y-m-d');
					elseif ($nextMonth > 12):
						$due_date = new DateTime($year + 1 . '-01-'. $parameters->day_due_date);
						$due_date = $due_date->format('Y-m-d');
					else:
	                	$due_date = new DateTime($year . '-' . $nextMonth . '-' . $parameters->day_due_date);
	                	$due_date = $due_date->format('Y-m-d');
					endif;					

					DB::table('months')->insert(array(
						'month_reference' => $dt->format('Y-m-d'),
						'month_name' => $monthNames[$dt->format('m')] . ' de ' . $year,
						'casted' => 0,
						'cost' => 0,
						'due_date' => $due_date,
						'user_id' => $userId,
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
			$userId = Auth::id();
			$start    = (new DateTime($year . '-01-01'))->modify('first day of this month');
			$end      = (new DateTime($year + 1 . '-01-01'))->modify('first day of this month');
			$interval = DateInterval::createFromDateString('1 month');
			$period   = new DatePeriod($start, $interval, $end);
			$monthNames = BaseController::$months_array;

			foreach ($period as $dt):
				DB::table('months')
					->where('month_reference', '=', $dt->format('Y-m-d'))
					->where('user_id', '=', $userId)
					->delete();
			endforeach;

			return Redirect::route('months.index')
			 				->with('success', '<strong>Sucesso</strong> Os meses de ' . $year . ' foram deletados!');
		else:
			return Redirect::route('months.index')
			 				->with('message', '<strong>Erro</strong> O ano digitado é inválido: ' . $year);			 				
		endif;			 				
	}

	public function getMonthsForExpensesReport()
	{
		return  DB::table('months')
				  ->select('*')
				  ->orderBy('month_reference', 'asc')
				  ->where('user_id', '=', Auth::id())
				  ->simplePaginate(10);

	}

	public function getMonths()
	{
		$Allmonths = DB::table('months')
					 ->select('*')
					 ->orderBy('month_reference', 'desc')
					 ->where('user_id', '=', Auth::id())
					 ->get();

		$months[0] = 'Selecione o mês de referência';

		foreach($Allmonths as $month) {
    		$months[$month->month_reference] = $month->month_name;
		}

		return $months;

	}

	public function getMonthId($expense)
	{
		$month = DB::table('months')
				 ->where('month_reference', $expense['date_reference'])
				 ->get(); 

		return $month[0]->id;
	}

	public function getOpenMonths()
	{
		$Allmonths = DB::table('months')
					 ->select('*')
					 ->orderBy('month_reference', 'desc')
					 ->where('casted', '=', 0)
					 ->where('user_id', '=', Auth::id())
					 ->get();

		$months[0] = 'Selecione o mês de referência';

		foreach($Allmonths as $month) {
    		$months[$month->month_reference] = $month->month_name;
		}

		return $months;

	}

	public function updateMonthId($expense, $id)
	{
		$month = DB::table('months')
		  			->where('month_reference', $expense['date_reference'])
		  			->get();
		
		DB::table('expenses')
		->where('id', $id)
		->update(['month_id' => $month[0]->id]);  			

		return true;
	}

}
