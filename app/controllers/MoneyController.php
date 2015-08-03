<?php

class MoneyController extends BaseController {

	public function reversePayment($dwellerId, $date)
	{
		DB::table('dweller_expenses')->where('date_expense', $date)
									 ->where('id_dweller', $dwellerId)
									 ->update(array(
									 	'status_expense' => 0,
									 	'credit' => 0
								 	  ));

		return Redirect::route('dwellers.show', $dwellerId)
						->with('success', '<strong>Sucesso</strong> Pagamento estornado com sucesso!');
	}

	public function checkParcialPay($idExpense, $value)
	{
		$expense = DB::table('dweller_expenses')
							->where('id', $idExpense)
							->get();
		
		$balance = ceil($expense[0]->value - $expense[0]->credit);
		$value = ceil($value);

		if ($value > $balance):
			return false;
			elseif(($value - $balance) == 0):
				$this->pay($expense[0]->id_dweller, $expense[0]->date_expense);							
		endif;

		return true;
	}

	public function pay($id, $date)
	{
		DB::table('dweller_expenses')
		->where('id_dweller', $id)
		->where('date_expense', $date)
		->update(array('status_expense' => 1, 'updated_at' => DB::raw('NOW()')));

		return Redirect::route('dwellers.show', $id);
	}

	public function sum($date)
	{
		$total = DB::table('expenses')
				   ->select(DB::raw('SUM(value) AS total'))
				   ->whereRaw(DB::raw("date_reference BETWEEN DATE_FORMAT(  '{$date}',  '%Y-%m-01' ) AND LAST_DAY(  '{$date}' )"))
				   ->where('user_id', Auth::id())
				   ->groupBy(DB::raw('YEAR(date_reference) , MONTH(date_reference)'))
				   ->get();
		
		return $total;				   
	}

	public function parcialPay($idExpense, $idDweller, $credit)
	{
		$input =  array_except(Input::all(), '_method');
		$credit += $input['value'];
		if($this->checkParcialPay($idExpense, $input['value'])):
			DB::table('dweller_expenses')
			->where('id', $idExpense)
			->update(array('credit' => $credit));
			return Redirect::route('dwellers.show', $idDweller)
						 ->with('success', '<strong>Sucesso</strong> pagamento parcial realizado!');
		else:
			return Redirect::route('dwellers.show', $idDweller)
						->with('message', '<strong>Erro</strong> o valor inserido é maior que o devido!');
		endif;	
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
	 * Cast expense for month
	 *
	 * @param  date  $date
	 * @return Response
	 */
	
	public function cast($date)
	{
		// sum total expenses for this month
		$expense = $this->sum($date);

		if (!empty($expense)):

			$userId = Auth::id();

			$parameters = Parameter::where('user_id', Auth::id())->first();

			// calc total and divider for total dwellers

			$total_by_dweller = $expense[0]->total / $parameters->number_apartments;

			// total of empty apartments

			$total_empty = Dweller::where('situation', 0)->count();

			// if exists empty apartments, change the calc

			if ($total_empty > 0):

				$halfAmount = $total_by_dweller / 2;

				$rest = $halfAmount * $total_empty;

				$newTotal = $rest + $expense[0]->total;

				// calc total and divider for total dwellers
				$total_by_dweller = $newTotal / $parameters->number_apartments;

			endif;	

			// update status this month to released and updated cost value for this month
			$this->castMonth($date, $total_by_dweller);

			foreach (Dweller::where('user_id', '=', $userId)->get() as $dweller):

				//throw expenses for each dweller
				DB::table('dweller_expenses')
					->insert(
						array(
							'id_dweller' => $dweller->id,
							'date_expense' => $date,
							// verify if apartament is occupied, when not divide this value for half
							'value' => ($dweller->situation == 1) ? $total_by_dweller : $halfAmount,
							'user_id' => $userId,
						)
				);

			endforeach;

			return Redirect::route('months.index')
											->with('success', '<strong>Sucesso</strong> Lançamento realizado!');
		else:
			
			return Redirect::route('months.index')
							->with('message', 
								'<strong>Erro</strong> Não há despesas para lançar para o mês escolhido: ' . 
								BaseController::getMonthNameExtension($date, 2));
		endif;									

		return Redirect::route('months.index')
										->with('message', 'Você precisa cadastrar a data de vencimento antes de lançar');
	}

	/**
	 * Display history the specified dweller.
	 *
	 * @param  int  $id
	 * @return Response
	 */

	public function history($id)
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
					->select(DB::raw('sum(value) as total'))
					->where('id_dweller', $id)
					->where('status_expense', 1)
					->where('type_expense', 1)
					->where('user_id', '=', Auth::id())
					->get();					

		$balance = $increase[0]->total - $decrease[0]->total;

		$sum = DB::table('dweller_expenses')
					->select(DB::raw('sum(value) as total'))
					->where('id_dweller', $id)
					->where('user_id', '=', Auth::id())
					->where('type_expense', 0)
					->get();

		$expenses = DB::table('dweller_expenses')
					->select(DB::raw('*'))
					->where('id_dweller', $id)
					->where('user_id', '=', Auth::id())
					->where('status_expense', 1)
					->get();

		return View::make('dwellers.history', compact('dweller', 'expenses', 'balance', 'sum'));
	}

	public function emptyApartmentPayment()
	{
		$input = Input::all();

		$expense = DwellerExpenses::where('user_id', Auth::id())
					   ->where('id_dweller', $input['id_dweller'])
					   ->where('date_expense', $input['date_expense'])
					   ->first();

		$newValue = $expense->value / 2;
		$expense->value = $newValue;
		$expense->apartmentEmpty = 1;
		$expense->save();

		return Redirect::route('dwellers.show', $input['id_dweller'])
					   ->with('success', 'Valor da despesa foi redefinida para o mês ' . BaseController::getMonthNameExtension($input['date_expense'], 2));	

	}

}