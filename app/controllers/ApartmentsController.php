<?php

class ApartmentsController extends BaseController {

	/**
	 * Apartment Repository
	 *
	 * @var Apartment
	 */
	protected $apartment;

	public function __construct(Apartment $apartment)
	{
		$this->apartment = $apartment;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$apartments = DB::table('apartments')
						->where('user_id', '=', Auth::id())
						->get();

		return View::make('apartments.index', compact('apartments'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('apartments.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Apartment::$rules);

		if ($validation->passes())
		{
			$this->apartment->create($input);

			return Redirect::route('apartments.index')
							->with('success', '<strong>Sucesso</strong> Registro inserido!');;
		}

		return Redirect::route('apartments.create')
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
		$apartment = $this->apartment->findOrFail($id);

		return View::make('apartments.show', compact('apartment'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$apartment = $this->apartment->find($id);

		if (is_null($apartment))
		{
			return Redirect::route('apartments.index');
		}

		return View::make('apartments.edit', compact('apartment'));
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
		$validation = Validator::make($input, Apartment::$rules);

		if ($validation->passes())
		{
			$apartment = $this->apartment->find($id);
			$apartment->update($input);

			return Redirect::route('apartments.index')
							->with('success', '<strong>Sucesso</strong> Registro atualizado!');;
		}

		return Redirect::route('apartments.edit', $id)
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
		$this->apartment->find($id)->delete();

		return Redirect::route('apartments.index');
	}

	public function getApartments()
	{
		$arr = [];

		if (!empty(Apartment::where('user_id', '=', Auth::id())->where('assigned', 0)->get()->toArray())):
			foreach (Apartment::where('user_id', '=', Auth::id())->where('assigned', 0)->get()->toArray() as $item):
				$arr[$item['number_apartment']] = $item['number_apartment'];			
			endforeach;
		endif;	

		return $arr;
	}

	public function setAssigned($number_apartment)
	{
		$apartment = Apartment::where('number_apartment', $number_apartment)->where('user_id', Auth::id())->first();
		$apartment->assigned = 1;
		return $apartment->save();
	}
	
}
