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

	public static function getCustomErrorMessages()
	{
		return array(
			'name.required' => 'nome é obrigatório',
			'situation.required' => 'situação é obrigatória',
			'number_apartament.required' => 'número do apartamento é obrigatório, cadastre todos os apartamentos antes de cadastrar os moradores',			
			'role_id.required' => 'O campo grupo do usuário é obrigatório',
		);
	}

}
