<?php

class BaseController extends Controller {

	public static $months_array = array(
		'01' => 'Janeiro',
		'02' => 'Fevereiro',
		'03' => 'Março',
		'04' => 'Abril',
		'05' => 'Maio',
		'06' => 'Junho',
		'07' => 'Julho',
		'08' => 'Agosto',
		'09' => 'Setembro',
		'10' => 'Outubro',
		'11' => 'Novembro',
		'12' => 'Dezembro',
	);

	public function index()
	{
		if (!Auth::check()):
			return View::make('users.login');
		else:
			$months = Month::orderBy('month_reference', 'desc')->simplePaginate(10);
			return View::make('months.index', compact('months'));
		endif;
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	public static function getMonthName($date)
	{
		$month =  substr($date, 5, 2);

		return BaseController::$months_array[$month];

	}

	public static function getMonthNameExtension($date, $type = 1)
	{

		$month =  substr($date, 5, 2);

		$day = substr($date, 8, 2); 

		$year = substr($date, 0, 4);

		$month_name = BaseController::$months_array[$month];

		if ($type == 1) {
			return $day . ' de ' . $month_name . ' de ' . $year;
		} else {
			return $month_name . ' de ' . $year;
		}	


	}

	public static function getDefaultDataFilter()
	{
		return '<form>
					<label for="'. Lang::get("app.dataFilter"). '">'. 
						Lang::get("app.dataFilter") .': </label>
			    	<input type="text" placeholder=" Digite..." id="search">
				</form>';
	}

}
